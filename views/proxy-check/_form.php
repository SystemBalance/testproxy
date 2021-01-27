<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ProxyCheckResult */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="proxy-check-result-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'check_id')->textInput() ?>

    <?= $form->field($model, 'proxy_id')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'type')->textInput() ?>

    <?= $form->field($model, 'ip_addr')->textInput() ?>

    <?= $form->field($model, 'ip_geo_country')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ip_geo_city')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'timeout')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
