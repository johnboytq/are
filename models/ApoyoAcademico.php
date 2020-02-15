<?php

/**********
Versión: 001
Fecha: 16-04-2018
Desarrollador: Oscar David Lopez
Descripción: CRUD de Apoyo Academico
---------------------------------------
Modificaciones:
Fecha: 12-06-2018
Persona encargada: Edwin Molina Grisales
Cambios realizados: - Se agrega campo remitido a EPS
---------------------------------------
**********/

namespace app\models;

use Yii;

/**
 * This is the model class for table "apoyo_academico".
 *
 * @property string $id
 * @property string $persona_doctor
 * @property string $registro
 * @property string $id_persona_estudiante
 * @property string $motivo_consulta
 * @property string $fecha_entrada
 * @property string $hora_entrada
 * @property string $fecha_salida
 * @property string $hora_salida
 * @property bool $incapacidad
 * @property int $no_dias_incapaciad
 * @property bool $discapacidad
 * @property string $observaciones
 * @property string $id_sede
 * @property string $id_tipo_apoyo
 * @property string $estado
 *
 * @property Estados $estado0
 * @property Estudiantes $personaEstudiante
 * @property Personas $personaDoctor
 * @property Sedes $sede
 * @property TiposApoyoAcademico $tipoApoyo
 */
class ApoyoAcademico extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'apoyo_academico';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['persona_doctor', 'id_persona_estudiante', 'motivo_consulta', 'fecha_entrada', 'hora_entrada', 'fecha_salida', 'hora_salida', 'id_sede', 'id_tipo_apoyo'], 'required'],
            [['persona_doctor', 'id_persona_estudiante', 'no_dias_incapaciad', 'id_sede', 'id_tipo_apoyo', 'estado'], 'default', 'value' => null],
            [['id_persona_estudiante', 'no_dias_incapaciad', 'id_sede', 'id_tipo_apoyo', 'estado'], 'integer'],
            [['fecha_entrada', 'hora_entrada', 'fecha_salida', 'hora_salida'], 'safe'],
            [['incapacidad', 'discapacidad', 'remitido_eps'], 'boolean'],
            [['registro'], 'string', 'max' => 50],
            [['motivo_consulta'], 'string', 'max' => 500],
            [['observaciones'], 'string', 'max' => 600],
            [['estado'], 'exist', 'skipOnError' => true, 'targetClass' => Estados::className(), 'targetAttribute' => ['estado' => 'id']],
            [['id_persona_estudiante'], 'exist', 'skipOnError' => true, 'targetClass' => Estudiantes::className(), 'targetAttribute' => ['id_persona_estudiante' => 'id_perfiles_x_personas']],
            [['id_sede'], 'exist', 'skipOnError' => true, 'targetClass' => Sedes::className(), 'targetAttribute' => ['id_sede' => 'id']],
            [['id_tipo_apoyo'], 'exist', 'skipOnError' => true, 'targetClass' => TiposApoyoAcademico::className(), 'targetAttribute' => ['id_tipo_apoyo' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'persona_doctor' => 'Atendido por',
            'registro' => 'Registro Medico',
            'id_persona_estudiante' => 'Estudiante',
            'motivo_consulta' => 'Motivo Consulta',
            'fecha_entrada' => 'Fecha Entrada',
            'hora_entrada' => 'Hora Entrada',
            'fecha_salida' => 'Fecha Salida',
            'hora_salida' => 'Hora Salida',
            'incapacidad' => 'Incapacidad',
            'no_dias_incapaciad' => 'No Días Incapacidad',
            'discapacidad' => 'Discapacidad',
            'observaciones' => 'Observaciones',
            'id_sede' => 'Sede',
            'id_tipo_apoyo' => 'Tipo Apoyo',
            'estado' => 'Estado',
            'remitido_eps' => 'Remitido a EPS',
			'consecutivo'=> 'Consecutivo',
			'paralelo'=>'Grupo',
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
    public function getPersonaEstudiante()
    {
        return $this->hasOne(Estudiantes::className(), ['id_perfiles_x_personas' => 'id_persona_estudiante']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersonaDoctor()
    {
        return $this->hasOne(Personas::className(), ['id' => 'persona_doctor']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSede()
    {
        return $this->hasOne(Sedes::className(), ['id' => 'id_sede']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipoApoyo()
    {
        return $this->hasOne(TiposApoyoAcademico::className(), ['id' => 'id_tipo_apoyo']);
    }
}
