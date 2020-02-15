<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "areas_trabajos".
 *
 * @property string $id
 * @property string $descripcion
 *
 * @property DocentesXAreasTrabajos[] $docentesXAreasTrabajos
 * @property Docentes[] $perfilesXPersonasDocentes
 * @property ProyectosXAreasTrabajos[] $proyectosXAreasTrabajos
 * @property Proyectos[] $proyectos
 */
class AreasTrabajos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'areas_trabajos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['descripcion'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'descripcion' => 'Descripcion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDocentesXAreasTrabajos()
    {
        return $this->hasMany(DocentesXAreasTrabajos::className(), ['id_areas_trabajos' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerfilesXPersonasDocentes()
    {
        return $this->hasMany(Docentes::className(), ['id_perfiles_x_personas' => 'id_perfiles_x_personas_docentes'])->viaTable('docentes_x_areas_trabajos', ['id_areas_trabajos' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProyectosXAreasTrabajos()
    {
        return $this->hasMany(ProyectosXAreasTrabajos::className(), ['id_areas_trabajos' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProyectos()
    {
        return $this->hasMany(Proyectos::className(), ['id' => 'id_proyectos'])->viaTable('proyectos_x_areas_trabajos', ['id_areas_trabajos' => 'id']);
    }
}
