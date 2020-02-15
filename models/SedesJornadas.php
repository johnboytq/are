<?php

/**********
Versión: 001
Fecha: 06-03-2018
Desarrollador: Edwin Molina Grisales
Descripción: CRUD de sedes-jornadas
---------------------------------------
Modificaciones:
Fecha: 06-03-2018
Persona encargada: Edwin Molina Grisales
Cambios realizados: Los atributos labels se dejan como Jornadas y Sedes y se dejan los campos is_sedes e id_jornadas como obligatorios
---------------------------------------
**********/


namespace app\models;

use Yii;

/**
 * This is the model class for table "sedes_jornadas".
 *
 * @property string $id
 * @property string $id_jornadas
 * @property string $id_sedes
 *
 * @property Paralelos[] $paralelos
 * @property Jornadas $jornadas
 * @property Sedes $sedes
 */
class SedesJornadas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sedes_jornadas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_jornadas', 'id_sedes'], 'default', 'value' => null],
            [['id_jornadas', 'id_sedes'], 'integer'],
            [['id_jornadas'], 'exist', 'skipOnError' => true, 'targetClass' => Jornadas::className(), 'targetAttribute' => ['id_jornadas' => 'id']],
            [['id_sedes'], 'exist', 'skipOnError' => true, 'targetClass' => Sedes::className(), 'targetAttribute' => ['id_sedes' => 'id']],
            [['id_sedes'], 'required' ],
            [['id_jornadas'], 'required' ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_jornadas' => 'Jornadas',
            'id_sedes' => 'Sedes',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParalelos()
    {
        return $this->hasMany(Paralelos::className(), ['id_sedes_jornadas' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJornadas()
    {
        return $this->hasOne(Jornadas::className(), ['id' => 'id_jornadas']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSedes()
    {
        return $this->hasOne(Sedes::className(), ['id' => 'id_sedes']);
    }
}
