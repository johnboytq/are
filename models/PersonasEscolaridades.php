<?php
/**********
Versión: 001
Fecha: Fecha en formato (12-03-2018)
Desarrollador: Viviana Rodas
Descripción: Modelo de Escolaridades
---------------------------------------
*/

namespace app\models;

use Yii;

/**
 * This is the model class for table "personas_x_escolaridades".
 *
 * @property string $id_personas
 * @property string $id_escolaridades
 * @property int $ultimo_nivel_cursado
 * @property int $ano_curso
 * @property bool $titulacion
 * @property string $titulo
 * @property string $institucion
 * @property string $id
 *
 * @property Escolaridades $escolaridades
 * @property Personas $personas
 */
class PersonasEscolaridades extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'personas_x_escolaridades';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_personas', 'id_escolaridades', 'ultimo_nivel_cursado', 'ano_curso'], 'default', 'value' => null],
            [['id_personas', 'id_escolaridades', 'ano_curso'], 'integer'],
            [['titulacion'], 'boolean'],
            [['titulo', 'institucion','ultimo_nivel_cursado'], 'string', 'max' => 80],
			[['id_personas','ultimo_nivel_cursado','titulo', 'id_escolaridades','ano_curso' ,'institucion'],'required'], 
            [['id_escolaridades'], 'exist', 'skipOnError' => true, 'targetClass' => Escolaridades::className(), 'targetAttribute' => ['id_escolaridades' => 'id']],
            [['id_personas'], 'exist', 'skipOnError' => true, 'targetClass' => Personas::className(), 'targetAttribute' => ['id_personas' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_personas' => 'Persona',
            'id_escolaridades' => 'Tipos Escolaridades',
            'ultimo_nivel_cursado' => 'Nivel Cursado',
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
    public function getEscolaridades()
    {
        return $this->hasOne(Escolaridades::className(), ['id' => 'id_escolaridades']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersonas()
    {
        return $this->hasOne(Personas::className(), ['id' => 'id_personas']);
    }
}
