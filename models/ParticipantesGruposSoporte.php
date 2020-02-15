<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "participantes_grupos_soporte".
 *
 * @property string $id
 * @property string $id_grupo_soporte
 * @property string $edad
 * @property string $id_paralelo
 * @property string $id_sede
 * @property string $nombre_equipo
 * @property string $estado
 * @property string $id_persona
 *
 * @property Estados $estado0
 * @property GruposSoporte $grupoSoporte
 * @property Paralelos $paralelo
 * @property Personas $persona
 * @property Sedes $sede
 */
class ParticipantesGruposSoporte extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'participantes_grupos_soporte';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_grupo_soporte', 'id_sede'], 'required'],
            [['id_grupo_soporte', 'id_sede', 'estado', 'id_persona'], 'default', 'value' => null],
            [['id_grupo_soporte', 'id_sede', 'estado', 'id_persona'], 'integer'],
            [['edad'], 'string', 'max' => 10],
            [['nombre_equipo'], 'string', 'max' => 50],
            [['estado'], 'exist', 'skipOnError' => true, 'targetClass' => Estados::className(), 'targetAttribute' => ['estado' => 'id']],
            [['id_grupo_soporte'], 'exist', 'skipOnError' => true, 'targetClass' => GruposSoporte::className(), 'targetAttribute' => ['id_grupo_soporte' => 'id']],
            [['id_persona'], 'exist', 'skipOnError' => true, 'targetClass' => Personas::className(), 'targetAttribute' => ['id_persona' => 'id']],
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
            'id_grupo_soporte' => 'Grupo Soporte',
            'edad' => 'Edad',
            'id_sede' => 'Id Sede',
            'nombre_equipo' => 'Nombre Equipo',
            'estado' => 'Estado',
            'id_persona' => 'Estudiante',
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
    public function getGrupoSoporte()
    {
        return $this->hasOne(GruposSoporte::className(), ['id' => 'id_grupo_soporte']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersona()
    {
        return $this->hasOne(Personas::className(), ['id' => 'id_persona']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSede()
    {
        return $this->hasOne(Sedes::className(), ['id' => 'id_sede']);
    }
}
