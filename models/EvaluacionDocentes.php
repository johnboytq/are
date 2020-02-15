<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "evaluacion_docentes".
 *
 * @property string $id
 * @property string $fecha
 * @property string $descripcion
 * @property string $puntaje
 * @property string $id_perfiles_x_personas_docentes
 * @property string $estado
 *
 * @property Docentes $perfilesXPersonasDocentes
 * @property Estados $estado0
 */
class EvaluacionDocentes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'evaluacion_docentes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fecha'], 'safe'],
            [['id_perfiles_x_personas_docentes', 'estado'], 'required'],
            [['id_perfiles_x_personas_docentes', 'estado'], 'default', 'value' => null],
            [['id_perfiles_x_personas_docentes', 'estado'], 'integer'],
            [['descripcion'], 'string', 'max' => 700],
            [['puntaje'], 'string', 'max' => 100],
            [['id_perfiles_x_personas_docentes'], 'exist', 'skipOnError' => true, 'targetClass' => Docentes::className(), 'targetAttribute' => ['id_perfiles_x_personas_docentes' => 'id_perfiles_x_personas']],
            [['estado'], 'exist', 'skipOnError' => true, 'targetClass' => Estados::className(), 'targetAttribute' => ['estado' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fecha' => 'Fecha',
            'descripcion' => 'Descripción',
            'puntaje' => 'Puntaje',
            'id_perfiles_x_personas_docentes' => 'Perfiles por personal docente',
            'estado' => 'Estado',
        ];
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
}
