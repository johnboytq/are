<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Instituciones;

/**
 * InstitucionesBuscar represents the model behind the search form of `app\models\Instituciones`.
 */
class InstitucionesBuscar extends Instituciones
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_tipos_instituciones', 'id_sectores', 'estado'], 'integer'],
            [['descripcion', 'nit', 'caracter', 'especialidad', 'rector', 'contacto_rector', 'correo_electronico_institucional', 'pagina_web', 'codigo_dane'], 'safe'],
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
        $query = Instituciones::find();

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
            'id_tipos_instituciones' => $this->id_tipos_instituciones,
            'id_sectores' => $this->id_sectores,
            'estado' => $this->estado,
        ]);

        $query->andFilterWhere(['ilike', 'descripcion', $this->descripcion])
            ->andFilterWhere(['ilike', 'nit', $this->nit])
            ->andFilterWhere(['ilike', 'caracter', $this->caracter])
            ->andFilterWhere(['ilike', 'especialidad', $this->especialidad])
            ->andFilterWhere(['ilike', 'rector', $this->rector])
            ->andFilterWhere(['ilike', 'contacto_rector', $this->contacto_rector])
            ->andFilterWhere(['ilike', 'correo_electronico_institucional', $this->correo_electronico_institucional])
            ->andFilterWhere(['ilike', 'pagina_web', $this->pagina_web])
            ->andFilterWhere(['ilike', 'codigo_dane', $this->codigo_dane]);

        return $dataProvider;
    }
}
