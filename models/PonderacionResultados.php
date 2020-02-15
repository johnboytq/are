<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ponderacion_resultados".
 *
 * @property string $id
 * @property string $id_periodo
 * @property int $calificacion
 * @property string $estado
 *
 * @property Estados $estado0
 * @property Periodos $periodo
 */
class PonderacionResultados extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ponderacion_resultados';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_periodo', 'calificacion', 'estado'], 'default', 'value' => null],
            [['id_periodo', 'calificacion', 'estado'], 'integer'],
            [['id_periodo', 'calificacion', 'estado','id_sede'], 'required'],
            [['estado'], 'exist', 'skipOnError' => true, 'targetClass' => Estados::className(), 'targetAttribute' => ['estado' => 'id']],
            [['id_periodo'], 'exist', 'skipOnError' => true, 'targetClass' => Periodos::className(), 'targetAttribute' => ['id_periodo' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_periodo' => 'Periodo',
            'calificacion' => 'Calificación en %',
            'estado' => 'Estado',
            'id_sede' => 'Sede',
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
    public function getPeriodo()
    {
        return $this->hasOne(Periodos::className(), ['id' => 'id_periodo']);
    }
}
