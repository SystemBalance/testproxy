<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProxyCheckResultSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Proxy Check Results';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="proxy-check-result-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Proxy Check Result', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'check_id',
            'proxy_id',
            'created_at',
            'updated_at',
            //'type',
            //'ip_addr',
            //'ip_geo_country',
            //'ip_geo_city',
            //'status',
            //'timeout:datetime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
