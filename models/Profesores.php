<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Profesores".
 *
 * @property string $id
 * @property string $tipoDocumento
 * @property string $nroDocumento
 * @property string $nombre
 * @property string $fechaDeNacimiento
 */
class Profesores extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Profesores';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'tipoDocumento', 'nroDocumento', 'nombre', 'fechaDeNacimiento'], 'required'],
            [['id', 'nroDocumento'], 'default', 'value' => null],
            [['id', 'nroDocumento'], 'integer'],
            [['tipoDocumento', 'nombre'], 'string'],
            [['fechaDeNacimiento'], 'safe'],
            [['id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tipoDocumento' => 'Tipo Documento',
            'nroDocumento' => 'Nro Documento',
            'nombre' => 'Nombre',
            'fechaDeNacimiento' => 'Fecha De Nacimiento',
        ];
    }
}
