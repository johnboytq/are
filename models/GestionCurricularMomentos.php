<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "gestion_curricular.momentos".
 *
 * @property string $id
 * @property string $descripcion
 * @property string $id_semana
 * @property string $estado
 */
class GestionCurricularMomentos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gestion_curricular.momentos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['descripcion', 'id_semana', 'estado'], 'required'],
            [['id_semana', 'estado'], 'default', 'value' => null],
            [['id_semana', 'estado'], 'integer'],
            [['descripcion'], 'string', 'max' => 800],
            [['id_semana'], 'exist', 'skipOnError' => true, 'targetClass' => GestionCurricularSemanas::className(), 'targetAttribute' => ['id_semana' => 'id']],
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
            'id_semana' => 'Id Semana',
            'estado' => 'Estado',
        ];
    }
}
