<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "gestion_curricular.actividades_planeadas".
 *
 * @property string $id
 * @property string $titulo
 * @property string $descripcion
 * @property string $descripcion_respuesta
 * @property string $id_momento
 * @property string $estado
 */
class GestionCurricularActividadesPlaneadas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gestion_curricular.actividades_planeadas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['titulo', 'descripcion', 'descripcion_respuesta', 'id_momento', 'estado'], 'required'],
            [['id_momento', 'estado'], 'default', 'value' => null],
            [['id_momento', 'estado'], 'integer'],
            [['titulo', 'descripcion', 'descripcion_respuesta'], 'string', 'max' => 800],
            [['id_momento'], 'exist', 'skipOnError' => true, 'targetClass' => GestionCurricularMomentos::className(), 'targetAttribute' => ['id_momento' => 'id']],
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
            'titulo' => 'Titulo',
            'descripcion' => 'Descripcion',
            'descripcion_respuesta' => 'Descripcion Respuesta',
            'id_momento' => 'Id Momento',
            'estado' => 'Estado',
        ];
    }
}
