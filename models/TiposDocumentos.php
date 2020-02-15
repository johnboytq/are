<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tipos_documentos".
 *
 * @property string $id
 * @property string $descripcion
 * @property string $estado
 * @property string $categoria
 *
 * @property DocumentosInstanciasInstitucionales[] $documentosInstanciasInstitucionales
 * @property DocumentosOficiales[] $documentosOficiales
 * @property Estados $estado0
 */
class TiposDocumentos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tipos_documentos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['estado'], 'default', 'value' => null],
            [['estado'], 'integer'],
            [['categoria'], 'string'],
            [['descripcion'], 'string', 'max' => 200],
            [['estado'], 'exist', 'skipOnError' => true, 'targetClass' => Estados::className(), 'targetAttribute' => ['estado' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'descripcion' => 'Descripcion',
            'estado' => 'Estado',
            'categoria' => 'Categoria',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDocumentosInstanciasInstitucionales()
    {
        return $this->hasMany(DocumentosInstanciasInstitucionales::className(), ['id_tipo_documentos' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDocumentosOficiales()
    {
        return $this->hasMany(DocumentosOficiales::className(), ['id_tipo_documentos' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstado0()
    {
        return $this->hasOne(Estados::className(), ['id' => 'estado']);
    }
}
