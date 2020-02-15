<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sedes_cobertura".
 *
 * @property string $id
 * @property string $id_sede
 * @property string $id_tema
 * @property string $ninos
 * @property string $ninas
 * @property string $observaciones
 * @property string $estado
 *
 * @property Estados $estado0
 * @property Sedes $sede
 * @property TemasCobertura $tema
 */
class SedesCobertura extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sedes_cobertura';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_sede', 'id_tema', 'ninos', 'ninas', 'estado'], 'required'],
            [['id_sede', 'id_tema', 'ninos', 'ninas', 'estado'], 'default', 'value' => null],
            [['id_sede', 'id_tema', 'ninos', 'ninas', 'estado'], 'integer'],
            [['observaciones'], 'string', 'max' => 700],
            [['estado'], 'exist', 'skipOnError' => true, 'targetClass' => Estados::className(), 'targetAttribute' => ['estado' => 'id']],
            [['id_sede'], 'exist', 'skipOnError' => true, 'targetClass' => Sedes::className(), 'targetAttribute' => ['id_sede' => 'id']],
            [['id_tema'], 'exist', 'skipOnError' => true, 'targetClass' => TemasCobertura::className(), 'targetAttribute' => ['id_tema' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_sede' => 'Id Sede',
            'id_tema' => 'Id Tema',
            'ninos' => 'Ninos',
            'ninas' => 'Ninas',
            'observaciones' => 'Observaciones',
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTema()
    {
        return $this->hasOne(TemasCobertura::className(), ['id' => 'id_tema']);
    }
}
