<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "jornadas".
 *
 * @property string $id
 * @property string $descripcion
 *
 * @property SedesJornadas[] $sedesJornadas
 */
class Jornadas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'jornadas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['descripcion'], 'string', 'max' => 60],
            [['descripcion'], 'required' ],
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
    public function getSedesJornadas()
    {
        return $this->hasMany(SedesJornadas::className(), ['id_jornadas' => 'id']);
    }
}
