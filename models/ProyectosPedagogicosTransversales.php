<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "proyectos_pedagogicos_transversales".
 *
 * @property string $id
 * @property int $codigo_grupo
 * @property string $nombre_grupo
 * @property string $coordinador
 * @property string $area
 * @property string $correo
 * @property string $celular
 * @property string $linea_investigacion_1
 * @property string $linea_investigacion_2
 * @property string $linea_investigacion_3
 * @property string $estado
 * @property string $id_sede
 *
 * @property Estados $estado0
 * @property Sedes $sede
 * @property Sedes $sede0
 */
class ProyectosPedagogicosTransversales extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'proyectos_pedagogicos_transversales';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['codigo_grupo', 'nombre_grupo', 'coordinador', 'area'], 'required'],
            [['codigo_grupo', 'coordinador', 'area', 'estado', 'id_sede'], 'default', 'value' => null],
            [['codigo_grupo', 'coordinador', 'area', 'estado', 'id_sede'], 'integer'],
            [['nombre_grupo', 'correo', 'celular', 'linea_investigacion_1', 'linea_investigacion_2', 'linea_investigacion_3'], 'string'],
            [['correo'], 'email'],
            [['estado'], 'exist', 'skipOnError' => true, 'targetClass' => Estados::className(), 'targetAttribute' => ['estado' => 'id']],
            [['id_sede'], 'exist', 'skipOnError' => true, 'targetClass' => Sedes::className(), 'targetAttribute' => ['id_sede' => 'id']],
            [['id_sede'], 'exist', 'skipOnError' => true, 'targetClass' => Sedes::className(), 'targetAttribute' => ['id_sede' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' 					=> 'ID',
            'codigo_grupo' 			=> 'Codigo del Grupo',
            'nombre_grupo' 			=> 'Nombre de Grupo',
            'coordinador' 			=> 'Coordinador',
            'area' 					=> 'Área',
            'correo' 				=> 'Correo Electrónico',
            'celular' 				=> 'Celular',
            'linea_investigacion_1' => 'Linea de Investigación 1',
            'linea_investigacion_2' => 'Linea de Investigación 2',
            'linea_investigacion_3' => 'Linea de Investigación 3',
            'estado' 				=> 'Estado',
            'id_sede' 				=> 'Sede',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstado0()
    {
        return $this->hasOne(Estados::className(), ['id' => 'estado']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSede()
    {
        return $this->hasOne(Sedes::className(), ['id' => 'id_sede']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSede0()
    {
        return $this->hasOne(Sedes::className(), ['id' => 'id_sede']);
    }
}
