<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "semilleros_tic.estudiantes_operativo".
 *
 * @property string $id
 * @property string $id_institucion
 * @property string $id_sede
 * @property string $id_profesional
 * @property string $id_nivel
 * @property string $estado
 */
class EstudiantesOperativo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'semilleros_tic.estudiantes_operativo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_institucion', 'id_sede', 'id_profesional', 'id_nivel', 'estado'], 'default', 'value' => null],
            [['id_institucion', 'id_sede', 'id_profesional', 'id_nivel', 'estado'], 'integer'],
            [['estado'], 'exist', 'skipOnError' => true, 'targetClass' => Estados::className(), 'targetAttribute' => ['estado' => 'id']],
            [['id_institucion'], 'exist', 'skipOnError' => true, 'targetClass' => Instituciones::className(), 'targetAttribute' => ['id_institucion' => 'id']],
            [['id_nivel'], 'exist', 'skipOnError' => true, 'targetClass' => Niveles::className(), 'targetAttribute' => ['id_nivel' => 'id']],
            [['id_profesional'], 'exist', 'skipOnError' => true, 'targetClass' => Personas::className(), 'targetAttribute' => ['id_profesional' => 'id']],
            [['id_sede'], 'exist', 'skipOnError' => true, 'targetClass' => Sedes::className(), 'targetAttribute' => ['id_sede' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' 			 => 'ID',
            'id_institucion' => 'Institución',
            'id_sede' 		 => 'Sede',
            'id_profesional' => 'Profesional',
            'id_nivel' 		 => 'Nivel',
            'estado' 		 => 'Estado',
        ];
    }
}
