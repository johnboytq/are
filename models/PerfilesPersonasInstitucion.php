<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "perfiles_x_personas_institucion".
 *
 * @property string $id
 * @property string $id_perfiles_x_persona
 * @property string $id_institucion
 * @property string $estado
 *
 * @property Estados $estado0
 * @property Instituciones $institucion
 * @property PerfilesXPersonas $perfilesXPersona
 */
class PerfilesPersonasInstitucion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'perfiles_x_personas_institucion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_perfiles_x_persona', 'id_institucion', 'estado'], 'required'],
            [['id_perfiles_x_persona', 'id_institucion', 'estado'], 'default', 'value' => null],
            [['id_perfiles_x_persona', 'id_institucion', 'estado'], 'integer'],
            [['observaciones'], 'string'],
            [['estado'], 'exist', 'skipOnError' => true, 'targetClass' => Estados::className(), 'targetAttribute' => ['estado' => 'id']],
            [['id_institucion'], 'exist', 'skipOnError' => true, 'targetClass' => Instituciones::className(), 'targetAttribute' => ['id_institucion' => 'id']],
            [['id_perfiles_x_persona'], 'exist', 'skipOnError' => true, 'targetClass' => PerfilesXPersonas::className(), 'targetAttribute' => ['id_perfiles_x_persona' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_perfiles_x_persona' => 'Persona',
            'id_institucion' => 'Institución',
            'estado' => 'Estado',
            'observaciones' => 'Observaciones',
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
    public function getInstitucion()
    {
        return $this->hasOne(Instituciones::className(), ['id' => 'id_institucion']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerfilesXPersona()
    {
        return $this->hasOne(PerfilesXPersonas::className(), ['id' => 'id_perfiles_x_persona']);
    }
}
