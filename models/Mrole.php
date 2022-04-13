<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mrole".
 *
 * @property string $idrole
 * @property string|null $namarole
 * @property string|null $stsaktif
 * @property string|null $idfas
 * @property string|null $alamat
 * @property string|null $telp
 * @property string|null $fax
 * @property string|null $owner
 * @property string|null $namapetugas
 * @property string|null $jabatanpetugas
 * @property string|null $npwp
 * @property string|null $email
 * @property string|null $website
 * @property string|null $bidangusaha
 * @property string|null $notaris
 * @property string|null $alamatnotaris
 * @property string|null $nomoraktenotaris
 * @property string|null $tglaktenotaris
 * @property string|null $nosiup
 * @property string|null $pkp
 * @property string|null $nodomisilipersh
 * @property string|null $notandapersh
 * @property string|null $userid
 * @property string|null $pass
 * @property string|null $namafas
 * @property string|null $ttdmanagement
 * @property string|null $ttdclient
 * @property string|null $lat
 * @property string|null $lon
 * @property string|null $tokenfb
 * @property string|null $role
 * @property string|null $tglinput
 * @property int|null $saldo
 */
class Mrole extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mrole';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idrole'], 'required'],
            [['saldo'], 'integer'],
            [['idrole'], 'string', 'max' => 20],
            [['namarole'], 'string', 'max' => 100],
            [['stsaktif'], 'string', 'max' => 10],
            [['idfas', 'userid'], 'string', 'max' => 8],
            [['alamat', 'jabatanpetugas', 'namafas', 'lat', 'lon'], 'string', 'max' => 16],
            [['telp', 'fax', 'owner', 'namapetugas', 'npwp', 'email', 'website', 'bidangusaha', 'notaris', 'alamatnotaris', 'nomoraktenotaris', 'tglaktenotaris', 'nosiup', 'pkp', 'nodomisilipersh', 'notandapersh', 'ttdmanagement', 'ttdclient'], 'string', 'max' => 1],
            [['pass', 'role', 'tglinput'], 'string', 'max' => 32],
            [['tokenfb'], 'string', 'max' => 256],
            [['idrole'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idrole' => Yii::t('app', 'Idrole'),
            'namarole' => Yii::t('app', 'Namarole'),
            'stsaktif' => Yii::t('app', 'Stsaktif'),
            'idfas' => Yii::t('app', 'Idfas'),
            'alamat' => Yii::t('app', 'Alamat'),
            'telp' => Yii::t('app', 'Telp'),
            'fax' => Yii::t('app', 'Fax'),
            'owner' => Yii::t('app', 'Owner'),
            'namapetugas' => Yii::t('app', 'Namapetugas'),
            'jabatanpetugas' => Yii::t('app', 'Jabatanpetugas'),
            'npwp' => Yii::t('app', 'Npwp'),
            'email' => Yii::t('app', 'Email'),
            'website' => Yii::t('app', 'Website'),
            'bidangusaha' => Yii::t('app', 'Bidangusaha'),
            'notaris' => Yii::t('app', 'Notaris'),
            'alamatnotaris' => Yii::t('app', 'Alamatnotaris'),
            'nomoraktenotaris' => Yii::t('app', 'Nomoraktenotaris'),
            'tglaktenotaris' => Yii::t('app', 'Tglaktenotaris'),
            'nosiup' => Yii::t('app', 'Nosiup'),
            'pkp' => Yii::t('app', 'Pkp'),
            'nodomisilipersh' => Yii::t('app', 'Nodomisilipersh'),
            'notandapersh' => Yii::t('app', 'Notandapersh'),
            'userid' => Yii::t('app', 'Userid'),
            'pass' => Yii::t('app', 'Pass'),
            'namafas' => Yii::t('app', 'Namafas'),
            'ttdmanagement' => Yii::t('app', 'Ttdmanagement'),
            'ttdclient' => Yii::t('app', 'Ttdclient'),
            'lat' => Yii::t('app', 'Lat'),
            'lon' => Yii::t('app', 'Lon'),
            'tokenfb' => Yii::t('app', 'Tokenfb'),
            'role' => Yii::t('app', 'Role'),
            'tglinput' => Yii::t('app', 'Tglinput'),
            'saldo' => Yii::t('app', 'Saldo'),
        ];
    }
}
