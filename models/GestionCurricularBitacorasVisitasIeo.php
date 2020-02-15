<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "gestion_curricular.bitacoras_visitas_ieo".
 *
 * @property string $id
 * @property string $fecha_inicio
 * @property string $fecha_fin
 * @property string $id_persona_docente_tutor
 * @property string $id_institucion
 * @property string $id_sede
 * @property string $id_jornada
 * @property string $estado
 */
class GestionCurricularBitacorasVisitasIeo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gestion_curricular.bitacoras_visitas_ieo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fecha_inicio', 'fecha_fin', 'id_persona_docente_tutor', 'id_institucion', 'id_sede', 'id_jornada'], 'required'],
            [['fecha_inicio', 'fecha_fin'], 'safe'],
            [['id_persona_docente_tutor', 'id_institucion', 'id_sede', 'id_jornada', 'estado'], 'default', 'value' => null],
            [['id_persona_docente_tutor', 'id_institucion', 'id_sede', 'id_jornada', 'estado'], 'integer'],
            [['estado'], 'exist', 'skipOnError' => true, 'targetClass' => Estados::className(), 'targetAttribute' => ['estado' => 'id']],
            [['id_institucion'], 'exist', 'skipOnError' => true, 'targetClass' => Instituciones::className(), 'targetAttribute' => ['id_institucion' => 'id']],
            [['id_jornada'], 'exist', 'skipOnError' => true, 'targetClass' => Jornadas::className(), 'targetAttribute' => ['id_jornada' => 'id']],
            [['id_persona_docente_tutor'], 'exist', 'skipOnError' => true, 'targetClass' => Personas::className(), 'targetAttribute' => ['id_persona_docente_tutor' => 'id']],
            [['id_sede'], 'exist', 'skipOnError' => true, 'targetClass' => Sedes::className(), 'targetAttribute' => ['id_sede' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fecha_inicio' => 'Fecha Inicio',
            'fecha_fin' => 'Fecha Fin',
            'id_persona_docente_tutor' => 'Docente / Tutor',
            'id_institucion' => 'Institución',
            'id_sede' => 'Sede',
            'id_jornada' => 'Jornada',
            'estado' => 'Estado',
        ];
    }
}
