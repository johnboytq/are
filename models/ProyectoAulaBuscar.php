<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ProyectoAula;

/**
 * ProyectoAulaBuscar represents the model behind the search form of `app\models\ProyectoAula`.
 */
class ProyectoAulaBuscar extends ProyectoAula
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_grupo', 'id_jornada', 'id_persona_coordinador', 'avance_1', 'avance_2', 'avance_3', 'avance_4', 'id_sede', 'id'], 'integer'],
            [['nombre_proyecto', 'correo', 'celular', 'descripcion'], 'safe'],
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
        $query = ProyectoAula::find();

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
            'id_grupo' => $this->id_grupo,
            'id_jornada' => $this->id_jornada,
            'id_persona_coordinador' => $this->id_persona_coordinador,
            'avance_1' => $this->avance_1,
            'avance_2' => $this->avance_2,
            'avance_3' => $this->avance_3,
            'avance_4' => $this->avance_4,
            'id_sede' => $this->id_sede,
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['ilike', 'nombre_proyecto', $this->nombre_proyecto])
            ->andFilterWhere(['ilike', 'correo', $this->correo])
            ->andFilterWhere(['ilike', 'celular', $this->celular])
            ->andFilterWhere(['ilike', 'descripcion', $this->descripcion]);

        return $dataProvider;
    }
}
