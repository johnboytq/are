<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "gestion_curricular.docente_tutor_acompanamiento".
 *
 * @property string $id
 * @property string $fecha
 * @property string $nombre_profesional_acompanamiento
 * @property string $id_docente
 * @property string $id_institucion
 * @property string $id_sede
 */
class GestionCurricularDocenteTutorAcompanamiento extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gestion_curricular.docente_tutor_acompanamiento';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'id_docente', 'id_institucion', 'id_sede'], 'default', 'value' => null],
            [['id', 'id_docente', 'id_institucion', 'id_sede'], 'integer'],
            [['fecha'], 'safe'],
            [['nombre_profesional_acompanamiento'], 'string', 'max' => 100],
            [['id'], 'unique'],
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
            'nombre_profesional_acompanamiento' => 'Nombre Profesional Acompañamiento',
            'id_docente' => 'Docente',
            'id_institucion' => 'Institución',
            'id_sede' => 'Sede',
        ];
    }
}
