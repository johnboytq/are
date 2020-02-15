<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "documentos_oficiales".
 *
 * @property string $id
 * @property string $ruta
 * @property string $id_tipo_documentos
 * @property string $id_instituciones
 * @property string $estado
 *
 * @property Estados $estado0
 * @property Instituciones $instituciones
 * @property TiposDocumentos $tipoDocumentos
 */
class DocumentosOficiales extends \yii\db\ActiveRecord
{
	
	public $file;
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'documentos_oficiales';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
			[['file'], 'file', 'maxSize' => 1024*1024*2 ],
            [['id_tipo_documentos', 'id_instituciones', 'estado'], 'default', 'value' => null],
            [['id_tipo_documentos', 'id_instituciones', 'estado'], 'integer'],
            [['id_tipo_documentos', 'id_instituciones'], 'required'],
            [['ruta'], 'string', 'max' => 200],
            [['estado'], 'exist', 'skipOnError' => true, 'targetClass' => Estados::className(), 'targetAttribute' => ['estado' => 'id']],
            [['id_instituciones'], 'exist', 'skipOnError' => true, 'targetClass' => Instituciones::className(), 'targetAttribute' => ['id_instituciones' => 'id']],
            [['id_tipo_documentos'], 'exist', 'skipOnError' => true, 'targetClass' => TiposDocumentos::className(), 'targetAttribute' => ['id_tipo_documentos' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' 				=> 'ID',
            'ruta' 				=> 'Ruta',
            'id_tipo_documentos'=> ' Tipo de Documento',
            'id_instituciones' 	=> 'Instituciones',
            'estado' 			=> 'Estado',
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
    public function getInstituciones()
    {
        return $this->hasOne(Instituciones::className(), ['id' => 'id_instituciones']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipoDocumentos()
    {
        return $this->hasOne(TiposDocumentos::className(), ['id' => 'id_tipo_documentos']);
    }
}
