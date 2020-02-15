<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Calificaciones;

/**
 * CalificacionesBuscar represents the model behind the search form of `app\models\Calificaciones`.
 */
class CalificacionesBuscar extends Calificaciones
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_perfiles_x_personas_docentes', 'id_perfiles_x_personas_estudiantes', 'id_distribuciones_x_indicador_desempeno', 'estado'], 'integer'],
            [['calificacion'], 'number'],
            [['fecha', 'observaciones', 'fecha_modificacion'], 'safe'],
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
        $query = Calificaciones::find();

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
            'calificacion' => $this->calificacion,
            'fecha' => $this->fecha,
            'id_perfiles_x_personas_docentes' => $this->id_perfiles_x_personas_docentes,
            'id_perfiles_x_personas_estudiantes' => $this->id_perfiles_x_personas_estudiantes,
            'id_distribuciones_x_indicador_desempeno' => $this->id_distribuciones_x_indicador_desempeno,
            'fecha_modificacion' => $this->fecha_modificacion,
            'estado' => $this->estado,
        ]);

        $query->andFilterWhere(['ilike', 'observaciones', $this->observaciones]);

        return $dataProvider;
    }
}
