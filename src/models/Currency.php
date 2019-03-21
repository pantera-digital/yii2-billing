<?php

namespace pantera\billing\models;

use Yii;

/**
 * This is the model class for table "currency".
 *
 * @property int $id Record Id
 * @property int $country_id Country id
 * @property string $name_ru Currency name in russian
 * @property string $name_en Currency name in english
 * @property string $code Currency code
 * @property string $date_create Record creation date
 * @property string $date_update Record update date
 * @property int $precision Precision for convert to price
 *
 * @property Balance[] $balances
 * @property User[] $users
 * @property FinanceTransaction[] $FinanceTransactions
 * @property FinanceTransaction[] $FinanceTransactions0
 * @property Country $country
 * @property Offer[] $offers
 * @property OfferGeo[] $offerGeos
 * @property Profile[] $profiles
 */
class Currency extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'currency';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['country_id', 'precision'], 'integer'],
            [['name_ru', 'name_en', 'code'], 'required'],
            [['date_create', 'date_update'], 'safe'],
            [['name_ru', 'name_en'], 'string', 'max' => 255],
            [['code'], 'string', 'max' => 3],
            [['code'], 'unique'],
            [['country_id'], 'exist', 'skipOnError' => true, 'targetClass' => Country::className(), 'targetAttribute' => ['country_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'country_id' => Yii::t('app', 'Country ID'),
            'name_ru' => Yii::t('app', 'Name Ru'),
            'name_en' => Yii::t('app', 'Name En'),
            'code' => Yii::t('app', 'Code'),
            'date_create' => Yii::t('app', 'Date Create'),
            'date_update' => Yii::t('app', 'Date Update'),
            'precision' => Yii::t('app', 'Precision'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBalances()
    {
        return $this->hasMany(Balance::className(), ['currency_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])->viaTable('balance', ['currency_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFinanceTransactions()
    {
        return $this->hasMany(FinanceTransaction::className(), ['currency_id_after' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFinanceTransactions0()
    {
        return $this->hasMany(FinanceTransaction::className(), ['currency_id_before' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Country::className(), ['id' => 'country_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOffers()
    {
        return $this->hasMany(Offer::className(), ['currency_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOfferGeos()
    {
        return $this->hasMany(OfferGeo::className(), ['currency_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfiles()
    {
        return $this->hasMany(Profile::className(), ['currency_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return CurrencyQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CurrencyQuery(get_called_class());
    }
}
