<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "order_revision_detail".
 *
 * @property int $id
 * @property int|null $order_revision_id
 * @property string|null $sampah_id
 * @property int|null $amount_diminished
 */
class OrderRevisionDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order_revision_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_revision_id', 'amount_diminished'], 'integer'],
            [['sampah_id'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'order_revision_id' => Yii::t('app', 'Order Revision ID'),
            'sampah_id' => Yii::t('app', 'Sampah ID'),
            'amount_diminished' => Yii::t('app', 'Amount Diminished'),
        ];
    }

    public function getWaste()
    {
        return $this->hasOne(Jenissampah::className(), ['idsampah' => 'sampah_id']);
    }
}
