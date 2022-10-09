<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Scan;

/**
 * ScanSearch represents the model behind the search form about `app\models\Scan`.
 */
class ScanSearch extends Scan
{
    /**
     * @inheritdoc
     */
    public $tgl_a;
    public $tgl_b;

    public function rules()
    {
        return [
            [['id', 'id_grup', 'id_perusahaan', 'status', 'add_who', 'edit_who'], 'integer'],
            [['barcode', 'kode', 'tanggal', 'add_date', 'edit_date','tgl_a','tgl_b'], 'safe'],
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
        $query = Scan::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        if(Yii::$app->user->identity->tipe_user==0){

        $query->andFilterWhere([
            'id' => $this->id,
            'id_grup' => $this->id_grup,
            'tanggal' => $this->tanggal,
            'id_perusahaan' => Yii::$app->user->identity->id_perusahaan,
            'status' => $this->status,
            'add_who' => $this->add_who,
            'add_date' => $this->add_date,
            'edit_who' => $this->edit_who,
            'edit_date' => $this->edit_date,
        ]);
        } elseif(Yii::$app->user->identity->tipe_user==3) {

        $query->andFilterWhere([
            'id' => $this->id,
            'id_grup' => $this->id_grup,
            'tanggal' => $this->tanggal,
            'id_perusahaan' => Yii::$app->user->identity->id_perusahaan,
            'status' => $this->status,
            'add_who' => $this->add_who,
            'add_date' => $this->add_date,
            'edit_who' => $this->edit_who,
            'edit_date' => $this->edit_date,
        ]);
            
        } else {
        $query->andFilterWhere([
            'id' => $this->id,
            'id_grup' => $this->id_grup,
            'tanggal' => $this->tanggal,
            'id_perusahaan' => Yii::$app->user->identity->id_perusahaan,
            'status' => $this->status,
            'add_who' => Yii::$app->user->identity->id,
            'add_date' => $this->add_date,
            'edit_who' => $this->edit_who,
            'edit_date' => $this->edit_date,
        ]);

        }

        $query->andFilterWhere(['like', 'barcode', $this->barcode])
            ->andFilterWhere(['>=', 'tanggal', $this->tgl_a])
            ->andFilterWhere(['<=', 'tanggal', $this->tgl_b])
            ->andFilterWhere(['like', 'kode', $this->kode]);

        return $dataProvider;
    }
}
