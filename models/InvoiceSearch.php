<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Invoice;

/**
 * InvoiceSearch represents the model behind the search form of `app\models\Invoice`.
 */
class InvoiceSearch extends Invoice
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['code', 'date', 'hormat_kami_name', 'place', 'hormat_kami_position', 'active_status', 'description'], 'safe'],
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
        $query = Invoice::find();

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

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'date' => $this->date,
        ]);
        $query->orderBy('date DESC');

        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'hormat_kami_name', $this->hormat_kami_name])
            ->andFilterWhere(['like', 'place', $this->place])
            ->andFilterWhere(['like', 'hormat_kami_position', $this->hormat_kami_position])
            ->andFilterWhere(['like', 'active_status', $this->active_status])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
