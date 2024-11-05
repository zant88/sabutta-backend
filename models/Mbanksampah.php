<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mbanksampah".
 *
 * @property int $id
 * @property string $banksampahid
 * @property int $parent_id
 * @property string $full_name
 * @property string|null $email
 * @property string|null $phone_number
 * @property string|null $address
 * @property string|null $json
 * @property string $created_at
 * @property string $updated_at
 */
class Mbanksampah extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mbanksampah';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['banksampahid', 'full_name', 'email', 'phone_number'], 'required'],
            [['address', 'json'], 'string'],
            [['parent_id'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['banksampahid'], 'string', 'max' => 50],
            [['full_name', 'email'], 'string', 'max' => 100],
            [['phone_number'], 'string', 'max' => 20],
            [['banksampahid'], 'unique'],
            [['email'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'banksampahid' => Yii::t('app', 'Banksampahid'),
            'parent_id' => Yii::t('app', 'Parent'),
            'full_name' => Yii::t('app', 'Full Name'),
            'email' => Yii::t('app', 'Email'),
            'phone_number' => Yii::t('app', 'Phone Number'),
            'address' => Yii::t('app', 'Address'),
            'json' => Yii::t('app', 'Json'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Get list of roles for creating dropdowns
     * @return array
     */
    public static function dropdown()
    {
        // get all records from database and generate
        static $dropdown;
        if ($dropdown === null) {
            $models = static::find()->all();
            foreach ($models as $model) {
                $dropdown[$model->id] = $model->banksampahid." - ".$model->full_name;
            }
        }
        return $dropdown;
    }

    /**
     * Get list of roles for creating dropdowns
     * @return array
     */
    public static function dropdownCode()
    {
        // get all records from database and generate
        static $dropdown;
        if ($dropdown === null) {
            $models = static::find()->all();
            foreach ($models as $model) {
                $dropdown[$model->banksampahid] = $model->banksampahid." - ".$model->full_name;
            }
        }
        return $dropdown;
    }
}
