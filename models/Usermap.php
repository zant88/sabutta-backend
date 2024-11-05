<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "usermap".
 *
 * @property string $idmap
 * @property string $userid
 * @property string $pwd
 * @property string $idbank
 * @property string $tglinput
 * @property int $status 0 - aktif 1 - tidak aktif
 */
class Usermap extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'usermap';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('dbProxy');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idmap', 'userid', 'pwd', 'idbank', 'tglinput'], 'required'],
            [['tglinput'], 'safe'],
            [['status'], 'integer'],
            [['idmap', 'userid', 'idbank'], 'string', 'max' => 20],
            [['pwd'], 'string', 'max' => 100],
            [['userid'], 'unique'],
            [['idmap'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idmap' => 'Idmap',
            'userid' => 'Userid',
            'pwd' => 'Pwd',
            'idbank' => 'Idbank',
            'tglinput' => 'Tglinput',
            'status' => 'Status',
        ];
    }
}
