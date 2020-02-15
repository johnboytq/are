<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\EjecucionFase;

/**
 * EjecucionFaseIBuscar represents the model behind the search form of `app\models\EjecucionFase`.
 */
class EjecucionFaseIBuscar extends EjecucionFase
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_fase', 'id_datos_sesiones', 'id_datos_ieo_profesional', 'estado'], 'integer'],
            [['docente', 'asignaturas', 'especiaidad', 'paricipacion_sesiones', 'numero_apps', 'seiones_empleadas', 'acciones_realiadas', 'temas_problama', 'tipo_conpetencias', 'observaciones', 'numero_sesiones_docente'], 'safe'],
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
        $query = EjecucionFase::find();

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
            'id_fase' => $this->id_fase,
            'id_datos_sesiones' => $this->id_datos_sesiones,
            'id_datos_ieo_profesional' => $this->id_datos_ieo_profesional,
            'estado' => $this->estado,
        ]);

        $query->andFilterWhere(['ilike', 'docente', $this->docente])
            ->andFilterWhere(['ilike', 'asignaturas', $this->asignaturas])
            ->andFilterWhere(['ilike', 'especiaidad', $this->especiaidad])
            ->andFilterWhere(['ilike', 'paricipacion_sesiones', $this->paricipacion_sesiones])
            ->andFilterWhere(['ilike', 'numero_apps', $this->numero_apps])
            ->andFilterWhere(['ilike', 'seiones_empleadas', $this->seiones_empleadas])
            ->andFilterWhere(['ilike', 'acciones_realiadas', $this->acciones_realiadas])
            ->andFilterWhere(['ilike', 'temas_problama', $this->temas_problama])
            ->andFilterWhere(['ilike', 'tipo_conpetencias', $this->tipo_conpetencias])
            ->andFilterWhere(['ilike', 'observaciones', $this->observaciones])
            ->andFilterWhere(['ilike', 'numero_sesiones_docente', $this->numero_sesiones_docente]);

        return $dataProvider;
    }
}
