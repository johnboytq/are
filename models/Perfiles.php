<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "perfiles".
 *
 * @property string $id
 * @property string $descripcion
 * @property int $jerarquia
 * @property string $estado
 *
 * @property Estados $estado0
 * @property PerfilesXPersonas[] $perfilesXPersonas
 * @property Permisos[] $permisos
 */
class Perfiles extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'perfiles';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['descripcion'], 'string'],
            [['descripcion','id'], 'required'],
            [['jerarquia', 'estado'], 'default', 'value' => null],
            [['jerarquia', 'estado'], 'integer'],
            [['estado'], 'exist', 'skipOnError' => true, 'targetClass' => Estados::className(), 'targetAttribute' => ['estado' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Perfil',
            'descripcion' => 'Perfil',
            'jerarquia' => 'Jerarquia',
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
    public function getPerfilesXPersonas()
    {
        return $this->hasMany(PerfilesXPersonas::className(), ['id_perfiles' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPermisos()
    {
        return $this->hasMany(Permisos::className(), ['id_perfiles' => 'id']);
    }
}
