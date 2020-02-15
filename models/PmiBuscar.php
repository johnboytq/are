<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Pmi;

/**
 * PmiBuscar represents the model behind the search form of `app\models\Pmi`.
 */
class PmiBuscar extends Pmi
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'comuna', 'id_proceso_especifico', 'id_institucion', 'estado'], 'integer'],
            [['codigo_dane', 'anio', 'zona', 'valor'], 'safe'],
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
        $query = Pmi::find();

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
            'comuna' => $this->comuna,
            'id_proceso_especifico' => $this->id_proceso_especifico,
            'id_institucion' => $this->id_institucion,
            'estado' => $this->estado,
        ]);

        $query->andFilterWhere(['ilike', 'codigo_dane', $this->codigo_dane])
            ->andFilterWhere(['ilike', 'anio', $this->anio])
            ->andFilterWhere(['ilike', 'zona', $this->zona])
            ->andFilterWhere(['ilike', 'valor', $this->valor]);

        return $dataProvider;
    }
}
