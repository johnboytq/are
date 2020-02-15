<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Personas;

/**
 * PersonasBuscar represents the model behind the search form of `app\models\Personas`.
 */
class PersonasBuscar extends Personas
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_municipios', 'id_tipos_identificaciones', 'id_estados_civiles', 'id_generos', 'id_barrios_veredas', 'estado'], 'integer'],
            [['usuario', 'psw', 'identificacion', 'nombres', 'apellidos', 'telefonos', 'fecha_nacimiento', 'fecha_registro', 'correo', 'domicilio', 'fecha_ultimo_ingreso', 'hobbies'], 'safe'],
            [['envio_correo'], 'boolean'],
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
        $query = Personas::find();

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
            'fecha_nacimiento' => $this->fecha_nacimiento,
            'fecha_registro' => $this->fecha_registro,
            'fecha_ultimo_ingreso' => $this->fecha_ultimo_ingreso,
            'envio_correo' => $this->envio_correo,
            'id_municipios' => $this->id_municipios,
            'id_tipos_identificaciones' => $this->id_tipos_identificaciones,
            'latitud' => $this->latitud,
            'longitud' => $this->longitud,
            'id_estados_civiles' => $this->id_estados_civiles,
            'id_generos' => $this->id_generos,
            'id_barrios_veredas' => $this->id_barrios_veredas,
            'estado' => $this->estado,
        ]);

        $query->andFilterWhere(['ilike', 'usuario', $this->usuario])
            ->andFilterWhere(['ilike', 'psw', $this->psw])
            ->andFilterWhere(['ilike', 'identificacion', $this->identificacion])
            ->andFilterWhere(['ilike', 'nombres', $this->nombres])
            ->andFilterWhere(['ilike', 'apellidos', $this->apellidos])
            ->andFilterWhere(['ilike', 'telefonos', $this->telefonos])
            ->andFilterWhere(['ilike', 'correo', $this->correo])
            ->andFilterWhere(['ilike', 'domicilio', $this->domicilio])
            ->andFilterWhere(['ilike', 'hobbies', $this->hobbies]);

        return $dataProvider;
    }
}
