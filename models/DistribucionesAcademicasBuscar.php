<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\DistribucionesAcademicas;

/**
 * DistribucionesAcademicasBuscar represents the model behind the search form of `app\models\DistribucionesAcademicas`.
 */
class DistribucionesAcademicasBuscar extends DistribucionesAcademicas
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_asignaturas_x_niveles_sedes', 'id_perfiles_x_personas_docentes', 'id_aulas_x_sedes', 'estado', 'id_paralelo_sede'], 'integer'],
            [['fecha_ingreso'], 'safe'],
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
        $query = DistribucionesAcademicas::find();

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
            'id_asignaturas_x_niveles_sedes' => $this->id_asignaturas_x_niveles_sedes,
            'id_perfiles_x_personas_docentes' => $this->id_perfiles_x_personas_docentes,
            'id_aulas_x_sedes' => $this->id_aulas_x_sedes,
            'fecha_ingreso' => $this->fecha_ingreso,
            'estado' => $this->estado,
            'id_paralelo_sede' => $this->id_paralelo_sede,
        ]);

        return $dataProvider;
    }
}
