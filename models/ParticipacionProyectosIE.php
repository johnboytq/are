<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "participacion_proyectos_IE".
 *
 * @property string $id
 * @property string $programa_proyecto
 * @property bool $participacion
 * @property string $operador
 * @property string $entidad_financia
 * @property string $objetivo
 * @property string $duracion
 * @property string $anio_inicio
 * @property string $anio_finalizacion
 * @property string $tematica
 * @property string $areas
 * @property string $sedes
 * @property string $numero_docentes
 * @property string $numero_estudiantes
 * @property string $numero_padres
 * @property string $numero_directivos
 * @property string $otros
 * @property string $materiales_recursos
 * @property string $logros
 * @property string $observaciones
 * @property string $id_institucion
 * @property string $estado
 *
 * @property Estados $estado0
 * @property Instituciones $institucion
 * @property NombresProyectosParticipacion $programaProyecto
 */
class ParticipacionProyectosIE extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'participacion_proyectos_IE';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['programa_proyecto', 'participacion'], 'required'],
            [['programa_proyecto', 'id_institucion', 'estado'], 'default', 'value' => null],
            [['programa_proyecto', 'id_institucion', 'estado'], 'integer'],
            [['participacion'], 'boolean'],
            [['operador', 'entidad_financia', 'objetivo'], 'string', 'max' => 100],
            [['duracion', 'anio_inicio', 'anio_finalizacion'], 'string', 'max' => 50],
            [['tematica', 'areas', 'sedes', 'numero_docentes', 'numero_estudiantes', 'numero_padres', 'numero_directivos', 'otros', 'logros'], 'string', 'max' => 300],
            [['materiales_recursos'], 'string', 'max' => 700],
            [['observaciones'], 'string', 'max' => 1000],
            [['estado'], 'exist', 'skipOnError' => true, 'targetClass' => Estados::className(), 'targetAttribute' => ['estado' => 'id']],
            [['id_institucion'], 'exist', 'skipOnError' => true, 'targetClass' => Instituciones::className(), 'targetAttribute' => ['id_institucion' => 'id']],
            [['programa_proyecto'], 'exist', 'skipOnError' => true, 'targetClass' => NombresProyectosParticipacion::className(), 'targetAttribute' => ['programa_proyecto' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'programa_proyecto' => 'Programa/Proyecto',
            'participacion' => 'Participación',
            'operador' => 'Operador',
            'entidad_financia' => 'Entidad que Financia',
            'objetivo' => 'Objetivo',
            'duracion' => 'Duración',
            'anio_inicio' => 'Año de Inicio',
            'anio_finalizacion' => 'Año Finalizacion',
            'tematica' => 'Temática',
            'areas' => 'Áreas',
            'sedes' => 'Sedes',
            'numero_docentes' => 'Numero de docentes',
            'numero_estudiantes' => 'Numero de estudiantes',
            'numero_padres' => 'Numero de padres',
            'numero_directivos' => 'Numero de directivos',
            'otros' => 'Otros',
            'materiales_recursos' => 'Materiales Recursos',
            'logros' => 'Logros',
            'observaciones' => 'Observaciones',
            'id_institucion' => 'Institución',
            'estado' => 'Estado',
        ];
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
    public function getInstitucion()
    {
        return $this->hasOne(Instituciones::className(), ['id' => 'id_institucion']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProgramaProyecto()
    {
        return $this->hasOne(NombresProyectosParticipacion::className(), ['id' => 'programa_proyecto']);
    }
}
