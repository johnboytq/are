<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ProyectosPedagogicosTransversales;

/**
 * ProyectosPedagogicosTransversalesBuscar represents the model behind the search form of `app\models\ProyectosPedagogicosTransversales`.
 */
class ProyectosPedagogicosTransversalesBuscar extends ProyectosPedagogicosTransversales
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'codigo_grupo', 'coordinador', 'area', 'estado'], 'integer'],
            [['nombre_grupo', 'correo', 'celular', 'linea_investigacion_1', 'linea_investigacion_2', 'linea_investigacion_3'], 'safe'],
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
        $query = ProyectosPedagogicosTransversales::find();

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
            'codigo_grupo' => $this->codigo_grupo,
            'coordinador' => $this->coordinador,
            'area' => $this->area,
            'estado' => $this->estado,
        ]);

        $query->andFilterWhere(['ilike', 'nombre_grupo', $this->nombre_grupo])
            ->andFilterWhere(['ilike', 'correo', $this->correo])
            ->andFilterWhere(['ilike', 'celular', $this->celular])
            ->andFilterWhere(['ilike', 'linea_investigacion_1', $this->linea_investigacion_1])
            ->andFilterWhere(['ilike', 'linea_investigacion_2', $this->linea_investigacion_2])
            ->andFilterWhere(['ilike', 'linea_investigacion_3', $this->linea_investigacion_3]);

        return $dataProvider;
    }
}
