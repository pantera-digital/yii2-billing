<?php

namespace pantera\billing\services;

use pantera\billing\models\FinanceTransaction;
use pantera\billing\models\Balance;
use Yii;
use yii\base\BaseObject;
use yii\helpers\ArrayHelper;

/**
 * Class BillingService
 * @package pantera\billing\services
 */
class BillingService extends BaseObject
{
    public $transactions = [];

    public static function instance($constructParams = null)
    {
        return new self($constructParams);
    }


    public function addTransaction($transaction) {
        $this->transactions[] = $transaction;
    }

    /**
     * @param Balance $balanceFrom
     * @param Balance $balanceTo
     * @param $sum
     * @param $comment
     * @return FinanceTransaction[]|null
     */
    public function transferMoney(Balance $balanceFrom, Balance $balanceTo, $sum, $comment)
    {
        $this->withdrawAccountBalance($balanceFrom, $sum, $balanceTo, $comment);
        $this->enrollAccountBalance($balanceTo, $sum, $balanceFrom, $comment);
        return $this->transactions;
    }

    /**
     * @param Balance $balance
     * @param $sum
     * @param Balance|null $balance_to
     * @param null $comment
     */
    public function withdrawAccountBalance(Balance $balance, $sum, Balance $balance_to = null, $comment = null)
    {

        $amount = $sum * 100; //BANK FORMATING (BIGINT)
        $balanceBeforeAmount = $balance->amount ?: 0;
        $balanceAfterAmount = ($balance->amount - $amount) ?: 0;

        $transaction = new FinanceTransaction([
            'type' => FinanceTransaction::OPERATION_TYPE_DRAW,
            'currency_id_before' => $balance->currency_id,
            'currency_id_after' => $balance->currency_id,
            'balance_to' => $balance_to ? $balance_to->id : null,
            'balance_from' => $balance->id,
            'sum' => $balanceAfterAmount - $balanceBeforeAmount,
            'amount_after' => $balanceAfterAmount,
            'amount_before' => $balanceBeforeAmount,
            'comment' => $comment,
            'balance_id' => $balance->id,
        ]);
        //TODO: придумать чтобы было без этого
        $balance->amount = $balanceAfterAmount;
        $balance->save();

        $this->addTransaction($transaction);
        return $this->transactions;
    }

    /**
     * @param $user_id
     * @param $sum
     * @param string $comment
     * Зачисляет сумму на баланс пользователя
     */
    public function enrollAccountBalance(Balance $balance, $sum, Balance $balance_from = null, $comment = '')
    {
        $amount = $sum * 100; //BANK FORMATING (BIGINT)
        $balanceBeforeAmount = $balance->amount ?: 0;
        $balanceAfterAmount = ($balance->amount + $amount) ?: 0;

        $transaction = new FinanceTransaction([
            'type' => FinanceTransaction::OPERATION_TYPE_TOPUP,
            'currency_id_before' => $balance->currency_id,
            'currency_id_after' => $balance->currency_id,
            'balance_to' => $balance->id,
            'balance_from' => $balance_from ? $balance_from->id : null,
            'amount_after' => $balanceAfterAmount,
            'sum' => $balanceAfterAmount - $balanceBeforeAmount,
            'amount_before' => $balanceBeforeAmount,
            'comment' => $comment,
            'balance_id' => $balance->id,
        ]);

        $this->addTransaction($transaction);
        $balance->amount = $balanceAfterAmount;
        $balance->save();

        return $this->transactions;
    }

}