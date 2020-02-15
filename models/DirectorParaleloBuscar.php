<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\DirectorParalelo;

/**
 * DirectorParaleloBuscar represents the model behind the search form of `app\models\DirectorParalelo`.
 */
class DirectorParaleloBuscar extends DirectorParalelo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_paralelo', 'id_perfiles_x_personas_docentes', 'estado'], 'integer'],
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
        $query = DirectorParalelo::find();

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
            'id_paralelo' => $this->id_paralelo,
            'id_perfiles_x_personas_docentes' => $this->id_perfiles_x_personas_docentes,
            'estado' => $this->estado,
        ]);

        return $dataProvider;
    }
}
