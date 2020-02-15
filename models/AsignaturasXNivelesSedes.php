<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "asignaturas_x_niveles_sedes".
 *
 * @property string $id
 * @property string $id_sedes_niveles
 * @property string $id_asignaturas
 * @property int $intensidad
 *
 * @property Asignaturas $asignaturas
 * @property SedesNiveles $sedesNiveles
 * @property DistribucionesAcademicas[] $distribucionesAcademicas
 */
class AsignaturasXNivelesSedes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'asignaturas_x_niveles_sedes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_sedes_niveles', 'id_asignaturas', 'intensidad'], 'default', 'value' => null],
            [['id_sedes_niveles', 'id_asignaturas', 'intensidad'], 'integer'],
            [['id_asignaturas'], 'exist', 'skipOnError' => true, 'targetClass' => Asignaturas::className(), 'targetAttribute' => ['id_asignaturas' => 'id']],
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
            'id_sedes_niveles' => 'Id Sedes Niveles',
            'id_asignaturas' => 'Id Asignaturas',
            'intensidad' => 'Intensidad',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAsignaturas()
    {
        return $this->hasOne(Asignaturas::className(), ['id' => 'id_asignaturas']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSedesNiveles()
    {
        return $this->hasOne(SedesNiveles::className(), ['id' => 'id_sedes_niveles']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDistribucionesAcademicas()
    {
        return $this->hasMany(DistribucionesAcademicas::className(), ['id_asignaturas_x_niveles_sedes' => 'id']);
    }
}
