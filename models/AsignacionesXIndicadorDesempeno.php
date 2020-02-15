<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "asignaciones_x_indicador_desempeno".
 *
 * @property string $id
 * @property string $id_asignaciones
 * @property string $id_indicador_desempeno
 *
 * @property Asignaciones $asignaciones
 * @property IndicadorDesempeno $indicadorDesempeno
 * @property Calificaciones[] $calificaciones
 */
class AsignacionesXIndicadorDesempeno extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'asignaciones_x_indicador_desempeno';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_asignaciones', 'id_indicador_desempeno'], 'default', 'value' => null],
            [['id_asignaciones', 'id_indicador_desempeno'], 'integer'],
            [['id_asignaciones'], 'exist', 'skipOnError' => true, 'targetClass' => Asignaciones::className(), 'targetAttribute' => ['id_asignaciones' => 'id']],
            [['id_indicador_desempeno'], 'exist', 'skipOnError' => true, 'targetClass' => IndicadorDesempeno::className(), 'targetAttribute' => ['id_indicador_desempeno' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_asignaciones' => 'Id Asignaciones',
            'id_indicador_desempeno' => 'Id Indicador Desempeno',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAsignaciones()
    {
        return $this->hasOne(Asignaciones::className(), ['id' => 'id_asignaciones']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIndicadorDesempeno()
    {
        return $this->hasOne(IndicadorDesempeno::className(), ['id' => 'id_indicador_desempeno']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCalificaciones()
    {
        return $this->hasMany(Calificaciones::className(), ['id_asignaciones_x_indicador_desempeno' => 'id']);
    }
}
