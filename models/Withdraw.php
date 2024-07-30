<?php

namespace app\models;

use Yii;
use zantknight\yii\gallery\Gallery4Behavior;

/**
 * This is the model class for table "withdraw".
 *
 * @property int $id
 * @property string|null $idfas
 * @property string|null $idbank
 * @property int|null $amount
 * @property string|null $status
 * @property string|null $request_date
 * @property string|null $transfer_date
 */
class Withdraw extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'withdraw';
    }

    public function behaviors()
    {
         return [
            [
                'class' => Gallery4Behavior::className(),
                'model' => $this
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['amount'], 'integer'],
            [['request_date', 'transfer_date'], 'safe'],
            [['idfas', 'idbank'], 'string', 'max' => 20],
            [['status'], 'string', 'max' => 35],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'idfas' => Yii::t('app', 'Idfas'),
            'idbank' => Yii::t('app', 'Idbank'),
            'amount' => Yii::t('app', 'Amount'),
            'status' => Yii::t('app', 'Status'),
            'request_date' => Yii::t('app', 'Request Date'),
            'transfer_date' => Yii::t('app', 'Transfer Date'),
        ];
    }

    public function getCustomer()
    {
        return $this->hasOne(FasyankesUser::className(), ['idfas' => 'idfas']);
    }

    public function getBank()
    {
        return $this->hasOne(Mbank::className(), ['idbank' => 'idbank']);
    }

}
