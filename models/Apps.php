<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "apps".
 *
 * @property string $idapps
 * @property string|null $desc
 * @property string|null $value
 * @property resource|null $imgs
 */
class Apps extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'apps';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idapps'], 'required'],
            [['imgs'], 'string'],
            [['idapps'], 'string', 'max' => 20],
            [['desc', 'value'], 'string', 'max' => 255],
            [['idapps'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idapps' => 'Idapps',
            'desc' => 'Desc',
            'value' => 'Value',
            'imgs' => 'Imgs',
        ];
    }
}
