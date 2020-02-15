<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "docentes_x_areas_trabajos".
 *
 * @property string $id_perfiles_x_personas_docentes
 * @property string $id_areas_trabajos
 *
 * @property AreasTrabajos $areasTrabajos
 * @property Docentes $perfilesXPersonasDocentes
 */
class DocentesXAreasTrabajos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'docentes_x_areas_trabajos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_perfiles_x_personas_docentes', 'id_areas_trabajos'], 'required'],
            [['id_perfiles_x_personas_docentes', 'id_areas_trabajos'], 'default', 'value' => null],
            [['id_perfiles_x_personas_docentes', 'id_areas_trabajos'], 'integer'],
            [['id_perfiles_x_personas_docentes', 'id_areas_trabajos'], 'unique', 'targetAttribute' => ['id_perfiles_x_personas_docentes', 'id_areas_trabajos']],
            [['id_areas_trabajos'], 'exist', 'skipOnError' => true, 'targetClass' => AreasTrabajos::className(), 'targetAttribute' => ['id_areas_trabajos' => 'id']],
            [['id_perfiles_x_personas_docentes'], 'exist', 'skipOnError' => true, 'targetClass' => Docentes::className(), 'targetAttribute' => ['id_perfiles_x_personas_docentes' => 'id_perfiles_x_personas']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_perfiles_x_personas_docentes' => 'Perfiles por personal docente',
            'id_areas_trabajos' => 'Áreas Trabajos',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAreasTrabajos()
    {
        return $this->hasOne(AreasTrabajos::className(), ['id' => 'id_areas_trabajos']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerfilesXPersonasDocentes()
    {
        return $this->hasOne(Docentes::className(), ['id_perfiles_x_personas' => 'id_perfiles_x_personas_docentes']);
    }
}
