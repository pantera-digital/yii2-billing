<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model pantera\billing\models\FinanceTransaction */

$this->title = Yii::t('app', 'Create Finance Transaction');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Finance Transactions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="finance-transaction-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
