<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "estados".
 *
 * @property string $id
 * @property string $descripcion
 *
 * @property Instituciones[] $instituciones
 * @property Instituciones[] $instituciones0
 * @property Personas[] $personas
 */
class Estados extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'estados';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInstituciones()
    {
        return $this->hasMany(Instituciones::className(), ['estado' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInstituciones0()
    {
        return $this->hasMany(Instituciones::className(), ['estado' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersonas()
    {
        return $this->hasMany(Personas::className(), ['estado' => 'id']);
    }
}
