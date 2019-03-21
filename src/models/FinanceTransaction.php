<?php

namespace pantera\billing\models;

use Yii;

/**
 * This is the model class for table "finance_transaction".
 *
 * @property string $id Record Id
 * @property string $balance_id User id
 * @property string $balance_to
 * @property string $balance_from
 * @property int $type Operation type: 0 - draw, 1 - topup, 2 - currency exchange
 * @property string $amount_before
 * @property string $amount_after
 * @property string $currency_id_before Balance currency (before)
 * @property string $currency_id_after Balance currency after
 * @property string $comment
 * @property string $date_create Record creation date
 * @property string $operation_id Operation identity
 * @property string $sum Transaction sum
 *
 * @property Balance $balance
 * @property Currency $currencyIdAfter
 * @property Currency $currencyIdBefore
 * @property Balance $balanceFrom
 * @property Balance $balanceTo
 * @property FinanceOperation $operation
 */
class FinanceTransaction extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'finance_transaction';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['balance_id', 'amount_before', 'amount_after', 'currency_id_before', 'currency_id_after', 'operation_id'], 'required'],
            [['balance_id', 'balance_to', 'balance_from', 'type', 'amount_before', 'amount_after', 'currency_id_before', 'currency_id_after', 'operation_id', 'sum'], 'integer'],
            [['comment'], 'string'],
            [['date_create'], 'safe'],
            [['balance_id'], 'exist', 'skipOnError' => true, 'targetClass' => Balance::className(), 'targetAttribute' => ['balance_id' => 'id']],
            [['currency_id_after'], 'exist', 'skipOnError' => true, 'targetClass' => Currency::className(), 'targetAttribute' => ['currency_id_after' => 'id']],
            [['currency_id_before'], 'exist', 'skipOnError' => true, 'targetClass' => Currency::className(), 'targetAttribute' => ['currency_id_before' => 'id']],
            [['balance_from'], 'exist', 'skipOnError' => true, 'targetClass' => Balance::className(), 'targetAttribute' => ['balance_from' => 'id']],
            [['balance_to'], 'exist', 'skipOnError' => true, 'targetClass' => Balance::className(), 'targetAttribute' => ['balance_to' => 'id']],
            [['operation_id'], 'exist', 'skipOnError' => true, 'targetClass' => FinanceOperation::className(), 'targetAttribute' => ['operation_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'Record Id'),
            'balance_id' => Yii::t('app', 'User id'),
            'balance_to' => Yii::t('app', 'Balance To'),
            'balance_from' => Yii::t('app', 'Balance From'),
            'type' => Yii::t('app', 'Operation type: 0 - draw, 1 - topup, 2 - currency exchange'),
            'amount_before' => Yii::t('app', 'Amount Before'),
            'amount_after' => Yii::t('app', 'Amount After'),
            'currency_id_before' => Yii::t('app', 'Balance currency (before)'),
            'currency_id_after' => Yii::t('app', 'Balance currency after'),
            'comment' => Yii::t('app', 'Comment'),
            'date_create' => Yii::t('app', 'Record creation date'),
            'operation_id' => Yii::t('app', 'Operation identity'),
            'sum' => Yii::t('app', 'Transaction sum'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBalance()
    {
        return $this->hasOne(Balance::className(), ['id' => 'balance_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCurrencyIdAfter()
    {
        return $this->hasOne(Currency::className(), ['id' => 'currency_id_after']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCurrencyIdBefore()
    {
        return $this->hasOne(Currency::className(), ['id' => 'currency_id_before']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBalanceFrom()
    {
        return $this->hasOne(Balance::className(), ['id' => 'balance_from']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBalanceTo()
    {
        return $this->hasOne(Balance::className(), ['id' => 'balance_to']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOperation()
    {
        return $this->hasOne(FinanceOperation::className(), ['id' => 'operation_id']);
    }
}
