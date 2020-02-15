<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "participacion_proyectos_maestro".
 *
 * @property string $id
 * @property string $programa_proyecto
 * @property string $participante
 * @property string $tipo
 * @property string $objeto
 * @property string $duracion
 * @property string $anio_inicio
 * @property string $anio_fin
 * @property string $tematica
 * @property string $areas
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
 * @property Perfiles $tipo0
 * @property Personas $participante0
 */
class ParticipacionProyectosMaestro extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'participacion_proyectos_maestro';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['programa_proyecto', 'participante', 'tipo'], 'required'],
            [['programa_proyecto', 'participante', 'tipo', 'id_institucion', 'estado'], 'default', 'value' => null],
            [['programa_proyecto', 'participante', 'tipo', 'id_institucion', 'estado'], 'integer'],
            [['objeto', 'tematica', 'areas', 'otros', 'materiales_recursos', 'logros'], 'string', 'max' => 200],
            [['duracion', 'anio_inicio', 'anio_fin'], 'string', 'max' => 50],
            [['observaciones'], 'string', 'max' => 600],
            [['estado'], 'exist', 'skipOnError' => true, 'targetClass' => Estados::className(), 'targetAttribute' => ['estado' => 'id']],
            [['id_institucion'], 'exist', 'skipOnError' => true, 'targetClass' => Instituciones::className(), 'targetAttribute' => ['id_institucion' => 'id']],
            [['programa_proyecto'], 'exist', 'skipOnError' => true, 'targetClass' => NombresProyectosParticipacion::className(), 'targetAttribute' => ['programa_proyecto' => 'id']],
            [['tipo'], 'exist', 'skipOnError' => true, 'targetClass' => Perfiles::className(), 'targetAttribute' => ['tipo' => 'id']],
            [['participante'], 'exist', 'skipOnError' => true, 'targetClass' => Personas::className(), 'targetAttribute' => ['participante' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' 				=> 'ID',
            'programa_proyecto' => 'Nombre del Programa/Proyecto',
            'participante' 		=> 'Nombre del participante',
            'tipo' 				=> 'Tipo(Docente/Estudiatne/DD/Administrativo/Padre/Otro,Cual)',
            'objeto' 			=> 'Objetivo',
            'duracion' 			=> 'Duración',
            'anio_inicio' 		=> 'Año de inicio',
            'anio_fin' 			=> 'Año de finalización',
            'tematica' 			=> 'Temática',
            'areas' 			=> 'Áreas',
            'otros' 			=> 'Otros',
            'materiales_recursos'=>'Materiales o Recursos Aportados',
            'logros' 			=> 'Logros',
            'observaciones' 	=> 'Observaciones',
            'id_institucion' 	=> 'Id Institucion',
            'estado' 			=> 'Estado',
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipo0()
    {
        return $this->hasOne(Perfiles::className(), ['id' => 'tipo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParticipante0()
    {
        return $this->hasOne(Personas::className(), ['id' => 'participante']);
    }
}
