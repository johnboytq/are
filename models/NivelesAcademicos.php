<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "niveles_academicos".
 *
 * @property string $id
 * @property string $descripcion
 *
 * @property Niveles[] $niveles
 */
class NivelesAcademicos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'niveles_academicos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['descripcion'], 'string', 'max' => 20],
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
    public function getNiveles()
    {
        return $this->hasMany(Niveles::className(), ['id_niveles_academicos' => 'id']);
    }
}
