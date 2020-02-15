<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "proceso_especifico".
 *
 * @property string $id
 * @property string $descripcion
 * @property string $id_sub_proceso
 * @property string $estado
 *
 * @property Pmi[] $pmis
 * @property Estados $estado0
 * @property SubProcesoEvaluacion $subProceso
 */
class ProcesoEspecifico extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'proceso_especifico';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['descripcion', 'id_sub_proceso', 'estado'], 'required'],
            [['id_sub_proceso', 'estado'], 'default', 'value' => null],
            [['id_sub_proceso', 'estado'], 'integer'],
            [['descripcion'], 'string', 'max' => 100],
            [['estado'], 'exist', 'skipOnError' => true, 'targetClass' => Estados::className(), 'targetAttribute' => ['estado' => 'id']],
            [['id_sub_proceso'], 'exist', 'skipOnError' => true, 'targetClass' => SubProcesoEvaluacion::className(), 'targetAttribute' => ['id_sub_proceso' => 'id']],
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
            'id_sub_proceso' => 'Id Sub Proceso',
            'estado' => 'Estado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPmis()
    {
        return $this->hasMany(Pmi::className(), ['id_proceso_especifico' => 'id']);
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
    public function getSubProceso()
    {
        return $this->hasOne(SubProcesoEvaluacion::className(), ['id' => 'id_sub_proceso']);
    }
}
