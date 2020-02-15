<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\GestionCurricularDocenteTutorAcompanamiento;

/**
 * GestionCurricularDocenteTutorAcompanamientoBuscar represents the model behind the search form of `app\models\GestionCurricularDocenteTutorAcompanamiento`.
 */
class GestionCurricularDocenteTutorAcompanamientoBuscar extends GestionCurricularDocenteTutorAcompanamiento
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_docente', 'id_institucion', 'id_sede'], 'integer'],
            [['fecha', 'nombre_profesional_acompanamiento'], 'safe'],
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
        $query = GestionCurricularDocenteTutorAcompanamiento::find();

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
            'id_docente' => $this->id_docente,
            'id_institucion' => $this->id_institucion,
            'id_sede' => $this->id_sede,
        ]);

        $query->andFilterWhere(['ilike', 'nombre_profesional_acompanamiento', $this->nombre_profesional_acompanamiento]);

        return $dataProvider;
    }
}
