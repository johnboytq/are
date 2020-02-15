<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "inasistencias".
 *
 * @property string $id
 * @property string $id_perfiles_x_personas_estudiantes
 * @property bool $justificada
 * @property string $id_distribuciones_academicas
 * @property string $fecha
 * @property string $justificacion
 * @property int $estado
 * @property string $fecha_ing
 *
 * @property DistribucionesAcademicas $distribucionesAcademicas
 * @property Estados $estado0
 * @property Estudiantes $perfilesXPersonasEstudiantes
 */
class Inasistencias extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'inasistencias';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_perfiles_x_personas_estudiantes', 'id_distribuciones_academicas', 'estado'], 'default', 'value' => null],
            [['id_perfiles_x_personas_estudiantes', 'id_distribuciones_academicas', 'estado'], 'integer'],
            [['justificada'], 'boolean'],
            [['fecha', 'fecha_ing'], 'safe'],
            [['justificacion'], 'string', 'max' => 500],
            [['id_distribuciones_academicas'], 'exist', 'skipOnError' => true, 'targetClass' => DistribucionesAcademicas::className(), 'targetAttribute' => ['id_distribuciones_academicas' => 'id']],
            [['estado'], 'exist', 'skipOnError' => true, 'targetClass' => Estados::className(), 'targetAttribute' => ['estado' => 'id']],
            [['id_perfiles_x_personas_estudiantes'], 'exist', 'skipOnError' => true, 'targetClass' => Estudiantes::className(), 'targetAttribute' => ['id_perfiles_x_personas_estudiantes' => 'id_perfiles_x_personas']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_perfiles_x_personas_estudiantes' => 'Id Perfiles X Personas Estudiantes',
            'justificada' => 'Justificada',
            'id_distribuciones_academicas' => 'Id Distribuciones Academicas',
            'fecha' => 'Fecha',
            'justificacion' => 'Justificacion',
            'estado' => 'Estado',
            'fecha_ing' => 'Fecha Ing',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDistribucionesAcademicas()
    {
        return $this->hasOne(DistribucionesAcademicas::className(), ['id' => 'id_distribuciones_academicas']);
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
    public function getPerfilesXPersonasEstudiantes()
    {
        return $this->hasOne(Estudiantes::className(), ['id_perfiles_x_personas' => 'id_perfiles_x_personas_estudiantes']);
    }
}
