<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\AsignaturasNivelesSedes;

/**
 * AsignaturasNivelesSedesBuscar represents the model behind the search form of `app\models\AsignaturasNivelesSedes`.
 */
class AsignaturasNivelesSedesBuscar extends AsignaturasNivelesSedes
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_sedes_niveles', 'id_asignaturas', 'intensidad'], 'integer'],
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
        $query = AsignaturasNivelesSedes::find();

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
            'id_sedes_niveles' => $this->id_sedes_niveles,
            'id_asignaturas' => $this->id_asignaturas,
            'intensidad' => $this->intensidad,
        ]);

        return $dataProvider;
    }
}
