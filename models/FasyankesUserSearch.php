<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\FasyankesUser;
use app\modules\user\models\User;

/**
 * FasyankesUserSearch represents the model behind the search form of `app\models\FasyankesUser`.
 */
class FasyankesUserSearch extends FasyankesUser
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idfas', 'alamat', 'telp', 'fax', 'owner', 'namapetugas', 'jabatanpetugas', 'npwp', 'email', 'website', 'bidangusaha', 'notaris', 'alamatnotaris', 'nomoraktenotaris', 'tglaktenotaris', 'nosiup', 'pkp', 'nodomisilipersh', 'notandapersh', 'userid', 'pass', 'namafas', 'ttdmanagement', 'ttdclient', 'lat', 'lon', 'tokenfb', 'role', 'tglinput', 'nip', 'nik'], 'safe'],
            [['saldo'], 'number'],
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
        $query = FasyankesUser::find();

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
            $query->where(['banksampah_id' => $user->banksampah_id]);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'tglaktenotaris' => $this->tglaktenotaris,
            'tglinput' => $this->tglinput,
            'saldo' => $this->saldo,
        ]);

        $query->andFilterWhere(['like', 'idfas', $this->idfas])
            ->andFilterWhere(['like', 'alamat', $this->alamat])
            ->andFilterWhere(['like', 'telp', $this->telp])
            ->andFilterWhere(['like', 'fax', $this->fax])
            ->andFilterWhere(['like', 'owner', $this->owner])
            ->andFilterWhere(['like', 'namapetugas', $this->namapetugas])
            ->andFilterWhere(['like', 'jabatanpetugas', $this->jabatanpetugas])
            ->andFilterWhere(['like', 'npwp', $this->npwp])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'website', $this->website])
            ->andFilterWhere(['like', 'bidangusaha', $this->bidangusaha])
            ->andFilterWhere(['like', 'notaris', $this->notaris])
            ->andFilterWhere(['like', 'alamatnotaris', $this->alamatnotaris])
            ->andFilterWhere(['like', 'nomoraktenotaris', $this->nomoraktenotaris])
            ->andFilterWhere(['like', 'nosiup', $this->nosiup])
            ->andFilterWhere(['like', 'pkp', $this->pkp])
            ->andFilterWhere(['like', 'nodomisilipersh', $this->nodomisilipersh])
            ->andFilterWhere(['like', 'notandapersh', $this->notandapersh])
            ->andFilterWhere(['like', 'userid', $this->userid])
            ->andFilterWhere(['like', 'pass', $this->pass])
            ->andFilterWhere(['like', 'namafas', $this->namafas])
            ->andFilterWhere(['like', 'ttdmanagement', $this->ttdmanagement])
            ->andFilterWhere(['like', 'ttdclient', $this->ttdclient])
            ->andFilterWhere(['like', 'lat', $this->lat])
            ->andFilterWhere(['like', 'lon', $this->lon])
            ->andFilterWhere(['like', 'tokenfb', $this->tokenfb])
            ->andFilterWhere(['like', 'role', $this->role])
            ->andFilterWhere(['like', 'nip', $this->nip])
            ->andFilterWhere(['like', 'nik', $this->nik]);
        
        $query->orderBy('namafas');

        return $dataProvider;
    }
}
