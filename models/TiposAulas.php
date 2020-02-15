<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tipos_aulas".
 *
 * @property string $id
 * @property string $descripcion
 *
 * @property Aulas[] $aulas
 */
class TiposAulas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tipos_aulas';
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
    public function getAulas()
    {
        return $this->hasMany(Aulas::className(), ['id_tipos_aulas' => 'id']);
    }
}
