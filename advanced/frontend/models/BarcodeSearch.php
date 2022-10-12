<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Barcode;

/**
 * BarcodeSearch represents the model behind the search form about `app\models\Barcode`.
 */
class BarcodeSearch extends Barcode
{
    /**
     * @inheritdoc
     */
    public $tgl_a;
    public $tgl_b;
    public function rules()
    {
        return [
            [['id', 'add_who', 'edit_who','id_perusahaan'], 'integer'],
            [['barcode', 'tanggal', 'add_date', 'edit_date','tgl_a','tgl_b'], 'safe'],
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
        $query = Barcode::find();

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
            'tanggal' => $this->tanggal,
            'add_who' => $this->add_who,
            'edit_who' => $this->edit_who,
            'add_date' => $this->add_date,
            'id_perusahaan' => Yii::$app->user->identity->id_perusahaan,
            'edit_date' => $this->edit_date,
        ]);

        $query->andFilterWhere(['like', 'barcode', $this->barcode])
         ->andFilterWhere(['>=', 'tanggal', $this->tgl_a])
            ->andFilterWhere(['<=', 'tanggal', $this->tgl_b]);

        return $dataProvider;
    }
}
