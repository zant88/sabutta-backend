<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "produk_user".
 *
 * @property string $idsampah
 * @property string $idfas
 * @property float|null $harga
 * @property int $idprodukuser
 */
class ProdukUser extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'produk_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idsampah', 'idfas'], 'required'],
            [['harga'], 'number'],
            [['idsampah', 'idfas'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idsampah' => Yii::t('app', 'Idsampah'),
            'idfas' => Yii::t('app', 'Idfas'),
            'harga' => Yii::t('app', 'Harga'),
            'idprodukuser' => Yii::t('app', 'Idprodukuser'),
        ];
    }

    public function getCustomer()
    {
        return $this->hasOne(FasyankesUser::className(), ['idfas' => 'idfas']);
    }
}
