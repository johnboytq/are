<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SemillerosDatosIeoEstudiantes;

/**
 * SemillerosDatosIeoEstudiantesBuscar represents the model behind the search form of `app\models\SemillerosDatosIeoEstudiantes`.
 */
class SemillerosDatosIeoEstudiantesBuscar extends SemillerosDatosIeoEstudiantes
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_institucion', 'profecional_a', 'estado', 'id_sede'], 'integer'],
            [['docente_aliado'], 'safe'],
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
        $query = SemillerosDatosIeoEstudiantes::find();

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
            'id_institucion' => $this->id_institucion,
            'profecional_a' => $this->profecional_a,
            'estado' => $this->estado,
            'id_sede' => $this->id_sede,
        ]);

        $query->andFilterWhere(['ilike', 'docente_aliado', $this->docente_aliado]);

        return $dataProvider;
    }
}
