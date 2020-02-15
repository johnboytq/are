<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "semilleros_tic.sesiones".
 *
 * @property string $id
 * @property string $descripcion
 * @property string $id_fase
 * @property string $estado
 */
class Sesiones extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'semilleros_tic.sesiones';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['descripcion', 'id_fase', 'estado'], 'required'],
            [['id_fase', 'estado'], 'default', 'value' => null],
            [['id_fase', 'estado'], 'integer'],
            [['descripcion'], 'string', 'max' => 200],
            [['estado'], 'exist', 'skipOnError' => true, 'targetClass' => Estados::className(), 'targetAttribute' => ['estado' => 'id']],
            [['id_fase'], 'exist', 'skipOnError' => true, 'targetClass' => SemillerosTicFases::className(), 'targetAttribute' => ['id_fase' => 'id']],
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
            'id_fase' => 'Id Fase',
            'estado' => 'Estado',
        ];
    }
}
