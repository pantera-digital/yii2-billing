<?php

namespace pantera\billing\services;

use pantera\billing\models\Balance;

/**
 * Class FinanceInvoiceDistributionService
 */
class DocumentExample extends BaseObject
{
    public $balanceFrom;

    public $totalSum;

    protected $transactions = [];

    public function execute() {
        $referals = $this->balanceFrom->user->referals;
        foreach ($referals as $referal) {
            $sum = $this->totalSum * $referal->coefficient;
            $this->addUserTransactions($referal->balance, $sum);
        }
        $this->transactionsExecute();
    }

    private function addUserTransactions(
        Balance $balanceTo,
        $paymentSum
    ) {
        foreach (BillingService::instance()->transferMoney(
            $this->balanceFrom,
            $balanceTo,
            $paymentSum,
            'По реферальной программе'
        ) as $financeTransaction) {
            $this->transactions[] = $financeTransaction;
        }
    }


    private function transactionsExecute()
    {
        if (FinanceOperationService::createOperation('REFERALS_DSITRIBUTION', $this->transactions)) {
            return true;
        }
    }


}