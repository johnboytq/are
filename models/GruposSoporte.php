<?php
/**********
Versión: 001
Fecha: 13-04-2018
Persona encargada: Viviana Rodas
Modulo de grupos de apoyo
---------------------------------------
**********/

namespace app\models;

use Yii;

/**
 * This is the model class for table "grupos_soporte".
 *
 * @property string $id
 * @property string $id_tipo_grupos
 * @property string $descripcion
 * @property string $id_sede
 * @property string $id_jornada_sede
 * @property int $edad_minima
 * @property int $edad_maxima
 * @property int $cantidad_participantes
 * @property string $id_docentes
 * @property string $observaciones
 * @property string $estado
 *
 * @property Docentes $docentes
 * @property Estados $estado0
 * @property Sedes $sede
 * @property SedesJornadas $jornadaSede
 * @property TiposGruposSoporte $tipoGrupos
 */
class GruposSoporte extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'grupos_soporte';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_tipo_grupos', 'descripcion', 'id_sede', 'id_jornada_sede', 'edad_minima', 'edad_maxima', 'cantidad_participantes', 'id_docentes', 'estado'], 'required'],
            [['id_tipo_grupos', 'id_sede', 'id_jornada_sede', 'edad_minima', 'edad_maxima', 'cantidad_participantes', 'id_docentes', 'estado'], 'default', 'value' => null],
            [['id_tipo_grupos', 'id_sede', 'id_jornada_sede', 'edad_minima', 'edad_maxima', 'cantidad_participantes', 'id_docentes', 'estado'], 'integer'],
            [['descripcion'], 'string'],
            [['observaciones'], 'string', 'max' => 1000],
            [['id_docentes'], 'exist', 'skipOnError' => true, 'targetClass' => Docentes::className(), 'targetAttribute' => ['id_docentes' => 'id_perfiles_x_personas']],
            [['estado'], 'exist', 'skipOnError' => true, 'targetClass' => Estados::className(), 'targetAttribute' => ['estado' => 'id']],
            [['id_sede'], 'exist', 'skipOnError' => true, 'targetClass' => Sedes::className(), 'targetAttribute' => ['id_sede' => 'id']],
            [['id_jornada_sede'], 'exist', 'skipOnError' => true, 'targetClass' => SedesJornadas::className(), 'targetAttribute' => ['id_jornada_sede' => 'id']],
            [['id_tipo_grupos'], 'exist', 'skipOnError' => true, 'targetClass' => TiposGruposSoporte::className(), 'targetAttribute' => ['id_tipo_grupos' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_tipo_grupos' => 'Tipo Grupos',
            'descripcion' => 'Descripción',
            'id_sede' => 'Sede',
            'id_jornada_sede' => 'Jornada Sede',
            'edad_minima' => 'Edad Mínima',
            'edad_maxima' => 'Edad Maxima',
            'cantidad_participantes' => 'Cantidad Participantes',
            'id_docentes' => 'Docentes',
            'observaciones' => 'Observaciones',
            'estado' => 'Estado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDocentes()
    {
        return $this->hasOne(Docentes::className(), ['id_perfiles_x_personas' => 'id_docentes']);
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
    public function getJornadaSede()
    {
        return $this->hasOne(SedesJornadas::className(), ['id' => 'id_jornada_sede']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipoGrupos()
    {
        return $this->hasOne(TiposGruposSoporte::className(), ['id' => 'id_tipo_grupos']);
    }
}
