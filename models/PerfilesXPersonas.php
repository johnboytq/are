<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "perfiles_x_personas".
 *
 * @property string $id
 * @property string $id_personas
 * @property string $id_perfiles
 *
 * @property Administradores $administradores
 * @property Docentes $docentes
 * @property Estudiantes $estudiantes
 * @property Perfiles $perfiles
 * @property Personas $personas
 * @property PruebasGeneradas[] $pruebasGeneradas
 * @property RepresentantesLegales[] $representantesLegales
 */
class PerfilesXPersonas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'perfiles_x_personas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_personas', 'id_perfiles'], 'default', 'value' => null],
            [['id_personas', 'id_perfiles'], 'integer'],
            [['id_perfiles'], 'exist', 'skipOnError' => true, 'targetClass' => Perfiles::className(), 'targetAttribute' => ['id_perfiles' => 'id']],
            [['id_personas'], 'exist', 'skipOnError' => true, 'targetClass' => Personas::className(), 'targetAttribute' => ['id_personas' => 'id']],
            [['id_personas', 'id_perfiles'], 'unique', 'targetAttribute' => ['id_personas', 'id_perfiles'], 'message' => 'La persona ya ha sido registrada con el perfil' ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_personas' => 'Personas',
            'id_perfiles' => 'Perfiles',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdministradores()
    {
        return $this->hasOne(Administradores::className(), ['id_perfiles_x_personas' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDocentes()
    {
        return $this->hasOne(Docentes::className(), ['id_perfiles_x_personas' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstudiantes()
    {
        return $this->hasOne(Estudiantes::className(), ['id_perfiles_x_personas' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerfiles()
    {
        return $this->hasOne(Perfiles::className(), ['id' => 'id_perfiles']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersonas()
    {
        return $this->hasOne(Personas::className(), ['id' => 'id_personas']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPruebasGeneradas()
    {
        return $this->hasMany(PruebasGeneradas::className(), ['id_perfiles_x_personas' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRepresentantesLegales()
    {
        return $this->hasMany(RepresentantesLegales::className(), ['id_perfiles_x_personas' => 'id']);
    }
}
