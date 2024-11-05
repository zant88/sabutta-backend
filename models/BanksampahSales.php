<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "banksampah_sales".
 *
 * @property int $id
 * @property string|null $code
 * @property int|null $from_banksampah_id
 * @property int|null $to_banksampah_id
 * @property string|null $transaction_date
 * @property string|null $created_at
 * @property int|null $created_by
 * @property string|null $status
 * @property string|null $pickup_at
 * @property string|null $vehicle_type
 * @property string|null $nopol
 * @property string|null $pickup_name
 * @property string|null $pickup_description
 * @property int|null $total
 *
 * @property User $createdBy
 * @property Mbanksampah $fromBanksampah
 * @property Mbanksampah $toBanksampah
 */
class BanksampahSales extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'banksampah_sales';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['from_banksampah_id', 'to_banksampah_id', 'created_by', 'total'], 'integer'],
            [['transaction_date', 'created_at', 'pickup_at'], 'safe'],
            [['pickup_description'], 'string'],
            [['code'], 'string', 'max' => 255],
            [['status'], 'string', 'max' => 75],
            [['vehicle_type'], 'string', 'max' => 100],
            [['nopol'], 'string', 'max' => 15],
            [['pickup_name'], 'string', 'max' => 150],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
            [['from_banksampah_id'], 'exist', 'skipOnError' => true, 'targetClass' => Mbanksampah::class, 'targetAttribute' => ['from_banksampah_id' => 'id']],
            [['to_banksampah_id'], 'exist', 'skipOnError' => true, 'targetClass' => Mbanksampah::class, 'targetAttribute' => ['to_banksampah_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Code',
            'from_banksampah_id' => 'From Banksampah ID',
            'to_banksampah_id' => 'To Banksampah ID',
            'transaction_date' => 'Transaction Date',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'status' => 'Status',
            'pickup_at' => 'Pickup At',
            'vehicle_type' => 'Vehicle Type',
            'nopol' => 'Nopol',
            'pickup_name' => 'Pickup Name',
            'pickup_description' => 'Pickup Description',
            'total' => 'Total',
        ];
    }

    /**
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }

    /**
     * Gets query for [[FromBanksampah]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFromBanksampah()
    {
        return $this->hasOne(Mbanksampah::class, ['id' => 'from_banksampah_id']);
    }

    /**
     * Gets query for [[ToBanksampah]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getToBanksampah()
    {
        return $this->hasOne(Mbanksampah::class, ['id' => 'to_banksampah_id']);
    }
}
