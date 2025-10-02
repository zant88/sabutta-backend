<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "transaction_processing_detail".
 *
 * @property int $id
 * @property int|null $transaction_processing_id
 * @property string|null $waste_id
 * @property int|null $prev_price
 * @property int|null $curr_price
 * @property string|null $sales_list
 *
 * @property TransactionProcessing $transactionProcessing
 */
class TransactionProcessingDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'transaction_processing_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['transaction_processing_id', 'prev_price', 'curr_price'], 'integer'],
            [['waste_id', 'sales_list'], 'string', 'max' => 255],
            [['transaction_processing_id'], 'exist', 'skipOnError' => true, 'targetClass' => TransactionProcessing::class, 'targetAttribute' => ['transaction_processing_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'transaction_processing_id' => Yii::t('app', 'Transaction Processing ID'),
            'waste_id' => Yii::t('app', 'Waste ID'),
            'prev_price' => Yii::t('app', 'Prev Price'),
            'curr_price' => Yii::t('app', 'Curr Price'),
            'sales_list' => Yii::t('app', 'Sales List'),
        ];
    }

    /**
     * Gets query for [[TransactionProcessing]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTransactionProcessing()
    {
        return $this->hasOne(TransactionProcessing::class, ['id' => 'transaction_processing_id']);
    }
}
