<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Jenissampah;
use app\modules\user\models\User;

/**
 * JenissampahSearch represents the model behind the search form of `app\models\Jenissampah`.
 */
class JenissampahSearch extends Jenissampah
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idsampah', 'nama', 'desc', 'status', 'roleuser'], 'safe'],
            [['hargaperkg'], 'number'],
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
        $query = Jenissampah::find();

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
        $query->where([
            'status' => 'AKTIF'
        ]);

        $query->andFilterWhere([
            'hargaperkg' => $this->hargaperkg,
        ]);
        
        // if (!Yii::$app->user->can("admin")) {
        //     $user = User::findOne(Yii::$app->user->id);
        //     $query->andFilterWhere(['banksampah_id' => $user->banksampah_id]);
        // }
        $query->andFilterWhere(['like', 'idsampah', $this->idsampah])
            ->andFilterWhere(['like', 'nama', $this->nama])
            ->andFilterWhere(['like', 'desc', $this->desc])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'roleuser', $this->roleuser]);

        return $dataProvider;
    }
}
