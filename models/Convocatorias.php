<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "convocatorias".
 *
 * @property string $id
 * @property int $nro_convocatoria
 * @property string $grupo
 * @property string $fecha_inicio
 * @property string $fecha_final
 */
class Convocatorias extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'convocatorias';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nro_convocatoria', 'grupo', 'fecha_inicio', 'id_sede'], 'required'],
            [['nro_convocatoria'], 'default', 'value' => null],
            [['nro_convocatoria'], 'integer'],
            [['grupo'], 'string'],
            [['fecha_inicio', 'fecha_final'], 'safe'],
			[['estado'], 'exist', 'skipOnError' => true, 'targetClass' => Estados::className(), 'targetAttribute' => ['estado' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' 				=> 'ID',
            'nro_convocatoria' 	=> 'Nro de Convocatoria',
            'grupo' 			=> 'Grupo',
            'fecha_inicio' 		=> 'Fecha Inicio',
            'fecha_final' 		=> 'Fecha Final',
            'id_sede' 			=> 'Sede',
            'estado' 			=> 'Estado',
        ];
    }
}
