<?php

namespace app\jobs;

use app\models\ProxyCheckResult;

/**
 * Class ProxyCheckJob.
 */
class ProxyCheckJob extends \yii\base\BaseObject implements \yii\queue\JobInterface
{
    public $ip;
    public $port;
    public $proxyId;
    public $proxyCheckId;

    /**
     * @inheritdoc
     */
    public function execute($queue)
    {
        $result = new ProxyCheckResult([
            'proxy_id' => $this->proxyId,
            'check_id' => $this->proxyCheckId,
        ]);
        if($result->save()){
            echo
                'checkID: '.$result->check_id.' '.
                'proxy: '.$result->proxy->getIp().':'.$result->proxy->getPort().
                "\n";
        };

        $proxies = [
            $result->proxy->getIp().':'.$result->proxy->getPort()
        ];

        $mc = curl_multi_init();
        for ($thread_no = 0; $thread_no < count($proxies); $thread_no++) {
            $c [$thread_no] = curl_init();
            curl_setopt($c [$thread_no], CURLOPT_URL, "http://google.com");
            curl_setopt($c [$thread_no], CURLOPT_HEADER, 0);
            curl_setopt($c [$thread_no], CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($c [$thread_no], CURLOPT_CONNECTTIMEOUT, 5);
            curl_setopt($c [$thread_no], CURLOPT_TIMEOUT, 10);
            curl_setopt($c [$thread_no], CURLOPT_PROXY, trim($proxies [$thread_no]));
            curl_setopt($c [$thread_no], CURLOPT_PROXYTYPE, 0);
            curl_multi_add_handle($mc, $c [$thread_no]);
        }


        do {
            while (($execrun = curl_multi_exec($mc, $running)) == CURLM_CALL_MULTI_PERFORM) ;
            if ($execrun != CURLM_OK) break;
            while ($done = curl_multi_info_read($mc)) {
                $info = curl_getinfo($done ['handle']);
                print_r($info);
                if ($info ['http_code'] == 301) {
                    echo trim($proxies [array_search($done['handle'], $c)]) . "\r\n";
                }
                curl_multi_remove_handle($mc, $done ['handle']);
            }
        } while ($running);
        curl_multi_close($mc);
    }
}
