<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\VinculacionDocentes;

/**
 * VinculacionDocentesBuscar represents the model behind the search form of `app\models\VinculacionDocentes`.
 */
class VinculacionDocentesBuscar extends VinculacionDocentes
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_perfiles_x_personas_docentes', 'id_tipos_contratos', 'estado'], 'integer'],
            [['resolucion_numero', 'resolucion_desde', 'antiguedad'], 'safe'],
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
        $query = VinculacionDocentes::find();

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
            'resolucion_desde' => $this->resolucion_desde,
            'id_perfiles_x_personas_docentes' => $this->id_perfiles_x_personas_docentes,
            'id_tipos_contratos' => $this->id_tipos_contratos,
            'estado' => $this->estado,
        ]);

        $query->andFilterWhere(['ilike', 'resolucion_numero', $this->resolucion_numero])
            ->andFilterWhere(['ilike', 'antiguedad', $this->antiguedad]);

        return $dataProvider;
    }
}
