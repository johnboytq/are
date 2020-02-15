<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "participacion_proyectos_jornada".
 *
 * @property string $id
 * @property string $nombre_programa
 * @property string $nombre_participante
 * @property string $tipo
 * @property string $objetivo
 * @property string $duracion
 * @property string $ano_inicio
 * @property string $ano_fin
 * @property string $tematica
 * @property string $areas
 * @property string $otros
 * @property string $materiales_recursos
 * @property string $logros
 * @property string $observaciones
 * @property string $id_institucion
 * @property string $estado
 *
 * @property Estados $estado0
 * @property Instituciones $institucion
 * @property NombresProyectosParticipacion $nombrePrograma
 * @property Perfiles $tipo0
 * @property Personas $nombreParticipante
 */
class ParticipacionProyectosJornada extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'participacion_proyectos_jornada';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre_programa', 'nombre_participante', 'tipo'], 'required'],
            [['nombre_programa', 'nombre_participante', 'tipo', 'id_institucion', 'estado'], 'default', 'value' => null],
            [['nombre_programa', 'nombre_participante', 'tipo', 'id_institucion', 'estado'], 'integer'],
            [['objetivo', 'duracion', 'tematica', 'areas', 'otros', 'materiales_recursos', 'logros', 'observaciones'], 'string', 'max' => 300],
            [['ano_inicio', 'ano_fin'], 'string', 'max' => 50],
            [['estado'], 'exist', 'skipOnError' => true, 'targetClass' => Estados::className(), 'targetAttribute' => ['estado' => 'id']],
            [['id_institucion'], 'exist', 'skipOnError' => true, 'targetClass' => Instituciones::className(), 'targetAttribute' => ['id_institucion' => 'id']],
            [['nombre_programa'], 'exist', 'skipOnError' => true, 'targetClass' => NombresProyectosParticipacion::className(), 'targetAttribute' => ['nombre_programa' => 'id']],
            [['tipo'], 'exist', 'skipOnError' => true, 'targetClass' => Perfiles::className(), 'targetAttribute' => ['tipo' => 'id']],
            [['nombre_participante'], 'exist', 'skipOnError' => true, 'targetClass' => Personas::className(), 'targetAttribute' => ['nombre_participante' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre_programa' => 'Nombre Programa',
            'nombre_participante' => 'Nombre Participante',
            'tipo' => 'Tipo',
            'objetivo' => 'Objetivo',
            'duracion' => 'Duración',
            'ano_inicio' => 'Año Inicio',
            'ano_fin' => 'Año Fin',
            'tematica' => 'Temática',
            'areas' => 'Áreas',
            'otros' => 'Otros',
            'materiales_recursos' => 'Materiales Recursos',
            'logros' => 'Logros',
            'observaciones' => 'Observaciones',
            'id_institucion' => 'Institución',
            'estado' => 'Estado',
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
    public function getInstitucion()
    {
        return $this->hasOne(Instituciones::className(), ['id' => 'id_institucion']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNombrePrograma()
    {
        return $this->hasOne(NombresProyectosParticipacion::className(), ['id' => 'nombre_programa']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipo0()
    {
        return $this->hasOne(Perfiles::className(), ['id' => 'tipo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNombreParticipante()
    {
        return $this->hasOne(Personas::className(), ['id' => 'nombre_participante']);
    }
}
