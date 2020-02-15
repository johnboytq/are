<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "documentos".
 *
 * @property string $id
 * @property string $ruta
 * @property string $id_persona
 * @property string $tipo_documento
 * @property string $estado
 *
 * @property Estados $estado0
 * @property Personas $persona
 */
class Documentos extends \yii\db\ActiveRecord
{
	
	public $file;
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'documentos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
			[['file'], 'file', 'maxSize' => 1024*1024*2 ],
            [['id_persona', 'tipo_documento', 'estado'], 'required'],
            [['id_persona', 'tipo_documento', 'estado'], 'default', 'value' => null],
            [['id_persona', 'tipo_documento', 'estado'], 'integer'],
            [['ruta'], 'string', 'max' => 200],
            [['estado'], 'exist', 'skipOnError' => true, 'targetClass' => Estados::className(), 'targetAttribute' => ['estado' => 'id']],
            [['id_persona'], 'exist', 'skipOnError' => true, 'targetClass' => Personas::className(), 'targetAttribute' => ['id_persona' => 'id']],
            [['tipo_documento'], 'exist', 'skipOnError' => true, 'targetClass' => TiposDocumentos::className(), 'targetAttribute' => ['tipo_documento' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' 			=> 'ID',
            'ruta' 			=> 'Ruta',
            'id_persona' 	=> 'Persona',
            'tipo_documento'=> 'Tipo de Documento',
            'estado' 		=> 'Estado',
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
    public function getPersona()
    {
        return $this->hasOne(Personas::className(), ['id' => 'id_persona']);
    }
}
