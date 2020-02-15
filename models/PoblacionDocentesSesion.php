<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "semilleros_tic.poblacion_docentes_sesion".
 *
 * @property string $id
 * @property string $id_poblacion_docentes
 * @property string $id_sesion
 * @property string $valor
 */
class PoblacionDocentesSesion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'semilleros_tic.poblacion_docentes_sesion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_poblacion_docentes', 'id_sesion'], 'required'],
            [['id_poblacion_docentes', 'id_sesion'], 'default', 'value' => null],
            [['id_poblacion_docentes', 'id_sesion'], 'integer'],
            [['valor'], 'string', 'max' => 100],
            [['id_poblacion_docentes'], 'exist', 'skipOnError' => true, 'targetClass' => InstrumentoPoblacionDocentes::className(), 'targetAttribute' => ['id_poblacion_docentes' => 'id']],
            [['id_sesion'], 'exist', 'skipOnError' => true, 'targetClass' => Sesiones::className(), 'targetAttribute' => ['id_sesion' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_poblacion_docentes' => 'Id Poblacion Docentes',
            'id_sesion' => 'Id Sesion',
            'valor' => 'Valor',
        ];
    }
}
