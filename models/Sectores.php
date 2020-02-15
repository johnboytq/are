<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sectores".
 *
 * @property string $id
 * @property string $descripcion
 *
 * @property Instituciones[] $instituciones
 */
class Sectores extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sectores';
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
        return $this->hasMany(Instituciones::className(), ['id_sectores' => 'id']);
    }
}
