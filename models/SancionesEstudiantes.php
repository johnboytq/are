<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sanciones_estudiantes".
 *
 * @property string $id
 * @property string $fecha
 * @property string $descripcion
 * @property string $id_perfiles_persona
 * @property string $estado
 *
 * @property Estados $estado0
 * @property PerfilesXPersonas $perfilesPersona
 */
class SancionesEstudiantes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sanciones_estudiantes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fecha', 'descripcion', 'id_perfiles_persona', 'estado'], 'required'],
            [['fecha'], 'safe'],
            [['id_perfiles_persona', 'estado'], 'default', 'value' => null],
            [['id_perfiles_persona', 'estado'], 'integer'],
            [['descripcion'], 'string', 'max' => 700],
            [['estado'], 'exist', 'skipOnError' => true, 'targetClass' => Estados::className(), 'targetAttribute' => ['estado' => 'id']],
            [['id_perfiles_persona'], 'exist', 'skipOnError' => true, 'targetClass' => PerfilesXPersonas::className(), 'targetAttribute' => ['id_perfiles_persona' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fecha' => 'Fecha',
            'descripcion' => 'Descripción',
            'id_perfiles_persona' => 'Estudiante',
            'estado' => 'Estado',
        ];
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
    public function getPerfilesPersona()
    {
        return $this->hasOne(PerfilesXPersonas::className(), ['id' => 'id_perfiles_persona']);
    }
}
