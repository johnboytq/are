<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "gestion_curricular.ciclos".
 *
 * @property string $id
 * @property string $descripcion
 * @property string $fecha_inicial
 * @property string $fecha_final
 * @property string $estado
 */
class GestionCurricularCiclos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gestion_curricular.ciclos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['descripcion', 'fecha_inicial', 'fecha_final', 'estado'], 'required'],
            [['fecha_inicial', 'fecha_final'], 'safe'],
            [['estado'], 'default', 'value' => null],
            [['estado'], 'integer'],
            [['descripcion'], 'string', 'max' => 100],
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
            'descripcion' => 'Descripción',
            'fecha_inicial' => 'Fecha Inicial',
            'fecha_final' => 'Fecha Final',
            'estado' => 'Estado',
        ];
    }
}
