<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "plan_de_aula".
 *
 * @property string $id
 * @property string $id_periodo
 * @property string $id_nivel
 * @property string $id_asignatura
 * @property string $fecha
 * @property string $actividad
 * @property string $observaciones
 * @property string $estado
 * @property string $id_indicador_desempeno
 * @property bool $cognitivo_conocer
 * @property bool $cognitivo_hacer
 * @property bool $cognitivo_ser
 * @property bool $personal
 * @property bool $social
 *
 * @property Asignaturas $asignatura
 * @property Estados $estado0
 * @property IndicadorDesempeno $indicadorDesempeno
 * @property Niveles $nivel
 * @property Periodos $periodo
 */
class PlanDeAula extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'plan_de_aula';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_periodo', 'id_nivel', 'estado'], 'required'],
            [['id_periodo', 'id_nivel', 'id_asignatura', 'estado', 'id_indicador_desempeno'], 'default', 'value' => null],
            [['id_periodo', 'id_nivel', 'id_asignatura', 'estado', 'id_indicador_desempeno'], 'integer'],
            [['fecha'], 'safe'],
            [['cognitivo_conocer', 'cognitivo_hacer', 'cognitivo_ser', 'personal', 'social'], 'boolean'],
            [['actividad'], 'string', 'max' => 1000],
            [['observaciones'], 'string', 'max' => 200],
            [['id_asignatura'], 'exist', 'skipOnError' => true, 'targetClass' => Asignaturas::className(), 'targetAttribute' => ['id_asignatura' => 'id']],
            [['estado'], 'exist', 'skipOnError' => true, 'targetClass' => Estados::className(), 'targetAttribute' => ['estado' => 'id']],
            [['id_indicador_desempeno'], 'exist', 'skipOnError' => true, 'targetClass' => IndicadorDesempeno::className(), 'targetAttribute' => ['id_indicador_desempeno' => 'id']],
            [['id_nivel'], 'exist', 'skipOnError' => true, 'targetClass' => Niveles::className(), 'targetAttribute' => ['id_nivel' => 'id']],
            [['id_periodo'], 'exist', 'skipOnError' => true, 'targetClass' => Periodos::className(), 'targetAttribute' => ['id_periodo' => 'id']],
            [['id_indicador_desempeno','id_periodo','id_nivel','id_asignatura'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_periodo' => 'Periodo',
            'id_nivel' => 'Nivel',
            'id_asignatura' => 'Asignatura',
            'fecha' => 'Fecha',
            'actividad' => 'Actividad',
            'observaciones' => 'Observaciones',
            'estado' => 'Estado',
            'id_indicador_desempeno' => 'Indicador de Desempeño',
            'cognitivo_conocer' => 'Cognitivo Conocer',
            'cognitivo_hacer' => 'Cognitivo Hacer',
            'cognitivo_ser' => 'Cognitivo Ser',
            'personal' => 'Personal',
            'social' => 'Social',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAsignatura()
    {
        return $this->hasOne(Asignaturas::className(), ['id' => 'id_asignatura']);
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
    public function getIndicadorDesempeno()
    {
        return $this->hasOne(IndicadorDesempeno::className(), ['id' => 'id_indicador_desempeno']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNivel()
    {
        return $this->hasOne(Niveles::className(), ['id' => 'id_nivel']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPeriodo()
    {
        return $this->hasOne(Periodos::className(), ['id' => 'id_periodo']);
    }
}
