<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model pantera\billing\models\FinanceOperationType */

$this->title = Yii::t('app', 'Create Finance Operation Type');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Finance Operation Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="finance-operation-type-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
