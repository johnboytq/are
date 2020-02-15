<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "semilleros_tic.datos_sesiones".
 *
 * @property string $id
 * @property string $id_sesion
 * @property string $facha_sesion
 * @property string $estado
 */
class DatosSesiones extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'semilleros_tic.datos_sesiones';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_sesion', 'facha_sesion', 'estado'], 'required'],
            [['id_sesion', 'facha_sesion', 'estado'], 'default', 'value' => null],
            [['id_sesion', 'facha_sesion', 'estado'], 'integer'],
            [['estado'], 'exist', 'skipOnError' => true, 'targetClass' => Estados::className(), 'targetAttribute' => ['estado' => 'id']],
            [['id_sesion'], 'exist', 'skipOnError' => true, 'targetClass' => SemillerosTicSesiones::className(), 'targetAttribute' => ['id_sesion' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_sesion' => 'Id Sesion',
            'facha_sesion' => 'Facha Sesion',
            'estado' => 'Estado',
        ];
    }
}
