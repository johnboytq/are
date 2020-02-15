<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "personas".
 *
 * @property string $id
 * @property string $usuario
 * @property string $psw
 * @property string $identificacion
 * @property string $nombres
 * @property string $apellidos
 * @property string $telefonos
 * @property string $fecha_nacimiento
 * @property string $fecha_registro
 * @property string $correo
 * @property string $domicilio
 * @property string $fecha_ultimo_ingreso
 * @property bool $envio_correo
 * @property string $id_municipios
 * @property string $id_tipos_identificaciones
 * @property double $latitud
 * @property double $longitud
 * @property string $id_estados_civiles
 * @property string $id_generos
 * @property string $hobbies
 * @property string $id_barrios_veredas
 * @property int $estado State -1 : Delete State 0  : Disable State 1  : Aviable
 * @property string $grupo_sanguineo
 *
 * @property ApoyoAcademico[] $apoyoAcademicos
 * @property Capacitaciones[] $capacitaciones
 * @property Documentos[] $documentos
 * @property ParticipacionProyectosMaestro[] $participacionProyectosMaestros
 * @property PerfilesXPersonas[] $perfilesXPersonas
 * @property BarriosVeredas $barriosVeredas
 * @property Estados $estado0
 * @property EstadosCiviles $estadosCiviles
 * @property Generos $generos
 * @property TiposIdentificaciones $tiposIdentificaciones
 * @property PersonasXDiscapacidades[] $personasXDiscapacidades
 * @property TiposDiscapacidades[] $tiposDiscapacidades
 * @property PersonasXEscolaridades[] $personasXEscolaridades
 * @property PersonasXFormaciones[] $personasXFormaciones
 * @property Reconocimientos[] $reconocimientos
 * @property RepresentantesLegales[] $representantesLegales
 * @property Sanciones[] $sanciones
 */
class HojaVidaEstudiante extends \yii\db\ActiveRecord
{
	
	public $institucion;
	public $sede;
	public $jornada;
	public $grupo;
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'personas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fecha_nacimiento', 'fecha_registro', 'fecha_ultimo_ingreso'], 'safe'],
            [['envio_correo'], 'boolean'],
            [['id_municipios', 'id_tipos_identificaciones', 'id_estados_civiles', 'id_generos', 'id_barrios_veredas', 'estado'], 'default', 'value' => null],
            [['id_municipios', 'id_tipos_identificaciones', 'id_estados_civiles', 'id_generos', 'id_barrios_veredas', 'estado'], 'integer'],
            [['latitud', 'longitud'], 'number'],
            [['usuario'], 'string', 'max' => 60],
            [['psw', 'domicilio'], 'string', 'max' => 200],
            [['identificacion'], 'string', 'max' => 45],
            [['nombres', 'apellidos', 'correo'], 'string', 'max' => 100],
            [['telefonos', 'grupo_sanguineo'], 'string', 'max' => 50],
            [['hobbies'], 'string', 'max' => 500],
            [['correo'], 'unique'],
            [['identificacion'], 'unique'],
            [['usuario'], 'unique'],
            [['id_barrios_veredas'], 'exist', 'skipOnError' => true, 'targetClass' => BarriosVeredas::className(), 'targetAttribute' => ['id_barrios_veredas' => 'id']],
            [['estado'], 'exist', 'skipOnError' => true, 'targetClass' => Estados::className(), 'targetAttribute' => ['estado' => 'id']],
            [['id_estados_civiles'], 'exist', 'skipOnError' => true, 'targetClass' => EstadosCiviles::className(), 'targetAttribute' => ['id_estados_civiles' => 'id']],
            [['id_generos'], 'exist', 'skipOnError' => true, 'targetClass' => Generos::className(), 'targetAttribute' => ['id_generos' => 'id']],
            [['id_tipos_identificaciones'], 'exist', 'skipOnError' => true, 'targetClass' => TiposIdentificaciones::className(), 'targetAttribute' => ['id_tipos_identificaciones' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'usuario' => 'Usuario',
            'psw' => 'Psw',
            'identificacion' => 'Identificacion',
            'nombres' => 'Nombres',
            'apellidos' => 'Apellidos',
            'telefonos' => 'Telefonos',
            'fecha_nacimiento' => 'Fecha Nacimiento',
            'fecha_registro' => 'Fecha Registro',
            'correo' => 'Correo',
            'domicilio' => 'Domicilio',
            'fecha_ultimo_ingreso' => 'Fecha Ultimo Ingreso',
            'envio_correo' => 'Envio Correo',
            'id_municipios' => 'Id Municipios',
            'id_tipos_identificaciones' => 'Id Tipos Identificaciones',
            'latitud' => 'Latitud',
            'longitud' => 'Longitud',
            'id_estados_civiles' => 'Id Estados Civiles',
            'id_generos' => 'Id Generos',
            'hobbies' => 'Hobbies',
            'id_barrios_veredas' => 'Id Barrios Veredas',
            'estado' => 'Estado',
            'grupo_sanguineo' => 'Grupo Sanguineo',
            'institucion' => 'Institucion',
            'sede' => 'sede',
            'jornada' => 'Jornada',
            'grupo' => 'Grupo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApoyoAcademicos()
    {
        return $this->hasMany(ApoyoAcademico::className(), ['id_persona_doctor' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCapacitaciones()
    {
        return $this->hasMany(Capacitaciones::className(), ['id_personas' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDocumentos()
    {
        return $this->hasMany(Documentos::className(), ['id_persona' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParticipacionProyectosMaestros()
    {
        return $this->hasMany(ParticipacionProyectosMaestro::className(), ['participante' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerfilesXPersonas()
    {
        return $this->hasMany(PerfilesXPersonas::className(), ['id_personas' => 'id']);
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
    public function getEstado0()
    {
        return $this->hasOne(Estados::className(), ['id' => 'estado']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstadosCiviles()
    {
        return $this->hasOne(EstadosCiviles::className(), ['id' => 'id_estados_civiles']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGeneros()
    {
        return $this->hasOne(Generos::className(), ['id' => 'id_generos']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTiposIdentificaciones()
    {
        return $this->hasOne(TiposIdentificaciones::className(), ['id' => 'id_tipos_identificaciones']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersonasXDiscapacidades()
    {
        return $this->hasMany(PersonasXDiscapacidades::className(), ['id_personas' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTiposDiscapacidades()
    {
        return $this->hasMany(TiposDiscapacidades::className(), ['id' => 'id_tipos_discapacidades'])->viaTable('personas_x_discapacidades', ['id_personas' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersonasXEscolaridades()
    {
        return $this->hasMany(PersonasXEscolaridades::className(), ['id_personas' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersonasXFormaciones()
    {
        return $this->hasMany(PersonasXFormaciones::className(), ['id_personas' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReconocimientos()
    {
        return $this->hasMany(Reconocimientos::className(), ['id_personas' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRepresentantesLegales()
    {
        return $this->hasMany(RepresentantesLegales::className(), ['id_personas' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSanciones()
    {
        return $this->hasMany(Sanciones::className(), ['id_personas' => 'id']);
    }
}
