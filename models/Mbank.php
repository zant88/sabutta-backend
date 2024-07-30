<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mbank".
 *
 * @property string $idbank
 * @property string|null $namabank
 * @property string|null $alamat
 * @property string|null $norekening
 * @property string|null $keterangan
 * @property string|null $idfas
 */
class Mbank extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mbank';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idbank'], 'required'],
            [['idbank', 'idfas'], 'string', 'max' => 20],
            [['namabank', 'alamat', 'norekening'], 'string', 'max' => 100],
            [['keterangan'], 'string', 'max' => 255],
            [['idbank'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idbank' => Yii::t('app', 'Idbank'),
            'namabank' => Yii::t('app', 'Namabank'),
            'alamat' => Yii::t('app', 'Alamat'),
            'norekening' => Yii::t('app', 'Norekening'),
            'keterangan' => Yii::t('app', 'Keterangan'),
            'idfas' => Yii::t('app', 'Idfas'),
        ];
    }
}
