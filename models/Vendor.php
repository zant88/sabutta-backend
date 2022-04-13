<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vendor".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $address
 * @property string|null $description
 * @property string|null $phone
 * @property int|null $status
 */
class Vendor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vendor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['address', 'description', 'phone'], 'string'],
            [['status'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'address' => Yii::t('app', 'Address'),
            'description' => Yii::t('app', 'Description'),
            'status' => Yii::t('app', 'Status'),
            'phone' => Yii::t('app', 'No. Tlp'),
        ];
    }
}
