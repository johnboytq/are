<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\DocumentosInstanciasInstitucionales;

/**
 * DocumentosInstanciasInstitucionalesBuscar represents the model behind the search form of `app\models\DocumentosInstanciasInstitucionales`.
 */
class DocumentosInstanciasInstitucionalesBuscar extends DocumentosInstanciasInstitucionales
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_tipo_documentos', 'id_instituciones', 'estado'], 'integer'],
            [['ruta'], 'safe'],
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
        $query = DocumentosInstanciasInstitucionales::find();

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
            'id_tipo_documentos' => $this->id_tipo_documentos,
            'id_instituciones' => $this->id_instituciones,
            'estado' => $this->estado,
        ]);

        $query->andFilterWhere(['ilike', 'ruta', $this->ruta]);

        return $dataProvider;
    }
}
