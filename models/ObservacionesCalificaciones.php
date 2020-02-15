<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "observaciones_calificaciones".
 *
 * @property string $id
 * @property string $id_estudiante
 * @property string $id_jornada
 * @property string $id_paralelo
 * @property string $id_asignatura
 * @property string $id_periodo
 * @property string $observacion_conocer
 * @property string $observacion_hacer
 * @property string $observacion_saber
 *
 * @property Asignaturas $asignatura
 * @property Estudiantes $estudiante
 * @property Jornadas $jornada
 * @property Paralelos $paralelo
 * @property Periodos $periodo
 */
class ObservacionesCalificaciones extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'observaciones_calificaciones';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_estudiante', 'id_jornada', 'id_paralelo', 'id_asignatura', 'id_periodo'], 'required'],
            [['id_estudiante', 'id_jornada', 'id_paralelo', 'id_asignatura', 'id_periodo'], 'default', 'value' => null],
            [['id_estudiante', 'id_jornada', 'id_paralelo', 'id_asignatura', 'id_periodo'], 'integer'],
            [['observacion_conocer', 'observacion_hacer', 'observacion_saber'], 'string'],
            [['id_asignatura'], 'exist', 'skipOnError' => true, 'targetClass' => Asignaturas::className(), 'targetAttribute' => ['id_asignatura' => 'id']],
            [['id_estudiante'], 'exist', 'skipOnError' => true, 'targetClass' => Estudiantes::className(), 'targetAttribute' => ['id_estudiante' => 'id_perfiles_x_personas']],
            [['id_jornada'], 'exist', 'skipOnError' => true, 'targetClass' => Jornadas::className(), 'targetAttribute' => ['id_jornada' => 'id']],
            [['id_paralelo'], 'exist', 'skipOnError' => true, 'targetClass' => Paralelos::className(), 'targetAttribute' => ['id_paralelo' => 'id']],
            [['id_periodo'], 'exist', 'skipOnError' => true, 'targetClass' => Periodos::className(), 'targetAttribute' => ['id_periodo' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_estudiante' => 'Id Estudiante',
            'id_jornada' => 'Id Jornada',
            'id_paralelo' => 'Id Paralelo',
            'id_asignatura' => 'Id Asignatura',
            'id_periodo' => 'Id Periodo',
            'observacion_conocer' => 'Observacion Conocer',
            'observacion_hacer' => 'Observacion Hacer',
            'observacion_saber' => 'Observacion Saber',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAsignatura()
    {
        return $this->hasOne(Asignaturas::className(), ['id' => 'id_asignatura']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstudiante()
    {
        return $this->hasOne(Estudiantes::className(), ['id_perfiles_x_personas' => 'id_estudiante']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJornada()
    {
        return $this->hasOne(Jornadas::className(), ['id' => 'id_jornada']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParalelo()
    {
        return $this->hasOne(Paralelos::className(), ['id' => 'id_paralelo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPeriodo()
    {
        return $this->hasOne(Periodos::className(), ['id' => 'id_periodo']);
    }
}
