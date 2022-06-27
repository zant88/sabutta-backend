<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "driver".
 *
 * @property string $iddriver
 * @property string|null $nama
 * @property string|null $nmperusahaan
 * @property string|null $telppersh
 * @property string|null $telpdriver
 * @property string|null $lat
 * @property string|null $lon
 * @property string|null $sts
 * @property string|null $stsjob
 * @property resource|null $foto
 * @property string $userid
 * @property string $pass
 * @property string|null $tokenfb
 * @property string|null $role
 */
class Driver extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'driver';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['iddriver', 'userid', 'pass', 'nama', 'nmperusahaan', 'role', 'telpdriver'], 'required'],
            [['foto'], 'string'],
            [['iddriver', 'telppersh', 'telpdriver', 'lon', 'stsjob'], 'string', 'max' => 20],
            [['nama', 'lat', 'sts'], 'string', 'max' => 50],
            [['nmperusahaan'], 'string', 'max' => 200],
            [['userid'], 'string', 'max' => 10],
            [['pass', 'tokenfb'], 'string', 'max' => 255],
            [['role'], 'string', 'max' => 100],
            [['iddriver'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'iddriver' => Yii::t('app', 'ID Pegawai'),
            'nama' => Yii::t('app', 'Nama'),
            'nmperusahaan' => Yii::t('app', 'Nama Perusahaan'),
            'telppersh' => Yii::t('app', 'Telp. Perushaaan'),
            'telpdriver' => Yii::t('app', 'HP'),
            'lat' => Yii::t('app', 'Lat'),
            'lon' => Yii::t('app', 'Lon'),
            'sts' => Yii::t('app', 'Status'),
            'stsjob' => Yii::t('app', 'Status Job'),
            'foto' => Yii::t('app', 'Foto'),
            'userid' => Yii::t('app', 'Userid'),
            'pass' => Yii::t('app', 'Password'),
            'tokenfb' => Yii::t('app', 'Tokenfb'),
            'role' => Yii::t('app', 'Role'),
        ];
    }
}
