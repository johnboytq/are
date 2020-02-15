<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Sedes;

/**
 * SedesBuscar represents the model behind the search form of `app\models\Sedes`.
 */
class SedesBuscar extends Sedes
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'area', 'id_instituciones', 'id_zonificaciones', 'id_tenencias', 'id_modalidades', 'id_municipios', 'id_generos_sedes', 'id_calendarios', 'id_estratos', 'id_barrios_veredas', 'sede_principal', 'comuna', 'estado'], 'integer'],
            [['descripcion', 'telefonos', 'direccion', 'codigo_dane'], 'safe'],
            [['latitud', 'longitud'], 'number'],
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
        $query = Sedes::find();

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
            'area' => $this->area,
            'id_instituciones' => $this->id_instituciones,
            'latitud' => $this->latitud,
            'longitud' => $this->longitud,
            'id_zonificaciones' => $this->id_zonificaciones,
            'id_tenencias' => $this->id_tenencias,
            'id_modalidades' => $this->id_modalidades,
            'id_municipios' => $this->id_municipios,
            'id_generos_sedes' => $this->id_generos_sedes,
            'id_calendarios' => $this->id_calendarios,
            'id_estratos' => $this->id_estratos,
            'id_barrios_veredas' => $this->id_barrios_veredas,
            'sede_principal' => $this->sede_principal,
            'comuna' => $this->comuna,
            'estado' => $this->estado,
        ]);

        $query->andFilterWhere(['ilike', 'descripcion', $this->descripcion])
            ->andFilterWhere(['ilike', 'telefonos', $this->telefonos])
            ->andFilterWhere(['ilike', 'direccion', $this->direccion])
            ->andFilterWhere(['ilike', 'codigo_dane', $this->codigo_dane]);

        return $dataProvider;
    }
}
