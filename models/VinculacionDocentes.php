<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vinculacion_docentes".
 *
 * @property string $id
 * @property string $resolucion_numero
 * @property string $resolucion_desde
 * @property string $antiguedad
 * @property string $id_perfiles_x_personas_docentes
 * @property string $id_tipos_contratos
 * @property string $estado
 *
 * @property Docentes $perfilesXPersonasDocentes
 * @property Estados $estado0
 * @property TiposContratos $tiposContratos
 */
class VinculacionDocentes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vinculacion_docentes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['resolucion_desde'], 'safe'],
            [['id_perfiles_x_personas_docentes', 'id_tipos_contratos', 'estado'], 'default', 'value' => null],
            [['id_perfiles_x_personas_docentes'], 'required' ],
            [['id_perfiles_x_personas_docentes', 'id_tipos_contratos', 'estado'], 'integer'],
            [['resolucion_numero', 'antiguedad'], 'string', 'max' => 30],
            [['id_perfiles_x_personas_docentes'], 'exist', 'skipOnError' => true, 'targetClass' => Docentes::className(), 'targetAttribute' => ['id_perfiles_x_personas_docentes' => 'id_perfiles_x_personas']],
            [['estado'], 'exist', 'skipOnError' => true, 'targetClass' => Estados::className(), 'targetAttribute' => ['estado' => 'id']],
            [['id_tipos_contratos'], 'exist', 'skipOnError' => true, 'targetClass' => TiposContratos::className(), 'targetAttribute' => ['id_tipos_contratos' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'resolucion_numero' => 'Número de resolución',
            'resolucion_desde' => 'Fecha de resolución',
            'antiguedad' => 'Antigüedad',
            'id_perfiles_x_personas_docentes' => 'Perfiles por personas por docentes',
            'id_tipos_contratos' => 'Tipo de contrato',
            'estado' => 'Estado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerfilesXPersonasDocentes()
    {
        return $this->hasOne(Docentes::className(), ['id_perfiles_x_personas' => 'id_perfiles_x_personas_docentes']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstado0()
    {
        return $this->hasOne(Estados::className(), ['id' => 'estado']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTiposContratos()
    {
        return $this->hasOne(TiposContratos::className(), ['id' => 'id_tipos_contratos']);
    }
}
