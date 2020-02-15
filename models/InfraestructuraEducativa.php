<?php
/**********
Versión: 001
Fecha: 21-05-2018
Desarrollador: Oscar David Lopez
Descripción: CRUD de infraestructura educativa
--------------------------------------
Modificaciones:
Fecha: 21-05-2018
Persona encargada: Oscar David Lopez
Cambios realizados: ortografia 
---------------------------------------
**********/
namespace app\models;

use Yii;

/**
 * This is the model class for table "infraestructura_educativa".
 *
 * @property string $id
 * @property string $id_sede
 * @property bool $objeto_intervencion
 * @property string $intervencion_infraestructura
 * @property string $alcance_intervencion
 * @property string $presupuesto
 * @property string $cumplimiento_pedido
 * @property string $estado
 *
 * @property Estados $estado0
 * @property Sedes $sede
 */
class InfraestructuraEducativa extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'infraestructura_educativa';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_sede', 'objeto_intervencion', 'estado'], 'required'],
            [['id_sede', 'estado'], 'default', 'value' => null],
            [['id_sede', 'estado'], 'integer'],
            [['objeto_intervencion'], 'boolean'],
            [['intervencion_infraestructura', 'alcance_intervencion'], 'string', 'max' => 300],
            [['presupuesto', 'cumplimiento_pedido'], 'string', 'max' => 100],
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
            'id_sede' => 'Sede',
            'objeto_intervencion' => 'Objeto Intervención',
            'intervencion_infraestructura' => 'Intervención Infraestructura',
            'alcance_intervencion' => 'Alcance Intervención',
            'presupuesto' => 'Presupuesto',
            'cumplimiento_pedido' => 'Cumplimiento Pedido',
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
