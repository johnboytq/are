<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ApoyoAcademico;

/**
 * ApoyoAcademicoBuscar represents the model behind the search form of `app\models\ApoyoAcademico`.
 */
class ApoyoAcademicoBuscar extends ApoyoAcademico
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id','id_persona_estudiante', 'no_dias_incapaciad', 'id_sede', 'id_tipo_apoyo', 'estado'], 'integer'],
            [['registro', 'motivo_consulta', 'fecha_entrada', 'hora_entrada', 'fecha_salida', 'hora_salida', 'observaciones'], 'safe'],
            [['incapacidad', 'discapacidad'], 'boolean'],
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
        $query = ApoyoAcademico::find();

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
            'persona_doctor' => $this->persona_doctor,
            'id_persona_estudiante' => $this->id_persona_estudiante,
            'fecha_entrada' => $this->fecha_entrada,
            'hora_entrada' => $this->hora_entrada,
            'fecha_salida' => $this->fecha_salida,
            'hora_salida' => $this->hora_salida,
            'incapacidad' => $this->incapacidad,
            'no_dias_incapaciad' => $this->no_dias_incapaciad,
            'discapacidad' => $this->discapacidad,
            'id_sede' => $this->id_sede,
            'id_tipo_apoyo' => $this->id_tipo_apoyo,
            'estado' => $this->estado,
        ]);

        $query->andFilterWhere(['ilike', 'registro', $this->registro])
            ->andFilterWhere(['ilike', 'motivo_consulta', $this->motivo_consulta])
            ->andFilterWhere(['ilike', 'observaciones', $this->observaciones]);

        return $dataProvider;
    }
}
