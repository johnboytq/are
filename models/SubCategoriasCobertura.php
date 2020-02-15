<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sub_categorias_cobertura".
 *
 * @property string $id
 * @property string $descripcion
 * @property string $id_categoria
 * @property string $estado
 *
 * @property CategoriasCobertura $categoria
 * @property Estados $estado0
 * @property TemasCobertura[] $temasCoberturas
 */
class SubCategoriasCobertura extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sub_categorias_cobertura';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['descripcion', 'id_categoria', 'estado'], 'required'],
            [['id_categoria', 'estado'], 'default', 'value' => null],
            [['id_categoria', 'estado'], 'integer'],
            [['descripcion'], 'string', 'max' => 200],
            [['id_categoria'], 'exist', 'skipOnError' => true, 'targetClass' => CategoriasCobertura::className(), 'targetAttribute' => ['id_categoria' => 'id']],
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
            'id_categoria' => 'Id Categoria',
            'estado' => 'Estado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoria()
    {
        return $this->hasOne(CategoriasCobertura::className(), ['id' => 'id_categoria']);
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
    public function getTemasCoberturas()
    {
        return $this->hasMany(TemasCobertura::className(), ['id_subCategoria' => 'id']);
    }
}
