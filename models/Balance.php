<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "balance".
 *
 * @property string $idfas
 * @property string $banksampah_code
 * @property float|null $initsaldo
 * @property float|null $saldo
 * @property string $last_update
 */
class Balance extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'balance';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idfas', 'banksampah_code'], 'required'],
            [['initsaldo', 'saldo'], 'number'],
            [['last_update'], 'safe'],
            [['idfas'], 'string', 'max' => 20],
            [['banksampah_code'], 'string', 'max' => 11],
            [['idfas', 'banksampah_code'], 'unique', 'targetAttribute' => ['idfas', 'banksampah_code']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idfas' => Yii::t('app', 'Idfas'),
            'banksampah_code' => Yii::t('app', 'Banksampah Code'),
            'initsaldo' => Yii::t('app', 'Initsaldo'),
            'saldo' => Yii::t('app', 'Saldo'),
            'last_update' => Yii::t('app', 'Last Update'),
        ];
    }
}
