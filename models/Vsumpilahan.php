<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vsumpilahan".
 *
 * @property string $idsampah
 * @property string $tgl
 * @property string|null $nama
 * @property float $berat
 * @property float|null $nilai
 */
class Vsumpilahan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vsumpilahan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idsampah', 'berat'], 'required'],
            [['tgl'], 'safe'],
            [['berat', 'nilai'], 'number'],
            [['idsampah'], 'string', 'max' => 20],
            [['nama'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idsampah' => 'Idsampah',
            'tgl' => 'Tgl',
            'nama' => 'Nama',
            'berat' => 'Berat',
            'nilai' => 'Nilai',
        ];
    }
}
