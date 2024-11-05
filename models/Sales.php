<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sales".
 *
 * @property int $id
 * @property int $vendor_id
 * @property int $banksampah_sales_id
 * @property int $banksampah_id
 * @property string $code
 * @property string $sales_date
 * @property int $total
 * @property string|null $status
 * @property string|null $surat_jalan_code
 * @property string|null $generated_date_surat_jalan
 * @property string|null $description
 * @property string|null $place
 * @property string|null $hormat_kami_name
 * @property string|null $hormat_kami_position
 * @property int|null $invoiced
 *
 * @property SalesDetail[] $salesDetails
 * @property Vendor $vendor
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
            [['vendor_id', 'total', 'invoiced', 'banksampah_id', 'banksampah_sales_id'], 'integer'],
            [['sales_date', 'generated_date_surat_jalan'], 'safe'],
            [['description'], 'string'],
            [['code', 'status'], 'string', 'max' => 255],
            [['surat_jalan_code'], 'string', 'max' => 30],
            [['place', 'hormat_kami_name', 'hormat_kami_position'], 'string', 'max' => 100],
            [['vendor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vendor::className(), 'targetAttribute' => ['vendor_id' => 'id']],
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
            'code' => Yii::t('app', 'Code'),
            'sales_date' => Yii::t('app', 'Sales Date'),
            'total' => Yii::t('app', 'Total'),
            'status' => Yii::t('app', 'Status'),
            'surat_jalan_code' => Yii::t('app', 'Surat Jalan Code'),
            'generated_date_surat_jalan' => Yii::t('app', 'Generated Date Surat Jalan'),
            'description' => Yii::t('app', 'Description'),
            'place' => Yii::t('app', 'Place'),
            'hormat_kami_name' => Yii::t('app', 'Hormat Kami Name'),
            'hormat_kami_position' => Yii::t('app', 'Hormat Kami Position'),
            'invoiced' => Yii::t('app', 'Diinvoice'),
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

    /**
     * Gets query for [[Vendor]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVendor()
    {
        return $this->hasOne(Vendor::className(), ['id' => 'vendor_id']);
    }
}
