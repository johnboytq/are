<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sedes_areas_ensenanza".
 *
 * @property string $id
 * @property string $id_sedes
 * @property string $id_areas_ensenanza
 *
 * @property AreasEnsenanza $areasEnsenanza
 * @property Sedes $sedes
 */
class SedesAreasEnsenanza extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sedes_areas_ensenanza';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // [['id'], 'required'],
            [['id_sedes', 'id_areas_ensenanza'], 'default', 'value' => null],
            [['id_sedes', 'id_areas_ensenanza'], 'integer'],
            [['id'], 'unique'],
            [['id_areas_ensenanza'], 'exist', 'skipOnError' => true, 'targetClass' => AreasEnsenanza::className(), 'targetAttribute' => ['id_areas_ensenanza' => 'id']],
            [['id_sedes'], 'exist', 'skipOnError' => true, 'targetClass' => Sedes::className(), 'targetAttribute' => ['id_sedes' => 'id']],
            [['id_sedes'], 'required'],
            [['id_areas_ensenanza'], 'required'],
            [['id_sedes','id_areas_ensenanza'],'unique','targetAttribute'=>['id_sedes','id_areas_ensenanza']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_sedes' => 'Sede',
            'id_areas_ensenanza' => 'Especialidad',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAreasEnsenanza()
    {
        return $this->hasOne(AreasEnsenanza::className(), ['id' => 'id_areas_ensenanza']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSedes()
    {
        return $this->hasOne(Sedes::className(), ['id' => 'id_sedes']);
    }
}
