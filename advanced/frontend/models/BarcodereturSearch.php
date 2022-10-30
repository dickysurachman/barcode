<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Barcoderetur;

/**
 * BarcodereturSearch represents the model behind the search form about `app\models\Barcoderetur`.
 */
class BarcodereturSearch extends Barcoderetur
{
    /**
     * @inheritdoc
     */
     public $tgl_a;
    public $tgl_b;
    public function rules()
    {
        return [
            [['id', 'status', 'id_perusahaan', 'add_who', 'edit_who','id_grup'], 'integer'],
            [['alasan', 'barcode', 'tanggal', 'add_date', 'edit_date','tgl_a','tgl_b','pesanan'], 'safe'],
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
        $query = Barcoderetur::find();

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
            'status' => $this->status,
             'id_perusahaan' => Yii::$app->user->identity->id_perusahaan,
             //'id_perusahaan' => $this->id_perusahaan,
            'tanggal' => $this->tanggal,
            'add_who' => $this->add_who,
            'edit_who' => $this->edit_who,
            'id_grup' => $this->id_grup,
            'add_date' => $this->add_date,
            'edit_date' => $this->edit_date,
        ]);

        $query->andFilterWhere(['like', 'alasan', $this->alasan])
         ->andFilterWhere(['>=', 'tanggal', $this->tgl_a])
         ->andFilterWhere(['like', 'pesanan', $this->pesanan])
            ->andFilterWhere(['<=', 'tanggal', $this->tgl_b])
            ->andFilterWhere(['like', 'barcode', $this->barcode]);

        return $dataProvider;
    }
}
