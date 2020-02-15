<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "gestion_curricular.actividades_ejecutadas".
 *
 * @property string $id
 * @property string $descripcion_respuesta
 * @property string $actividad_planeada
 * @property string $se_realizo
 * @property string $descripcion_actividad
 * @property string $justificacion
 * @property string $id_momento
 * @property string $estado
 */
class GestionCurricularActividadesEjecutadas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gestion_curricular.actividades_ejecutadas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['descripcion_respuesta', 'actividad_planeada', 'se_realizo', 'descripcion_actividad', 'id_momento', 'estado'], 'required'],
            [['se_realizo', 'id_momento', 'estado'], 'default', 'value' => null],
            [['se_realizo', 'id_momento', 'estado'], 'integer'],
            [['descripcion_respuesta', 'actividad_planeada', 'descripcion_actividad', 'justificacion'], 'string', 'max' => 800],
            [['id_momento'], 'exist', 'skipOnError' => true, 'targetClass' => GestionCurricularMomentos::className(), 'targetAttribute' => ['id_momento' => 'id']],
            [['estado'], 'exist', 'skipOnError' => true, 'targetClass' => Estados::className(), 'targetAttribute' => ['estado' => 'id']],
            [['se_realizo'], 'exist', 'skipOnError' => true, 'targetClass' => TipoParametro::className(), 'targetAttribute' => ['se_realizo' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'descripcion_respuesta' => 'Descripción Respuesta',
            'actividad_planeada' => 'Actividad Planeada',
            'se_realizo' => 'Se Realizó',
            'descripcion_actividad' => 'Descripción Actividad',
            'justificacion' => 'Justificación',
            'id_momento' => 'Id Momento',
			'estado' => 'Estado',
        ];
    }
}
