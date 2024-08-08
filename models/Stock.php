<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "stock".
 *
 * @property string $idstock
 * @property string|null $idjnssampah
 * @property float|null $nilai
 * @property string|null $tgl
 * @property string|null $jnsstock
 * @property string|null $idorder
 * @property int|null $banksampah_id
 * @property string|null $banksampah_code
 */
class Stock extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'stock';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idstock'], 'required'],
            [['nilai'], 'number'],
            [['tgl'], 'safe'],
            [['idstock', 'idjnssampah', 'idorder'], 'string', 'max' => 20],
            [['jnsstock'], 'string', 'max' => 5],
            [['idstock'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idstock' => Yii::t('app', 'Idstock'),
            'idjnssampah' => Yii::t('app', 'Idjnssampah'),
            'nilai' => Yii::t('app', 'Nilai'),
            'tgl' => Yii::t('app', 'Tgl'),
            'jnsstock' => Yii::t('app', 'Masuk / Keluar'),
            'idorder' => Yii::t('app', 'Idorder'),
        ];
    }

    /**
     * Gets query for [[SalesDetails]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWaste()
    {
        return $this->hasOne(Jenissampah::className(), ['idsampah' => 'idjnssampah']);
    }

    public function getOrder()
    {
        return $this->hasOne(Order::className(), ['idorder' => 'idorder']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBS()
    {
        return $this->hasOne(Mbanksampah::className(), ['id' => 'banksampah_id']);
    }
}
