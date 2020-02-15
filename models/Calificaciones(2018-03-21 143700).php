<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "calificaciones".
 *
 * @property string $id
 * @property double $calificacion
 * @property string $fecha
 * @property string $observaciones
 * @property string $id_perfiles_x_personas_docentes
 * @property string $id_perfiles_x_personas_estudiantes
 * @property string $id_asignaciones_x_indicador_desempeno
 * @property string $fecha_modificacion
 * @property string $estado
 *
 * @property AsignacionesXIndicadorDesempeno $asignacionesXIndicadorDesempeno
 * @property Docentes $perfilesXPersonasDocentes
 * @property Estados $estado0
 * @property Estudiantes $perfilesXPersonasEstudiantes
 */
class Calificaciones extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'calificaciones';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['calificacion'], 'number'],
            [['fecha', 'fecha_modificacion'], 'safe'],
            [['id_perfiles_x_personas_docentes', 'id_perfiles_x_personas_estudiantes', 'id_asignaciones_x_indicador_desempeno', 'estado'], 'default', 'value' => null],
            [['id_perfiles_x_personas_docentes', 'id_perfiles_x_personas_estudiantes', 'id_asignaciones_x_indicador_desempeno', 'estado'], 'integer'],
            [['observaciones'], 'string', 'max' => 500],
            [['id_asignaciones_x_indicador_desempeno'], 'exist', 'skipOnError' => true, 'targetClass' => AsignacionesXIndicadorDesempeno::className(), 'targetAttribute' => ['id_asignaciones_x_indicador_desempeno' => 'id']],
            [['id_perfiles_x_personas_docentes'], 'exist', 'skipOnError' => true, 'targetClass' => Docentes::className(), 'targetAttribute' => ['id_perfiles_x_personas_docentes' => 'id_perfiles_x_personas']],
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
            'calificacion' => 'Calificacion',
            'fecha' => 'Fecha',
            'observaciones' => 'Observaciones',
            'id_perfiles_x_personas_docentes' => 'Id Perfiles X Personas Docentes',
            'id_perfiles_x_personas_estudiantes' => 'Id Perfiles X Personas Estudiantes',
            'id_asignaciones_x_indicador_desempeno' => 'Id Asignaciones X Indicador Desempeno',
            'fecha_modificacion' => 'Fecha Modificacion',
            'estado' => 'Estado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAsignacionesXIndicadorDesempeno()
    {
        return $this->hasOne(AsignacionesXIndicadorDesempeno::className(), ['id' => 'id_asignaciones_x_indicador_desempeno']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerfilesXPersonasDocentes()
    {
        return $this->hasOne(Docentes::className(), ['id_perfiles_x_personas' => 'id_perfiles_x_personas_docentes']);
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
