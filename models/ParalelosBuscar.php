<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Paralelos;

/**
 * ParalelosBuscar represents the model behind the search form of `app\models\Paralelos`.
 */
class ParalelosBuscar extends Paralelos
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_sedes_jornadas', 'id_sedes_niveles', 'ano_lectivo', 'estado', 'capacidad', 'numero_matriculados'], 'integer'],
            [['descripcion', 'fecha_ingreso'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Paralelos::find();

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
            'id_sedes_jornadas' => $this->id_sedes_jornadas,
            'id_sedes_niveles' => $this->id_sedes_niveles,
            'ano_lectivo' => $this->ano_lectivo,
            'fecha_ingreso' => $this->fecha_ingreso,
            'estado' => $this->estado,
            'capacidad' => $this->capacidad,
            'numero_matriculados' => $this->numero_matriculados,
        ]);

        $query->andFilterWhere(['ilike', 'descripcion', $this->descripcion]);

        return $dataProvider;
    }
}
