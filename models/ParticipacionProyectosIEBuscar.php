<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ParticipacionProyectosIE;

/**
 * ParticipacionProyectosIEBuscar represents the model behind the search form of `app\models\ParticipacionProyectosIE`.
 */
class ParticipacionProyectosIEBuscar extends ParticipacionProyectosIE
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'programa_proyecto', 'id_institucion', 'estado'], 'integer'],
            [['participacion'], 'boolean'],
            [['operador', 'entidad_financia', 'objetivo', 'duracion', 'anio_inicio', 'anio_finalizacion', 'tematica', 'areas', 'sedes', 'numero_docentes', 'numero_estudiantes', 'numero_padres', 'numero_directivos', 'otros', 'materiales_recursos', 'logros', 'observaciones'], 'safe'],
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
        $query = ParticipacionProyectosIE::find();

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
            'programa_proyecto' => $this->programa_proyecto,
            'participacion' => $this->participacion,
            'id_institucion' => $this->id_institucion,
            'estado' => $this->estado,
        ]);

        $query->andFilterWhere(['ilike', 'operador', $this->operador])
            ->andFilterWhere(['ilike', 'entidad_financia', $this->entidad_financia])
            ->andFilterWhere(['ilike', 'objetivo', $this->objetivo])
            ->andFilterWhere(['ilike', 'duracion', $this->duracion])
            ->andFilterWhere(['ilike', 'anio_inicio', $this->anio_inicio])
            ->andFilterWhere(['ilike', 'anio_finalizacion', $this->anio_finalizacion])
            ->andFilterWhere(['ilike', 'tematica', $this->tematica])
            ->andFilterWhere(['ilike', 'areas', $this->areas])
            ->andFilterWhere(['ilike', 'sedes', $this->sedes])
            ->andFilterWhere(['ilike', 'numero_docentes', $this->numero_docentes])
            ->andFilterWhere(['ilike', 'numero_estudiantes', $this->numero_estudiantes])
            ->andFilterWhere(['ilike', 'numero_padres', $this->numero_padres])
            ->andFilterWhere(['ilike', 'numero_directivos', $this->numero_directivos])
            ->andFilterWhere(['ilike', 'otros', $this->otros])
            ->andFilterWhere(['ilike', 'materiales_recursos', $this->materiales_recursos])
            ->andFilterWhere(['ilike', 'logros', $this->logros])
            ->andFilterWhere(['ilike', 'observaciones', $this->observaciones]);

        return $dataProvider;
    }
}
