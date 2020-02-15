<?php
/**********
Versión: 001
Fecha: 14-03-2018
Desarrollador: Oscar David Lopez
Descripción: CRUD de AsignaturasNivelesSedes
---------------------------------------
Modificaciones:
Fecha: 14-03-2018
Persona encargada: Oscar David Lopez
Cambios realizados: - xxxxxxx
---------------------------------------
**********/


namespace app\models;

use Yii;

/**
 * This is the model class for table "periodos".
 *
 * @property string $id
 * @property string $descripcion
 * @property string $estado
 * @property string $fecha_inicio
 * @property string $fecha_fin
 *
 * @property Asignaciones[] $asignaciones
 * @property Estados $estado0
 * @property PlanDeAula[] $planDeAulas
 * @property PonderacionResultados[] $ponderacionResultados
 */
class Periodos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'periodos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['estado'], 'default', 'value' => null],
            [['estado'], 'integer'],
            [['id_sedes'], 'integer'],
            [['fecha_inicio', 'fecha_fin'], 'safe'],
            [['descripcion'], 'string', 'max' => 60],
            [['estado'], 'exist', 'skipOnError' => true, 'targetClass' => Estados::className(), 'targetAttribute' => ['estado' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'descripcion' => 'Descripcion',
            'estado' => 'Estado',
            'fecha_inicio' => 'Fecha Inicio',
            'fecha_fin' => 'Fecha Fin',
            'fecha_fin' => 'Fecha Fin',
			'id_sedes'=> 'Sede'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAsignaciones()
    {
        return $this->hasMany(Asignaciones::className(), ['id_periodos' => 'id']);
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
    public function getPlanDeAulas()
    {
        return $this->hasMany(PlanDeAula::className(), ['id_periodo' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPonderacionResultados()
    {
        return $this->hasMany(PonderacionResultados::className(), ['id_periodo' => 'id']);
    }
}
