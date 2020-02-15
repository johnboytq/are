<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\RecursoInfraestructuraPedagogica;

/**
 * RecursoInfraestructuraPedagogicaBuscar represents the model behind the search form of `app\models\RecursoInfraestructuraPedagogica`.
 */
class RecursoInfraestructuraPedagogicaBuscar extends RecursoInfraestructuraPedagogica
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'cantidad_computdores_portatiles', 'cantidad_aulas_tita', 'cantidad_bibliotecas', 'cantidad_ludotecas', 'cantidad_salones_juegos', 'id_sede', 'estado'], 'integer'],
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
        $query = RecursoInfraestructuraPedagogica::find();

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
            'cantidad_computdores_portatiles' => $this->cantidad_computdores_portatiles,
            'cantidad_aulas_tita' => $this->cantidad_aulas_tita,
            'cantidad_bibliotecas' => $this->cantidad_bibliotecas,
            'cantidad_ludotecas' => $this->cantidad_ludotecas,
            'cantidad_salones_juegos' => $this->cantidad_salones_juegos,
            'id_sede' => $this->id_sede,
            'estado' => $this->estado,
        ]);

        return $dataProvider;
    }
}
