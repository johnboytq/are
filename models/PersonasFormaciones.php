<?php
/**********
Versión: 001
Fecha: Fecha en formato (10-03-2018)
Desarrollador: Viviana Rodas
Descripción: Modelo de Formaciones
---------------------------------------
*/

namespace app\models;

use Yii;

/**
 * This is the model class for table "personas_x_formaciones".
 *
 * @property string $id_personas
 * @property string $id_tipos_formaciones
 * @property int $horas_curso
 * @property int $ano_curso
 * @property bool $titulacion
 * @property string $titulo
 * @property string $institucion
 * @property string $id
 *
 * @property Personas $personas
 * @property TiposFormaciones $tiposFormaciones
 */
class PersonasFormaciones extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'personas_x_formaciones';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_personas', 'id_tipos_formaciones', 'horas_curso', 'ano_curso'], 'default', 'value' => null],
            [['id_personas', 'id_tipos_formaciones', 'horas_curso', 'ano_curso'], 'integer'],
            [['titulacion'], 'boolean'],
            [['titulo', 'institucion'], 'string', 'max' => 80],
			[['id_personas','titulo','horas_curso', 'id_tipos_formaciones','institucion'],'required'], 
            [['id_personas'], 'exist', 'skipOnError' => true, 'targetClass' => Personas::className(), 'targetAttribute' => ['id_personas' => 'id']],
            [['id_tipos_formaciones'], 'exist', 'skipOnError' => true, 'targetClass' => TiposFormaciones::className(), 'targetAttribute' => ['id_tipos_formaciones' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_personas' => 'Persona',
            'id_tipos_formaciones' => 'Tipos Formación',
            'horas_curso' => 'Horas Curso',
            'ano_curso' => 'Año Curso',
            'titulacion' => 'Titulación',
            'titulo' => 'Título',
            'institucion' => 'Institución',
            'id' => 'ID',
        ];
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
    public function getTiposFormaciones()
    {
        return $this->hasOne(TiposFormaciones::className(), ['id' => 'id_tipos_formaciones']);
    }
}
