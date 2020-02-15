<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sedes_x_bloques".
 *
 * @property string $id
 * @property string $id_sedes
 * @property string $id_bloques
 *
 * @property Bloques $bloques
 * @property Sedes $sedes
 */
class SedesBloques extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sedes_x_bloques';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_sedes', 'id_bloques'], 'default', 'value' => null],
            [['id_sedes', 'id_bloques'], 'integer'],
            [['id_bloques'], 'exist', 'skipOnError' => true, 'targetClass' => Bloques::className(), 'targetAttribute' => ['id_bloques' => 'id']],
            [['id_sedes'], 'exist', 'skipOnError' => true, 'targetClass' => Sedes::className(), 'targetAttribute' => ['id_sedes' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_sedes' => 'Id Sedes',
            'id_bloques' => 'Bloque',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBloques()
    {
        return $this->hasOne(Bloques::className(), ['id' => 'id_bloques']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSedes()
    {
        return $this->hasOne(Sedes::className(), ['id' => 'id_sedes']);
    }
}
