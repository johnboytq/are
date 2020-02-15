<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "niveles".
 *
 * @property string $id
 * @property string $descripcion
 * @property string $id_niveles_academicos
 * @property string $estado
 *
 * @property Estados $estado0
 * @property NivelesAcademicos $nivelesAcademicos
 * @property Proyectos[] $proyectos
 * @property SedesNiveles[] $sedesNiveles
 */
class Niveles extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'niveles';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_niveles_academicos', 'estado'], 'default', 'value' => null],
            [['id_niveles_academicos', 'estado'], 'integer'],
            [['descripcion'], 'string', 'max' => 60],
			[['descripcion','id_niveles_academicos'],'required'],
            [['estado'], 'exist', 'skipOnError' => true, 'targetClass' => Estados::className(), 'targetAttribute' => ['estado' => 'id']],
            [['id_niveles_academicos'], 'exist', 'skipOnError' => true, 'targetClass' => NivelesAcademicos::className(), 'targetAttribute' => ['id_niveles_academicos' => 'id']],
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
            'id_niveles_academicos' => 'Niveles Académicos',
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
    public function getNivelesAcademicos()
    {
        return $this->hasOne(NivelesAcademicos::className(), ['id' => 'id_niveles_academicos']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProyectos()
    {
        return $this->hasMany(Proyectos::className(), ['id_niveles' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSedesNiveles()
    {
        return $this->hasMany(SedesNiveles::className(), ['id_niveles' => 'id']);
    }
}
