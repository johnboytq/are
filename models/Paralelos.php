<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "paralelos".
 *
 * @property string $id
 * @property string $descripcion
 * @property string $id_sedes_jornadas
 * @property string $id_sedes_niveles
 * @property int $ano_lectivo
 * @property string $fecha_ingreso
 * @property string $estado
 *
 * @property AulasXParalelos[] $aulasXParalelos
 * @property Estudiantes[] $estudiantes
 * @property Estados $estado0
 * @property SedesJornadas $sedesJornadas
 * @property SedesNiveles $sedesNiveles
 */
 
 /**********
Versión: 001
Fecha: 09-03-2018
Desarrollador: Oscar David Lopez
Descripción: CRUD de Paralelos
---------------------------------------
Modificaciones:
Fecha: 09-03-2018
Persona encargada: Oscar David Lopez
Cambios realizados: - Modificaciones de la funcion attributeLabels(), para cambiar la etiquetas de los campos y ortografia
Cambios realizados: - Se agrega una regla en la funcion rules() del campo ano_lectivo NOTA: si no existe alguna regla
del campo este no se inserta en la base de datos 
---------------------------------------
**********/
 
class Paralelos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'paralelos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fecha_ingreso'], 'safe'],
            [['descripcion'], 'string', 'max' => 60],
            [['ano_lectivo'], 'string', 'max' => 20000],
            [['estado'], 'exist', 'skipOnError' => true, 'targetClass' => Estados::className(), 'targetAttribute' => ['estado' => 'id']],
            [['id_sedes_jornadas'], 'exist', 'skipOnError' => true, 'targetClass' => SedesJornadas::className(), 'targetAttribute' => ['id_sedes_jornadas' => 'id']],
            [['id_sedes_niveles'], 'exist', 'skipOnError' => true, 'targetClass' => SedesNiveles::className(), 'targetAttribute' => ['id_sedes_niveles' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'descripcion' => 'Descripción',
            'id_sedes_jornadas' => 'Jornadas',
            'id_sedes_niveles' => 'Niveles',
            'ano_lectivo' => 'Año Lectivo',
            'fecha_ingreso' => 'Fecha Ingreso',
            'estado' => 'Estado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAulasXParalelos()
    {
        return $this->hasMany(AulasXParalelos::className(), ['id_paralelos' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstudiantes()
    {
        return $this->hasMany(Estudiantes::className(), ['id_paralelos' => 'id']);
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
    public function getSedesJornadas()
    {
        return $this->hasOne(SedesJornadas::className(), ['id' => 'id_sedes_jornadas']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSedesNiveles()
    {
        return $this->hasOne(SedesNiveles::className(), ['id' => 'id_sedes_niveles']);
    }
}
