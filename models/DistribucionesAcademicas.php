<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "distribuciones_academicas".
 *
 * @property string $id
 * @property string $id_asignaturas_x_niveles_sedes
 * @property string $id_perfiles_x_personas_docentes
 * @property string $id_aulas_x_sedes
 * @property string $fecha_ingreso
 * @property string $estado
 *
 * @property Asignaciones[] $asignaciones
 * @property AsignaturasXNivelesSedes $asignaturasXNivelesSedes
 * @property Aulas $aulasXSedes
 * @property Aulas $ParalelosSedes
 * @property Docentes $perfilesXPersonasDocentes
 * @property Estados $estado0
 * @property DistribucionesXBloquesXDias[] $distribucionesXBloquesXDias
 * @property Inasistencias[] $inasistencias
 */
class DistribucionesAcademicas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'distribuciones_academicas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_asignaturas_x_niveles_sedes', 'id_perfiles_x_personas_docentes', 'id_aulas_x_sedes', 'estado'], 'default', 'value' => null],
            [['id_asignaturas_x_niveles_sedes', 'id_perfiles_x_personas_docentes', 'id_aulas_x_sedes', 'estado', 'id_paralelo_sede'], 'string'],
            [['id_asignaturas_x_niveles_sedes', 'id_perfiles_x_personas_docentes', 'id_aulas_x_sedes', 'estado', 'id_paralelo_sede'],'required'],
			[['fecha_ingreso'], 'safe'],
            [['id_asignaturas_x_niveles_sedes'], 'exist', 'skipOnError' => true, 'targetClass' => AsignaturasNivelesSedes::className(), 'targetAttribute' => ['id_asignaturas_x_niveles_sedes' => 'id']],
            [['id_aulas_x_sedes'], 'exist', 'skipOnError' => true, 'targetClass' => Aulas::className(), 'targetAttribute' => ['id_aulas_x_sedes' => 'id']],
            [['id_perfiles_x_personas_docentes'], 'exist', 'skipOnError' => true, 'targetClass' => Docentes::className(), 'targetAttribute' => ['id_perfiles_x_personas_docentes' => 'id_perfiles_x_personas']],
            [['estado'], 'exist', 'skipOnError' => true, 'targetClass' => Estados::className(), 'targetAttribute' => ['estado' => 'id']],
            [['id_paralelo_sede'], 'exist', 'skipOnError' => true, 'targetClass' => Paralelos::className(), 'targetAttribute' => ['id_paralelo_sede' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_asignaturas_x_niveles_sedes' => 'Asignatura',
            'id_perfiles_x_personas_docentes' => 'Docente',
            'id_aulas_x_sedes' => 'Aula',
            'fecha_ingreso' => 'Fecha Ingreso',
            'estado' => 'Estado',
            'id_paralelo_sede' => 'Grupo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAsignaciones()
    {
        return $this->hasMany(Asignaciones::className(), ['id_distribuciones_academicas' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAsignaturasXNivelesSedes()
    {
        return $this->hasOne(AsignaturasXNivelesSedes::className(), ['id' => 'id_asignaturas_x_niveles_sedes']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAulasXSedes()
    {
        return $this->hasOne(Aulas::className(), ['id' => 'id_aulas_x_sedes']);
    }
	
	 /**
     * @return \yii\db\ActiveQuery
     */
    public function getParalelosSedes()
    {
        return $this->hasOne(Paralelos::className(), ['id' => 'id_paralelo_sede']);
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
    public function getDistribucionesXBloquesXDias()
    {
        return $this->hasMany(DistribucionesXBloquesXDias::className(), ['id_distribuciones_academicas' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInasistencias()
    {
        return $this->hasMany(Inasistencias::className(), ['id_distribuciones_academicas' => 'id']);
    }
}
