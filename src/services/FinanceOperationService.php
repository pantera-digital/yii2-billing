<?php

namespace pantera\billing\services;

use pantera\billing\models\FinanceOperation;
use pantera\billing\models\FinanceOperationType;
use pantera\billing\models\FinanceTransaction;
use Yii;
use yii\base\InvalidConfigException;
use yii\db\Exception;
use yii\helpers\ArrayHelper;

class FinanceOperationService extends \yii\base\BaseObject
{

    /**
     * @param string $operationAlias
     * @param FinanceTransaction[] $transactions
     * @throws InvalidConfigException
     */
    public static function createOperation(string $operationAlias, array $transactions)
    {
        $transactionIsHere = false;
        if (empty($transactions) || !is_array($transactions)) {
            throw new InvalidConfigException('Please set transactions correctly');
        }

        if (!Yii::$app->db->transaction) {
            Yii::$app->db->beginTransaction();
            $transactionIsHere = true;
        }

        try {
            $operationType = FinanceOperationType::findOneByAlias($operationAlias);

            if (empty($operationType)) {
                throw new InvalidConfigException('Please set correct operation type alias');
            }

            $operation = new FinanceOperation([
                'operation_type_id' => $operationType->id,
                'currency_id' => 1, //TODO: HARDCODED RUBLES
            ]);

            $operation->save();
            foreach ($transactions as $transaction) {
                $transaction->operation_id = $operation->id;
                $transaction->save();
            }


            if ($transactionIsHere) {
                Yii::$app->db->transaction->commit();
            }

            return $operation;

        } catch (Exception $e) {
            Log::error('db', $e->getMessage(), $e->getTraceAsString());
            Yii::$app->db->transaction->rollBack();
            return false;
        }

    }

}