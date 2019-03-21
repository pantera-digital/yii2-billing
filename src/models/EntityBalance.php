<?php

namespace pantera\billing\models;

use Yii;

/**
 * This is the model class for table "user_balance".
 *
 * @property string $id
 * @property int $user_id User identity
 * @property string $balance_id Balance identity
 *
 * @property Balance $balance
 * @property User $user
 */
class EntityBalance extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_balance';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'balance_id'], 'required'],
            [['user_id', 'balance_id'], 'integer'],
            [['user_id', 'balance_id'], 'unique', 'targetAttribute' => ['user_id', 'balance_id']],
            [['balance_id'], 'exist', 'skipOnError' => true, 'targetClass' => Balance::className(), 'targetAttribute' => ['balance_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User identity'),
            'balance_id' => Yii::t('app', 'Balance identity'),
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
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * {@inheritdoc}
     * @return UserBalanceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserBalanceQuery(get_called_class());
    }
}
