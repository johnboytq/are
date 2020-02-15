<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "semilleros_tic.instrumento_poblacion_estudiantes".
 *
 * @property string $id
 * @property string $id_institucion
 * @property string $id_sede
 * @property string $id_persona_estudiante
 * @property string $estado
 */
class InstrumentoPoblacionEstudiantes extends \yii\db\ActiveRecord
{
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'semilleros_tic.instrumento_poblacion_estudiantes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_institucion', 'id_sede', 'id_persona_estudiante', 'estado'], 'required'],
            [['id_institucion', 'id_sede', 'id_persona_estudiante', 'estado'], 'default', 'value' => null],
            [['id_institucion', 'id_sede', 'id_persona_estudiante', 'estado'], 'integer'],
            [['id_institucion'], 'exist', 'skipOnError' => true, 'targetClass' => Instituciones::className(), 'targetAttribute' => ['id_institucion' => 'id']],
            [['id_persona_estudiante'], 'exist', 'skipOnError' => true, 'targetClass' => Personas::className(), 'targetAttribute' => ['id_persona_estudiante' => 'id']],
            [['id_sede'], 'exist', 'skipOnError' => true, 'targetClass' => Sedes::className(), 'targetAttribute' => ['id_sede' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' 					=> 'ID',
            'id_institucion' 		=> 'Institución',
            'id_sede' 				=> 'Sede',
            'id_persona_estudiante' => 'Estudiante',
            'estado' 				=> 'Estado',
        ];
    }
}
