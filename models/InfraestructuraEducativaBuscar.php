<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\InfraestructuraEducativa;

/**
 * InfraestructuraEducativaBuscar represents the model behind the search form of `app\models\InfraestructuraEducativa`.
 */
class InfraestructuraEducativaBuscar extends InfraestructuraEducativa
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_sede', 'estado'], 'integer'],
            [['objeto_intervencion'], 'boolean'],
            [['intervencion_infraestructura', 'alcance_intervencion', 'presupuesto', 'cumplimiento_pedido'], 'safe'],
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
        $query = InfraestructuraEducativa::find();

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
            'id_sede' => $this->id_sede,
            'objeto_intervencion' => $this->objeto_intervencion,
            'estado' => $this->estado,
        ]);

        $query->andFilterWhere(['ilike', 'intervencion_infraestructura', $this->intervencion_infraestructura])
            ->andFilterWhere(['ilike', 'alcance_intervencion', $this->alcance_intervencion])
            ->andFilterWhere(['ilike', 'presupuesto', $this->presupuesto])
            ->andFilterWhere(['ilike', 'cumplimiento_pedido', $this->cumplimiento_pedido]);

        return $dataProvider;
    }
}
