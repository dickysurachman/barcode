<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Kurir;

/**
 * KurirSearch represents the model behind the search form about `app\models\Kurir`.
 */
class KurirSearch extends Kurir
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'cari2', 'id_perusahaan', 'status', 'add_who', 'edit_who','id_grup'], 'integer'],
            [['nama', 'cari1', 'add_date', 'edit_date'], 'safe'],
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
        $query = Kurir::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'cari2' => $this->cari2,
            //'id_perusahaan' => Yii::$app->user->identity->id_perusahaan,
            'id_grup' => $this->id_grup,
            'status' => $this->status,
            'add_who' => $this->add_who,
            'add_date' => $this->add_date,
            'edit_who' => $this->edit_who,
            'edit_date' => $this->edit_date,
        ]);

        $query->andFilterWhere(['like', 'nama', $this->nama])
            ->andFilterWhere(['like', 'cari1', $this->cari1]);

        return $dataProvider;
    }
}
