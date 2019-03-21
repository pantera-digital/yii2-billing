<?php

namespace pantera\billing\models;

use Yii;

/**
 * This is the model class for table "finance_operation_type".
 *
 * @property string $id
 * @property string $name
 * @property string $alias
 *
 * @property FinanceOperation[] $financeOperations
 */
class FinanceOperationType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'finance_operation_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'alias'], 'required'],
            [['name', 'alias'], 'string', 'max' => 255],
            [['name'], 'unique'],
            [['alias'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'alias' => Yii::t('app', 'Alias'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFinanceOperations()
    {
        return $this->hasMany(FinanceOperation::className(), ['operation_type_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return FinanceOperationTypeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new FinanceOperationTypeQuery(get_called_class());
    }
}
