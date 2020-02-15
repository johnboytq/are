<?php
/**********
Versión: 001
Fecha: 2018-08-16
Desarrollador: Edwin Molina Grisales
Descripción: MODELO AcuerdosInstitucionalesEstudiantes
---------------------------------------
**********/

namespace app\models;

use Yii;

/**
 * This is the model class for table "semilleros_tic.acuerdos_institucionales_estudiantes".
 *
 * @property string $id
 * @property string $id_fase
 * @property string $curso
 * @property string $cantidad_inscritos
 * @property string $frecuencia_sesiones
 * @property string $jornada
 * @property string $recursos_requeridos
 * @property string $observaciones
 * @property string $id_semilleros_datos_estudiantes
 * @property string $estado
 */
class AcuerdosInstitucionalesEstudiantes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'semilleros_tic.acuerdos_institucionales_estudiantes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_fase', 'curso', 'cantidad_inscritos', 'frecuencia_sesiones', 'jornada', 'recursos_requeridos', 'id_semilleros_datos_estudiantes', 'estado'], 'required'],
            [['id_fase', 'frecuencia_sesiones', 'jornada', 'recursos_requeridos', 'id_semilleros_datos_estudiantes', 'estado'], 'default', 'value' => null],
            [['id_fase', 'frecuencia_sesiones', 'jornada', 'recursos_requeridos', 'id_semilleros_datos_estudiantes', 'estado'], 'integer'],
            [['curso', 'cantidad_inscritos'], 'string', 'max' => 200],
            [['observaciones'], 'string', 'max' => 1000],
            [['estado'], 'exist', 'skipOnError' => true, 'targetClass' => Estados::className(), 'targetAttribute' => ['estado' => 'id']],
            [['frecuencia_sesiones'], 'exist', 'skipOnError' => true, 'targetClass' => Parametro::className(), 'targetAttribute' => ['frecuencia_sesiones' => 'id']],
            [['jornada'], 'exist', 'skipOnError' => true, 'targetClass' => Parametro::className(), 'targetAttribute' => ['jornada' => 'id']],
            [['recursos_requeridos'], 'exist', 'skipOnError' => true, 'targetClass' => Parametro::className(), 'targetAttribute' => ['recursos_requeridos' => 'id']],
            [['id_fase'], 'exist', 'skipOnError' => true, 'targetClass' => SemillerosTicFases::className(), 'targetAttribute' => ['id_fase' => 'id']],
            [['id_semilleros_datos_estudiantes'], 'exist', 'skipOnError' => true, 'targetClass' => SemillerosTicSemillerosDatosIeoEstudiantes::className(), 'targetAttribute' => ['id_semilleros_datos_estudiantes' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' 					=> 'ID',
            'id_fase' 				=> 'Id Fase',
            'curso' 				=> 'Curso',
            'cantidad_inscritos' 	=> 'Cantidad Inscritos',
            'frecuencia_sesiones' 	=> 'Frecuencia Sesiones',
            'jornada'				=> 'Jornada',
            'recursos_requeridos' 	=> 'Recursos Requeridos',
            'observaciones' 		=> 'Observaciones',
            'id_semilleros_datos_estudiantes' => 'Id Semilleros Datos Estudiantes',
            'estado' 				=> 'Estado',
        ];
    }
}
