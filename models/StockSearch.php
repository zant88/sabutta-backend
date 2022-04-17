<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Stock;

/**
 * StockSearch represents the model behind the search form of `app\models\Stock`.
 */
class StockSearch extends Stock
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idstock', 'idjnssampah', 'tgl', 'jnsstock', 'idorder'], 'safe'],
            [['nilai'], 'number'],
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
        $query = Stock::find();

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
            'nilai' => $this->nilai,
            'tgl' => $this->tgl,
        ]);

        $query->andFilterWhere(['like', 'idstock', $this->idstock])
            ->andFilterWhere(['like', 'idjnssampah', $this->idjnssampah])
            ->andFilterWhere(['like', 'jnsstock', $this->jnsstock])
            ->andFilterWhere(['like', 'idorder', $this->idorder]);

        return $dataProvider;
    }
}
