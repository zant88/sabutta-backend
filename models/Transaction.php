<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "transaction".
 *
 * @property int $id
 * @property string|null $type
 * @property string|null $description
 * @property int|null $cash_in
 * @property int|null $cash_out
 * @property string|null $created_date
 * @property int|null $user_id
 */
class Transaction extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'transaction';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description'], 'string'],
            [['cash_in', 'cash_out', 'user_id'], 'integer'],
            [['created_date'], 'safe'],
            [['type'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'description' => 'Description',
            'cash_in' => 'Cash In',
            'cash_out' => 'Cash Out',
            'created_date' => 'Created Date',
            'user_id' => 'User ID',
        ];
    }
}
