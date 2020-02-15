<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\DocentesXAreasTrabajos;

/**
 * DocentesXAreasTrabajosBuscar represents the model behind the search form of `app\models\DocentesXAreasTrabajos`.
 */
class DocentesXAreasTrabajosBuscar extends DocentesXAreasTrabajos
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_perfiles_x_personas_docentes', 'id_areas_trabajos'], 'integer'],
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
        $query = DocentesXAreasTrabajos::find();

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
            'id_perfiles_x_personas_docentes' => $this->id_perfiles_x_personas_docentes,
            'id_areas_trabajos' => $this->id_areas_trabajos,
        ]);

        return $dataProvider;
    }
}
