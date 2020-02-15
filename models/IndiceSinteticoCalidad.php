<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "indice_sintetico_calidad".
 *
 * @property string $id
 * @property string $anio
 * @property string $id_indice_especifico
 * @property string $valor
 * @property string $estado
 *
 * @property Estados $estado0
 * @property IndiceEspecifico $indiceEspecifico
 */
class IndiceSinteticoCalidad extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'indice_sintetico_calidad';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['anio', 'id_indice_especifico', 'valor', 'estado'], 'required'],
            [['id_indice_especifico', 'valor', 'estado'], 'default', 'value' => null],
            [['id_indice_especifico', 'estado'], 'integer'],
            [['valor'], 'double'],
            [['anio'], 'integer'],
            [['estado'], 'exist', 'skipOnError' => true, 'targetClass' => Estados::className(), 'targetAttribute' => ['estado' => 'id']],
            [['id_indice_especifico'], 'exist', 'skipOnError' => true, 'targetClass' => IndiceEspecifico::className(), 'targetAttribute' => ['id_indice_especifico' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' 					=> 'ID',
            'anio' 					=> 'Año',
            'id_indice_especifico' 	=> 'Indice Específico',
            'valor' 				=> 'Valor',
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
    public function getIndiceEspecifico()
    {
        return $this->hasOne(IndiceEspecifico::className(), ['id' => 'id_indice_especifico']);
    }
}
