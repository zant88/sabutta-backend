<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vendor".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $address
 * @property string|null $description
 * @property int|null $status
 * @property string|null $phone
 *
 * @property Sales[] $sales
 * @property VendorWaste[] $vendorWastes
 */
class Vendor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vendor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['address', 'description'], 'string'],
            [['status'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 35],
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
            'address' => Yii::t('app', 'Address'),
            'description' => Yii::t('app', 'Description'),
            'status' => Yii::t('app', 'Status'),
            'phone' => Yii::t('app', 'Phone'),
        ];
    }

    /**
     * Gets query for [[Sales]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSales()
    {
        return $this->hasMany(Sales::className(), ['vendor_id' => 'id']);
    }

    /**
     * Gets query for [[VendorWastes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVendorWastes()
    {
        return $this->hasMany(VendorWaste::className(), ['vendor_id' => 'id']);
    }
}
