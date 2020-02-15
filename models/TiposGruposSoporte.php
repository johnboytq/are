<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tipos_grupos_soporte".
 *
 * @property string $id
 * @property string $descripcion
 * @property string $estado
 *
 * @property GruposSoporte[] $gruposSoportes
 * @property Estados $estado0
 */
class TiposGruposSoporte extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tipos_grupos_soporte';
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
            [['descripcion'], 'string', 'max' => 200],
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
    public function getGruposSoportes()
    {
        return $this->hasMany(GruposSoporte::className(), ['id_tipo_grupos' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstado0()
    {
        return $this->hasOne(Estados::className(), ['id' => 'estado']);
    }
}
