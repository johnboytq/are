<?php

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
use app\models\DistribucionesAcademicas;
use app\models\DistribucionesAcademicasBuscar;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use yii\web\Response;

use app\models\Estados;
use app\models\DistribucionesXBloquesXDias;
use yii\data\SqlDataProvider;



/**
 * DistribucionesAcademicasController implements the CRUD actions for DistribucionesAcademicas model.
 */
class DistribucionesAcademicasController extends Controller
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
	
			/**
     * Lists all DistribucionesAcademicas models.
     * @return mixed
     */
    public function actionIndex()
    {
        $idInstitucion = $_SESSION['instituciones'][0];
		$idSedes = $_SESSION['sede'][0];
		
			
			$searchModel = new DistribucionesAcademicasBuscar();
			$dataProvider = $searchModel->search(Yii::$app->request->queryParams); //traer los datos de la distribucion academica por sede
			$dataProvider->query->select ("da.id, da.id_asignaturas_x_niveles_sedes, da.id_perfiles_x_personas_docentes, da.id_aulas_x_sedes, da.fecha_ingreso, da.estado, da.id_paralelo_sede");
			$dataProvider->query->from( 'distribuciones_academicas as da, asignaturas_x_niveles_sedes as ans, sedes_niveles as sn');
			$dataProvider->query->andwhere( "da.id_asignaturas_x_niveles_sedes = ans.id
											AND sn.id = ans.id_sedes_niveles
											AND sn.id_sedes = $idSedes
											AND da.estado = 1");
		
			// echo "<pre>"; print_r($dataProvider); echo "</pre>";
			return $this->render('index', [
				'searchModel' => $searchModel,
				'dataProvider' => $dataProvider,
				'idSedes' 	=> $idSedes,
				'idInstitucion' => $idInstitucion,
			]);
		
    }

    /**
     * Displays a single DistribucionesAcademicas model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        
		$idInstitucion = $_SESSION['instituciones'][0];
		$idSedes = $_SESSION['sede'][0];
		
		return $this->render('view', [
            'model' => $this->findModel($id),
			'idSedes' 		=> $idSedes,
			'idInstitucion' => $idInstitucion,
        ]);
    }

    /**
     * Creates a new DistribucionesAcademicas model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {	
	
		$idInstitucion = $_SESSION['instituciones'][0];
		$idSedes = $_SESSION['sede'][0];
		
		//se usa en el form para que en el yii se activen los dataTables
		$sql ="
		SELECT p.identificacion
		FROM personas as p
			 
		   ";		
		$dataProvider = new SqlDataProvider([
				'sql' => $sql,
				
			]);
						
        //se crea una instancia del modelo estados
		$estadosTable 		 	= new Estados();
		//se traen los datos de estados
		$dataestados		 	= $estadosTable->find()->where( 'id=1' )->all();
		//se guardan los datos en un array
		$estados	 	 	 	= ArrayHelper::map( $dataestados, 'id', 'descripcion' );
		
		/**
		* Concexion a la db, llenar select de docentes
		*/
		//variable con la conexion a la base de datos  pe.id=10 es el perfil docente
		$connection = Yii::$app->getDb();
		
		$command = $connection->createCommand("select d.id_perfiles_x_personas as id, concat(p.nombres,' ',p.apellidos) as nombres
												from personas as p, perfiles_x_personas as pp, docentes as d, perfiles as pe
												where p.id= pp.id_personas
												and p.estado=1
												and pp.id_perfiles=pe.id
												and pe.id=10
												and pe.estado=1
												and pp.id= d.id_perfiles_x_personas");
		$result = $command->queryAll();
		//se formatea para que lo reconozca el select
		foreach($result as $key){
			$docentes[$key['id']]=$key['nombres'];
		}
		
		/**
		* Llenar select de aulas por sede
		*/
		$command = $connection->createCommand("SELECT a.id, a.descripcion
												FROM aulas as a, sedes as s
												WHERE a.id_sedes = s.id
												AND a.id_sedes = $idSedes");
		$result = $command->queryAll();
		//se formatea para que lo reconozca el select
		foreach($result as $key){
			$aulas[$key['id']]=$key['descripcion'];
		}
		
		
		$modificar = false;
		
		$model = new DistribucionesAcademicas();
			
		
		if($_POST)
		{		
	
			$id_asignaturas_x_niveles_sedes	= $_POST['id_asignaturas_x_niveles_sedes'];
			$id_perfiles_x_personas_docentes= $_POST['id_perfiles_x_personas_docentes'];
			$id_aulas_x_sedes				= $_POST['id_aulas_x_sedes'];
			$estado							= $_POST['estado'];
			$id_paralelo_sede				= $_POST['id_paralelo_sede'];
			$fecha_ingreso					= $_POST['fecha_ingreso'];
			$dia 							= $_POST['dia'];
			$bloque 						= $_POST['bloque'];
			
			//variable de conexion
			$connection = Yii::$app->getDb();
			
			/**intensiad horario no se pueden asignar mas horas de las te tiene en la insentidad horaria*/
			
			//saber si tiene insentidad Horaria y cuanto es
			$command 	= $connection->createCommand("
			SELECT intensidad
			FROM asignaturas_x_niveles_sedes
			where id = $id_asignaturas_x_niveles_sedes
			");
			$intensidadhoraria = $command->queryAll();
			$intensidadHoraria = $intensidadhoraria[0]['intensidad']; 
			
			
			// print_r($intensidadHoraria);
			// print_r(" --- ");
			// print_r($_SESSION['sede'][0]);
			// die("aqui");
			//si no tiene intensiadhoraria
			if(!empty($intensidadHoraria) == 0)
			{
				$data=array('error'=>1,'mensaje'=>"La materia no tiene intensiad horaria");
				echo json_encode($data);
				die;
			}
			
			//cuantas horas tiene la materia en este momento
			$command 	= $connection->createCommand("
			SELECT count(dbd.id)
			FROM distribuciones_academicas as da, distribuciones_x_bloques_x_dias as dbd
			where dbd.id_distribuciones_academicas = da.id
			and da.id_asignaturas_x_niveles_sedes = $id_asignaturas_x_niveles_sedes
			and da.estado = 1
			and da.id_paralelo_sede = $id_paralelo_sede
		
			");
			$result 	= $command->queryAll();
			$horasMateria	= @$result[0]['count'];
					
			
			//id del dia del la celda que seleciona en el dataTable
			$command 	= $connection->createCommand("SELECT id FROM dias WHERE descripcion ='$dia'");
			$result 	= $command->queryAll();
			$idDia 		= $result[0]['id'];
			
			//id del bloque del la celda que seleciona en el dataTable
			$command 	= $connection->createCommand("SELECT sb.id 
													FROM sedes_x_bloques as sb, bloques as b
													WHERE sb.id_bloques = b.id
													and b.descripcion ='$bloque'
													and sb.id_sedes=$idSedes");
			$result 	= $command->queryAll();
			$idBloqueXSede	= $result[0]['id'];
			
			
			//saber si ya existe una distribucion academica que pertenesca a ese horario
			$command = $connection->createCommand
			("
				SELECT id
				FROM distribuciones_academicas
				where id_asignaturas_x_niveles_sedes = $id_asignaturas_x_niveles_sedes
				and id_perfiles_x_personas_docentes = $id_perfiles_x_personas_docentes
				and id_paralelo_sede =$id_paralelo_sede	
				and estado = 1			
			");
			$distribucion  = $command->queryAll();
			$idDistribucion = @$distribucion[0]['id'];	
			//si no tiene horario no tiene ninguna distribucion academica se crea de lo contario se continua con 
			//el id $idDistribucion
			if (!empty($idDistribucion) == 0 )
			{
				$command = $connection->createCommand
				("
					INSERT INTO public.distribuciones_academicas
					(
						id_asignaturas_x_niveles_sedes,
						id_perfiles_x_personas_docentes,
						fecha_ingreso,
						estado,
						id_paralelo_sede
					)
					VALUES 
					(
						$id_asignaturas_x_niveles_sedes,
						$id_perfiles_x_personas_docentes,
						'$fecha_ingreso',
						1,
						$id_paralelo_sede
						
					)returning id;
				");
				$distribucion = $command->queryAll();
				$idDistribucion = $distribucion[0]['id'];
			}
			
					
			if(strpos($_POST['informacionCelda'],"</insertar>") > 0)
			{
				
				//intensiad horaria
				if($horasMateria+1 > $intensidadHoraria )
				{
					$data=array('error'=>1,'mensaje'=>"la materia no pueden superar la insentidad horaria ($intensidadHoraria)");
					echo json_encode($data);
					die;
				}
				
				
				//insertar en distribuciones_x_bloques_x_dias
				$command = $connection->createCommand
				("
					INSERT INTO public.distribuciones_x_bloques_x_dias
					(
						id_distribuciones_academicas,
						id_bloques_sedes,
						id_dias,
						id_aulas_sedes
					)
					VALUES 
					(
						$idDistribucion,
						$idBloqueXSede,
						$idDia,
						$id_aulas_x_sedes
					)
				");
				$result = $command->queryAll();
				
				$data = array("error"=>"0");
				echo json_encode($data);
				die;
				
			}
			elseif(strpos($_POST['informacionCelda'],"</actualizar=") > 0)
			{
				
				
				$pos = strpos($_POST['informacionCelda'],"</actualizar=");
				//id de la distribucion academica
				$id  = substr($_POST['informacionCelda'],$pos+13);
				
				
				/***se valida que una materia no se asigne mas horas de las que se indican en la instensidad horaria*/		


				//Saber que asignatura se esta modificando
				$command = $connection->createCommand
				("
					SELECT asig.descripcion
					FROM distribuciones_academicas as da, asignaturas_x_niveles_sedes as ans, asignaturas as asig
					where da.id_asignaturas_x_niveles_sedes = ans.id
					and ans.id_asignaturas = asig.id
					and da.id in ($id, $idDistribucion)
				");
				$result = $command->queryAll();
				
				//saber si las asignaturas son las mismas de ser asi no se comprueba la intensiad horaria
				if(count ($result) == 1)
				{}
				else
				{
					//intensiad horaria
					if($horasMateria+1 > $intensidadHoraria )
					{
						$data=array('error'=>1,'mensaje'=>"la materia no pueden superar la insentidad horaria ($intensidadHoraria)");
						echo json_encode($data);
						die;
					}
				}
				
				//borrar el registro
				$command = $connection->createCommand
				("
					DELETE FROM distribuciones_x_bloques_x_dias
					WHERE id_bloques_sedes = $idBloqueXSede
					and id_dias = $idDia
				");
				$result = $command->execute();
					
				//actualiza distribuciones_x_bloques_x_dias
				//se ingresa nuevamente 
				$command = $connection->createCommand
				("
					INSERT INTO distribuciones_x_bloques_x_dias(
					id_distribuciones_academicas,
					id_bloques_sedes, 
					id_dias,
					id_aulas_sedes)
					VALUES 
					(
					$idDistribucion,
					$idBloqueXSede,
					$idDia,
					$id_aulas_x_sedes
					)	
				");
				$result = $command->queryAll();
				$data = array("error"=>"0");
				echo json_encode($data);
				die;
			}
			
		}
		
		
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            // return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'idSedes' => $idSedes,
			'estados'=>$estados,
			'docentes'=>$docentes,
			'aulas'=>$aulas,
			'paralelos_distribucion'=>'',
			'modificar'=>$modificar,
			'niveles_sede'=>'',
			'asignaturas_distribucion'=>'',
			'idInstitucion'=>$idInstitucion,
			'paralelos_distribucion'=>'',
			'dataProvider'=>$dataProvider,
			
        ]);
    }

    /**
     * Updates an existing DistribucionesAcademicas model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
		
		$idInstitucion = $_SESSION['instituciones'][0];
		$idSedes = $_SESSION['sede'][0];
		
		$sql ="
		SELECT p.identificacion
		FROM personas as p
			 
		   ";		
		$dataProvider = new SqlDataProvider([
				'sql' => $sql,
				
			]);
		
        //se crea una instancia del modelo estados
		$estadosTable 		 	= new Estados();
		//se traen los datos de estadosCiviles
		$dataestados		 	= $estadosTable->find()->all();
		//se guardan los datos en un array
		$estados	 	 	 	= ArrayHelper::map( $dataestados, 'id', 'descripcion' );
		
	
		
		
		// Concexion a la db, llenar select de docentes
		$connection = Yii::$app->getDb();
		
		//variable con la conexion a la base de datos  pe.id=10 es el perfil docente
		
		$command = $connection->createCommand("select d.id_perfiles_x_personas as id, concat(p.nombres,' ',p.apellidos) as nombres
												from personas as p, perfiles_x_personas as pp, docentes as d, perfiles as pe, perfiles_x_personas_institucion as ppi
												where p.id= pp.id_personas
												and p.estado=1
												and pp.id_perfiles=pe.id
												and pe.id=10
												and pe.estado=1
												and pp.id= d.id_perfiles_x_personas
												and ppi.id_institucion = $idInstitucion
												and pp.id = ppi.id_perfiles_x_persona
												");
		$result = $command->queryAll();
		//se formatea para que lo reconozca el select
		foreach($result as $key){
			$docentes[$key['id']]=$key['nombres'];
		}
		
		
		/**
		* Llenar select de aulas por sede
		*/
		$command = $connection->createCommand("SELECT a.id, a.descripcion
												FROM aulas as a, sedes as s
												WHERE a.id_sedes = s.id
												AND a.id_sedes = $idSedes");
		$result = $command->queryAll();
		//se formatea para que lo reconozca el select
		foreach($result as $key){
			$aulas[$key['id']]=$key['descripcion'];
		}
		
		$model = $this->findModel($id);
		/**
		* Traer de id_asignaturas_x_niveles_sedes con id de distribuciones academicas
		*/
		// $command = $connection->createCommand("select da.id_asignaturas_x_niveles_sedes
												// from distribuciones_academicas as da
												// where da.id = $id");
		// $result = $command->queryAll();
		// $id_asignaturas_x_niveles_sedes = $result[0]['id_asignaturas_x_niveles_sedes'];
		$id_asignaturas_x_niveles_sedes = $model->id_asignaturas_x_niveles_sedes;
		
		
		/**
		* Traer de los niveles de esa sede 
		*/
		$command = $connection->createCommand("SELECT sn.id, n.descripcion
												FROM public.sedes_niveles as sn, niveles as n, asignaturas_x_niveles_sedes as ans
												where sn.id_sedes = $idSedes
												and sn.id_niveles = n.id
												and n.estado = 1
												
												group by sn.id, n.descripcion
												");
		$result = $command->queryAll();
		
		foreach ($result as $r)
		{
			$niveles_sede[$r['id']]=$r['descripcion'];
			
		}
		// $niveles_sede = $result[0]['id'];  //ya se tiene el valor del nivel que se selecciono 26 septimo
		
		
		/**
		* Traer de las asignaturas ya guardada en la asignaturas por niveles sedes 
		*/
		
		
										
		
		$command = $connection->createCommand("SELECT ans.id, a.descripcion
												FROM asignaturas_x_niveles_sedes as ans, asignaturas as a, sedes_niveles as sn
												WHERE a.estado = 1
												AND a.id = ans.id_asignaturas
												AND ans.id_sedes_niveles = sn.id
												and ans.id = $id_asignaturas_x_niveles_sedes");
		$result = $command->queryAll();
		$asignaturas_distribucion = $result[0]['id']; 
		
			/**
		* Traer el nivel que esta seleccionado 
		*/
		
		$command = $connection->createCommand("
			SELECT sn.id
			FROM distribuciones_academicas as da, asignaturas_x_niveles_sedes as ans, sedes_niveles as sn
			where da.id_asignaturas_x_niveles_sedes = ans.id
			and ans.id_sedes_niveles = sn.id
			and da.id=$id");
		$result = $command->queryAll();
		$nivelSelected = $result[0]['id']; 
		
		/**
		* Traer paralelo(grupo) guardado por sede por nivel
		*/
		$command = $connection->createCommand("select da.id_paralelo_sede
												from distribuciones_academicas as da
												where da.id = $id"); //idSedesNiveles
		$result = $command->queryAll();
		$paralelos_distribucion = $result[0]['id_paralelo_sede']; 
		$modificar = true;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
			
            'model' => $model,
			'estados'=>$estados,
			'idSedes' => $idSedes,
			'idInstitucion' => $idInstitucion,
			'docentes'=>$docentes,
			'aulas'=>$aulas,
			'paralelos_distribucion'=>$paralelos_distribucion,
			'niveles_sede'=>$niveles_sede, //todos
			'asignaturas_distribucion'=>$asignaturas_distribucion,
			'modificar'=>$modificar,
			'dataProvider'=>$dataProvider,
			'nivelSelected'=>$nivelSelected,
        ]);
    }

    /**
     * Deletes an existing DistribucionesAcademicas model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        
		$model = DistribucionesAcademicas::findOne($id);
		$model->estado = 2;
		$model->update(false);
		
		return $this->redirect(['index']);
    }

    /**
     * Finds the DistribucionesAcademicas model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return DistribucionesAcademicas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DistribucionesAcademicas::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
	
	 /**
     * Esta funcion lista las asignaturas por sede nivel que estan activas.
     * 
     * @param Recibe id sedes nivel
     * @return la lista de asignaturas
     * @throws no tiene excepciones
     */		
  public function actionListarA($idSedesNiveles )
	{
		
		
		//variable con la conexion a la base de datos
		$connection = Yii::$app->getDb();
		//asignaturas del grupo
		$command = $connection->createCommand("
		SELECT ans.id, a.descripcion
		FROM asignaturas_x_niveles_sedes as ans, asignaturas as a, sedes_niveles as sn
		WHERE a.estado = 1
		AND a.id = ans.id_asignaturas
		AND ans.id_sedes_niveles = sn.id
		AND sn.id = $idSedesNiveles");
		$result = $command->queryAll();
		
		return Json::encode( $result );
		
	
	}    

	//trae la iformacion del horario con respeto al docente y a la sede
  public function actionHorario($idParalelo)
	{
		
		$idSedes = $_SESSION['sede'][0];
		
		//variable con la conexion a la base de datos
		$connection = Yii::$app->getDb();
		
		//
		
		$command = $connection->createCommand("
		select dbd.id_distribuciones_academicas as id, d.descripcion as dias, b.descripcion as bloques, a.descripcion as asignatura,
			pa.descripcion as grupo, au.descripcion as aula
			from distribuciones_x_bloques_x_dias as dbd, asignaturas_x_niveles_sedes as ans, distribuciones_academicas as da, 
			sedes_niveles as sn, dias as d, bloques as b, sedes_x_bloques as sb, asignaturas as a, paralelos as pa, aulas as au
			Where dbd.id_distribuciones_academicas = da.id
			and dbd.id_dias = d.id
			and dbd.id_bloques_sedes = sb.id
			and sb.id_sedes = $idSedes
			and pa.id = $idParalelo
			and da.id_asignaturas_x_niveles_sedes = ans.id
			and ans.id_asignaturas = a.id
			and ans.id_sedes_niveles = sn.id
			and sb.id_bloques = b.id 
			and da.id_paralelo_sede =pa.id
			and dbd.id_aulas_sedes = au.id
		");
			$result = $command->queryAll();
		
			$command = $connection->createCommand("SELECT id, descripcion
			FROM dias
			where estado  =1
			order by id");
			$dias = $command->queryAll();
			
			
			$command = $connection->createCommand("
			SELECT b.id, b.descripcion
			FROM bloques as b, sedes_x_bloques as sb 
			where b.estado  =1
			and sb.id_sedes =$idSedes
			and sb.id_bloques = b.id
			order by id asc");
			$bloques = $command->queryAll();
			
			
			//se crea un array con los bloque de la sede VS los dias de la semana con el valor no asignado
			foreach ($dias as $dia)
			{
				foreach ($bloques as $bloque)
				{
					//$bloque['descripcion'] nombre del bloque 
					//$dia['descripcion'] dia de la semana
					$arrayHorario[$bloque['descripcion']][$dia['descripcion']]="-"."</insertar>";
				}
				
				
			}
			
			//en la ubicacion bloque - dia se pone el nombrede la asignatura - group - aula que da ese docente $idDocente
			foreach($result as $r)
			{
				
				$arrayHorario[$r['bloques']][$r['dias']]=$r['asignatura']." |".$r['grupo']."|".$r['aula']."&nbsp;&nbsp;&nbsp;&nbsp;<img src='images/Borrar.png' width='20' height='20' onclick='borrarDA(this);'>"."</actualizar=".$r['id']."";
			}
			
			
			//se construye el formato json para llenar el dataTable
			$data='[';
			$data.='{"bloques":" BLOQUE ","LUNES":"LUNES","MARTES":"MARTES","MIERCOLES":"MIERCOLES","JUEVES":"JUEVES","VIERNES":"VIERNES","SABADO":"SABADO","DOMINGO":"DOMINGO"},';
			foreach($arrayHorario as $arrayHorarioJson=>$valor) 
			{
				$data.='{"bloques":"'.$arrayHorarioJson.'",';
				foreach($valor as $v=>$value)
				{
					// print_r($v);
					$arraydata[]='"'.$v.'":"'.$value.'"';
				}
				$data.=implode(",",$arraydata);
				unset($arraydata);
				$data.='},';
			}
			$data = substr($data, 0, -1);
			$data.=']';
			echo $data;
			// print_r($arrayHorario);
	

		// return Json::encode( $arrayHorario );
		// return Json::encode( $result );
		
	
	}
	
	public function actionListarG($idSedesNiveles)
	{
		
		$idSedes = $_SESSION['sede'][0];
		//variable con la conexion a la base de datos
		$connection = Yii::$app->getDb();
		/**
		* Llenar select de paralelo(grupo) por sede y nivel seleccionado
		*/
		
		$command = $connection->createCommand("SELECT p.id, p.descripcion
												FROM paralelos as p, sedes_niveles as sn
												WHERE sn.id = p.id_sedes_niveles
												AND sn.id_sedes = $idSedes
												and p.id_sedes_niveles = ".$idSedesNiveles."");
		$result = $command->queryAll();
		//se formatea para que lo reconozca el select
		// foreach($result as $key){
			// $grupos[$key['id']]=$key['descripcion'];
		// }
		
		return Json::encode( $result );
	}
	
  public function actionBorrarDA($bloque, $dia)
	{
		$connection = Yii::$app->getDb();
		//id del dia del la celda que seleciona en el dataTable
		$command 	= $connection->createCommand("SELECT id FROM dias WHERE descripcion ='$dia'");
		$result 	= $command->queryAll();
		$idDia 		= $result[0]['id'];
		
		$idSedes = $_SESSION['sede'][0];
		
		//id del bloque del la celda que seleciona en el dataTable
		$command 	= $connection->createCommand("SELECT sb.id 
												FROM sedes_x_bloques as sb, bloques as b
												WHERE sb.id_bloques = b.id
												and b.descripcion ='$bloque'
												and sb.id_sedes=$idSedes");
		$result 	= $command->queryAll();
		$idBloqueXSede	= $result[0]['id'];
		
		// echo "DELETE FROM distribuciones_x_bloques_x_dias
			// WHERE id_bloques_sedes = $idBloqueXSede
			// and id_dias = $idDia";
			// die;
		//borrar el registro de la distribucion academica seleccionada
		$command = $connection->createCommand
		("
			DELETE FROM distribuciones_x_bloques_x_dias
			WHERE id_bloques_sedes = $idBloqueXSede
			and id_dias = $idDia
		");
		$borrado = $command->queryAll();
		
		return Json::encode( 1 );
	
	}
	
}
