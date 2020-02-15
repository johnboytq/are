<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "semilleros_tic.semilleros_datos_ieo".
 *
 * @property string $id
 * @property string $id_institucion
 * @property string $sede
 * @property string $personal_a
 * @property string $docente_aliado
 * @property string $estado
 */
class SemillerosDatosIeo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'semilleros_tic.semilleros_datos_ieo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_institucion', 'personal_a', 'docente_aliado', 'estado'], 'required'],
            [['id_institucion', 'estado'], 'default', 'value' => null],
            [['id_institucion', 'estado'], 'integer'],
            [['personal_a', 'docente_aliado'], 'string'],
            [['sede'], 'string', 'max' => 100],
            [['estado'], 'exist', 'skipOnError' => true, 'targetClass' => Estados::className(), 'targetAttribute' => ['estado' => 'id']],
            [['id_institucion'], 'exist', 'skipOnError' => true, 'targetClass' => Instituciones::className(), 'targetAttribute' => ['id_institucion' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' 				=> 'ID',
            'id_institucion' 	=> 'Institución educativa',
            'sede' 				=> 'Sede',
            'personal_a' 		=> 'Personal A.',
            'docente_aliado' 	=> 'Docente aliado',
            'estado' 			=> 'Estado',
        ];
    }
}
