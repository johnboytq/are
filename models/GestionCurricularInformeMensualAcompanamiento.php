<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "gestion_curricular.informe_mensual_acompanamiento".
 *
 * @property string $id
 * @property string $ruta_archivo
 * @property string $id_bitacora_visita_ieo
 * @property string $estado
 */
class GestionCurricularInformeMensualAcompanamiento extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gestion_curricular.informe_mensual_acompanamiento';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ruta_archivo', 'id_bitacora_visita_ieo', 'estado'], 'required'],
            [['id_bitacora_visita_ieo', 'estado'], 'default', 'value' => null],
            [['id_bitacora_visita_ieo', 'estado'], 'integer'],
            [['ruta_archivo'], 'string', 'max' => 100],
            [['id_bitacora_visita_ieo'], 'exist', 'skipOnError' => true, 'targetClass' => GestionCurricularBitacorasVisitasIeo::className(), 'targetAttribute' => ['id_bitacora_visita_ieo' => 'id']],
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
            'ruta_archivo' => 'Ruta Archivo',
            'id_bitacora_visita_ieo' => 'Id Bitacora Visita Ieo',
            'estado' => 'Estado',
        ];
    }
}
