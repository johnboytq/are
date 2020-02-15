<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "distribuciones_x_bloques_x_dias".
 *
 * @property string $id_distribuciones_academicas
 * @property string $id_bloques_sedes
 * @property string $id_dias
 * @property string $id
 *
 * @property Dias $dias
 * @property DistribucionesAcademicas $distribucionesAcademicas
 * @property SedesXBloques $bloquesSedes
 */
class DistribucionesXBloquesXDias extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'distribuciones_x_bloques_x_dias';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_distribuciones_academicas', 'id_bloques_sedes', 'id_dias'], 'required'],
            [['id_distribuciones_academicas', 'id_bloques_sedes', 'id_dias'], 'default', 'value' => null],
            [['id_distribuciones_academicas', 'id_bloques_sedes', 'id_dias'], 'integer'],
            [['id_dias'], 'exist', 'skipOnError' => true, 'targetClass' => Dias::className(), 'targetAttribute' => ['id_dias' => 'id']],
            [['id_distribuciones_academicas'], 'exist', 'skipOnError' => true, 'targetClass' => DistribucionesAcademicas::className(), 'targetAttribute' => ['id_distribuciones_academicas' => 'id']],
            [['id_bloques_sedes'], 'exist', 'skipOnError' => true, 'targetClass' => SedesXBloques::className(), 'targetAttribute' => ['id_bloques_sedes' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_distribuciones_academicas' => 'Id Distribuciones Academicas',
            'id_bloques_sedes' => 'Id Bloques Sedes',
            'id_dias' => 'Id Dias',
            'id' => 'ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDias()
    {
        return $this->hasOne(Dias::className(), ['id' => 'id_dias']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDistribucionesAcademicas()
    {
        return $this->hasOne(DistribucionesAcademicas::className(), ['id' => 'id_distribuciones_academicas']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBloquesSedes()
    {
        return $this->hasOne(SedesXBloques::className(), ['id' => 'id_bloques_sedes']);
    }
}
