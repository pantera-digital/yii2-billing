<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model pantera\billing\models\FinanceTransactionSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="finance-transaction-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'balance_id') ?>

    <?= $form->field($model, 'balance_to') ?>

    <?= $form->field($model, 'balance_from') ?>

    <?= $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'amount_before') ?>

    <?php // echo $form->field($model, 'amount_after') ?>

    <?php // echo $form->field($model, 'currency_id_before') ?>

    <?php // echo $form->field($model, 'currency_id_after') ?>

    <?php // echo $form->field($model, 'comment') ?>

    <?php // echo $form->field($model, 'date_create') ?>

    <?php // echo $form->field($model, 'operation_id') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
