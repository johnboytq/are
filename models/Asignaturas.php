<?php
/**********
Versión: 001
Fecha: 10-03-2018
Desarrollador: Oscar David Lopez
Descripción: CRUD de Asignaturas
---------------------------------------
Modificaciones:
Fecha: 01-05-2018
Persona encargada: Edwin Molina Grisales
Cambios realizados: Se agrega campo AREAS DE ENSEÑANZA al CRUD
---------------------------------------
**********/


namespace app\models;

use Yii;

/**
 * This is the model class for table "asignaturas".
 *
 * @property string $id
 * @property string $descripcion
 * @property string $id_sedes
 * @property string $estado
 *
 * @property Estados $estado0
 * @property Sedes $sedes
 * @property AsignaturasXNivelesSedes[] $asignaturasXNivelesSedes
 */
class Asignaturas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'asignaturas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_sedes', 'estado'], 'default', 'value' => null],
            [['id_sedes', 'estado'], 'integer'],
            [['descripcion'], 'string', 'max' => 100],
            [['estado'], 'exist', 'skipOnError' => true, 'targetClass' => Estados::className(), 'targetAttribute' => ['estado' => 'id']],
            [['id_sedes'], 'exist', 'skipOnError' => true, 'targetClass' => Sedes::className(), 'targetAttribute' => ['id_sedes' => 'id']],
            [['id_areas_ensenanza'], 'exist', 'skipOnError' => true, 'targetClass' => AreasEnsenanza::className(), 'targetAttribute' => ['id_areas_ensenanza' => 'id']],
			[['id_areas_ensenanza', 'descripcion'], 'required' ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' 				=> 'ID',
            'descripcion' 		=> 'Descripción',
            'id_sedes' 			=> 'Sedes',
            'estado' 			=> 'Estado',
            'id_areas_ensenanza'=> 'Area de enseñanza',
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
    public function getSedes()
    {
        return $this->hasOne(Sedes::className(), ['id' => 'id_sedes']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAsignaturasXNivelesSedes()
    {
        return $this->hasMany(AsignaturasXNivelesSedes::className(), ['id_asignaturas' => 'id']);
    }
}
