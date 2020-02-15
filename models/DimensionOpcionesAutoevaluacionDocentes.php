<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "gestion_curricular.dimension_opciones_autoevaluacion_docentes".
 *
 * @property string $id
 * @property string $descripcion
 * @property string $id_tipo_dimension
 * @property string $estado
 */
class DimensionOpcionesAutoevaluacionDocentes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gestion_curricular.dimension_opciones_autoevaluacion_docentes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['descripcion', 'id_tipo_dimension', 'estado'], 'required'],
            [['id_tipo_dimension', 'estado'], 'default', 'value' => null],
            [['id_tipo_dimension', 'estado'], 'integer'],
            [['descripcion'], 'string', 'max' => 800],
            [['estado'], 'exist', 'skipOnError' => true, 'targetClass' => Estados::className(), 'targetAttribute' => ['estado' => 'id']],
            [['id_tipo_dimension'], 'exist', 'skipOnError' => true, 'targetClass' => Parametro::className(), 'targetAttribute' => ['id_tipo_dimension' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'descripcion' => 'Descripcion',
            'id_tipo_dimension' => 'Id Tipo Dimension',
            'estado' => 'Estado',
        ];
    }
}
