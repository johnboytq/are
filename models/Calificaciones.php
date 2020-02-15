<?php
/**********
Versión: 001
Fecha: 04-04-2018
---------------------------------------
Modificaciones:
Fecha: 09-07-2018
Persona encargada: Edwin Molina Grisales
Se consulta las faltas del estudiante y se asocia el perido a las califiaciones
---------------------------------------
**********/

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
 * @property string $id_distribuciones_x_indicador_desempeno
 * @property string $fecha_modificacion
 * @property string $estado
 *
 * @property DistribucionesXIndicadorDesempeno $distribucionesXIndicadorDesempeno
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
            [['id_perfiles_x_personas_docentes', 'id_perfiles_x_personas_estudiantes', 'id_distribuciones_x_indicador_desempeno', 'estado'], 'default', 'value' => null],
            [['id_perfiles_x_personas_docentes', 'id_perfiles_x_personas_estudiantes', 'id_distribuciones_x_indicador_desempeno', 'estado'], 'integer'],
            [['observaciones'], 'string', 'max' => 500],
            [['id_distribuciones_x_indicador_desempeno'], 'exist', 'skipOnError' => true, 'targetClass' => DistribucionesXIndicadorDesempeno::className(), 'targetAttribute' => ['id_distribuciones_x_indicador_desempeno' => 'id']],
            [['id_perfiles_x_personas_docentes'], 'exist', 'skipOnError' => true, 'targetClass' => Docentes::className(), 'targetAttribute' => ['id_perfiles_x_personas_docentes' => 'id_perfiles_x_personas']],
            [['estado'], 'exist', 'skipOnError' => true, 'targetClass' => Estados::className(), 'targetAttribute' => ['estado' => 'id']],
            [['id_perfiles_x_personas_estudiantes'], 'exist', 'skipOnError' => true, 'targetClass' => Estudiantes::className(), 'targetAttribute' => ['id_perfiles_x_personas_estudiantes' => 'id_perfiles_x_personas']],
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
            'calificacion' => 'Calificacion',
            'fecha' => 'Fecha',
            'observaciones' => 'Observaciones',
            'id_perfiles_x_personas_docentes' => 'Id Perfiles X Personas Docentes',
            'id_perfiles_x_personas_estudiantes' => 'Id Perfiles X Personas Estudiantes',
            'id_distribuciones_x_indicador_desempeno' => 'Id Distribuciones X Indicador Desempeno',
            'fecha_modificacion' => 'Fecha Modificacion',
            'estado' => 'Estado',
            'id_periodo' => 'Periodo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDistribucionesXIndicadorDesempeno()
    {
        return $this->hasOne(DistribucionesXIndicadorDesempeno::className(), ['id' => 'id_distribuciones_x_indicador_desempeno']);
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
