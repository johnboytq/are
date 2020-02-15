<?php
/**********
Versión: 001
Fecha: 13-03-2018
Desarrollador: Oscar David Lopez
Descripción: CRUD de RangosCalificacion
---------------------------------------
Modificaciones:
Fecha: 13-03-2018
Persona encargada: Oscar David Lopez
Cambios realizados: - Cambios en la etiquetas- ortografia
---------------------------------------
**********/

namespace app\models;

use Yii;

/**
 * This is the model class for table "rangos_calificacion".
 *
 * @property string $id
 * @property string $valor_minimo
 * @property string $valor_maximo
 * @property string $descripcion
 * @property string $id_tipo_calificacion
 * @property string $id_instituciones
 * @property string $estado
 *
 * @property Estados $estado0
 * @property Instituciones $instituciones
 * @property TiposCalificacion $tipoCalificacion
 */
class RangosCalificacion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rangos_calificacion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            
            [['id_tipo_calificacion', 'id_instituciones', 'estado'], 'default', 'value' => null],
            [['id_tipo_calificacion', 'id_instituciones', 'estado'], 'integer'],
            [['valor_minimo', 'valor_maximo'], 'number'],
            [['valor_minimo', 'valor_maximo'], 'required'],
            [['descripcion'], 'string', 'max' => 100],
            [['estado'], 'exist', 'skipOnError' => true, 'targetClass' => Estados::className(), 'targetAttribute' => ['estado' => 'id']],
            [['id_instituciones'], 'exist', 'skipOnError' => true, 'targetClass' => Instituciones::className(), 'targetAttribute' => ['id_instituciones' => 'id']],
            [['id_tipo_calificacion'], 'exist', 'skipOnError' => true, 'targetClass' => TiposCalificacion::className(), 'targetAttribute' => ['id_tipo_calificacion' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'valor_minimo' => 'Valor Mínimo',
            'valor_maximo' => 'Valor Máximo',
            'descripcion' => 'Descripción',
            'id_tipo_calificacion' => 'Tipo Calificación',
            'id_instituciones' => 'Instituciones',
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
    public function getInstituciones()
    {
        return $this->hasOne(Instituciones::className(), ['id' => 'id_instituciones']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipoCalificacion()
    {
        return $this->hasOne(TiposCalificacion::className(), ['id' => 'id_tipo_calificacion']);
    }
}
