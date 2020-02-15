<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ParticipacionProyectosMaestro;

/**
 * ParticipacionProyectosMaestroBuscar represents the model behind the search form of `app\models\ParticipacionProyectosMaestro`.
 */
class ParticipacionProyectosMaestroBuscar extends ParticipacionProyectosMaestro
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'programa_proyecto', 'participante', 'tipo', 'id_institucion', 'estado'], 'integer'],
            [['objeto', 'duracion', 'anio_inicio', 'anio_fin', 'tematica', 'areas', 'otros', 'materiales_recursos', 'logros', 'observaciones'], 'safe'],
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
        $query = ParticipacionProyectosMaestro::find();

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
            'participante' => $this->participante,
            'tipo' => $this->tipo,
            'id_institucion' => $this->id_institucion,
            'estado' => $this->estado,
        ]);

        $query->andFilterWhere(['ilike', 'objeto', $this->objeto])
            ->andFilterWhere(['ilike', 'duracion', $this->duracion])
            ->andFilterWhere(['ilike', 'anio_inicio', $this->anio_inicio])
            ->andFilterWhere(['ilike', 'anio_fin', $this->anio_fin])
            ->andFilterWhere(['ilike', 'tematica', $this->tematica])
            ->andFilterWhere(['ilike', 'areas', $this->areas])
            ->andFilterWhere(['ilike', 'otros', $this->otros])
            ->andFilterWhere(['ilike', 'materiales_recursos', $this->materiales_recursos])
            ->andFilterWhere(['ilike', 'logros', $this->logros])
            ->andFilterWhere(['ilike', 'observaciones', $this->observaciones]);

        return $dataProvider;
    }
}
