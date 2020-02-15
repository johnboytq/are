<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SedesAreasEnsenanza;

/**
 * SedesAreasEnsenanzaBuscar represents the model behind the search form of `app\models\SedesAreasEnsenanza`.
 */
class SedesAreasEnsenanzaBuscar extends SedesAreasEnsenanza
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_sedes', 'id_areas_ensenanza'], 'integer'],
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
        $query = SedesAreasEnsenanza::find();

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
            'id_sedes' => $this->id_sedes,
            'id_areas_ensenanza' => $this->id_areas_ensenanza,
        ]);

        return $dataProvider;
    }
}
