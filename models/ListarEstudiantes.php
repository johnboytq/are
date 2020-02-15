<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "estudiantes".
 *
 * @property string $id_perfiles_x_personas
 * @property string $id_paralelos
 * @property int $estado
 *
 * @property ApoyoAcademico[] $apoyoAcademicos
 * @property Calificaciones[] $calificaciones
 * @property Paralelos $paralelos
 * @property PerfilesXPersonas $perfilesXPersonas
 * @property Inasistencias[] $inasistencias
 */
class ListarEstudiantes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'estudiantes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_perfiles_x_personas'], 'required'],
            [['id_perfiles_x_personas', 'id_paralelos', 'estado'], 'default', 'value' => null],
            [['id_perfiles_x_personas', 'id_paralelos', 'estado'], 'integer'],
            [['id_perfiles_x_personas'], 'unique'],
            [['id_paralelos'], 'exist', 'skipOnError' => true, 'targetClass' => Paralelos::className(), 'targetAttribute' => ['id_paralelos' => 'id']],
            [['id_perfiles_x_personas'], 'exist', 'skipOnError' => true, 'targetClass' => PerfilesXPersonas::className(), 'targetAttribute' => ['id_perfiles_x_personas' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_perfiles_x_personas' => 'Estudiante',
            'id_paralelos' => 'Grupo',
            'estado' => 'Estado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApoyoAcademicos()
    {
        return $this->hasMany(ApoyoAcademico::className(), ['id_persona_estudiante' => 'id_perfiles_x_personas']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCalificaciones()
    {
        return $this->hasMany(Calificaciones::className(), ['id_perfiles_x_personas_estudiantes' => 'id_perfiles_x_personas']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParalelos()
    {
        return $this->hasOne(Paralelos::className(), ['id' => 'id_paralelos']);
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
    public function getInasistencias()
    {
        return $this->hasMany(Inasistencias::className(), ['id_perfiles_x_personas_estudiantes' => 'id_perfiles_x_personas']);
    }
}
