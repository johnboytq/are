<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "semilleros_tic.instrumento_poblacion_docentes".
 *
 * @property string $id
 * @property string $id_institucion
 * @property string $id_sede
 * @property string $id_persona
 * @property string $profesion
 * @property string $ultimo_nivel
 * @property string $id_escalafon
 * @property string $id_asignaturas_niveles_sedes
 * @property string $id_niveles
 * @property string $estado
 */
class InstrumentoPoblacionDocentes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'semilleros_tic.instrumento_poblacion_docentes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_institucion', 'id_sede', 'id_persona', 'profesion', 'ultimo_nivel', 'id_escalafon', 'id_asignaturas_niveles_sedes', 'id_niveles', 'estado'], 'required'],
            [['id_institucion', 'id_sede', 'id_persona', 'id_escalafon', 'id_asignaturas_niveles_sedes', 'id_niveles', 'estado'], 'default', 'value' => null],
            [['id_institucion', 'id_sede', 'id_persona', 'id_escalafon', 'id_asignaturas_niveles_sedes', 'id_niveles', 'estado'], 'integer'],
            [['profesion', 'ultimo_nivel'], 'string', 'max' => 200],
            [['id_asignaturas_niveles_sedes'], 'exist', 'skipOnError' => true, 'targetClass' => AsignaturasXNivelesSedes::className(), 'targetAttribute' => ['id_asignaturas_niveles_sedes' => 'id']],
            [['id_escalafon'], 'exist', 'skipOnError' => true, 'targetClass' => Escalafones::className(), 'targetAttribute' => ['id_escalafon' => 'id']],
            [['estado'], 'exist', 'skipOnError' => true, 'targetClass' => Estados::className(), 'targetAttribute' => ['estado' => 'id']],
            [['id_institucion'], 'exist', 'skipOnError' => true, 'targetClass' => Instituciones::className(), 'targetAttribute' => ['id_institucion' => 'id']],
            [['id_niveles'], 'exist', 'skipOnError' => true, 'targetClass' => Niveles::className(), 'targetAttribute' => ['id_niveles' => 'id']],
            [['id_persona'], 'exist', 'skipOnError' => true, 'targetClass' => Personas::className(), 'targetAttribute' => ['id_persona' => 'id']],
            [['id_sede'], 'exist', 'skipOnError' => true, 'targetClass' => Sedes::className(), 'targetAttribute' => ['id_sede' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' 				=> 'ID',
            'id_institucion' 	=> 'Institución',
            'id_sede' 			=> 'Sede',
            'id_persona' 		=> 'Docente',
            'profesion' 		=> 'Profesión',
            'ultimo_nivel' 		=> 'Último Nivel de Formación',
            'id_escalafon' 		=> 'Escalafón',
            'id_asignaturas_niveles_sedes' => 'Asignaturas Niveles Sedes',
            'id_niveles' 		=> 'Nivel',
            'estado' 			=> 'Estado',
        ];
    }
}
