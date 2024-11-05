<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "banksampah_sales_detail".
 *
 * @property int $id
 * @property int|null $banksampah_sales_id
 * @property string|null $sampah_id
 * @property int|null $unit_price
 * @property int|null $quantity
 * @property int|null $amount
 */
class BanksampahSalesDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'banksampah_sales_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['banksampah_sales_id', 'unit_price', 'quantity', 'amount'], 'integer'],
            [['sampah_id'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'banksampah_sales_id' => 'Banksampah Sales ID',
            'sampah_id' => 'Sampah ID',
            'unit_price' => 'Unit Price',
            'quantity' => 'Quantity',
            'amount' => 'Amount',
        ];
    }
}
