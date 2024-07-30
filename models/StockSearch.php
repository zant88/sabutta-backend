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
    public $startDate;
    public $endDate;
    public $wasteName;
    public $trxType;
    public $userName;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idstock', 'idjnssampah', 'tgl', 'jnsstock', 'idorder', 'startDate', 'endDate', 'wasteName', 'trxType', 'userName'], 'safe'],
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
        if ($this->startDate !=null && $this->endDate != null) {
            $query->where("tgl BETWEEN '$this->startDate' AND '$this->endDate'");
        }else {
            $query->where("tgl BETWEEN '".date('Y-m-d')."' AND '".date('Y-m-d')."'");
        }
        if ($this->wasteName != null) {
            $query->joinWith('waste')->andFilterWhere(['like', 'nama', $this->wasteName]);
        }
        if ($this->trxType != null) {
            if ($this->trxType == 'TPST-GABRUKAN') {
                $query->joinWith('order')->andFilterWhere(['like', 'lokasipenjemputan', 'TPST']);
                $query->andFilterWhere(['<>', 'jnsTrxRequest', 'HASIL_GABRUKAN']);
            }else if ($this->trxType == 'TPST-TERPILAH') {
                $query->joinWith('order')->andFilterWhere(['like', 'lokasipenjemputan', 'TPST']);
                $query->andFilterWhere(['jnsTrxRequest' => 'HASIL_GABRUKAN']);
            }else {
                $query->joinWith('order')->andFilterWhere(['like', 'lokasipenjemputan', $this->trxType]);
            }
            
        }
        if ($this->userName != null) {
            $query->joinWith('order.user')->andFilterWhere(['like', 'namafas', $this->userName]);
        }
        $query->andFilterWhere([
            'nilai' => $this->nilai,
            'tgl' => $this->tgl,
        ]);
        $query->andFilterWhere([
            'nilai' => $this->nilai,
            'tgl' => $this->tgl,
        ]);
        $query->andFilterWhere(['like', 'idstock', $this->idstock])
            ->andFilterWhere(['like', 'idjnssampah', $this->idjnssampah])
            ->andFilterWhere(['like', 'jnsstock', $this->jnsstock])
            ->andFilterWhere(['like', 'idorder', $this->idorder]);
        $query->orderBy([
            'created_at' => SORT_DESC,
            'tgl' => SORT_DESC,
        ]);

        return $dataProvider;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchWeight($params)
    {
        $query = Stock::find();

        $this->load($params);

        if ($this->startDate !=null && $this->endDate != null) {
            $query->where("tgl BETWEEN '$this->startDate' AND '$this->endDate'");
        }else {
            $query->where("tgl BETWEEN '".date('Y-m-d')."' AND '".date('Y-m-d')."'");
        }
        if ($this->wasteName != null) {
            $query->joinWith('waste')->andFilterWhere(['like', 'nama', $this->wasteName]);
        }
        if ($this->trxType != null) {
            if ($this->trxType == 'TPST-GABRUKAN') {
                $query->joinWith('order')->andFilterWhere(['like', 'lokasipenjemputan', 'TPST']);
                $query->andFilterWhere(['<>', 'jnsTrxRequest', 'HASIL_GABRUKAN']);
            }else if ($this->trxType == 'TPST-TERPILAH') {
                $query->joinWith('order')->andFilterWhere(['like', 'lokasipenjemputan', 'TPST']);
                $query->andFilterWhere(['jnsTrxRequest' => 'HASIL_GABRUKAN']);
            }else {
                $query->joinWith('order')->andFilterWhere(['like', 'lokasipenjemputan', $this->trxType]);
            }
            
        }
        if ($this->userName != null) {
            $query->joinWith('order.user')->andFilterWhere(['like', 'namafas', $this->userName]);
        }
        $query->andFilterWhere([
            'nilai' => $this->nilai,
            'tgl' => $this->tgl,
        ]);
        $query->andFilterWhere(['like', 'idstock', $this->idstock])
            ->andFilterWhere(['like', 'idjnssampah', $this->idjnssampah])
            ->andFilterWhere(['like', 'jnsstock', $this->jnsstock])
            ->andFilterWhere(['like', 'idorder', $this->idorder]);
        $query->orderBy([
            'created_at' => SORT_DESC,
            'tgl' => SORT_DESC,
        ]);

        return number_format($query->sum('nilai'), 3, ',', '.');
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchBalance($params)
    {
        $query = Order::find();
        $query->joinWith('orderDetails.waste');
        $this->load($params);

        if ($this->startDate !=null && $this->endDate != null) {
            $query->where("tanggalinput BETWEEN '$this->startDate' AND '$this->endDate'");
        }else {
            $query->where("tanggalinput BETWEEN '".date('Y-m-d')."' AND '".date('Y-m-d')."'");
        }
        if ($this->wasteName != null) {
            $query->andFilterWhere(['like', 'nama', $this->wasteName]);
        }
        if ($this->trxType != null) {
            if ($this->trxType == 'TPST-GABRUKAN') {
                $query->andFilterWhere(['like', 'lokasipenjemputan', 'TPST']);
                $query->andFilterWhere(['<>', 'jnsTrxRequest', 'HASIL_GABRUKAN']);
            }else if ($this->trxType == 'TPST-TERPILAH') {
                $query->andFilterWhere(['like', 'lokasipenjemputan', 'TPST']);
                $query->andFilterWhere(['jnsTrxRequest' => 'HASIL_GABRUKAN']);
            }else {
                $query->andFilterWhere(['like', 'lokasipenjemputan', $this->trxType]);
            }
            
        }
        
        if ($this->userName != null) {
            $query->joinWith('user')->andFilterWhere(['like', 'namafas', $this->userName]);
        }
        
        return number_format($query->sum('harga'), 0, ',', '.');
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
            'trxType' => Yii::t('app', 'Jenis Transaksi'),
            'wasteName' => Yii::t('app', 'Nama Sampah'),
            'userName' => Yii::t('app', 'Pengguna'),
        ];
    }
}
