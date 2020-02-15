<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PersonasDiscapacidades;

/**
 * PersonasDiscapacidadesBuscar represents the model behind the search form of `app\models\PersonasDiscapacidades`.
 */
class PersonasDiscapacidadesBuscar extends PersonasDiscapacidades
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_personas', 'id_tipos_discapacidades'], 'integer'],
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
        $query = PersonasDiscapacidades::find();

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
            'id_personas' => $this->id_personas,
            'id_tipos_discapacidades' => $this->id_tipos_discapacidades,
        ]);

        $query->andFilterWhere(['ilike', 'descripcion', $this->descripcion]);

        return $dataProvider;
    }
}
