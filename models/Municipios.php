<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "municipios".
 *
 * @property string $id
 * @property string $descripcion
 * @property string $codigo
 * @property string $id_departamentos
 * @property string $estado
 *
 * @property ComunasCorregimientos[] $comunasCorregimientos
 * @property Departamentos $departamentos
 * @property Estados $estado0
 */
class Municipios extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'municipios';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_departamentos', 'estado'], 'default', 'value' => null],
            [['id_departamentos', 'estado'], 'integer'],
            [['descripcion'], 'string', 'max' => 60],
            [['codigo'], 'string', 'max' => 6],
            [['id_departamentos'], 'exist', 'skipOnError' => true, 'targetClass' => Departamentos::className(), 'targetAttribute' => ['id_departamentos' => 'id']],
            [['estado'], 'exist', 'skipOnError' => true, 'targetClass' => Estados::className(), 'targetAttribute' => ['estado' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'descripcion' => 'Descripcion',
            'codigo' => 'Codigo',
            'id_departamentos' => 'Id Departamentos',
            'estado' => 'Estado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComunasCorregimientos()
    {
        return $this->hasMany(ComunasCorregimientos::className(), ['id_municipios' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDepartamentos()
    {
        return $this->hasOne(Departamentos::className(), ['id' => 'id_departamentos']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstado0()
    {
        return $this->hasOne(Estados::className(), ['id' => 'estado']);
    }
}
