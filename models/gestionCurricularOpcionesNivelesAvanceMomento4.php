<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "gestion_curricular.opciones_niveles_avance_momento4".
 *
 * @property string $id
 * @property string $desepcion
 * @property string $id_tipo_opciones
 * @property string $estado
 */
class gestionCurricularOpcionesNivelesAvanceMomento4 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gestion_curricular.opciones_niveles_avance_momento4';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['desepcion', 'id_tipo_opciones', 'estado'], 'required'],
            [['id_tipo_opciones', 'estado'], 'default', 'value' => null],
            [['id_tipo_opciones', 'estado'], 'integer'],
            [['desepcion'], 'string', 'max' => 800],
            [['estado'], 'exist', 'skipOnError' => true, 'targetClass' => Estados::className(), 'targetAttribute' => ['estado' => 'id']],
            [['id_tipo_opciones'], 'exist', 'skipOnError' => true, 'targetClass' => TipoParametro::className(), 'targetAttribute' => ['id_tipo_opciones' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'desepcion' => 'Desepcion',
            'id_tipo_opciones' => 'Id Tipo Opciones',
            'estado' => 'Estado',
        ];
    }
}
