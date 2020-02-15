<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "temas_cobertura".
 *
 * @property string $id
 * @property string $descripcion
 * @property string $id_subCategoria
 * @property string $estado
 *
 * @property SedesCobertura[] $sedesCoberturas
 * @property Estados $estado0
 * @property SubCategoriasCobertura $subCategoria
 */
class TemasCobertura extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'temas_cobertura';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['descripcion', 'id_subCategoria', 'estado'], 'required'],
            [['id_subCategoria', 'estado'], 'default', 'value' => null],
            [['id_subCategoria', 'estado'], 'integer'],
            [['descripcion'], 'string', 'max' => 200],
            [['estado'], 'exist', 'skipOnError' => true, 'targetClass' => Estados::className(), 'targetAttribute' => ['estado' => 'id']],
            [['id_subCategoria'], 'exist', 'skipOnError' => true, 'targetClass' => SubCategoriasCobertura::className(), 'targetAttribute' => ['id_subCategoria' => 'id']],
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
            'id_subCategoria' => 'Id Sub Categoria',
            'estado' => 'Estado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSedesCoberturas()
    {
        return $this->hasMany(SedesCobertura::className(), ['id_tema' => 'id']);
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
    public function getSubCategoria()
    {
        return $this->hasOne(SubCategoriasCobertura::className(), ['id' => 'id_subCategoria']);
    }
}
