<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\User;

/**
 * usersearch represents the model behind the search form about `app\models\user`.
 */
class usersearch extends user
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'created_at', 'updated_at', 'tipe_user', 'id_profile','id_perusahaan'], 'integer'],
            [['username', 'auth_key', 'password_hash', 'password_reset_token', 'email','nama','nik','jabatan'], 'safe'],
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
        $query = user::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
             'pagination' => [
        'pageSize' => 20,
    ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'tipe_user' => $this->tipe_user,
            'id_profile' => $this->id_profile,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'nama', $this->nama])
            ->andFilterWhere(['like', 'nik', $this->nik])
            ->andFilterWhere(['like', 'jabatan', $this->jabatan])
            ->andFilterWhere(['like', 'password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
            ->andFilterWhere(['like', 'email', $this->email]);

        return $dataProvider;
    }
    public function searchpr($params)
    {
        $query = user::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
             'pagination' => [
        'pageSize' => 20,
    ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'tipe_user2' => 0,
            'tipe_user' => $this->tipe_user,
            'id_profile' => $this->id_profile,
            'id_perusahaan' => Yii::$app->user->identity->id_perusahaan,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key])
             ->andFilterWhere(['like', 'nama', $this->nama])
            ->andFilterWhere(['like', 'nik', $this->nik])
            ->andFilterWhere(['like', 'jabatan', $this->jabatan])
            ->andFilterWhere(['like', 'password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
            ->andFilterWhere(['like', 'email', $this->email]);

        return $dataProvider;
    }
}
