<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tipos_formaciones".
 *
 * @property string $id
 * @property string $descripcion
 * @property string $estado
 *
 * @property PersonasXFormaciones[] $personasXFormaciones
 * @property Estados $estado0
 */
class TiposFormaciones extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tipos_formaciones';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['estado'], 'default', 'value' => null],
            [['estado'], 'integer'],
            [['descripcion'], 'string', 'max' => 40],
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
    public function getPersonasXFormaciones()
    {
        return $this->hasMany(PersonasXFormaciones::className(), ['id_tipos_formaciones' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstado0()
    {
        return $this->hasOne(Estados::className(), ['id' => 'estado']);
    }
}
