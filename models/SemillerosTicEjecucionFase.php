<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "semilleros_tic.ejecucion_fase".
 *
 * @property string $id
 * @property string $id_fase
 * @property string $id_datos_sesiones
 * @property string $docente
 * @property string $asignaturas
 * @property string $especiaidad
 * @property string $paricipacion_sesiones
 * @property string $numero_apps
 * @property string $seiones_empleadas
 * @property string $acciones_realiadas
 * @property string $temas_problama
 * @property string $tipo_conpetencias
 * @property string $observaciones
 * @property string $id_datos_ieo_profesional
 * @property string $estado
 * @property string $numero_sesiones_docente
 */
class SemillerosTicEjecucionFase extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'semilleros_tic.ejecucion_fase';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_fase', 'id_datos_sesiones', 'docente', 'asignaturas', 'especiaidad', 'paricipacion_sesiones', 'numero_apps', 'seiones_empleadas', 'acciones_realiadas', 'temas_problama', 'tipo_conpetencias', 'observaciones', 'id_datos_ieo_profesional', 'estado', 'numero_sesiones_docente'], 'required'],
            [['id_fase', 'id_datos_sesiones', 'id_datos_ieo_profesional', 'estado'], 'default', 'value' => null],
            [['id_fase', 'id_datos_sesiones', 'id_datos_ieo_profesional', 'estado'], 'integer'],
            [['docente'], 'string', 'max' => 200],
            [['asignaturas', 'especiaidad', 'paricipacion_sesiones', 'numero_apps', 'seiones_empleadas', 'acciones_realiadas', 'temas_problama', 'tipo_conpetencias', 'observaciones', 'numero_sesiones_docente'], 'string', 'max' => 500],
            [['estado'], 'exist', 'skipOnError' => true, 'targetClass' => Estados::className(), 'targetAttribute' => ['estado' => 'id']],
            [['id_datos_ieo_profesional'], 'exist', 'skipOnError' => true, 'targetClass' => SemillerosTicDatosIeoProfesional::className(), 'targetAttribute' => ['id_datos_ieo_profesional' => 'id']],
            [['id_datos_sesiones'], 'exist', 'skipOnError' => true, 'targetClass' => SemillerosTicDatosSesiones::className(), 'targetAttribute' => ['id_datos_sesiones' => 'id']],
            [['id_fase'], 'exist', 'skipOnError' => true, 'targetClass' => SemillerosTicFases::className(), 'targetAttribute' => ['id_fase' => 'id']],
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
            'id_datos_sesiones' => 'Id Datos Sesiones',
            'docente' => 'Docente',
            'asignaturas' => 'Asignaturas',
            'especiaidad' => 'Especiaidad',
            'paricipacion_sesiones' => 'Paricipacion Sesiones',
            'numero_apps' => 'Numero Apps',
            'seiones_empleadas' => 'Seiones Empleadas',
            'acciones_realiadas' => 'Acciones Realiadas',
            'temas_problama' => 'Temas Problama',
            'tipo_conpetencias' => 'Tipo Conpetencias',
            'observaciones' => 'Observaciones',
            'id_datos_ieo_profesional' => 'Id Datos Ieo Profesional',
            'estado' => 'Estado',
            'numero_sesiones_docente' => 'Numero Sesiones Docente',
        ];
    }
}
