<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "categorias_cobertura".
 *
 * @property string $id
 * @property string $descripcion
 * @property string $estado
 *
 * @property Estados $estado0
 * @property SubCategoriasCobertura[] $subCategoriasCoberturas
 */
class CategoriasCobertura extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'categorias_cobertura';
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
    public function getEstado0()
    {
        return $this->hasOne(Estados::className(), ['id' => 'estado']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubCategoriasCoberturas()
    {
        return $this->hasMany(SubCategoriasCobertura::className(), ['id_categoria' => 'id']);
    }
}
