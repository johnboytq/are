<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ParticipantesGruposSoporte;

/**
 * ParticipantesGruposSoporteBuscar represents the model behind the search form of `app\models\ParticipantesGruposSoporte`.
 */
class ParticipantesGruposSoporteBuscar extends ParticipantesGruposSoporte
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_grupo_soporte', 'id_sede', 'estado', 'id_persona'], 'integer'],
            [['edad', 'nombre_equipo'], 'safe'],
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
        $query = ParticipantesGruposSoporte::find();

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
            'id_grupo_soporte' => $this->id_grupo_soporte,
            'id_sede' => $this->id_sede,
            'estado' => $this->estado,
            'id_persona' => $this->id_persona,
        ]);

        $query->andFilterWhere(['ilike', 'edad', $this->edad])
            ->andFilterWhere(['ilike', 'nombre_equipo', $this->nombre_equipo]);

        return $dataProvider;
    }
}
