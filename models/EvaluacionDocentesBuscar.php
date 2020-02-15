<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\EvaluacionDocentes;

/**
 * EvaluacionDocentesBuscar represents the model behind the search form of `app\models\EvaluacionDocentes`.
 */
class EvaluacionDocentesBuscar extends EvaluacionDocentes
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_perfiles_x_personas_docentes', 'estado'], 'integer'],
            [['fecha', 'descripcion', 'puntaje'], 'safe'],
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
        $query = EvaluacionDocentes::find();

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
            'fecha' => $this->fecha,
            'id_perfiles_x_personas_docentes' => $this->id_perfiles_x_personas_docentes,
            'estado' => $this->estado,
        ]);

        $query->andFilterWhere(['ilike', 'descripcion', $this->descripcion])
            ->andFilterWhere(['ilike', 'puntaje', $this->puntaje]);

        return $dataProvider;
    }
}
