<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "areas_ensenanza".
 *
 * @property string $id
 * @property string $descripcion
 * @property string $estado
 *
 * @property Estados $estado0
 * @property SedesAreasEnsenanza[] $sedesAreasEnsenanzas
 */
class AreasEnsenanza extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'areas_ensenanza';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'estado'], 'default', 'value' => null],
            [['id', 'estado'], 'integer'],
            [['descripcion'], 'string', 'max' => 1000],
            [['id'], 'unique'],
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
            'estado' => 'Estado',
        ];
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
    public function getSedesAreasEnsenanzas()
    {
        return $this->hasMany(SedesAreasEnsenanza::className(), ['id_areas_ensenanza' => 'id']);
    }
}
