<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\BanksampahSales;
use app\modules\user\models\User;

/**
 * BanksampahSalesSearch represents the model behind the search form of `app\models\BanksampahSales`.
 */
class BanksampahSalesSearch extends BanksampahSales
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'from_banksampah_id', 'to_banksampah_id', 'created_by'], 'integer'],
            [['code', 'transaction_date', 'created_at', 'status', 'pickup_at', 'vehicle_type', 'nopol', 'pickup_name', 'pickup_description'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = BanksampahSales::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if (!Yii::$app->user->can("admin")) {
            $user = User::findOne(Yii::$app->user->id);
            $query->where(['from_banksampah_id' => $user->banksampah_id]);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'from_banksampah_id' => $this->to_banksampah_id,
            'transaction_date' => $this->transaction_date,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'pickup_at' => $this->pickup_at,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'vehicle_type', $this->vehicle_type])
            ->andFilterWhere(['like', 'nopol', $this->nopol])
            ->andFilterWhere(['like', 'pickup_name', $this->pickup_name])
            ->andFilterWhere(['like', 'pickup_description', $this->pickup_description]);

        return $dataProvider;
    }
}
