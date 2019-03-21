<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel pantera\billing\models\FinanceOperationTypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Finance Operation Types');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="finance-operation-type-index">
    <div class="finance-invoices-index element-wrapper">
        <h6 class="element-header"><?= Html::encode($this->title) ?></h6>
        <div class="card border-default">
            <div class="content-box">
                <p>
                    <?= Html::a(Yii::t('app', 'Create'), ['create'], ['class' => 'btn btn-primary']) ?>
                </p>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'summary' => false,
                    'columns' => [
                        'name',
                        'alias',
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{view}'
                        ],
                    ],
                ]); ?>
            </div>
        </div>
    </div>
</div>
