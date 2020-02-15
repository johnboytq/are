<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "docentes".
 *
 * @property string $id_perfiles_x_personas
 * @property string $id_escalafones
 * @property int $estado
 * @property string $Antiguedad
 *
 * @property Calificaciones[] $calificaciones
 * @property ContratosInstituciones[] $contratosInstituciones
 * @property DistribucionesAcademicas[] $distribucionesAcademicas
 * @property Escalafones $escalafones
 * @property Estados $estado0
 * @property PerfilesXPersonas $perfilesXPersonas
 * @property DocentesXAreasTrabajos[] $docentesXAreasTrabajos
 * @property AreasTrabajos[] $areasTrabajos
 * @property EvaluacionDocentes[] $evaluacionDocentes
 * @property PlanDeAula[] $planDeAulas
 * @property ProyectosPreAutor[] $proyectosPreAutors
 * @property ProyectosXDocentes[] $proyectosXDocentes
 * @property Proyectos[] $proyectos
 * @property VinculacionDocentes[] $vinculacionDocentes
 */
class Docentes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'docentes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_perfiles_x_personas'], 'required'],
            [['id_perfiles_x_personas', 'id_escalafones', 'estado'], 'default', 'value' => null],
            [['id_perfiles_x_personas', 'id_escalafones', 'estado'], 'integer'],
            [['Antiguedad'], 'integer'],
            [['id_perfiles_x_personas'], 'unique'],
            [['id_escalafones'], 'exist', 'skipOnError' => true, 'targetClass' => Escalafones::className(), 'targetAttribute' => ['id_escalafones' => 'id']],
            [['estado'], 'exist', 'skipOnError' => true, 'targetClass' => Estados::className(), 'targetAttribute' => ['estado' => 'id']],
            [['id_perfiles_x_personas'], 'exist', 'skipOnError' => true, 'targetClass' => PerfilesXPersonas::className(), 'targetAttribute' => ['id_perfiles_x_personas' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_perfiles_x_personas' => 'Perfiles por persona',
            'id_escalafones' => 'Escalafones',
            'estado' => 'Estado',
            'Antiguedad' => 'Antigüedad',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCalificaciones()
    {
        return $this->hasMany(Calificaciones::className(), ['id_perfiles_x_personas_docentes' => 'id_perfiles_x_personas']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContratosInstituciones()
    {
        return $this->hasMany(ContratosInstituciones::className(), ['id_perfiles_x_personas_docentes' => 'id_perfiles_x_personas']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDistribucionesAcademicas()
    {
        return $this->hasMany(DistribucionesAcademicas::className(), ['id_perfiles_x_personas_docentes' => 'id_perfiles_x_personas']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEscalafones()
    {
        return $this->hasOne(Escalafones::className(), ['id' => 'id_escalafones']);
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
    public function getPerfilesXPersonas()
    {
        return $this->hasOne(PerfilesXPersonas::className(), ['id' => 'id_perfiles_x_personas']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDocentesXAreasTrabajos()
    {
        return $this->hasMany(DocentesXAreasTrabajos::className(), ['id_perfiles_x_personas_docentes' => 'id_perfiles_x_personas']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAreasTrabajos()
    {
        return $this->hasMany(AreasTrabajos::className(), ['id' => 'id_areas_trabajos'])->viaTable('docentes_x_areas_trabajos', ['id_perfiles_x_personas_docentes' => 'id_perfiles_x_personas']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvaluacionDocentes()
    {
        return $this->hasMany(EvaluacionDocentes::className(), ['id_perfiles_x_personas_docentes' => 'id_perfiles_x_personas']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanDeAulas()
    {
        return $this->hasMany(PlanDeAula::className(), ['id_perfiles_x_personas_docentes' => 'id_perfiles_x_personas']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProyectosPreAutors()
    {
        return $this->hasMany(ProyectosPreAutor::className(), ['id_perfiles_x_personas_docentes' => 'id_perfiles_x_personas']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProyectosXDocentes()
    {
        return $this->hasMany(ProyectosXDocentes::className(), ['id_perfiles_x_personas_docentes' => 'id_perfiles_x_personas']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProyectos()
    {
        return $this->hasMany(Proyectos::className(), ['id' => 'id_proyectos'])->viaTable('proyectos_x_docentes', ['id_perfiles_x_personas_docentes' => 'id_perfiles_x_personas']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVinculacionDocentes()
    {
        return $this->hasMany(VinculacionDocentes::className(), ['id_perfiles_x_personas_docentes' => 'id_perfiles_x_personas']);
    }
}
