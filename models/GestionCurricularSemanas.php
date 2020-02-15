<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "gestion_curricular.semanas".
 *
 * @property string $id
 * @property string $descripcion
 * @property string $fecha_inicial
 * @property string $fecha_final
 * @property string $id_bitacora_visitas_ieo
 * @property string $estado
 */
class GestionCurricularSemanas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gestion_curricular.semanas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['descripcion', 'fecha_inicial', 'fecha_final', 'id_bitacora_visitas_ieo', 'estado'], 'required'],
            [['fecha_inicial', 'fecha_final'], 'safe'],
            [['id_bitacora_visitas_ieo', 'estado'], 'default', 'value' => null],
            [['id_bitacora_visitas_ieo', 'estado'], 'integer'],
            [['descripcion'], 'string', 'max' => 800],
            [['id_bitacora_visitas_ieo'], 'exist', 'skipOnError' => true, 'targetClass' => GestionCurricularBitacorasVisitasIeo::className(), 'targetAttribute' => ['id_bitacora_visitas_ieo' => 'id']],
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
            'fecha_inicial' => 'Fecha Inicial',
            'fecha_final' => 'Fecha Final',
            'id_bitacora_visitas_ieo' => 'Id Bitacora Visitas Ieo',
            'estado' => 'Estado',
        ];
    }
}
