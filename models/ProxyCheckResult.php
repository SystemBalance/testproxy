<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "proxy_check_result".
 *
 * @property int $id
 * @property int $check_id
 * @property int $proxy_id
 * @property string $created_at
 * @property string $updated_at
 * @property int|null $type
 * @property string|null $ip_geo_country
 * @property string|null $ip_geo_city
 * @property int|null $status
 * @property int|null $timeout
 * @property int|null $ip_addr
 *
 * @property ProxyCheck $check
 * @property Proxy $proxy
 */
class ProxyCheckResult extends \yii\db\ActiveRecord
{
    /**
     * @return int|null
     */
    public function getIpAddr()
    {
        return long2ip($this->ip_addr);
    }

    /**
     * @param int|null $ip_addr
     */
    public function setIpAddr($ip_addr)
    {
        $this->ip_addr = ip2long($ip_addr);
    }

    /**
     * Proxy types
     * @var string[]
     */
    public static $types = [
        1 => 'HTTP',
        4 => 'SOCKS5',
    ];


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'proxy_check_result';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['check_id', 'proxy_id'], 'required'],
            [['check_id', 'proxy_id', 'type', 'status', 'timeout', 'ip_addr'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['ip_geo_country'], 'string', 'max' => 100],
            [['ip_geo_city'], 'string', 'max' => 200],
            [['check_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProxyCheck::className(), 'targetAttribute' => ['check_id' => 'id']],
            [['proxy_id'], 'exist', 'skipOnError' => true, 'targetClass' => Proxy::className(), 'targetAttribute' => ['proxy_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'check_id' => 'Check ID',
            'proxy_id' => 'Proxy ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'type' => 'Type',
            'ip_geo_country' => 'Ip Geo Country',
            'ip_geo_city' => 'Ip Geo City',
            'status' => 'Status',
            'timeout' => 'Timeout',
            'ip_addr' => 'Ip Addr',
        ];
    }

    /**
     * Gets query for [[Check]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCheck()
    {
        return $this->hasOne(ProxyCheck::className(), ['id' => 'check_id']);
    }

    /**
     * Gets query for [[Proxy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProxy()
    {
        return $this->hasOne(Proxy::className(), ['id' => 'proxy_id']);
    }
}
