<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "gestion_curricular.visitas_acompanamiento".
 *
 * @property string $id
 * @property string $descripcion
 * @property bool $asistio
 * @property string $id_dia
 * @property string $ruta_archivo
 * @property string $no_visita
 * @property string $estado
 */
class GestionCurricularVisitasAcompanamiento extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gestion_curricular.visitas_acompanamiento';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['descripcion', 'asistio', 'id_dia', 'estado'], 'required'],
            [['asistio'], 'boolean'],
            [['id_dia', 'estado'], 'default', 'value' => null],
            [['id_dia', 'estado'], 'integer'],
            [['descripcion', 'no_visita'], 'string', 'max' => 800],
            [['ruta_archivo'], 'string', 'max' => 100],
            [['id_dia'], 'exist', 'skipOnError' => true, 'targetClass' => GestionCurricularDiasMomentos::className(), 'targetAttribute' => ['id_dia' => 'id']],
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
            'asistio' => 'Asistio',
            'id_dia' => 'Id Dia',
            'ruta_archivo' => 'Ruta Archivo',
            'no_visita' => 'No Visita',
            'estado' => 'Estado',
        ];
    }
}
