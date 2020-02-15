<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tipos_apoyo_academico".
 *
 * @property string $id
 * @property string $descripcion
 * @property string $estado
 *
 * @property ApoyoAcademico[] $apoyoAcademicos
 */
class TiposApoyoAcademico extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tipos_apoyo_academico';
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
            [['descripcion'], 'string', 'max' => 100],
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
    public function getApoyoAcademicos()
    {
        return $this->hasMany(ApoyoAcademico::className(), ['id_tipo_apoyo' => 'id']);
    }
}
