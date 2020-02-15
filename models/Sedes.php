<?php

/**********
Versión: 001
Fecha: 08-03-2018
Desarrollador: Edwin Molina Grisales
Descripción: CRUD de sedes
---------------------------------------
Modificaciones:
Fecha: 07-03-2018
Persona encargada: Edwin Molina Grisales
Cambios realizados: No se obliga barrios y/o veredas ni comuna
---------------------------------------
**********/

namespace app\models;

use Yii;

/**
 * This is the model class for table "sedes".
 *
 * @property string $id
 * @property string $descripcion
 * @property string $telefonos
 * @property string $direccion
 * @property int $area
 * @property string $id_instituciones
 * @property double $latitud
 * @property double $longitud
 * @property string $id_zonificaciones
 * @property string $id_tenencias
 * @property string $id_modalidades
 * @property string $id_municipios
 * @property string $id_generos_sedes
 * @property string $id_calendarios
 * @property string $id_estratos
 * @property string $id_barrios_veredas
 * @property string $codigo_dane
 * @property string $sede_principal
 * @property string $comuna
 * @property string $estado
 *
 * @property Administradores[] $administradores
 * @property Asignaturas[] $asignaturas
 * @property Aulas[] $aulas
 * @property ContratosInstituciones[] $contratosInstituciones
 * @property FestivosNolaborales[] $festivosNolaborales
 * @property BarriosVeredas $barriosVeredas
 * @property Calendarios $calendarios
 * @property Estratos $estratos
 * @property GenerosSedes $generosSedes
 * @property Instituciones $instituciones
 * @property Modalidades $modalidades
 * @property Tenencias $tenencias
 * @property Zonificaciones $zonificaciones
 * @property SedesJornadas[] $sedesJornadas
 * @property SedesNiveles[] $sedesNiveles
 * @property SedesXDias[] $sedesXDias
 */
class Sedes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sedes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['area', 'id_instituciones', 'id_zonificaciones', 'id_tenencias', 'id_modalidades', 'id_municipios', 'id_generos_sedes', 'id_calendarios', 'id_estratos', 'id_barrios_veredas', 'sede_principal', 'comuna', 'estado'], 'default', 'value' => null],
            [['area', 'id_instituciones', 'id_zonificaciones', 'id_tenencias', 'id_modalidades', 'id_municipios', 'id_generos_sedes', 'id_calendarios', 'id_estratos', 'id_barrios_veredas', 'sede_principal', 'comuna', 'estado'], 'integer'],
            [['latitud', 'longitud'], 'number'],
            [['descripcion'], 'string', 'max' => 255],
            [['telefonos'], 'string', 'max' => 60],
            [['direccion', 'codigo_dane'], 'string', 'max' => 100],
            [['id_barrios_veredas'], 'exist', 'skipOnError' => true, 'targetClass' => BarriosVeredas::className(), 'targetAttribute' => ['id_barrios_veredas' => 'id']],
            [['id_calendarios'], 'exist', 'skipOnError' => true, 'targetClass' => Calendarios::className(), 'targetAttribute' => ['id_calendarios' => 'id']],
            [['id_estratos'], 'exist', 'skipOnError' => true, 'targetClass' => Estratos::className(), 'targetAttribute' => ['id_estratos' => 'id']],
            [['id_generos_sedes'], 'exist', 'skipOnError' => true, 'targetClass' => GenerosSedes::className(), 'targetAttribute' => ['id_generos_sedes' => 'id']],
            [['id_instituciones'], 'exist', 'skipOnError' => true, 'targetClass' => Instituciones::className(), 'targetAttribute' => ['id_instituciones' => 'id']],
            [['id_modalidades'], 'exist', 'skipOnError' => true, 'targetClass' => Modalidades::className(), 'targetAttribute' => ['id_modalidades' => 'id']],
            [['id_tenencias'], 'exist', 'skipOnError' => true, 'targetClass' => Tenencias::className(), 'targetAttribute' => ['id_tenencias' => 'id']],
            [['id_zonificaciones'], 'exist', 'skipOnError' => true, 'targetClass' => Zonificaciones::className(), 'targetAttribute' => ['id_zonificaciones' => 'id']],
            // [['id_barrios_veredas'], 'required'],
            [['id_calendarios'], 'required'],
            [['id_estratos'], 'required'],
            [['id_generos_sedes'], 'required'],
            [['id_instituciones'], 'required'],
            [['id_modalidades'], 'required'],
            [['id_tenencias'], 'required'],
            [['id_zonificaciones'], 'required'],
            [['estado'], 'required'],
            [['id_municipios'], 'required'],
            [['codigo_dane'], 'required'],
            [['codigo_dane'], 'unique'],
            // [['comuna'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' 				=> 'ID',
            'descripcion' 		=> 'Descripción',
            'telefonos' 		=> 'Teléfonos',
            'direccion' 		=> 'Dirección',
            'area' 				=> 'Área',
            'id_instituciones' 	=> 'Instituciones',
            'latitud' 			=> 'Latitud',
            'longitud' 			=> 'Longitud',
            'id_zonificaciones' => 'Zonificaciones',
            'id_tenencias' 		=> 'Tenencias',
            'id_modalidades' 	=> 'Modalidades',
            'id_municipios' 	=> 'Municipios',
            'id_generos_sedes' 	=> 'Géneros Sedes',
            'id_calendarios' 	=> 'Calendarios',
            'id_estratos' 		=> 'Estratos',
            'id_barrios_veredas'=> 'Barrios y/o Veredas',
            'codigo_dane' 		=> 'Código Dane',
            'sede_principal' 	=> 'Sede Principal',
            'comuna' 			=> 'Comuna',
            'estado' 			=> 'Estado',
        ];

    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdministradores()
    {
        return $this->hasMany(Administradores::className(), ['id_sedes' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAsignaturas()
    {
        return $this->hasMany(Asignaturas::className(), ['id_sedes' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAulas()
    {
        return $this->hasMany(Aulas::className(), ['id_sedes' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContratosInstituciones()
    {
        return $this->hasMany(ContratosInstituciones::className(), ['id_sedes' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFestivosNolaborales()
    {
        return $this->hasMany(FestivosNolaborales::className(), ['id_sedes' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBarriosVeredas()
    {
        return $this->hasOne(BarriosVeredas::className(), ['id' => 'id_barrios_veredas']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCalendarios()
    {
        return $this->hasOne(Calendarios::className(), ['id' => 'id_calendarios']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstratos()
    {
        return $this->hasOne(Estratos::className(), ['id' => 'id_estratos']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGenerosSedes()
    {
        return $this->hasOne(GenerosSedes::className(), ['id' => 'id_generos_sedes']);
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
    public function getModalidades()
    {
        return $this->hasOne(Modalidades::className(), ['id' => 'id_modalidades']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTenencias()
    {
        return $this->hasOne(Tenencias::className(), ['id' => 'id_tenencias']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getZonificaciones()
    {
        return $this->hasOne(Zonificaciones::className(), ['id' => 'id_zonificaciones']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSedesJornadas()
    {
        return $this->hasMany(SedesJornadas::className(), ['id_sedes' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSedesNiveles()
    {
        return $this->hasMany(SedesNiveles::className(), ['id_sedes' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSedesXDias()
    {
        return $this->hasMany(SedesXDias::className(), ['id_sedes' => 'id']);
    }
}
