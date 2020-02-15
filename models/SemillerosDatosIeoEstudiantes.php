<?php

/**********
Versión: 001
Fecha: 2018-08-16
Desarrollador: Edwin Molina Grisales
Descripción: MODELO SemillerosDatosIeoEstudiantes
---------------------------------------
**********/

namespace app\models;

use Yii;

/**
 * This is the model class for table "semilleros_tic.semilleros_datos_ieo_estudiantes".
 *
 * @property string $id
 * @property string $id_institucion
 * @property string $profecional_a
 * @property string $docente_aliado
 * @property string $estado
 * @property string $id_sede
 */
class SemillerosDatosIeoEstudiantes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'semilleros_tic.semilleros_datos_ieo_estudiantes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_institucion', 'profecional_a', 'docente_aliado', 'estado'], 'required'],
            [['id_institucion', 'profecional_a', 'estado', 'id_sede'], 'default', 'value' => null],
            [['id_institucion', 'profecional_a', 'estado', 'id_sede'], 'integer'],
            [['docente_aliado'], 'string', 'max' => 200],
            [['estado'], 'exist', 'skipOnError' => true, 'targetClass' => Estados::className(), 'targetAttribute' => ['estado' => 'id']],
            [['id_institucion'], 'exist', 'skipOnError' => true, 'targetClass' => Instituciones::className(), 'targetAttribute' => ['id_institucion' => 'id']],
            [['profecional_a'], 'exist', 'skipOnError' => true, 'targetClass' => Personas::className(), 'targetAttribute' => ['profecional_a' => 'id']],
            [['id_sede'], 'exist', 'skipOnError' => true, 'targetClass' => Sedes::className(), 'targetAttribute' => ['id_sede' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' 			=> 'ID',
            'id_institucion'=> 'Institución educativa',
            'profecional_a' => 'Profesional A.',
            'docente_aliado'=> 'Docente aliado',
            'estado' 		=> 'Estado',
            'id_sede' 		=> 'Sede',
        ];
    }
}
