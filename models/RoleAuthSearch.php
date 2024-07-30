<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\RoleAuth;
use app\modules\user\models\Role;

/**
 * RoleAuthSearch represents the model behind the search form of `app\models\RoleAuth`.
 */
class RoleAuthSearch extends RoleAuth
{
    public $role;
    public $auth;
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['role', 'role'], 'safe'],
            [['role', 'auth'], 'string', 'max' => 255],
            [['id', 'role_id', 'auth_id'], 'integer'],
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
        $query = RoleAuth::find();
        $query->joinWith(['role', 'auth']);
        

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->where('role_id <> '.Role::ROLE_ADMIN);
        $query->andFilterWhere([
            'id' => $this->id,
            'role_id' => $this->role_id,
            'auth_id' => $this->auth_id,
        ]);
        $query->andFilterWhere([
            'like', 'role.name', $this->role
        ]);
        $query->andFilterWhere([
            'like', 'auth_master.name', $this->auth
        ]);

        return $dataProvider;
    }
}
