<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tenencias".
 *
 * @property string $id
 * @property string $descripcion
 *
 * @property Sedes[] $sedes
 */
class Tenencias extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tenencias';
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
    public function getSedes()
    {
        return $this->hasMany(Sedes::className(), ['id_tenencias' => 'id']);
    }
}
