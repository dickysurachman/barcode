<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Profile;

/**
 * ProfileSearch2 represents the model behind the search form about `app\models\Profile`.
 */
class ProfileSearch2 extends Profile
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'shelter'], 'integer'],
            [['nama', 'alamat', 'telp', 'fax', 'map'], 'safe'],
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
        $query = Profile::find();

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
            'shelter' => $this->shelter,
        ]);

        $query->andFilterWhere(['like', 'nama', $this->nama])
            ->andFilterWhere(['like', 'alamat', $this->alamat])
            ->andFilterWhere(['like', 'telp', $this->telp])
            ->andFilterWhere(['like', 'fax', $this->fax])
            ->andFilterWhere(['like', 'map', $this->map]);

        return $dataProvider;
    }
}
