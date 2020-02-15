<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tipos_discapacidades".
 *
 * @property string $id
 * @property string $descripcion
 * @property string $estado
 *
 * @property PersonasXDiscapacidades[] $personasXDiscapacidades
 * @property Personas[] $personas
 * @property Estados $estado0
 */
class TiposDiscapacidades extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tipos_discapacidades';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['estado'], 'default', 'value' => null],
            [['estado'], 'integer'],
            [['descripcion'], 'string', 'max' => 100],
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
    public function getPersonasXDiscapacidades()
    {
        return $this->hasMany(PersonasXDiscapacidades::className(), ['id_tipos_discapacidades' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersonas()
    {
        return $this->hasMany(Personas::className(), ['id' => 'id_personas'])->viaTable('personas_x_discapacidades', ['id_tipos_discapacidades' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstado0()
    {
        return $this->hasOne(Estados::className(), ['id' => 'estado']);
    }
}
