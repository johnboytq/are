<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "distribuciones_x_indicador_desempeno".
 *
 * @property string $id
 * @property string $id_distribuciones
 * @property string $id_indicador_desempeno
 *
 * @property Calificaciones[] $calificaciones
 * @property DistribucionesAcademicas $distribuciones
 * @property IndicadorDesempeno $indicadorDesempeno
 */
class DistribucionesXIndicadorDesempeno extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'distribuciones_x_indicador_desempeno';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_distribuciones', 'id_indicador_desempeno'], 'default', 'value' => null],
            [['id_distribuciones', 'id_indicador_desempeno'], 'integer'],
            [['id_distribuciones'], 'exist', 'skipOnError' => true, 'targetClass' => DistribucionesAcademicas::className(), 'targetAttribute' => ['id_distribuciones' => 'id']],
            [['id_indicador_desempeno'], 'exist', 'skipOnError' => true, 'targetClass' => IndicadorDesempeno::className(), 'targetAttribute' => ['id_indicador_desempeno' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_distribuciones' => 'Id Distribuciones',
            'id_indicador_desempeno' => 'Id Indicador Desempeno',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCalificaciones()
    {
        return $this->hasMany(Calificaciones::className(), ['id_distribuciones_x_indicador_desempeno' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDistribuciones()
    {
        return $this->hasOne(DistribucionesAcademicas::className(), ['id' => 'id_distribuciones']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIndicadorDesempeno()
    {
        return $this->hasOne(IndicadorDesempeno::className(), ['id' => 'id_indicador_desempeno']);
    }
}
