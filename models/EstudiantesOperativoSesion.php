<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "semilleros_tic.estudiantes_operativo_sesion".
 *
 * @property string $id
 * @property string $id_sesion
 * @property int $asistentes
 * @property int $dificultades_operativas
 * @property string $estado
 * @property string $id_estudiantes_operativo
 */
class EstudiantesOperativoSesion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'semilleros_tic.estudiantes_operativo_sesion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_sesion', 'asistentes', 'dificultades_operativas', 'estado', 'id_estudiantes_operativo'], 'default', 'value' => null],
            [['id_sesion', 'asistentes', 'dificultades_operativas', 'estado', 'id_estudiantes_operativo'], 'integer'],
            [['estado'], 'exist', 'skipOnError' => true, 'targetClass' => Estados::className(), 'targetAttribute' => ['estado' => 'id']],
            [['id_sesion'], 'exist', 'skipOnError' => true, 'targetClass' => Sesiones::className(), 'targetAttribute' => ['id_sesion' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_sesion' => 'Id Sesion',
            'asistentes' => 'Asistentes',
            'dificultades_operativas' => 'Dificultades Operativas',
            'estado' => 'Estado',
            'id_estudiantes_operativo' => 'Id Estudiantes Operativo',
        ];
    }
}
