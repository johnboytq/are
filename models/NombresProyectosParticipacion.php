<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "nombres_proyectos_participacion".
 *
 * @property string $id
 * @property string $descripcion
 * @property string $tipo
 * @property string $estado
 *
 * @property Estados $estado0
 * @property TiposParticipacion $tipo0
 * @property ParticipacionProyectosIE[] $participacionProyectosIEs
 */
class NombresProyectosParticipacion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'nombres_proyectos_participacion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['descripcion', 'estado'], 'required'],
            [['tipo', 'estado'], 'default', 'value' => null],
            [['tipo', 'estado'], 'integer'],
            [['descripcion'], 'string', 'max' => 100],
            [['estado'], 'exist', 'skipOnError' => true, 'targetClass' => Estados::className(), 'targetAttribute' => ['estado' => 'id']],
            [['tipo'], 'exist', 'skipOnError' => true, 'targetClass' => TiposParticipacion::className(), 'targetAttribute' => ['tipo' => 'id']],
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
            'tipo' => 'Tipo',
            'estado' => 'Estado',
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
    public function getTipo0()
    {
        return $this->hasOne(TiposParticipacion::className(), ['id' => 'tipo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParticipacionProyectosIEs()
    {
        return $this->hasMany(ParticipacionProyectosIE::className(), ['programa_proyecto' => 'id']);
    }
}
