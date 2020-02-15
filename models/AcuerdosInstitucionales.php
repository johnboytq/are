<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "semilleros_tic.acuerdos_institucionales".
 *
 * @property string $id
 * @property string $id_fase
 * @property string $id_docente
 * @property string $asignatura
 * @property string $especialidad
 * @property string $frecuencias_sesiones
 * @property string $jornada
 * @property string $recursos_requeridos
 * @property string $total_docentes
 * @property string $observaciones
 * @property string $id_semilleros_datos_ieo
 * @property string $estado
 */
class AcuerdosInstitucionales extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'semilleros_tic.acuerdos_institucionales';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_fase', 'id_docente', 'asignatura', 'especialidad', 'frecuencias_sesiones', 'jornada', 'recursos_requeridos', 'total_docentes', 'id_semilleros_datos_ieo'], 'required'],
            [['id_fase', 'id_docente', 'frecuencias_sesiones', 'jornada', 'recursos_requeridos', 'id_semilleros_datos_ieo', 'estado'], 'default', 'value' => null],
            [['id_fase', 'id_docente', 'frecuencias_sesiones', 'jornada', 'recursos_requeridos', 'id_semilleros_datos_ieo', 'estado'], 'integer'],
            [['asignatura', 'especialidad', 'total_docentes', 'observaciones'], 'string', 'max' => 500],
            [['frecuencias_sesiones'], 'exist', 'skipOnError' => true, 'targetClass' => Parametro::className(), 'targetAttribute' => ['frecuencias_sesiones' => 'id']],
            [['jornada'], 'exist', 'skipOnError' => true, 'targetClass' => Parametro::className(), 'targetAttribute' => ['jornada' => 'id']],
            [['recursos_requeridos'], 'exist', 'skipOnError' => true, 'targetClass' => Parametro::className(), 'targetAttribute' => ['recursos_requeridos' => 'id']],
            [['id_docente'], 'exist', 'skipOnError' => true, 'targetClass' => Personas::className(), 'targetAttribute' => ['id_docente' => 'id']],
            [['id_fase'], 'exist', 'skipOnError' => true, 'targetClass' => Fases::className(), 'targetAttribute' => ['id_fase' => 'id']],
            [['id_semilleros_datos_ieo'], 'exist', 'skipOnError' => true, 'targetClass' => SemillerosDatosIeo::className(), 'targetAttribute' => ['id_semilleros_datos_ieo' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_fase' => 'Id Fase',
            'id_docente' => 'Id Docente',
            'asignatura' => 'Asignatura',
            'especialidad' => 'Especialidad',
            'frecuencias_sesiones' => 'Frecuencias Sesiones',
            'jornada' => 'Jornada',
            'recursos_requeridos' => 'Recursos Requeridos',
            'total_docentes' => 'Total Docentes',
            'observaciones' => 'Observaciones',
            'id_semilleros_datos_ieo' => 'Id Semilleros Datos Ieo',
            'estado' => 'Estado',
        ];
    }
}
