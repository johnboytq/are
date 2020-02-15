<?php
/**********
---------------------------------------
Versión: 001
Fecha: 10-03-2018
Desarrollador: Oscar David Lopez
Descripción: reportes
---------------------------------------
Modificaciones:
Fecha: 24-06-2018
Persona encargada: Edwin Molina Grisales
Cambios realizados: - Se agrega cantidad de alumnos tanto en el reporte de CANTIDAD DE ESUTIDANTES POR GRADO
					  como CANTIDAD DE ESTUDIATNES POR GRUPO
---------------------------------------
Fecha: 12-04-2018
Persona encargada: Edwin Molina Grisales
Cambios realizados: - Se deja institución y sede por defecto las seleccionadas al inicio de SESSION
---------------------------------------
Fecha: 12-04-2018
Persona encargada: Edwin Molina Grisales
Cambios realizados: - Se agrega opción Listado de estudiantes por grupo
---------------------------------------
Fecha: 11-04-2018
Persona encargada: Oscar David Lopez
Cambios realizados: - Se crea el reporte Tasa cobertura bruta
---------------------------------------
Modificaciones:
Fecha: 05-04-2018
Persona encargada: Edwin Molina Grisales
Cambios realizados: 
Se crea opción 4 del action index correspondiente al reporte de PORCENTAJE OCUPACION AULAS.
---------------------------------------
Fecha: 02-04-2018
Persona encargada: Edwin Molina Grisales
Cambios realizados: 
Se crea opción 2 del action index correspondiente al reporte de CANTIDAD DE ESTUDIANTES POR GRUPOS con su correspondiente resumido.
Se corrige queries en el método actionIndex, ya que se unió la tabla perfiles sin relación alguna.
---------------------------------------
Modificaciones:
Fecha: 10-03-2018
Persona encargada: Oscar David Lopez
Cambios realizados: - cambios en todas las funciones y 
se agrega el listar dependiente de institucion y sede
se añade funcion actionListarInstituciones
---------------------------------------
Modificaciones:
Fecha: 04-06-2018
Persona encargada: Oscar David Lopez
Cambios realizados: - cambios en los reportes 5 y 6
---------------------------------------
**********/
namespace app\controllers;

if(@$_SESSION['sesion']=="si")
{ 
	// echo $_SESSION['nombre'];
} 
//si no tiene sesion se redirecciona al login
else
{
	header('Location: index.php?r=site%2Flogin');
	die;
}

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use app\models\Estudiantes;
use yii\data\SqlDataProvider;


use app\models\Asignaturas;
use app\models\AsginaturasBuscar;
use app\models\Estados;
use app\models\Sedes;
use app\models\Instituciones;
use app\models\Paralelos;
use app\models\SedesJornadas;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;




/**
 * AsignaturasController implements the CRUD actions for Asignaturas model.
 */
class ReportesController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
	
	
	
	public function actionListarInstituciones( $idInstitucion = 0, $idSedes = 0 )
    {
        return $this->render('listarInstituciones',[
			'idSedes' 		=> $idSedes,
			'idInstitucion' => $idInstitucion,
		] );
    }


    /**
     * Lists all Asignaturas models.
     * @return mixed
     */
	 //recibe 2 parametros con la intencion de filtrar por institucion y por sede
    // public function actionIndex($idInstitucion = 0, $idSedes = 0)
    public function actionIndex()
    {
		$idInstitucion 	= $_SESSION['instituciones'][0];
		$idSedes 		= $_SESSION['sede'][0];
		
		// Si existe id sedes e institución se muestra la listas de todas las asignaturas correspondientes
		if( $idInstitucion != 0 && $idSedes != 0 )
		{
			
			//instancia del controlador sedes 
			$sedes = new Sedes();
			//buscar todas las sedes 
			$sedes = $sedes->find()->all();
			//formateo del array 
			$sedes = ArrayHelper::map($sedes,'id', 'descripcion' );
			
			
			$searchModel = new AsginaturasBuscar();
			$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
			//se agregar el andwhere( 'id_sedes='.$idSedes) para que las vista muestre solo las asignatura de la sede seleccionada
			$dataProvider->query->andwhere( 'id_sedes='.$idSedes);
			//y solo los que tengan estado activo
			$dataProvider->query->andwhere( 'estado=1');
				
			return $this->render('index', [
				'searchModel' => $searchModel,
				'dataProvider' => $dataProvider,
				'idSedes' 		=> $idSedes,
				'idInstitucion' => $idInstitucion,
				//se envia la variable sedes a la vista index para mostrar la descripcion de la sede en vez de su Id
				'sedes' 	=>$sedes,
			]);
		}
		else
		{
			// Si el id de institucion o de sedes es 0 se llama a la vista listarInstituciones
			 return $this->render('listarInstituciones',[
				'idSedes' 		=> $idSedes,
				'idInstitucion' => $idInstitucion,
			] );
		}
    }

    /**
     * Displays a single Asignaturas model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
		
        return $this->render('view', [
            'model' => $this->findModel($id),	
        ]);
    }

	
	public function actionReportes($idReporte,$idSedes,$idInstitucion)
    {
		
		$dataProviderCantidad = "";
		
		switch ($idReporte) 
		{
			case 1:
			$sql ="
				SELECT p.identificacion, concat(p.nombres,' ',p.apellidos) as nombres, p.domicilio, j.descripcion
				FROM personas as p, 
					 perfiles_x_personas as pp, 
					 estudiantes as e, 
					 paralelos as pa, 
					 sedes_jornadas as sj, 
					 jornadas as j, 
					 sedes as s, 
					 instituciones as i
				   where p.estado = 1
				   and e.estado = 1
				   and e.id_perfiles_x_personas = pp.id
				   and pp.id_perfiles=11
				   and pp.id_personas = p.id
				   and e.id_paralelos = pa.id
				   and pa.id_sedes_jornadas = sj.id
				   and sj.id_jornadas = j.id
				   and sj.id_sedes = $idSedes
				   and s.id_instituciones = i.id
				   and i.id = $idInstitucion
				   group by p.identificacion, p.nombres,p.apellidos, p.domicilio, j.descripcion
				   ";
				
				$dataProvider = new SqlDataProvider([
						'sql' => $sql,
						
						
					]);
				break;
			case 2:
			
				$sql ="SELECT p.identificacion, concat(p.nombres,' ',p.apellidos) as nombres, p.domicilio, j.descripcion, pa.descripcion as grupo, n.descripcion as nivel
					     FROM personas as p, 
							  perfiles_x_personas as pp, 
							  estudiantes as e,
							  paralelos as pa, 
							  sedes_jornadas as sj, 
							  jornadas as j, 
							  sedes as s,
							  instituciones as i,
							  sedes_niveles sn,
							  niveles n
					    WHERE p.estado 					= 1
					      AND e.estado 					= 1
					      AND e.id_perfiles_x_personas 	= pp.id
					      AND pp.id_perfiles			= 11
					      AND pp.id_personas 			= p.id
					      AND e.id_paralelos 			= pa.id
					      AND pa.id_sedes_jornadas 		= sj.id
					      AND sj.id_jornadas 			= j.id
					      AND sj.id_sedes 				= $idSedes
					      AND s.id_instituciones 		= i.id
					      AND i.id 						= $idInstitucion
						  AND sn.id 					= pa.id_sedes_niveles
						  AND sn.id_sedes 				= s.id
						  AND n.id						= sn.id_niveles
						  AND n.estado 					= 1
					";
			
			
				$dataProvider = new SqlDataProvider([
					'sql' => $sql,
				]);
				
				$sql ="SELECT p.descripcion as grados, count (p.descripcion) as Cantidad
					FROM public.paralelos as p,
					public.sedes_jornadas as sj,
					public.estudiantes as e
					Where p.id_sedes_jornadas = sj.id
					and sj.id_sedes = 48
					and e.id_paralelos = p.id
					group by p.descripcion, p.id
					order by p.id asc
					";
			
			
				$dataProviderCantidad = new SqlDataProvider([
					'sql' => $sql,
				]);
				
				break;
			case 3:
				
				$sql ="SELECT p.identificacion, concat(p.nombres,' ',p.apellidos) as nombres, p.domicilio, j.descripcion, pa.descripcion as grupo, n.descripcion as nivel
					     FROM personas as p, 
							  perfiles_x_personas as pp, 
							  perfiles_x_personas_institucion as ppi,
							  estudiantes as e,
							  paralelos as pa, 
							  sedes_jornadas as sj, 
							  jornadas as j, 
							  sedes as s,
							  instituciones as i,
							  sedes_niveles sn,
							  niveles n
					    WHERE p.estado 					= 1
					      AND e.estado 					= 1
					      AND e.id_perfiles_x_personas 	= pp.id
					      AND pp.id_perfiles			= 11
					      AND pp.id_personas 			= p.id
					      AND e.id_paralelos 			= pa.id
					      AND pa.id_sedes_jornadas 		= sj.id
					      AND sj.id_jornadas 			= j.id
					      AND sj.id_sedes 				= $idSedes
					      AND s.id_instituciones 		= i.id
					      AND i.id 						= $idInstitucion
						  AND sn.id 					= pa.id_sedes_niveles
						  AND ppi.id_institucion		= $idInstitucion
					      AND ppi.id_perfiles_x_persona	= pp.id
						  AND sn.id_sedes 				= s.id
						  AND n.id						= sn.id_niveles
						  AND n.estado 					= 1
						  AND ppi.estado				= 1
					";
			
			
				$dataProvider = new SqlDataProvider([
					'sql' => $sql,
				]);
				
				$sql ="SELECT pa.descripcion as grupo, n.descripcion as nivel, count(*) as cantidad
					     FROM personas as p, 
							  perfiles_x_personas as pp, 
							  perfiles_x_personas_institucion as ppi,
							  estudiantes as e, 
							  paralelos as pa, 
							  sedes_jornadas as sj, 
							  jornadas as j, 
							  sedes as s,
							  instituciones as i,
							  sedes_niveles sn,
							  niveles n
					    WHERE p.estado 					= 1
					      AND e.estado 					= 1
					      AND e.id_perfiles_x_personas 	= pp.id
					      AND pp.id_perfiles			= 11
					      AND pp.id_personas 			= p.id
					      AND e.id_paralelos 			= pa.id
					      AND pa.id_sedes_jornadas 		= sj.id
					      AND sj.id_jornadas 			= j.id
					      AND sj.id_sedes 				= $idSedes
					      AND s.id_instituciones 		= i.id
					      AND i.id 						= $idInstitucion
					      AND ppi.id_institucion		= $idInstitucion
					      AND ppi.id_perfiles_x_persona	= pp.id
						  AND sn.id 					= pa.id_sedes_niveles
						  AND sn.id_sedes 				= s.id
						  AND n.id						= sn.id_niveles
						  AND n.estado 					= 1
						  AND ppi.estado				= 1
					 GROUP BY grupo, nivel
					";
			
			
				$dataProviderCantidad = new SqlDataProvider([
					'sql' => $sql,
				]);
			
				break;
				
			case 4:
				
				$sql ="SELECT a.descripcion AS aula, a.capacidad, COUNT(*) AS cantidad_ocupada
						 FROM distribuciones_academicas da, 
							  aulas a,
							  estudiantes e,
							  paralelos p,
							  aulas_x_paralelos ap
						WHERE a.estado 				= 1
						  AND ap.id_paralelos		= da.id_paralelo_sede
						  AND a.id					= ap.id_aulas
						  AND da.estado 			= 1
						  AND da.id_paralelo_sede 	= p.id
						  AND p.estado			 	= 1
						  AND e.id_paralelos		= p.id
						  AND e.estado				= 1
						  AND a.id_sedes			= $idSedes
					 GROUP BY 1, 2
					"; 
			
			
				$dataProvider = new SqlDataProvider([
					'sql' => $sql,
				]);
							
				break;//fin break 4
				
				case 5://tasa de cobertura bruta
				
				$connection = Yii::$app->getDb();
				
				//edad de los estudiantes
				$command = $connection->createCommand("
					SELECT extract(year from age(p.fecha_nacimiento)) as edad
					FROM estudiantes as e, personas as p, perfiles_x_personas as pp
					WHERE e.id_perfiles_x_personas = pp.id
					and pp.id_personas = p.id
					group by p.fecha_nacimiento
										
				");
				$result = $command->queryAll();
				
				
				$contTranscision =0;
				$contPrimaria =0;
				$contSecundaria =0;
				$contMedia =0;
				$arrayPEN=array('transcision'=>0,'primaria'=>0,'secundaria'=>0,'media'=>0);
				
				
				
				//POBLACIÓN CON EDAD TEORICA O EN EL NIVEL
				foreach ($result as $r)
				{
					// echo $r['edad'];
					$edad = (int)$r['edad'];
					
					if($edad >= 5 and 6 >= $edad )
					{
						$arrayPEN['transcision']=++$contTranscision;
					}					
					elseif($edad >= 7 and  11 >= $edad )
					{
						$arrayPEN['primaria']=++$contPrimaria;
					}					
					elseif($edad >= 12 and 15 >= $edad )
					{
						$arrayPEN['secundaria']=++$contSecundaria;
					}					
					elseif($edad>= 16 and 17 >= $edad )
					{
						$arrayPEN['media']=++$contMedia;
					}
				}
				
						return $this->render('reporte', [
						'arrayPEN'		=> $arrayPEN,
						'idReporte'			=> $idReporte,
						'idSedes' 			=> $idSedes,
						'idInstitucion' 	=> $idInstitucion,
					]);
				break;//fin break 5
				
				case 6://tasa de cobertura Neta
				
				$connection = Yii::$app->getDb();
				
				//edad de los estudiantes
				$command = $connection->createCommand("
					SELECT extract(year from age(p.fecha_nacimiento)) as edad
					FROM estudiantes as e, personas as p, perfiles_x_personas as pp
					WHERE e.id_perfiles_x_personas = pp.id
					and pp.id_personas = p.id
					group by p.fecha_nacimiento
										
				");
				$result = $command->queryAll();
				
				
				$contTranscision =0;
				$contPrimaria =0;
				$contSecundaria =0;
				$contMedia =0;
				$arrayPEN=array('transcision'=>0,'primaria'=>0,'secundaria'=>0,'media'=>0);
				
				
				
				//POBLACIÓN CON EDAD TEORICA O EN EL NIVEL
				foreach ($result as $r)
				{
					// echo $r['edad'];
					$edad = (int)$r['edad'];
					
					if($edad >= 5 and 6 >= $edad )
					{
						$arrayPEN['transcision']=++$contTranscision;
					}					
					elseif($edad >= 7 and  11 >= $edad )
					{
						$arrayPEN['primaria']=++$contPrimaria;
					}					
					elseif($edad >= 12 and 15 >= $edad )
					{
						$arrayPEN['secundaria']=++$contSecundaria;
					}					
					elseif($edad>= 16 and 17 >= $edad )
					{
						$arrayPEN['media']=++$contMedia;
					}
				}
				
					return $this->render('reporte', [
						'arrayPEN'		=> $arrayPEN,
						'idReporte'			=> $idReporte,
						'idSedes' 			=> $idSedes,
						'idInstitucion' 	=> $idInstitucion,
					]);
				
				
				break;//fin break 6
				
				case 7:	//Listado de estudiatnes por grupos
					
					$dataProvider = [];
					
					$sql ="SELECT p.id
							 FROM public.sedes_jornadas as sj, 
								  public.jornadas as j, 
								  public.sedes as s,
								  public.paralelos as p, 
								  public.niveles as n, 
								  public.sedes_niveles as sn
							WHERE sj.id_jornadas= j.id
							  AND sj.id_sedes 	= s.id
							  AND s.id  		= $idSedes
							  AND sj.id 		= p.id_sedes_jornadas
							  AND s.id  		= sn.id_sedes
							  AND sn.id 		= p.id_sedes_niveles
							  AND n.id  		= sn.id_niveles
						";
					
					$connection = Yii::$app->getDb();
					
					$command = $connection->createCommand($sql);
					
					$result = $command->queryAll();
				
					foreach( $result as $key => $value )
					{
						$sql ="SELECT p.identificacion, concat(p.nombres,' ',p.apellidos) as nombre, p.domicilio, pa.descripcion as grupo, SUM(c.calificacion) as puesto
								 FROM personas as p, 
									  perfiles_x_personas as pp 
							LEFT JOIN calificaciones as c
								   ON c.id_perfiles_x_personas_estudiantes = pp.id,
									  perfiles_x_personas_institucion as ppi,
									  estudiantes as e,
									  paralelos as pa
								WHERE p.estado 					= 1
								  AND e.estado 					= 1
								  AND ppi.estado				= 1
								  AND e.id_perfiles_x_personas 	= pp.id
								  AND pp.id_perfiles			= 11
								  AND pp.id_personas 			= p.id
								  AND e.id_paralelos 			= pa.id
								  AND ppi.id_perfiles_x_persona = pp.id
								  AND ppi.id_institucion		= $idInstitucion
								  AND pa.id 					= ".$value['id']."
							 GROUP BY p.identificacion, nombre, p.domicilio, grupo
							 ORDER BY grupo desc
							";
				
						$dataProvider[] = new SqlDataProvider([
							'sql' => $sql,
						]);
					}
							
					$dataProviderCantidad = "";
			
				break;//fin break 7
				
				case 8://reporte cantida de estudiantes por genero
			
				$sql ="SELECT p.identificacion, concat(p.nombres,' ',p.apellidos) as nombres, p.domicilio, j.descripcion, g.descripcion as genero, n.descripcion as nivel
						FROM personas as p,perfiles_x_personas as pp,
						estudiantes as e,paralelos as pa, 
						sedes_jornadas as sj,
						jornadas as j,
						sedes as s,
						instituciones as i,
						sedes_niveles sn,
						niveles n,
						generos g 
						WHERE p.estado 					= 1
					    AND e.estado 					= 1
						AND e.id_perfiles_x_personas 	= pp.id
						AND pp.id_perfiles				= 11
						AND pp.id_personas 				= p.id
						AND e.id_paralelos 				= pa.id
						AND pa.id_sedes_jornadas 		= sj.id
						AND sj.id_jornadas 				= j.id
						AND sj.id_sedes 				= $idSedes
						AND s.id_instituciones 			= i.id
						AND i.id 						= $idInstitucion
						AND sn.id 						= pa.id_sedes_niveles
						AND sn.id_sedes 				= s.id
						AND n.id						= sn.id_niveles
						AND n.estado 					= 1
						And P.id_generos 				= g.id 
					";
			
			
				$dataProvider = new SqlDataProvider([
					'sql' => $sql,
				]);
				
				$sql ="SELECT g.descripcion as genero,count(*) as cantidad
						FROM personas as p,
						perfiles_x_personas as pp,
						estudiantes as e,
						paralelos as pa,
						sedes_jornadas as sj,
						jornadas as j,
						sedes as s,
						instituciones as i,
						sedes_niveles sn,
						niveles n,
						generos g 
					    WHERE p.estado 					= 1
					      AND e.estado 					= 1
					      AND e.id_perfiles_x_personas 	= pp.id
					      AND pp.id_perfiles			= 11
					      AND pp.id_personas 			= p.id
					      AND e.id_paralelos 			= pa.id
					      AND pa.id_sedes_jornadas 		= sj.id
					      AND sj.id_jornadas 			= j.id
					      AND sj.id_sedes 				= $idSedes
					      AND s.id_instituciones 		= i.id
					      AND i.id 						= $idInstitucion
						  AND sn.id 					= pa.id_sedes_niveles
						  AND sn.id_sedes 				= s.id
						  AND n.id						= sn.id_niveles
						  AND n.estado 					= 1
						  And P.id_generos 				= g.id 
						GROUP BY g.descripcion
					";
			
			
				$dataProviderCantidad = new SqlDataProvider([
					'sql' => $sql,
				]);
				
				break;//fin case 8
				
				case 9:	//Cantidad de estudiantes por grado desempeño
					
					$dataProvider = [];
					
					$sql ="SELECT p.id
							 FROM public.sedes_jornadas as sj, 
								  public.jornadas as j, 
								  public.sedes as s,
								  public.paralelos as p, 
								  public.niveles as n, 
								  public.sedes_niveles as sn
							WHERE sj.id_jornadas= j.id
							  AND sj.id_sedes 	= s.id
							  AND s.id  		= $idSedes
							  AND sj.id 		= p.id_sedes_jornadas
							  AND s.id  		= sn.id_sedes
							  AND sn.id 		= p.id_sedes_niveles
							  AND n.id  		= sn.id_niveles
						";
					
					$connection = Yii::$app->getDb();
					
					$command = $connection->createCommand($sql);
					
					$result = $command->queryAll();
				
					foreach( $result as $key => $value )
					{
						$sql ="SELECT p.identificacion, concat(p.nombres,' ',p.apellidos) as nombre, p.domicilio, pa.descripcion as grupo, '' as puesto
								 FROM personas as p, 
									  perfiles_x_personas as pp, 
									  estudiantes as e,
									  paralelos as pa
								WHERE p.estado 					= 1
								  AND e.estado 					= 1
								  AND e.id_perfiles_x_personas 	= pp.id
								  AND pp.id_perfiles			= 11
								  AND pp.id_personas 			= p.id
								  AND e.id_paralelos 			= pa.id
								  AND pa.id 					= ".$value['id']."
							 ORDER BY grupo desc
							";
							
						$sql ="SELECT p.identificacion, concat(p.nombres,' ',p.apellidos) as nombre, p.domicilio, pa.descripcion as grupo, SUM(c.calificacion) as puesto
								 FROM personas as p,
									  perfiles_x_personas as pp
							LEFT JOIN calificaciones as c
								   ON c.id_perfiles_x_personas_estudiantes = pp.id,
									  perfiles_x_personas_institucion as ppi,
									  estudiantes as e,
									  paralelos as pa
								WHERE p.estado 					= 1
								  AND e.estado 					= 1
								  AND ppi.estado				= 1
								  AND e.id_perfiles_x_personas 	= pp.id
								  AND pp.id_perfiles			= 11
								  AND pp.id_personas 			= p.id
								  AND e.id_paralelos 			= pa.id
								  AND ppi.id_perfiles_x_persona = pp.id
								  AND ppi.id_institucion		= $idInstitucion
								  AND pa.id 					= ".$value['id']."
							 GROUP BY p.identificacion, nombre, p.domicilio, grupo
							 ORDER BY grupo desc, puesto
							";
				
						$dataProvider[] = new SqlDataProvider([
							'sql' => $sql,
						]);
					}
							
					$dataProviderCantidad = "";
			
				break;//fin break 9
		}
		
		return $this->render('reporte', [
				'dataProvider'		=> $dataProvider,
				'dataProviderCantidad'=> $dataProviderCantidad,
				'idReporte'			=> $idReporte,
				'idSedes' 			=> $idSedes,
				'idInstitucion' 	=> $idInstitucion,
			]);
    }
	
	
	public function printr ($valor)
	{
		echo "<pre>"; print_r($valor ); echo "</pre>";
	}
	
    /**
     * Creates a new Asignaturas model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($idSedes, $idInstitucion)
    {
				
		//se selecciona el estado activo siempre se crea activo
		$estados = new Estados();
		$estados = $estados->find()->where('id=1')->all();
		$estados = ArrayHelper::map($estados,'id','descripcion');
		
		//se seleccionan solo la sede actual 
		$sedes = new Sedes();
		$sedes = $sedes->find()->where('id='.$idSedes)->all();
		$sedes = ArrayHelper::map($sedes,'id','descripcion');
		
        $model = new Asignaturas();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
			'estados'=>$estados,
			'sedes'=>$sedes,
        ]);
    }

    /**
     * Updates an existing Asignaturas model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
		$model = $this->findModel($id);
		
		//se seleccionan todos los estados para mostrarlos en la vista 
		$estados = new Estados();
		$estados = $estados->find()->all();
		$estados = ArrayHelper::map($estados,'id','descripcion');
		
		//se seleccionan solo la sede actual para mostrar en la vista update
		$sedes = new Sedes();
		$sedes = $sedes->find()->where('id='.$model->id_sedes)->all();
		$sedes = ArrayHelper::map($sedes,'id','descripcion');
		
		
       
		
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
			'estados'=>$estados,
			'sedes'=>$sedes,
        ]);
    }

    /**
     * Deletes an existing Asignaturas model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
	 
	 //Se cambia para que no borre, en cambio actualiza el campo estado a 2;
    public function actionDelete($id)
    {
		
		$model = $this->findModel($id);
		$idSedes= $model->id_sedes;
		//variable con la conexion a la base de datos
		$connection = Yii::$app->getDb();
		//saber el id de la sede para redicionar al index correctamente
		$command = $connection->createCommand("
		SELECT i.id
		FROM instituciones as i,sedes as s
		WHERE s.id_instituciones = i.id
		and s.id = $idSedes
		");
		$result = $command->queryAll();
		$idInstituciones = $result[0]['id'];
		
		$model = Asignaturas::findOne($id);
		$model->estado = 2;
		$idInstitucion = $model->id;
		$model->update(false);

		return $this->redirect(['index', 'idInstitucion' => $idInstituciones,'idSedes'=>$idSedes]);		
		
    }

    /**
     * Finds the Asignaturas model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Asignaturas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Asignaturas::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('La página que está solicitando no existe.');
    }
}
