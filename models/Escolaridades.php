<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "escolaridades".
 *
 * @property string $id
 * @property string $descripcion
 * @property string $estado
 *
 * @property Estados $estado0
 * @property PersonasXEscolaridades[] $personasXEscolaridades
 */
class Escolaridades extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'escolaridades';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['estado'], 'default', 'value' => null],
            [['estado'], 'integer'],
            [['descripcion'], 'string', 'max' => 50],
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
    public function getEstado0()
    {
        return $this->hasOne(Estados::className(), ['id' => 'estado']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersonasXEscolaridades()
    {
        return $this->hasMany(PersonasXEscolaridades::className(), ['id_escolaridades' => 'id']);
    }
}
