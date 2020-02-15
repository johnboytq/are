<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\RecursosInfraestructuraFisica;

/**
 * RecursosInfraestructuraFisicaBuscar represents the model behind the search form of `app\models\RecursosInfraestructuraFisica`.
 */
class RecursosInfraestructuraFisicaBuscar extends RecursosInfraestructuraFisica
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'cantidad_aulas_regulares', 'cantidad_aulas_multiples', 'cantidad_oficinas_admin', 'cantidad_aulas_profesores', 'cantidad_espacios_deportivos', 'cantidad_baterias_sanitarias', 'cantidad_laboratorios', 'cantidad_portatiles', 'cantidad_computadores', 'cantidad_tabletas', 'cantidad_bibliotecas_salas_lectura', 'id_sede', 'estado'], 'integer'],
            [['programas_informaticos_admin'], 'safe'],
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
        $query = RecursosInfraestructuraFisica::find();

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
            'cantidad_aulas_regulares' => $this->cantidad_aulas_regulares,
            'cantidad_aulas_multiples' => $this->cantidad_aulas_multiples,
            'cantidad_oficinas_admin' => $this->cantidad_oficinas_admin,
            'cantidad_aulas_profesores' => $this->cantidad_aulas_profesores,
            'cantidad_espacios_deportivos' => $this->cantidad_espacios_deportivos,
            'cantidad_baterias_sanitarias' => $this->cantidad_baterias_sanitarias,
            'cantidad_laboratorios' => $this->cantidad_laboratorios,
            'cantidad_portatiles' => $this->cantidad_portatiles,
            'cantidad_computadores' => $this->cantidad_computadores,
            'cantidad_tabletas' => $this->cantidad_tabletas,
            'cantidad_bibliotecas_salas_lectura' => $this->cantidad_bibliotecas_salas_lectura,
            'id_sede' => $this->id_sede,
            'estado' => $this->estado,
        ]);

        $query->andFilterWhere(['ilike', 'programas_informaticos_admin', $this->programas_informaticos_admin]);

        return $dataProvider;
    }
}
