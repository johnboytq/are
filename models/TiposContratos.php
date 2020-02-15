<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tipos_contratos".
 *
 * @property string $id
 * @property string $descripcion
 * @property string $estado
 *
 * @property ContratosInstituciones[] $contratosInstituciones
 * @property Estados $estado0
 * @property VinculacionDocentes[] $vinculacionDocentes
 */
class TiposContratos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tipos_contratos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['estado'], 'default', 'value' => null],
            [['estado'], 'integer'],
            [['descripcion'], 'string', 'max' => 60],
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
            'estado' => 'Estado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContratosInstituciones()
    {
        return $this->hasMany(ContratosInstituciones::className(), ['id_tipos_contratos' => 'id']);
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
    public function getVinculacionDocentes()
    {
        return $this->hasMany(VinculacionDocentes::className(), ['id_tipos_contratos' => 'id']);
    }
}
