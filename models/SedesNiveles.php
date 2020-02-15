<?php

/**********
Versión: 001
Fecha: 16-03-2018
Desarrollador: Edwin Molina Grisales
Descripción: CRUD de sedes
---------------------------------------
Modificaciones:
Fecha: 16-03-2018
Persona encargada: Edwin Molina Grisales
Cambios realizados: Se valida que la sede y el nivel sean unicos en la tabla
---------------------------------------
**********/

namespace app\models;

use Yii;

/**
 * This is the model class for table "sedes_niveles".
 *
 * @property string $id
 * @property string $id_niveles
 * @property string $id_sedes
 *
 * @property AsignaturasXNivelesSedes[] $asignaturasXNivelesSedes
 * @property Paralelos[] $paralelos
 * @property Niveles $niveles
 * @property Sedes $sedes
 */
class SedesNiveles extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sedes_niveles';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_niveles', 'id_sedes'], 'default', 'value' => null],
            [['id_niveles', 'id_sedes'], 'integer'],
            [['id_niveles'], 'exist', 'skipOnError' => true, 'targetClass' => Niveles::className(), 'targetAttribute' => ['id_niveles' => 'id']],
            [['id_sedes'], 'exist', 'skipOnError' => true, 'targetClass' => Sedes::className(), 'targetAttribute' => ['id_sedes' => 'id']],
            [['id_sedes'], 'required' ],
            [['id_sedes','id_niveles'], 'unique', 'targetAttribute' => ['id_sedes','id_niveles'] ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_niveles' => 'Niveles',
            'id_sedes' => 'Sedes',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAsignaturasXNivelesSedes()
    {
        return $this->hasMany(AsignaturasXNivelesSedes::className(), ['id_sedes_niveles' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParalelos()
    {
        return $this->hasMany(Paralelos::className(), ['id_sedes_niveles' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNiveles()
    {
        return $this->hasOne(Niveles::className(), ['id' => 'id_niveles']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSedes()
    {
        return $this->hasOne(Sedes::className(), ['id' => 'id_sedes']);
    }
}
