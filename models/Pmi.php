<?php

/**********
Versión: 001
Fecha: 12-07-2018
Desarrollador: Edwin Molina Grisales
Descripción: CRUD PMI
---------------------------------------
**********/


namespace app\models;

use Yii;

/**
 * This is the model class for table "pmi".
 *
 * @property string $id
 * @property string $codigo_dane
 * @property string $anio
 * @property string $comuna
 * @property string $zona
 * @property string $id_proceso_especifico
 * @property string $valor
 * @property string $id_institucion
 * @property string $estado
 *
 * @property Estados $estado0
 * @property Instituciones $institucion
 * @property ProcesoEspecifico $procesoEspecifico
 */
class Pmi extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pmi';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['codigo_dane', 'anio', 'comuna', 'zona', 'id_proceso_especifico', 'valor', 'id_institucion', 'estado'], 'required'],
            [['comuna', 'id_proceso_especifico', 'id_institucion', 'estado'], 'default', 'value' => null],
            [['comuna', 'id_proceso_especifico', 'id_institucion', 'estado'], 'integer'],
            [['codigo_dane', 'anio', 'zona'], 'string', 'max' => 100],
            [['valor'], 'integer'],
            [['estado'], 'exist', 'skipOnError' => true, 'targetClass' => Estados::className(), 'targetAttribute' => ['estado' => 'id']],
            [['id_institucion'], 'exist', 'skipOnError' => true, 'targetClass' => Instituciones::className(), 'targetAttribute' => ['id_institucion' => 'id']],
            [['id_proceso_especifico'], 'exist', 'skipOnError' => true, 'targetClass' => ProcesoEspecifico::className(), 'targetAttribute' => ['id_proceso_especifico' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' 					=> 'ID',
            'codigo_dane' 			=> 'Código Dane',
            'anio' 					=> 'Año',
            'comuna' 				=> 'Comuna',
            'zona' 					=> 'Zona',
            'id_proceso_especifico' => 'Proceso específico',
            'valor' 				=> 'Valor',
            'id_institucion' 		=> 'Institución',
            'estado' 				=> 'Estado',
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
    public function getInstitucion()
    {
        return $this->hasOne(Instituciones::className(), ['id' => 'id_institucion']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProcesoEspecifico()
    {
        return $this->hasOne(ProcesoEspecifico::className(), ['id' => 'id_proceso_especifico']);
    }
}
