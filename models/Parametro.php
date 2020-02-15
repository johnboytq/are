<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "parametro".
 *
 * @property string $id
 * @property string $descripcion
 * @property string $id_tipo_parametro
 * @property string $estado
 *
 * @property Estados $estado0
 * @property TipoParametro $tipoParametro
 */
class Parametro extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'parametro';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['descripcion', 'id_tipo_parametro', 'estado'], 'required'],
            [['id_tipo_parametro', 'estado'], 'default', 'value' => null],
            [['id_tipo_parametro', 'estado'], 'integer'],
            [['descripcion'], 'string', 'max' => 100],
            [['estado'], 'exist', 'skipOnError' => true, 'targetClass' => Estados::className(), 'targetAttribute' => ['estado' => 'id']],
            [['id_tipo_parametro'], 'exist', 'skipOnError' => true, 'targetClass' => TipoParametro::className(), 'targetAttribute' => ['id_tipo_parametro' => 'id']],
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
            'id_tipo_parametro' => 'Id Tipo Parametro',
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
    public function getTipoParametro()
    {
        return $this->hasOne(TipoParametro::className(), ['id' => 'id_tipo_parametro']);
    }
}
