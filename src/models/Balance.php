<?php

namespace pantera\billing\models;

use Yii;

/**
 * This is the model class for table "balance".
 *
 * @property string $id Record Id
 * @property string $currency_id Currency id
 * @property string $amount
 * @property string $date_create Record creation date
 * @property string $date_update Record update date
 * @property int $is_deleted
 * @property int $ready Эта колонка указывает, наличный счет или нет, 1 - наличный, 0 - безналичный
 *
 * @property Currency $currency
 * @property CompanyBalance[] $companyBalances
 * @property FinanceCompanyDepositIncome[] $financeCompanyDepositIncomes
 * @property FinanceServiceWithdrawalOfFunds[] $financeServiceWithdrawalOfFunds
 * @property FinanceTransaction[] $financeTransactions
 * @property FinanceTransaction[] $financeTransactions0
 * @property FinanceTransaction[] $financeTransactions1
 * @property ServiceBalance $serviceBalance
 * @property UserBalance $userBalance
 * @property User[] $users
 */
class Balance extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'balance';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['currency_id'], 'required'],
            [['currency_id', 'amount', 'is_deleted', 'ready'], 'integer'],
            [['date_create', 'date_update'], 'safe'],
            [['currency_id'], 'exist', 'skipOnError' => true, 'targetClass' => Currency::className(), 'targetAttribute' => ['currency_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'currency_id' => 'Currency ID',
            'amount' => 'Amount',
            'date_create' => 'Date Create',
            'date_update' => 'Date Update',
            'is_deleted' => 'Is Deleted',
            'ready' => 'Ready',
        ];
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
    public function getCompanyBalances()
    {
        return $this->hasMany(CompanyBalance::className(), ['balance_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFinanceCompanyDepositIncomes()
    {
        return $this->hasMany(FinanceCompanyDepositIncome::className(), ['balance_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFinanceServiceWithdrawalOfFunds()
    {
        return $this->hasMany(FinanceServiceWithdrawalOfFunds::className(), ['balance_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFinanceTransactions()
    {
        return $this->hasMany(FinanceTransaction::className(), ['balance_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFinanceTransactions0()
    {
        return $this->hasMany(FinanceTransaction::className(), ['balance_from' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFinanceTransactions1()
    {
        return $this->hasMany(FinanceTransaction::className(), ['balance_to' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServiceBalance()
    {
        return $this->hasOne(ServiceBalance::className(), ['balance_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserBalance()
    {
        return $this->hasOne(UserBalance::className(), ['balance_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])->viaTable('user_balance', ['balance_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return BalanceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BalanceQuery(get_called_class());
    }
}
