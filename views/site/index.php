<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ProxyLoadForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Add proxies';
?>
<div class="site-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->session->hasFlash('contactFormSubmitted')): ?>

        <div class="alert alert-success">
            Thank you for contacting us. We will respond to you as soon as possible.
        </div>
    <?php else: ?>

        <p>
            If you have business inquiries or other questions, please fill out the following form to contact us.
            Thank you.
        </p>

        <div class="row">
            <div class="col-lg-5">


                <?php $form = ActiveForm::begin(['id' => 'proxy-load-form']); ?>

                <?= $form->field($model, 'proxiesText')->textarea(['rows' => 6,'autofocus' => true]) ?>

                <?= $form->field($model, 'proxiesFile')->fileInput() ?>

                <div class="form-group">
                    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'proxies-button']) ?>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>

    <?php endif; ?>
</div>
