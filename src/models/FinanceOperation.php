<?php

namespace pantera\billing\models;

use Yii;

/**
 * This is the model class for table "finance_operation".
 *
 * @property string $id
 * @property string $operation_type_id
 * @property string $currency_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property FinanceCompanyDepositIncome $financeCompanyDepositIncome
 * @property FinanceCompanyDepositeFinanceOperation[] $financeCompanyDepositeFinanceOperations
 * @property FinanceCompanyDepositIncome[] $deposits
 * @property FinanceInvoices $financeInvoices
 * @property FinanceInvoices $financeInvoices0
 * @property Currency $currency
 * @property FinanceOperationType $operationType
 * @property FinanceServiceWithdrawalOfFunds[] $financeServiceWithdrawalOfFunds
 * @property FinanceTransaction[] $financeTransactions
 * @property UserPaymentRequest $userPaymentRequest
 */
class FinanceOperation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'finance_operation';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['operation_type_id', 'currency_id'], 'required'],
            [['operation_type_id', 'currency_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['currency_id'], 'exist', 'skipOnError' => true, 'targetClass' => Currency::className(), 'targetAttribute' => ['currency_id' => 'id']],
            [['operation_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => FinanceOperationType::className(), 'targetAttribute' => ['operation_type_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'operation_type_id' => Yii::t('app', 'Operation Type ID'),
            'currency_id' => Yii::t('app', 'Currency ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFinanceCompanyDepositIncome()
    {
        return $this->hasOne(FinanceCompanyDepositIncome::className(), ['finance_operation_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFinanceCompanyDepositeFinanceOperations()
    {
        return $this->hasMany(FinanceCompanyDepositeFinanceOperation::className(), ['operation_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeposits()
    {
        return $this->hasMany(FinanceCompanyDepositIncome::className(), ['id' => 'deposit_id'])->viaTable('finance_company_deposite_finance_operation', ['operation_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFinanceInvoices()
    {
        return $this->hasOne(FinanceInvoices::className(), ['distribute_finance_operation_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFinanceInvoices0()
    {
        return $this->hasOne(FinanceInvoices::className(), ['pay_finance_operation_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCurrency()
    {
        return $this->hasOne(Currency::className(), ['id' => 'currency_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOperationType()
    {
        return $this->hasOne(FinanceOperationType::className(), ['id' => 'operation_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFinanceServiceWithdrawalOfFunds()
    {
        return $this->hasMany(FinanceServiceWithdrawalOfFunds::className(), ['finance_operation_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFinanceTransactions()
    {
        return $this->hasMany(FinanceTransaction::className(), ['operation_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserPaymentRequest()
    {
        return $this->hasOne(UserPaymentRequest::className(), ['user_output_finance_operation_id' => 'id']);
    }
}
