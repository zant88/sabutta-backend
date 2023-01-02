<?php

namespace app\models;

use Yii;
use app\modules\user\models\Role;

/**
 * This is the model class for table "role_auth".
 *
 * @property int $id
 * @property int|null $role_id
 * @property int|null $auth_id
 *
 * @property AuthMaster $auth
 * @property Role $role
 */
class RoleAuth extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'role_auth';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['role_id', 'auth_id'], 'integer'],
            [['auth_id'], 'exist', 'skipOnError' => true, 'targetClass' => AuthMaster::class, 'targetAttribute' => ['auth_id' => 'id']],
            [['role_id'], 'exist', 'skipOnError' => true, 'targetClass' => Role::class, 'targetAttribute' => ['role_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'role_id' => Yii::t('app', 'Role ID'),
            'auth_id' => Yii::t('app', 'Auth ID'),
        ];
    }

    /**
     * Gets query for [[Auth]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuth()
    {
        return $this->hasOne(AuthMaster::class, ['id' => 'auth_id']);
    }

    /**
     * Gets query for [[Role]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(Role::class, ['id' => 'role_id']);
    }
}
