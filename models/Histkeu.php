<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "histkeu".
 *
 * @property string $idkeu
 * @property string|null $idfasyankes
 * @property string|null $status
 * @property float|null $value
 * @property string|null $tglhist
 * @property string|null $idOrder
 * @property string|null $keterangan
 */
class Histkeu extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'histkeu';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idkeu'], 'required'],
            [['value'], 'number'],
            [['tglhist'], 'safe'],
            [['idkeu', 'idfasyankes', 'idOrder'], 'string', 'max' => 20],
            [['status'], 'string', 'max' => 10],
            [['keterangan'], 'string', 'max' => 100],
            [['idkeu'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idkeu' => Yii::t('app', 'Idkeu'),
            'idfasyankes' => Yii::t('app', 'Idfasyankes'),
            'status' => Yii::t('app', 'Status'),
            'value' => Yii::t('app', 'Value'),
            'tglhist' => Yii::t('app', 'Tglhist'),
            'idOrder' => Yii::t('app', 'Id Order'),
            'keterangan' => Yii::t('app', 'Keterangan'),
        ];
    }
}
