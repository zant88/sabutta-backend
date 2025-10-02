<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "apps".
 *
 * @property string $idapps
 * @property string|null $desk
 * @property string|null $value
 */
class AppsProxy extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'apps';
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
            [['idapps'], 'required'],
            [['value'], 'string'],
            [['idapps'], 'string', 'max' => 20],
            [['desk'], 'string', 'max' => 255],
            [['idapps'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idapps' => Yii::t('app', 'Idapps'),
            'desk' => Yii::t('app', 'Desk'),
            'value' => Yii::t('app', 'Value'),
        ];
    }
}
