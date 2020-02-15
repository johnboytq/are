<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\DistribucionesIndicadorDesempeno;

/**
 * DistribucionesIndicadorDesempenoBuscar represents the model behind the search form of `app\models\DistribucionesIndicadorDesempeno`.
 */
class DistribucionesIndicadorDesempenoBuscar extends DistribucionesIndicadorDesempeno
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_distribuciones', 'id_indicador_desempeno'], 'integer'],
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
        $query = DistribucionesIndicadorDesempeno::find();

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
            'id_distribuciones' => $this->id_distribuciones,
            'id_indicador_desempeno' => $this->id_indicador_desempeno,
        ]);

        return $dataProvider;
    }
}
