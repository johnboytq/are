<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tipos_instituciones".
 *
 * @property string $id
 * @property string $descripcion
 *
 * @property Instituciones[] $instituciones
 */
class TiposInstituciones extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tipos_instituciones';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['descripcion'], 'string', 'max' => 60],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInstituciones()
    {
        return $this->hasMany(Instituciones::className(), ['id_tipos_instituciones' => 'id']);
    }
}
