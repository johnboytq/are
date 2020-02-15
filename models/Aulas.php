<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "aulas".
 *
 * @property string $id
 * @property string $descripcion
 * @property int $capacidad
 * @property string $id_sedes
 * @property string $id_tipos_aulas
 *
 * @property Sedes $sedes
 * @property TiposAulas $tiposAulas
 * @property AulasXParalelos[] $aulasXParalelos
 * @property DotacionesAulas[] $dotacionesAulas
 */
class Aulas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'aulas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['capacidad', 'id_sedes', 'id_tipos_aulas'], 'default', 'value' => null],
            [['capacidad', 'id_sedes', 'id_tipos_aulas'], 'integer'],
            [['descripcion'], 'string', 'max' => 60],
            [['id_sedes'], 'exist', 'skipOnError' => true, 'targetClass' => Sedes::className(), 'targetAttribute' => ['id_sedes' => 'id']],
            [['id_tipos_aulas'], 'exist', 'skipOnError' => true, 'targetClass' => TiposAulas::className(), 'targetAttribute' => ['id_tipos_aulas' => 'id']],
            [['id_tipos_aulas'], 'required' ],
            [['id_sedes'], 'required' ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'descripcion' => 'Descripción',
            'capacidad' => 'Capacidad',
            'id_sedes' => 'Sedes',
            'id_tipos_aulas' => 'Tipos de Aula',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSedes()
    {
        return $this->hasOne(Sedes::className(), ['id' => 'id_sedes']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTiposAulas()
    {
        return $this->hasOne(TiposAulas::className(), ['id' => 'id_tipos_aulas']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAulasXParalelos()
    {
        return $this->hasMany(AulasXParalelos::className(), ['id_aulas' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDotacionesAulas()
    {
        return $this->hasMany(DotacionesAulas::className(), ['id_aulas' => 'id']);
    }
}
