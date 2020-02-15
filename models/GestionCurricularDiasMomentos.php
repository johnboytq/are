<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "gestion_curricular.dias_momentos".
 *
 * @property string $id
 * @property string $descripcion
 * @property string $id_momento
 * @property string $estado
 */
class GestionCurricularDiasMomentos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gestion_curricular.dias_momentos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['descripcion', 'id_momento', 'estado'], 'required'],
            [['id_momento', 'estado'], 'default', 'value' => null],
            [['id_momento', 'estado'], 'integer'],
            [['descripcion'], 'string', 'max' => 800],
            [['id_momento'], 'exist', 'skipOnError' => true, 'targetClass' => GestionCurricularMomentos::className(), 'targetAttribute' => ['id_momento' => 'id']],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => Estados::className(), 'targetAttribute' => ['id' => 'id']],
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
            'id_momento' => 'Id Momento',
            'estado' => 'Estado',
        ];
    }
}
