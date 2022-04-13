<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vendor_waste".
 *
 * @property int $id
 * @property string $idsampah
 * @property int $vendor_id
 * @property int $price_kg
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Jenissampah $idsampah0
 * @property Vendor $vendor
 */
class VendorWaste extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vendor_waste';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idsampah', 'vendor_id', 'price_kg'], 'required'],
            [['vendor_id', 'price_kg'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['idsampah'], 'string', 'max' => 20],
            [['idsampah'], 'exist', 'skipOnError' => true, 'targetClass' => Jenissampah::className(), 'targetAttribute' => ['idsampah' => 'idsampah']],
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
            'idsampah' => Yii::t('app', 'Idsampah'),
            'vendor_id' => Yii::t('app', 'Vendor ID'),
            'price_kg' => Yii::t('app', 'Price Kg'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[Idsampah0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWaste()
    {
        return $this->hasOne(Jenissampah::className(), ['idsampah' => 'idsampah']);
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
