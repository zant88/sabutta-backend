<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Driver;

/**
 * DriverSearch represents the model behind the search form of `app\models\Driver`.
 */
class DriverSearch extends Driver
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['iddriver', 'nama', 'nmperusahaan', 'telppersh', 'telpdriver', 'lat', 'lon', 'sts', 'stsjob', 'foto', 'userid', 'pass', 'tokenfb', 'role'], 'safe'],
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
        $query = Driver::find();

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
        $query->andFilterWhere(['like', 'iddriver', $this->iddriver])
            ->andFilterWhere(['like', 'nama', $this->nama])
            ->andFilterWhere(['like', 'nmperusahaan', $this->nmperusahaan])
            ->andFilterWhere(['like', 'telppersh', $this->telppersh])
            ->andFilterWhere(['like', 'telpdriver', $this->telpdriver])
            ->andFilterWhere(['like', 'lat', $this->lat])
            ->andFilterWhere(['like', 'lon', $this->lon])
            ->andFilterWhere(['like', 'sts', $this->sts])
            ->andFilterWhere(['like', 'stsjob', $this->stsjob])
            ->andFilterWhere(['like', 'foto', $this->foto])
            ->andFilterWhere(['like', 'userid', $this->userid])
            ->andFilterWhere(['like', 'pass', $this->pass])
            ->andFilterWhere(['like', 'tokenfb', $this->tokenfb])
            ->andFilterWhere(['like', 'role', $this->role]);

        $query->orderBy('iddriver');

        return $dataProvider;
    }
}
