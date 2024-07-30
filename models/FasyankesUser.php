<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mfasyankes".
 *
 * @property string $idfas
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
 * @property string $userid
 * @property string $pass
 * @property string|null $namafas
 * @property resource|null $ttdmanagement
 * @property resource|null $ttdclient
 * @property string|null $lat
 * @property string|null $lon
 * @property string|null $tokenfb
 * @property string|null $role
 * @property string|null $tglinput
 * @property string|null $nip
 * @property string|null $nik
 * @property float|null $saldo
 *
 * @property Refdokumen[] $iddoks
 * @property Mbank[] $mbanks
 * @property Mdokumen[] $mdokumens
 */
class FasyankesUser extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mfasyankes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idfas', 'userid', 'pass'], 'required'],
            [['tglaktenotaris', 'tglinput'], 'safe'],
            [['ttdmanagement', 'ttdclient'], 'string'],
            [['saldo'], 'number'],
            [['idfas', 'telp', 'fax'], 'string', 'max' => 20],
            [['alamat', 'alamatnotaris', 'pass', 'tokenfb'], 'string', 'max' => 255],
            [['owner', 'namapetugas', 'jabatanpetugas', 'npwp', 'notaris', 'userid', 'lat', 'nip', 'nik'], 'string', 'max' => 50],
            [['email'], 'string', 'max' => 30],
            [['website', 'bidangusaha', 'nomoraktenotaris', 'nosiup', 'pkp', 'nodomisilipersh', 'notandapersh', 'namafas', 'lon', 'role'], 'string', 'max' => 100],
            [['idfas'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idfas' => 'id',
            'alamat' => 'Alamat',
            'telp' => 'HP',
            'fax' => 'Fax',
            'owner' => 'Owner',
            'namapetugas' => 'Nama',
            'jabatanpetugas' => 'Jabatanpetugas',
            'npwp' => 'Npwp',
            'email' => 'Email',
            'website' => 'Website',
            'bidangusaha' => 'Bidangusaha',
            'notaris' => 'Notaris',
            'alamatnotaris' => 'Alamatnotaris',
            'nomoraktenotaris' => 'Nomoraktenotaris',
            'tglaktenotaris' => 'Tglaktenotaris',
            'nosiup' => 'Nosiup',
            'pkp' => 'Pkp',
            'nodomisilipersh' => 'Nodomisilipersh',
            'notandapersh' => 'Notandapersh',
            'userid' => 'Userid',
            'pass' => 'Pass',
            'namafas' => 'Nama',
            'ttdmanagement' => 'Ttdmanagement',
            'ttdclient' => 'Ttdclient',
            'lat' => 'Lat',
            'lon' => 'Lon',
            'tokenfb' => 'Tokenfb',
            'role' => 'Role',
            'tglinput' => 'Tglinput',
            'nip' => 'NIP',
            'nik' => 'NIK',
            'saldo' => 'Saldo',
        ];
    }

    /**
     * Gets query for [[Iddoks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIddoks()
    {
        return $this->hasMany(Refdokumen::className(), ['iddok' => 'iddok'])->viaTable('mdokumen', ['idfas' => 'idfas']);
    }

    /**
     * Gets query for [[Mbanks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMbanks()
    {
        return $this->hasMany(Mbank::className(), ['idfas' => 'idfas']);
    }

    /**
     * Gets query for [[Mdokumens]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMdokumens()
    {
        return $this->hasMany(Mdokumen::className(), ['idfas' => 'idfas']);
    }
}
