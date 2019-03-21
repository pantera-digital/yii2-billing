<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model pantera\billing\models\FinanceTransaction */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="finance-transaction-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'balance_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'balance_to')->textInput() ?>

    <?= $form->field($model, 'balance_from')->textInput() ?>

    <?= $form->field($model, 'type')->textInput() ?>

    <?= $form->field($model, 'amount_before')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'amount_after')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'currency_id_before')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'currency_id_after')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'comment')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'date_create')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
