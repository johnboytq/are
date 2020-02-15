<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "instituciones".
 *
 * @property string $id
 * @property string $descripcion
 * @property string $id_tipos_instituciones
 * @property string $id_sectores
 * @property string $nit
 * @property int $estado
 * @property string $caracter
 * @property string $especialidad
 * @property string $rector
 * @property string $contacto_rector
 * @property string $correo_electronico_institucional
 * @property string $pagina_web
 * @property string $codigo_dane
 *
 * @property Administradores[] $administradores
 * @property ContratosInstituciones[] $contratosInstituciones
 * @property Estados $estado0
 * @property Estados $estado1
 * @property Sectores $sectores
 * @property TiposInstituciones $tiposInstituciones
 * @property OfertasXInstituciones[] $ofertasXInstituciones
 * @property Ofertas[] $ofertas
 * @property Proyectos[] $proyectos
 * @property ProyectosPreAutor[] $proyectosPreAutors
 * @property PruebasGeneradas[] $pruebasGeneradas
 * @property Sedes[] $sedes
 */
class Instituciones extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'instituciones';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_tipos_instituciones', 'id_sectores', 'estado'], 'default', 'value' => null],
            [['id_tipos_instituciones', 'id_sectores', 'estado'], 'integer'],
            [['descripcion'], 'string', 'max' => 255],
            // [['nit'], 'string', 'max' => 60],
            [['nit','codigo_dane'], 'integer'],
            [['caracter', 'especialidad', 'rector', 'contacto_rector', 'correo_electronico_institucional', 'pagina_web', 'codigo_dane'], 'string', 'max' => 100],
            [['estado'], 'exist', 'skipOnError' => true, 'targetClass' => Estados::className(), 'targetAttribute' => ['estado' => 'id']],
            [['estado'], 'exist', 'skipOnError' => true, 'targetClass' => Estados::className(), 'targetAttribute' => ['estado' => 'id']],
            [['id_sectores'], 'exist', 'skipOnError' => true, 'targetClass' => Sectores::className(), 'targetAttribute' => ['id_sectores' => 'id']],
            [['id_tipos_instituciones'], 'exist', 'skipOnError' => true, 'targetClass' => TiposInstituciones::className(), 'targetAttribute' => ['id_tipos_instituciones' => 'id']],
            [['estado'], 'required'],
            [['id_tipos_instituciones'], 'required'],
            [['id_sectores'], 'required'],
            [['correo_electronico_institucional'], 'email'],
            [['nit','codigo_dane'], 'required'],
            [['codigo_dane'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'descripcion' => 'Descripción',
            'id_tipos_instituciones' => 'Tipo de Institución',
            'id_sectores' => 'Sectores',
            'nit' => 'Nit',
            'estado' => 'Estado',
            'caracter' => 'Caracter',
            'especialidad' => 'Especialidad',
            'rector' => 'Rector',
            'contacto_rector' => 'Contacto Rector',
            'correo_electronico_institucional' => 'Correo Electronico Institucional',
            'pagina_web' => 'Pagina Web',
            'codigo_dane' => 'Codigo Dane',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdministradores()
    {
        return $this->hasMany(Administradores::className(), ['id_instituciones' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContratosInstituciones()
    {
        return $this->hasMany(ContratosInstituciones::className(), ['id_instituciones' => 'id']);
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
    public function getEstado1()
    {
        return $this->hasOne(Estados::className(), ['id' => 'estado']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSectores()
    {
        return $this->hasOne(Sectores::className(), ['id' => 'id_sectores']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTiposInstituciones()
    {
        return $this->hasOne(TiposInstituciones::className(), ['id' => 'id_tipos_instituciones']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOfertasXInstituciones()
    {
        return $this->hasMany(OfertasXInstituciones::className(), ['id_instituciones' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOfertas()
    {
        return $this->hasMany(Ofertas::className(), ['id' => 'id_ofertas'])->viaTable('ofertas_x_instituciones', ['id_instituciones' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProyectos()
    {
        return $this->hasMany(Proyectos::className(), ['id_instituciones' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProyectosPreAutors()
    {
        return $this->hasMany(ProyectosPreAutor::className(), ['id_instituciones' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPruebasGeneradas()
    {
        return $this->hasMany(PruebasGeneradas::className(), ['instituciones_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSedes()
    {
        return $this->hasMany(Sedes::className(), ['id_instituciones' => 'id']);
    }
}
