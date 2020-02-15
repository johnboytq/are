<?php
/**********
Versión: 001
Fecha: Fecha en formato (05-03-2018)
Desarrollador: Viviana Rodas
Descripción: Modelo de personas, permite hacer el crud
---------------------------------------


Modificaciones:
Fecha: Fecha en formato(08-03-2018)
Persona encargada: Vivina Rodas
Cambios realizados: Se modifican las reglas de los campos

Fecha: Fecha en formato(09-03-2018)
Persona encargada: Vivina Rodas
Cambios realizados: Se crea funcion para codificar en ut8 los campos con caracteres especiales

Fecha: Fecha en formato(24-04-2018)
Persona encargada: Vivina Rodas
Cambios realizados: Se pone campo estado como requerido
*/



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
 *
 * @property Capacitaciones[] $capacitaciones
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
class Personas extends \yii\db\ActiveRecord
{
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
            [['id_municipios', 'id_tipos_identificaciones', 'id_estados_civiles', 'id_generos', 'id_barrios_veredas', 'estado','grupo_sanguineo','RH','comuna'], 'string'],
            [['latitud', 'longitud'], 'number'],
            [['usuario'], 'string', 'max' => 60],
            [['psw', 'domicilio'], 'string', 'max' => 200],
            [['identificacion'], 'string', 'max' => 45],
            [['nombres', 'apellidos', 'correo'], 'string', 'max' => 100],
            [['telefonos'], 'string', 'max' => 50],
            [['hobbies'], 'string', 'max' => 500],
            [['correo'], 'unique'],
            [['identificacion'], 'unique'],
			[['identificacion', 'nombres','apellidos', 'correo','id_tipos_identificaciones','usuario','psw','estado'],'required'],
            [['usuario'], 'unique'],
            [['id_barrios_veredas'], 'exist', 'skipOnError' => true, 'targetClass' => BarriosVeredas::className(), 'targetAttribute' => ['id_barrios_veredas' => 'id']],
            [['estado'], 'exist', 'skipOnError' => true, 'targetClass' => Estados::className(), 'targetAttribute' => ['estado' => 'id']],
            [['id_estados_civiles'], 'exist', 'skipOnError' => true, 'targetClass' => EstadosCiviles::className(), 'targetAttribute' => ['id_estados_civiles' => 'id']],
            [['id_generos'], 'exist', 'skipOnError' => true, 'targetClass' => Generos::className(), 'targetAttribute' => ['id_generos' => 'id']],
            [['id_tipos_identificaciones'], 'exist', 'skipOnError' => true, 'targetClass' => TiposIdentificaciones::className(), 'targetAttribute' => ['id_tipos_identificaciones' => 'id']],
        ];
    }
	
	/**
 * Metodo para codificar en utf8.
 * 
 * param Parámetro: Recibe la cadena que se va a codificar
 * return Tipo de retorno: Retorna la cadena codificada
 * author : Viviana Rodas
 * exception : No tiene ninguna excepción
 */

	function codificarEnUtf8($fila) {
        $aux;
        foreach ($fila as $value) {
            $aux[] = utf8_encode($value);
        }
        return $aux;
    }

    /**
     * @inheritdoc
     */
	 
    public function attributeLabels()
    {
		
		$Identificacion = utf8_encode('Identificación');
		$telefono = utf8_encode('Teléfonos');
		$tipoIdentificacion = utf8_encode('Tipo Identificación');
		$genero = utf8_encode('Género');
		$grupo_sanguineo = utf8_encode('Grupo Sanguíneo');
        return [
            'id' => 'ID',
            'usuario' => 'Usuario',
            'psw' => 'Clave',
            'identificacion' => $Identificacion,
            'nombres' => 'Nombres',
            'apellidos' => 'Apellidos',
            'telefonos' => $telefono,
            'fecha_nacimiento' => 'Fecha Nacimiento',
            'fecha_registro' => 'Fecha Registro',
            'correo' => 'Correo',
            'domicilio' => 'Domicilio',
            'fecha_ultimo_ingreso' => 'Fecha Ultimo Ingreso',
            'envio_correo' => 'Envio Correo',
            'id_municipios' => 'Municipio',
            'id_tipos_identificaciones' => $tipoIdentificacion,
            'latitud' => 'Latitud',
            'longitud' => 'Longitud',
            'id_estados_civiles' => 'Estado Civil',
            'id_generos' => $genero,
            'hobbies' => 'Hobbies',
            'id_barrios_veredas' => 'Barrio - Vereda',
            'grupo_sanguineo' => $grupo_sanguineo,
			'RH'=>'RH',
            'estado' => 'Estado',
			'comuna'=>'Comuna'
        ];
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
