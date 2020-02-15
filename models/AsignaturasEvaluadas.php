<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "asignaturas_evaluadas".
 *
 * @property string $id
 * @property string $descripcion
 * @property string $estado
 *
 * @property AsignaturaEspecifica[] $asignaturaEspecificas
 * @property Estados $estado0
 */
class AsignaturasEvaluadas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'asignaturas_evaluadas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['descripcion', 'estado'], 'required'],
            [['estado'], 'default', 'value' => null],
            [['estado'], 'integer'],
            [['descripcion'], 'string', 'max' => 100],
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
    public function getAsignaturaEspecificas()
    {
        return $this->hasMany(AsignaturaEspecifica::className(), ['id_asignatura_evaluada' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstado0()
    {
        return $this->hasOne(Estados::className(), ['id' => 'estado']);
    }
}
