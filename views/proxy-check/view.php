<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ProxyCheckResult */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Proxy Check Results', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="proxy-check-result-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'check_id',
            'proxy_id',
            'created_at',
            'updated_at',
            'type',
            'ip_addr',
            'ip_geo_country',
            'ip_geo_city',
            'status',
            'timeout:datetime',
        ],
    ]) ?>

</div>
