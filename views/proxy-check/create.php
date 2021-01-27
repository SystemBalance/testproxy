<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ProxyCheckResult */

$this->title = 'Create Proxy Check Result';
$this->params['breadcrumbs'][] = ['label' => 'Proxy Check Results', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="proxy-check-result-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
