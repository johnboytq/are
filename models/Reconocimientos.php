<?php
/**********
Versión: 001
Fecha: Fecha en formato (12-03-2018)
Desarrollador: Viviana Rodas
Descripción: Modelo de Reconocimientos
---------------------------------------
*/

namespace app\models;

use Yii;

/**
 * This is the model class for table "reconocimientos".
 *
 * @property string $descripcion
 * @property string $id_personas
 * @property string $estado
 * @property string $id
 *
 * @property Estados $estado0
 * @property Personas $personas
 */
class Reconocimientos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'reconocimientos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_personas', 'estado'], 'default', 'value' => null],
            [['id_personas', 'estado'], 'integer'],
            [['descripcion'], 'string', 'max' => 200],
			[['id_personas','descripcion','estado'],'required'],
            [['estado'], 'exist', 'skipOnError' => true, 'targetClass' => Estados::className(), 'targetAttribute' => ['estado' => 'id']],
            [['id_personas'], 'exist', 'skipOnError' => true, 'targetClass' => Personas::className(), 'targetAttribute' => ['id_personas' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'descripcion' => 'Descripción',
            'id_personas' => 'Persona',
            'estado' => 'Estado',
            'id' => 'ID',
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
    public function getPersonas()
    {
        return $this->hasOne(Personas::className(), ['id' => 'id_personas']);
    }
}
