<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "transaction_processing".
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $start_date
 * @property string|null $end_date
 * @property int|null $banksampah_id
 *
 * @property Mbanksampah $banksampah
 * @property TransactionProcessingDetail[] $transactionProcessingDetails
 * @property User $user
 */
class TransactionProcessing extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'transaction_processing';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'banksampah_id'], 'integer'],
            [['start_date', 'end_date'], 'safe'],
            [['banksampah_id'], 'exist', 'skipOnError' => true, 'targetClass' => Mbanksampah::class, 'targetAttribute' => ['banksampah_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'start_date' => Yii::t('app', 'Start Date'),
            'end_date' => Yii::t('app', 'End Date'),
            'banksampah_id' => Yii::t('app', 'Banksampah ID'),
        ];
    }

    /**
     * Gets query for [[Banksampah]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBanksampah()
    {
        return $this->hasOne(Mbanksampah::class, ['id' => 'banksampah_id']);
    }

    /**
     * Gets query for [[TransactionProcessingDetails]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTransactionProcessingDetails()
    {
        return $this->hasMany(TransactionProcessingDetail::class, ['transaction_processing_id' => 'id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
