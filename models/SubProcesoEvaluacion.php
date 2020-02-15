<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sub_proceso_evaluacion".
 *
 * @property string $id
 * @property string $descripcion
 * @property string $id_area_gestion
 * @property string $estado
 *
 * @property ProcesoEspecifico[] $procesoEspecificos
 * @property AreaGestion $areaGestion
 * @property Estados $estado0
 */
class SubProcesoEvaluacion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sub_proceso_evaluacion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['descripcion', 'id_area_gestion', 'estado'], 'required'],
            [['id_area_gestion', 'estado'], 'default', 'value' => null],
            [['id_area_gestion', 'estado'], 'integer'],
            [['descripcion'], 'string', 'max' => 100],
            [['id_area_gestion'], 'exist', 'skipOnError' => true, 'targetClass' => AreaGestion::className(), 'targetAttribute' => ['id_area_gestion' => 'id']],
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
            'id_area_gestion' => 'Id Area Gestion',
            'estado' => 'Estado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProcesoEspecificos()
    {
        return $this->hasMany(ProcesoEspecifico::className(), ['id_sub_proceso' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAreaGestion()
    {
        return $this->hasOne(AreaGestion::className(), ['id' => 'id_area_gestion']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstado0()
    {
        return $this->hasOne(Estados::className(), ['id' => 'estado']);
    }
}
