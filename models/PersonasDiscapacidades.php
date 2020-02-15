<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "personas_x_discapacidades".
 *
 * @property string $id_personas
 * @property string $id_tipos_discapacidades
 * @property string $descripcion
 *
 * @property Personas $personas
 * @property TiposDiscapacidades $tiposDiscapacidades
 */
class PersonasDiscapacidades extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'personas_x_discapacidades';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_personas', 'id_tipos_discapacidades'], 'required'],
            [['id_personas', 'id_tipos_discapacidades'], 'default', 'value' => null],
            [['id_personas', 'id_tipos_discapacidades'], 'integer'],
            [['descripcion', 'alergico'], 'string'],
            [['id_personas', 'id_tipos_discapacidades'], 'unique', 'targetAttribute' => ['id_personas', 'id_tipos_discapacidades']],
            [['id_personas'], 'exist', 'skipOnError' => true, 'targetClass' => Personas::className(), 'targetAttribute' => ['id_personas' => 'id']],
            [['id_tipos_discapacidades'], 'exist', 'skipOnError' => true, 'targetClass' => TiposDiscapacidades::className(), 'targetAttribute' => ['id_tipos_discapacidades' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_personas' => 'Persona',
            'id_tipos_discapacidades' => 'Tipos Discapacidad',
            'descripcion' => 'Descripción',
            'alergico' => 'Alérgico',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersonas()
    {
        return $this->hasOne(Personas::className(), ['id' => 'id_personas']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTiposDiscapacidades()
    {
        return $this->hasOne(TiposDiscapacidades::className(), ['id' => 'id_tipos_discapacidades']);
    }
}
