<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tipos_participacion".
 *
 * @property string $id
 * @property string $descripcion
 * @property string $estado
 *
 * @property NombresProyectosParticipacion[] $nombresProyectosParticipacions
 * @property Estados $estado0
 */
class TiposParticipacion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tipos_participacion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['descripcion', 'estado'], 'required'],
            [['descripcion'], 'string'],
            [['estado'], 'default', 'value' => null],
            [['estado'], 'integer'],
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
            'descripcion' => 'Descripcion',
            'estado' => 'Estado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNombresProyectosParticipacions()
    {
        return $this->hasMany(NombresProyectosParticipacion::className(), ['tipo' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstado0()
    {
        return $this->hasOne(Estados::className(), ['id' => 'estado']);
    }
}
