<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "barrios_veredas".
 *
 * @property string $id
 * @property string $descripcion
 * @property string $id_comunas_corregimientos
 * @property string $cod_dane
 *
 * @property ComunasCorregimientos $comunasCorregimientos
 * @property Personas[] $personas
 * @property Sedes[] $sedes
 */
class BarriosVeredas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'barrios_veredas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_comunas_corregimientos'], 'default', 'value' => null],
            [['id_comunas_corregimientos'], 'integer'],
            [['descripcion'], 'string', 'max' => 100],
            [['cod_dane'], 'string', 'max' => 50],
            [['id_comunas_corregimientos'], 'exist', 'skipOnError' => true, 'targetClass' => ComunasCorregimientos::className(), 'targetAttribute' => ['id_comunas_corregimientos' => 'id']],
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
            'id_comunas_corregimientos' => 'Id Comunas Corregimientos',
            'cod_dane' => 'Cod Dane',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComunasCorregimientos()
    {
        return $this->hasOne(ComunasCorregimientos::className(), ['id' => 'id_comunas_corregimientos']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersonas()
    {
        return $this->hasMany(Personas::className(), ['id_barrios_veredas' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSedes()
    {
        return $this->hasMany(Sedes::className(), ['id_barrios_veredas' => 'id']);
    }
}
