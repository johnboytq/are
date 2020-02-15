<?php

/**********
Versión: 001
Fecha: 09-04-2018
Persona encargada: Edwin Molina Grisales
CRUD de RECURSOS DE INFRAESTRUCTURA PEDAGOGICA
---------------------------------------
**********/

namespace app\models;

use Yii;

/**
 * This is the model class for table "recurso_infraestructura_pedagogica".
 *
 * @property string $id
 * @property int $cantidad_computdores_portatiles
 * @property int $cantidad_aulas_tita
 * @property int $cantidad_bibliotecas
 * @property int $cantidad_ludotecas
 * @property int $cantidad_salones_juegos
 * @property string $id_sede
 * @property string $estado
 *
 * @property Estados $estado0
 * @property Sedes $sede
 */
class RecursoInfraestructuraPedagogica extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'recurso_infraestructura_pedagogica';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cantidad_computdores_portatiles', 'cantidad_aulas_tita', 'cantidad_bibliotecas', 'cantidad_ludotecas', 'cantidad_salones_juegos', 'id_sede', 'estado'], 'default', 'value' => null],
            [['cantidad_computdores_portatiles', 'cantidad_aulas_tita', 'cantidad_bibliotecas', 'cantidad_ludotecas', 'cantidad_salones_juegos', 'id_sede', 'estado'], 'integer'],
            [['observaciones'], 'string'],
            [['id_sede', 'estado'], 'required'],
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
            'cantidad_computdores_portatiles' => 'Cantidad Computadores Portátiles',
            'cantidad_aulas_tita' => 'Cantidad en Aulas Tita',
            'cantidad_bibliotecas' => 'Cantidad en Bibliotecas',
            'cantidad_ludotecas' => 'Cantidad en Ludotecas',
            'cantidad_salones_juegos' => 'Cantidad en Salones de Juegos',
            'id_sede' => 'Sede',
            'estado' => 'Estado',
            'observaciones' => 'Observaciones',
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
