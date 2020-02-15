<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "asignatura_especifica".
 *
 * @property string $id
 * @property string $descripcion
 * @property string $id_asignatura_evaluada
 * @property string $estado
 *
 * @property AsignaturasEvaluadas $asignaturaEvaluada
 * @property Estados $estado0
 * @property ResultadosPruebasSaberCali[] $resultadosPruebasSaberCalis
 * @property ResultadosPruebasSaberIe[] $resultadosPruebasSaberIes
 */
class AsignaturaEspecifica extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'asignatura_especifica';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['descripcion', 'id_asignatura_evaluada', 'estado'], 'required'],
            [['id_asignatura_evaluada', 'estado'], 'default', 'value' => null],
            [['id_asignatura_evaluada', 'estado'], 'integer'],
            [['descripcion'], 'string', 'max' => 100],
            [['id_asignatura_evaluada'], 'exist', 'skipOnError' => true, 'targetClass' => AsignaturasEvaluadas::className(), 'targetAttribute' => ['id_asignatura_evaluada' => 'id']],
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
            'id_asignatura_evaluada' => 'Id Asignatura Evaluada',
            'estado' => 'Estado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAsignaturaEvaluada()
    {
        return $this->hasOne(AsignaturasEvaluadas::className(), ['id' => 'id_asignatura_evaluada']);
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
    public function getResultadosPruebasSaberCalis()
    {
        return $this->hasMany(ResultadosPruebasSaberCali::className(), ['id_asignatura_especifica' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResultadosPruebasSaberIes()
    {
        return $this->hasMany(ResultadosPruebasSaberIe::className(), ['id_asignatura_espacifica' => 'id']);
    }
}
