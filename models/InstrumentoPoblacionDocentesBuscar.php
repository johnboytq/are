<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\InstrumentoPoblacionDocentes;

/**
 * InstrumentoPoblacionDocentesBuscar represents the model behind the search form of `app\models\InstrumentoPoblacionDocentes`.
 */
class InstrumentoPoblacionDocentesBuscar extends InstrumentoPoblacionDocentes
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_institucion', 'id_sede', 'id_persona', 'id_escalafon', 'id_asignaturas_niveles_sedes', 'id_niveles', 'estado'], 'integer'],
            [['profesion', 'ultimo_nivel'], 'safe'],
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
        $query = InstrumentoPoblacionDocentes::find();

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
            'id_sede' => $this->id_sede,
            'id_persona' => $this->id_persona,
            'id_escalafon' => $this->id_escalafon,
            'id_asignaturas_niveles_sedes' => $this->id_asignaturas_niveles_sedes,
            'id_niveles' => $this->id_niveles,
            'estado' => $this->estado,
        ]);

        $query->andFilterWhere(['ilike', 'profesion', $this->profesion])
            ->andFilterWhere(['ilike', 'ultimo_nivel', $this->ultimo_nivel]);

        return $dataProvider;
    }
}
