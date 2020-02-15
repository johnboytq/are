<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ParticipacionProyectosJornada;

/**
 * ParticipacionProyectosJornadaBuscar represents the model behind the search form of `app\models\ParticipacionProyectosJornada`.
 */
class ParticipacionProyectosJornadaBuscar extends ParticipacionProyectosJornada
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'nombre_programa', 'nombre_participante', 'tipo', 'id_institucion', 'estado'], 'integer'],
            [['objetivo', 'duracion', 'ano_inicio', 'ano_fin', 'tematica', 'areas', 'otros', 'materiales_recursos', 'logros', 'observaciones'], 'safe'],
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
        $query = ParticipacionProyectosJornada::find();

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
            'nombre_programa' => $this->nombre_programa,
            'nombre_participante' => $this->nombre_participante,
            'tipo' => $this->tipo,
            'id_institucion' => $this->id_institucion,
            'estado' => $this->estado,
        ]);

        $query->andFilterWhere(['ilike', 'objetivo', $this->objetivo])
            ->andFilterWhere(['ilike', 'duracion', $this->duracion])
            ->andFilterWhere(['ilike', 'ano_inicio', $this->ano_inicio])
            ->andFilterWhere(['ilike', 'ano_fin', $this->ano_fin])
            ->andFilterWhere(['ilike', 'tematica', $this->tematica])
            ->andFilterWhere(['ilike', 'areas', $this->areas])
            ->andFilterWhere(['ilike', 'otros', $this->otros])
            ->andFilterWhere(['ilike', 'materiales_recursos', $this->materiales_recursos])
            ->andFilterWhere(['ilike', 'logros', $this->logros])
            ->andFilterWhere(['ilike', 'observaciones', $this->observaciones]);

        return $dataProvider;
    }
}
