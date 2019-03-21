<?php

use pantera\billing\models\FinanceTransaction;
use pantera\billing\helpers\FinanceHelper;
use kartik\daterange\DateRangePicker;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel pantera\billing\models\FinanceTransactionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Finance Transactions');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-box finance-transaction-index">
    <div class="element-wrapper">
        <h6 class="element-header"><?= Html::encode($this->title) ?></h6>
        <div class="element-box">
            Введено в систему: <?=
            $incomed = (
                    FinanceTransaction::find()
                        ->andWhere(['balance_from' => null]) //TODO: incomed()
                        ->sum('amount_after - amount_before') ?: 0) / 100
            ?> <br>
            Выведено из системы: <?= $outed = (FinanceTransaction::find()
                    ->andWhere(['balance_to' => null]) //TODO: outed()
                    ->sum('amount_after - amount_before') ?: 0) / 100
            ?> <br>
            Минус на балансах: <?= $currentCredit = \pantera\billing\models\Balance::find()
                    ->andWhere(['<', 'amount', 0]) //TODO: plus()
                    ->sum('amount') / 100
            ?> <br>
            Плюс на балансах: <?= $currentDebit = \pantera\billing\models\Balance::find()
                    ->andWhere(['>', 'amount', 0]) //TODO: minus()
                    ->sum('amount') / 100
            ?> <br>
            Баланс системы по транзакциям: <?= $transactionBalance = (FinanceTransaction::find()
                    ->sum('amount_after - amount_before') ?: 0) / 100
            ?>

            <br>
            <?=\pantera\billing\widgets\TransactionsGrid::widget([
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
            ])?>
        </div>
    </div>

</div>
