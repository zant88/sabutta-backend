<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "jenissampah".
 *
 * @property string $idsampah
 * @property string|null $nama
 * @property float|null $hargaperkg
 * @property string|null $desc
 * @property string|null $status
 * @property string|null $roleuser
 * @property int|null $waste_type_id
 */
class Jenissampah extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'jenissampah';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idsampah', 'waste_type_id'], 'required'],
            [['hargaperkg'], 'number'],
            [['idsampah', 'status'], 'string', 'max' => 20],
            [['nama'], 'string', 'max' => 100],
            [['desc'], 'string', 'max' => 255],
            [['idsampah'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idsampah' => Yii::t('app', 'ID Sampah'),
            'nama' => Yii::t('app', 'Nama'),
            'hargaperkg' => Yii::t('app', 'Harga per KG'),
            'desc' => Yii::t('app', 'Deskripsi'),
            'status' => Yii::t('app', 'Status'),
            'roleuser' => Yii::t('app', 'Role User'),
            'waste_type_id' => Yii::t('app', 'Tipe Sampah'),
        ];
    }
}
