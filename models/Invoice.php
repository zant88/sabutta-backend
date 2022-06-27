<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "invoice".
 *
 * @property int $id
 * @property string|null $code
 * @property string|null $date
 * @property string|null $hormat_kami_name
 * @property string|null $place
 * @property string|null $hormat_kami_position
 * @property int|null $active_status
 * @property string|null $description
 * @property int|null $vendor_id
 *
 * @property InvoiceDetail[] $invoiceDetails
 */
class Invoice extends \yii\db\ActiveRecord
{
    public $surat_jalan;
    public $vendor;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'invoice';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date', 'surat_jalan'], 'safe'],
            [['active_status'], 'integer'],
            [['description'], 'string'],
            [['date', 'description', 'hormat_kami_name', 'place', 'hormat_kami_position', 'vendor_id', 'surat_jalan'], 'required'],
            [['code', 'hormat_kami_name', 'place', 'hormat_kami_position'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'code' => Yii::t('app', 'Code'),
            'date' => Yii::t('app', 'Date'),
            'hormat_kami_name' => Yii::t('app', 'Hormat Kami Name'),
            'place' => Yii::t('app', 'Place'),
            'hormat_kami_position' => Yii::t('app', 'Hormat Kami Position'),
            'active_status' => Yii::t('app', 'Active Status'),
            'description' => Yii::t('app', 'Description'),
            'vendor_id' => Yii::t('app', 'Vendor'),
            'surat_jalan' => Yii::t('app', 'Surat Jalan'),
        ];
    }

    /**
     * Gets query for [[InvoiceDetails]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getInvoiceDetails()
    {
        return $this->hasMany(InvoiceDetail::className(), ['invoice_id' => 'id']);
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
