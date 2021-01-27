<?php

namespace app\services;

use app\jobs\ProxyCheckJob;
use app\models\Proxy;
use app\models\ProxyCheck;
use Yii;
use app\models\ProxyCheckResult;
use yii\db\Exception;


class ProxyService extends \yii\base\Component
{

    const THREAD_LIMIT = 10;

    /**
     * Функция загрузки списка прокси.
     * Оптимизирована с точки зрения ооп.
     * Не оптимизирована с точки зрения SQL. Для данной операции лучше использовать SQL INSERT|REPLACE VALUES.
     *
     * @param array $proxies
     * @return ProxyCheck
     */
    public function addProxies(array $proxies)
    {
        $count = count($proxies);
        if ($count == 0) return false;

        /**
         * @var $ProxyCheck ProxyCheck
         */
        $ProxyCheck = new ProxyCheck();
        $ProxyCheck->save();

        foreach ($proxies as $row) {
            if(empty($row)) continue;
            list($ip, $port) = explode(':', trim($row));

            $proxy = Proxy::getByIpPort($ip, $port);
            if (!$proxy) {
                $proxy = new Proxy();
                $proxy->setIp($ip);
                $proxy->setPort($port);
                $proxy->save();
            }

            $this->addProxyCheckJob($proxy,$ProxyCheck);
//            $ProxyCheck->addProxyCheckResult($proxy);
        }
        return $ProxyCheck;
    }

    protected function addProxyCheckJob(Proxy $proxy, ProxyCheck $proxyCheck)
    {
        Yii::$app->queue->push(new ProxyCheckJob([
            'ip' => $proxy->ip,
            'port' => $proxy->port,
            'proxyCheckId' => $proxyCheck->id,
            'proxyId' => $proxy->id,
        ]));
        return true;
    }
}