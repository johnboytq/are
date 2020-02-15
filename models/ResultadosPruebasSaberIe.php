<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "resultados_pruebas_saber_ie".
 *
 * @property string $id
 * @property string $anio
 * @property string $id_asignatura_espacifica
 * @property string $valor
 * @property string $id_institucion
 * @property string $estado
 *
 * @property AsignaturaEspecifica $asignaturaEspacifica
 * @property Estados $id0
 * @property Instituciones $institucion
 */
class ResultadosPruebasSaberIe extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'resultados_pruebas_saber_ie';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['anio', 'id_asignatura_especifica', 'valor', 'id_institucion', 'estado'], 'required'],
            [['id_asignatura_especifica', 'id_institucion', 'estado'], 'default', 'value' => null],
            [['id_asignatura_especifica', 'id_institucion', 'estado'], 'integer'],
            [['anio', 'valor'], 'string', 'max' => 100],
            [['id_asignatura_especifica'], 'exist', 'skipOnError' => true, 'targetClass' => AsignaturaEspecifica::className(), 'targetAttribute' => ['id_asignatura_especifica' => 'id']],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => Estados::className(), 'targetAttribute' => ['estado' => 'id']],
            [['id_institucion'], 'exist', 'skipOnError' => true, 'targetClass' => Instituciones::className(), 'targetAttribute' => ['id_institucion' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' 						=> 'ID',
            'anio' 						=> 'Año',
            'id_asignatura_especifica' 	=> 'Asignatura Específica',
            'valor' 					=> 'Valor',
            'id_institucion' 			=> 'Institucion',
            'estado' 					=> 'Estado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAsignaturaEspecifica()
    {
        return $this->hasOne(AsignaturaEspecifica::className(), ['id' => 'id_asignatura_especifica']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getId0()
    {
        return $this->hasOne(Estados::className(), ['id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInstitucion()
    {
        return $this->hasOne(Instituciones::className(), ['id' => 'id_institucion']);
    }
}
