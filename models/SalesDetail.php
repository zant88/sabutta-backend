<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sales_detail".
 *
 * @property int $id
 * @property int $sales_id
 * @property string $sampah_id
 * @property int|null $amount_kg
 * @property int $total_price
 *
 * @property Sales $sales
 */
class SalesDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sales_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sales_id', 'sampah_id', 'total_price'], 'required'],
            [['sales_id', 'amount_kg', 'total_price'], 'integer'],
            [['sampah_id'], 'string', 'max' => 20],
            [['sales_id'], 'exist', 'skipOnError' => true, 'targetClass' => Sales::className(), 'targetAttribute' => ['sales_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'sales_id' => Yii::t('app', 'Sales ID'),
            'sampah_id' => Yii::t('app', 'Sampah ID'),
            'amount_kg' => Yii::t('app', 'Amount Kg'),
            'total_price' => Yii::t('app', 'Total Price'),
        ];
    }

    /**
     * Gets query for [[Sales]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSales()
    {
        return $this->hasOne(Sales::className(), ['id' => 'sales_id']);
    }
}
