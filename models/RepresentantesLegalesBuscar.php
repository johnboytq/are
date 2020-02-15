<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\RepresentantesLegales;

/**
 * RepresentantesLegalesBuscar represents the model behind the search form of `app\models\RepresentantesLegales`.
 */
class RepresentantesLegalesBuscar extends RepresentantesLegales
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_perfiles_x_personas', 'id_personas', 'id'], 'integer'],
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
        $query = RepresentantesLegales::find();

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
            'id_perfiles_x_personas' => $this->id_perfiles_x_personas,
            'id_personas' => $this->id_personas,
            'id' => $this->id,
        ]);

        return $dataProvider;
    }
}
