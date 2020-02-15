<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\RangosCalificacion;

/**
 * RangosCalificacionBuscar represents the model behind the search form of `app\models\RangosCalificacion`.
 */
class RangosCalificacionBuscar extends RangosCalificacion
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_tipo_calificacion', 'id_instituciones', 'estado'], 'integer'],
            [['valor_minimo', 'valor_maximo'], 'number'],
            [['descripcion'], 'safe'],
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
        $query = RangosCalificacion::find();

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
            'valor_minimo' => $this->valor_minimo,
            'valor_maximo' => $this->valor_maximo,
            'id_tipo_calificacion' => $this->id_tipo_calificacion,
            'id_instituciones' => $this->id_instituciones,
            'estado' => $this->estado,
        ]);

        $query->andFilterWhere(['ilike', 'descripcion', $this->descripcion]);

        return $dataProvider;
    }
}
