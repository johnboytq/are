<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "representantes_legales".
 *
 * @property string $id_perfiles_x_personas
 * @property string $id_personas
 * @property string $id
 *
 * @property PerfilesXPersonas $perfilesXPersonas
 * @property Personas $personas
 */
class RepresentantesLegales extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'representantes_legales';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_perfiles_x_personas', 'id_personas'], 'default', 'value' => null],
            [['id_perfiles_x_personas', 'id_personas'], 'integer'],
            [['id_perfiles_x_personas', 'id_personas'], 'required'],
            // [['id_perfiles_x_personas'], 'exist', 'skipOnError' => true, 'targetClass' => PerfilesXPersonas::className(), 'targetAttribute' => ['id_perfiles_x_personas' => 'id']],
            // [['id_personas'], 'exist', 'skipOnError' => true, 'targetClass' => Personas::className(), 'targetAttribute' => ['id_personas' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_perfiles_x_personas' => 'Estudiante',
            'id_personas' => 'Representante Legal',
            'id' => 'ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerfilesXPersonas()
    {
        return $this->hasOne(PerfilesXPersonas::className(), ['id' => 'id_perfiles_x_personas']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersonas()
    {
        return $this->hasOne(Personas::className(), ['id' => 'id_personas']);
    }
}
