<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Withdraw;
use app\modules\user\models\User;

/**
 * WithdrawSearch represents the model behind the search form of `app\models\Withdraw`.
 */
class WithdrawSearch extends Withdraw
{
    public $customer;
    public $bank;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'amount'], 'integer'],
            [['idfas', 'idbank', 'status', 'request_date', 'transfer_date', 'customer', 'bank'], 'safe'],
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
        $query = Withdraw::find();
        $query->joinWith(['customer', 'bank']);

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
            $query->where(['withdraw.banksampah_id' => $user->banksampah_id]);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'amount' => $this->amount,
            'request_date' => $this->request_date,
            'transfer_date' => $this->transfer_date,
        ]);

        $query->andFilterWhere(['like', 'idfas', $this->idfas])
            ->andFilterWhere(['like', 'idbank', $this->idbank])
            ->andFilterWhere(['like', 'status', $this->status]);
        $query->andFilterWhere(['OR', 
            ['like', 'mfasyankes.namafas', $this->customer], 
            ['like', 'withdraw.idfas', $this->customer]
        ]);
        $query->andFilterWhere(['OR', 
            ['like', 'mbank.namabank', $this->bank], 
            ['like', 'mbank.norekening', $this->bank],
            ['like', 'mbank.keterangan', $this->bank]
        ]);

        return $dataProvider;
    }
}
