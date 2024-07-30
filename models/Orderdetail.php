<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "orderdetail".
 *
 * @property string $detailid
 * @property string $idsampah
 * @property float $berat
 * @property string $orderid
 * @property float $harga
 */
class Orderdetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'orderdetail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['detailid', 'idsampah', 'berat', 'orderid', 'harga'], 'required'],
            [['berat', 'harga'], 'number'],
            [['detailid', 'idsampah', 'orderid'], 'string', 'max' => 20],
            [['detailid'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'detailid' => Yii::t('app', 'Detailid'),
            'idsampah' => Yii::t('app', 'Idsampah'),
            'berat' => Yii::t('app', 'Berat'),
            'orderid' => Yii::t('app', 'Orderid'),
            'harga' => Yii::t('app', 'Harga'),
        ];
    }

    public function getWaste()
    {
        return $this->hasOne(Jenissampah::className(), ['idsampah' => 'idsampah']);
    }
}
