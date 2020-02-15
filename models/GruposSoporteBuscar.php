<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\GruposSoporte;

/**
 * GruposSoporteBuscar represents the model behind the search form of `app\models\GruposSoporte`.
 */
class GruposSoporteBuscar extends GruposSoporte
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_tipo_grupos', 'id_sede', 'id_jornada_sede', 'edad_minima', 'edad_maxima', 'cantidad_participantes', 'id_docentes', 'estado'], 'integer'],
            [['descripcion', 'observaciones'], 'safe'],
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
        $query = GruposSoporte::find();

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
            'id_tipo_grupos' => $this->id_tipo_grupos,
            'id_sede' => $this->id_sede,
            'id_jornada_sede' => $this->id_jornada_sede,
            'edad_minima' => $this->edad_minima,
            'edad_maxima' => $this->edad_maxima,
            'cantidad_participantes' => $this->cantidad_participantes,
            'id_docentes' => $this->id_docentes,
            'estado' => $this->estado,
        ]);

        $query->andFilterWhere(['ilike', 'descripcion', $this->descripcion])
            ->andFilterWhere(['ilike', 'observaciones', $this->observaciones]);

        return $dataProvider;
    }
}
