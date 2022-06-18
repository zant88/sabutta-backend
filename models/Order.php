<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property string $idorder
 * @property string|null $idfasyankes
 * @property string|null $iddriver
 * @property string $tanggalinput
 * @property string|null $tanggalrequest
 * @property string|null $tanggalpickup
 * @property float|null $berat
 * @property string|null $status
 * @property float|null $distance
 * @property float|null $feekir
 * @property float|null $feesam
 * @property string|null $lokasipenjemputan
 * @property string|null $jnsTrxRequest
 * @property string|null $userpengurai
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idorder'], 'required'],
            [['tanggalinput', 'tanggalrequest', 'tanggalpickup'], 'safe'],
            [['berat', 'distance', 'feekir', 'feesam'], 'number'],
            [['idorder'], 'string', 'max' => 50],
            [['idfasyankes', 'iddriver', 'status', 'jnsTrxRequest', 'userpengurai'], 'string', 'max' => 20],
            [['lokasipenjemputan'], 'string', 'max' => 100],
            [['idorder'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idorder' => Yii::t('app', 'Idorder'),
            'idfasyankes' => Yii::t('app', 'Idfasyankes'),
            'iddriver' => Yii::t('app', 'Iddriver'),
            'tanggalinput' => Yii::t('app', 'Tanggalinput'),
            'tanggalrequest' => Yii::t('app', 'Tanggalrequest'),
            'tanggalpickup' => Yii::t('app', 'Tanggalpickup'),
            'berat' => Yii::t('app', 'Berat'),
            'status' => Yii::t('app', 'Status'),
            'distance' => Yii::t('app', 'Distance'),
            'feekir' => Yii::t('app', 'Feekir'),
            'feesam' => Yii::t('app', 'Feesam'),
            'lokasipenjemputan' => Yii::t('app', 'Lokasipenjemputan'),
            'jnsTrxRequest' => Yii::t('app', 'Jns Trx Request'),
            'userpengurai' => Yii::t('app', 'Userpengurai'),
        ];
    }

    public function getUser()
    {
        return $this->hasOne(FasyankesUser::className(), ['idfas' => 'idfasyankes']);
    }
}
