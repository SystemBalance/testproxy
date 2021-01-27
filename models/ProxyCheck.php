<?php

namespace app\models;

use Yii;
use app\models\Proxy;
use app\models\ProxyCheckResult;

/**
 * This is the model class for table "proxy_check".
 *
 * @property int $id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property ProxyCheckResult[] $proxyCheckResults
 */
class ProxyCheck extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'proxy_check';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[ProxyCheckResults]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProxyCheckResults()
    {
        return $this->hasMany(ProxyCheckResult::className(), ['check_id' => 'id']);
    }

    /**
     * @param \app\models\Proxy $proxy
     * @return bool
     */
    public function addProxyCheckResult(Proxy $proxy){
        $proxyCheckResult = new ProxyCheckResult();
        $proxyCheckResult->proxy_id = $proxy->id;
        $proxyCheckResult->check_id = $this->id;
        return $proxyCheckResult->save();
    }

}
