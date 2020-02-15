<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "comunas_corregimientos".
 *
 * @property string $id
 * @property string $descripcion
 * @property string $id_municipios
 * @property string $cod_dane
 * @property string $estado
 *
 * @property BarriosVeredas[] $barriosVeredas
 * @property Estados $estado0
 * @property Municipios $municipios
 */
class ComunasCorregimientos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comunas_corregimientos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_municipios', 'estado'], 'default', 'value' => null],
            [['id_municipios', 'estado'], 'integer'],
            [['descripcion'], 'string', 'max' => 100],
            [['cod_dane'], 'string', 'max' => 50],
            [['estado'], 'exist', 'skipOnError' => true, 'targetClass' => Estados::className(), 'targetAttribute' => ['estado' => 'id']],
            [['id_municipios'], 'exist', 'skipOnError' => true, 'targetClass' => Municipios::className(), 'targetAttribute' => ['id_municipios' => 'id']],
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
            'id_municipios' => 'Id Municipios',
            'cod_dane' => 'Cod Dane',
            'estado' => 'Estado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBarriosVeredas()
    {
        return $this->hasMany(BarriosVeredas::className(), ['id_comunas_corregimientos' => 'id']);
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
    public function getMunicipios()
    {
        return $this->hasOne(Municipios::className(), ['id' => 'id_municipios']);
    }
}
