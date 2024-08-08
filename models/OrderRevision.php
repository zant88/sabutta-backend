<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "order_revision".
 *
 * @property int $id
 * @property string $code
 * @property string|null $order_id
 * @property string|null $description
 * @property string|null $revision_date
 * @property int|null $banksampah_id
 * @property string|null $banksampah_code
 */
class OrderRevision extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order_revision';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code'], 'required'],
            [['description', 'banksampah_code'], 'string'],
            [['revision_date', 'banksampah_code'], 'safe'],
            [['code', 'order_id'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'code' => Yii::t('app', 'Code'),
            'order_id' => Yii::t('app', 'Order ID'),
            'description' => Yii::t('app', 'Description'),
            'revision_date' => Yii::t('app', 'Revision Date'),
            'banksampah_id' => Yii::t('app', 'Bank Sampah ID'),
            'banksampah_code' => Yii::t('app', 'Bank Sampah Code'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBS()
    {
        return $this->hasOne(Mbanksampah::className(), ['id' => 'banksampah_id']);
    }
}
