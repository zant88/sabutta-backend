<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sales".
 *
 * @property int $id
 * @property int $vendor_id
 * @property string $code
 * @property string $sales_date
 * @property int $total
 * @property string|null $status
 *
 * @property SalesDetail[] $salesDetails
 */
class Sales extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sales';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['vendor_id', 'code', 'sales_date', 'total'], 'required'],
            [['vendor_id', 'total'], 'integer'],
            [['sales_date'], 'safe'],
            [['code', 'status'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'vendor_id' => Yii::t('app', 'Vendor ID'),
            'code' => Yii::t('app', 'Kode'),
            'sales_date' => Yii::t('app', 'Tanggal Penjualan'),
            'total' => Yii::t('app', 'Total Penjualan'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * Gets query for [[SalesDetails]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSalesDetails()
    {
        return $this->hasMany(SalesDetail::className(), ['sales_id' => 'id']);
    }
}
