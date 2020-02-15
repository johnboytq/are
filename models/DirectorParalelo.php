<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "director_paralelo".
 *
 * @property string $id
 * @property string $id_paralelo
 * @property string $id_perfiles_x_personas_docentes
 * @property string $estado
 *
 * @property Docentes $perfilesXPersonasDocentes
 * @property Estados $estado0
 * @property Paralelos $paralelo
 */
class DirectorParalelo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'director_paralelo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_paralelo', 'id_perfiles_x_personas_docentes', 'estado'], 'default', 'value' => null],
            [['id_paralelo'], 'required' ],
            [['id_paralelo', 'id_perfiles_x_personas_docentes', 'estado'], 'integer'],
            [['id_perfiles_x_personas_docentes'], 'exist', 'skipOnError' => true, 'targetClass' => Docentes::className(), 'targetAttribute' => ['id_perfiles_x_personas_docentes' => 'id_perfiles_x_personas']],
            [['estado'], 'exist', 'skipOnError' => true, 'targetClass' => Estados::className(), 'targetAttribute' => ['estado' => 'id']],
            [['id_paralelo'], 'exist', 'skipOnError' => true, 'targetClass' => Paralelos::className(), 'targetAttribute' => ['id_paralelo' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_paralelo' => 'Grupo',
            'id_perfiles_x_personas_docentes' => 'Director',
            'estado' => 'Estado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerfilesXPersonasDocentes()
    {
        return $this->hasOne(Docentes::className(), ['id_perfiles_x_personas' => 'id_perfiles_x_personas_docentes']);
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
    public function getParalelo()
    {
        return $this->hasOne(Paralelos::className(), ['id' => 'id_paralelo']);
    }
}
