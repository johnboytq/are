<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "recursos_infraestructura_fisica".
 *
 * @property string $id
 * @property int $cantidad_aulas_regulares
 * @property int $cantidad_aulas_multiples
 * @property int $cantidad_oficinas_admin
 * @property int $cantidad_aulas_profesores
 * @property int $cantidad_espacios_deportivos
 * @property int $cantidad_baterias_sanitarias
 * @property int $cantidad_laboratorios
 * @property int $cantidad_portatiles
 * @property int $cantidad_computadores
 * @property int $cantidad_tabletas
 * @property int $cantidad_bibliotecas_salas_lectura
 * @property string $programas_informaticos_admin
 * @property string $id_sede
 * @property string $estado
 *
 * @property Estados $estado0
 * @property Sedes $sede
 */
class RecursosInfraestructuraFisica extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'recursos_infraestructura_fisica';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cantidad_aulas_regulares', 'cantidad_aulas_multiples', 'cantidad_oficinas_admin', 'cantidad_aulas_profesores', 'cantidad_espacios_deportivos', 'cantidad_baterias_sanitarias', 'cantidad_laboratorios', 'cantidad_portatiles', 'cantidad_computadores', 'cantidad_tabletas', 'cantidad_bibliotecas_salas_lectura', 'id_sede', 'estado'], 'default', 'value' => null],
            [['cantidad_aulas_regulares', 'cantidad_aulas_multiples', 'cantidad_oficinas_admin', 'cantidad_aulas_profesores', 'cantidad_espacios_deportivos', 'cantidad_baterias_sanitarias', 'cantidad_laboratorios', 'cantidad_portatiles', 'cantidad_computadores', 'cantidad_tabletas', 'cantidad_bibliotecas_salas_lectura', 'id_sede', 'estado'], 'integer'],
            [['programas_informaticos_admin'], 'string', 'max' => 500],
            [['observaciones'], 'string'],
            [['estado'], 'exist', 'skipOnError' => true, 'targetClass' => Estados::className(), 'targetAttribute' => ['estado' => 'id']],
            [['id_sede'], 'exist', 'skipOnError' => true, 'targetClass' => Sedes::className(), 'targetAttribute' => ['id_sede' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cantidad_aulas_regulares' => 'Aulas Regulares',
            'cantidad_aulas_multiples' => 'Aulas Múltiples',
            'cantidad_oficinas_admin' => 'Oficinas Administrativas',
            'cantidad_aulas_profesores' => 'Aulas Profesores',
            'cantidad_espacios_deportivos' => 'Espacios Deportivos',
            'cantidad_baterias_sanitarias' => 'Baterías Sanitarias',
            'cantidad_laboratorios' => 'Laboratorios',
            'cantidad_portatiles' => 'Portatiles',
            'cantidad_computadores' => 'Computadores',
            'cantidad_tabletas' => 'Tabletas',
            'cantidad_bibliotecas_salas_lectura' => 'Bibliotecas Salas Lectura',
            'programas_informaticos_admin' => 'Programas Informaticos Admin',
            'id_sede' => 'Sede',
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
    public function getSede()
    {
        return $this->hasOne(Sedes::className(), ['id' => 'id_sede']);
    }
}
