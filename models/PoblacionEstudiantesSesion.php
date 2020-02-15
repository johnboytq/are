<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "semilleros_tic.poblacion_estudiantes_sesion".
 *
 * @property string $id
 * @property string $id_poblacion_estudiantes
 * @property string $id_sesiones
 * @property int $valor
 */
class PoblacionEstudiantesSesion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'semilleros_tic.poblacion_estudiantes_sesion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_poblacion_estudiantes', 'id_sesiones'], 'required'],
            [['id_poblacion_estudiantes', 'id_sesiones', 'valor'], 'default', 'value' => null],
            [['id_poblacion_estudiantes', 'id_sesiones', 'valor'], 'integer'],
            [['id_poblacion_estudiantes'], 'exist', 'skipOnError' => true, 'targetClass' => InstrumentoPoblacionEstudiantes::className(), 'targetAttribute' => ['id_poblacion_estudiantes' => 'id']],
            [['id_sesiones'], 'exist', 'skipOnError' => true, 'targetClass' => Sesiones::className(), 'targetAttribute' => ['id_sesiones' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' 						=> 'ID',
            'id_poblacion_estudiantes' 	=> 'Id Poblacion Estudiantes',
            'id_sesiones' 				=> 'Id Sesiones',
            'valor' 					=> 'Valor',
        ];
    }
}
