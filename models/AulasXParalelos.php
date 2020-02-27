<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "aulas_x_paralelos".
 *
 * @property string $id
 * @property string $id_aulas
 * @property string $id_paralelos
 * @property string $fecha_ingreso
 *
 * @property Aulas $aulas
 * @property Paralelos $paralelos
 */
class AulasXParalelos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'aulas_x_paralelos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_aulas', 'id_paralelos'], 'required'],
            [['id_aulas', 'id_paralelos'], 'default', 'value' => null],
            [['id_aulas', 'id_paralelos'], 'integer'],
            [['fecha_ingreso'], 'string' ],
            [['id_aulas'], 'exist', 'skipOnError' => true, 'targetClass' => Aulas::className(), 'targetAttribute' => ['id_aulas' => 'id']],
            [['id_paralelos'], 'exist', 'skipOnError' => true, 'targetClass' => Paralelos::className(), 'targetAttribute' => ['id_paralelos' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' 			=> 'ID',
            'id_aulas' 		=> 'Aula',
            'id_paralelos' 	=> 'Grupo',
            'fecha_ingreso' => 'Fecha Ingreso',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAulas()
    {
        return $this->hasOne(Aulas::className(), ['id' => 'id_aulas']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParalelos()
    {
        return $this->hasOne(Paralelos::className(), ['id' => 'id_paralelos']);
    }
}
