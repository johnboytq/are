<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PlanDeAula;

/**
 * PlanDeAulaBuscar represents the model behind the search form of `app\models\PlanDeAula`.
 */
class PlanDeAulaBuscar extends PlanDeAula
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_periodo', 'id_nivel', 'id_asignatura', 'estado', 'id_indicador_desempeno'], 'integer'],
            [['fecha', 'actividad', 'observaciones'], 'safe'],
            [['cognitivo_conocer', 'cognitivo_hacer', 'cognitivo_ser', 'personal', 'social'], 'boolean'],
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
        $query = PlanDeAula::find();

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
            'id_periodo' => $this->id_periodo,
            'id_nivel' => $this->id_nivel,
            'id_asignatura' => $this->id_asignatura,
            'fecha' => $this->fecha,
            'estado' => $this->estado,
            'id_indicador_desempeno' => $this->id_indicador_desempeno,
            'cognitivo_conocer' => $this->cognitivo_conocer,
            'cognitivo_hacer' => $this->cognitivo_hacer,
            'cognitivo_ser' => $this->cognitivo_ser,
            'personal' => $this->personal,
            'social' => $this->social,
        ]);

        $query->andFilterWhere(['ilike', 'actividad', $this->actividad])
            ->andFilterWhere(['ilike', 'observaciones', $this->observaciones]);

        return $dataProvider;
    }
}
