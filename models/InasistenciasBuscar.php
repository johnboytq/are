<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Inasistencias;

/**
 * InasistenciasBuscar represents the model behind the search form of `app\models\Inasistencias`.
 */
class InasistenciasBuscar extends Inasistencias
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_perfiles_x_personas_estudiantes', 'id_distribuciones_academicas', 'estado'], 'integer'],
            [['justificada'], 'boolean'],
            [['fecha', 'justificacion', 'fecha_ing'], 'safe'],
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
        $query = Inasistencias::find();

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
            'id_perfiles_x_personas_estudiantes' => $this->id_perfiles_x_personas_estudiantes,
            'justificada' => $this->justificada,
            'id_distribuciones_academicas' => $this->id_distribuciones_academicas,
            'fecha' => $this->fecha,
            'estado' => $this->estado,
            'fecha_ing' => $this->fecha_ing,
        ]);

        $query->andFilterWhere(['ilike', 'justificacion', $this->justificacion]);

        return $dataProvider;
    }
}
