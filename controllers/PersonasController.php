<?php
/**********
Versión: 001
Fecha: Fecha en formato (09-03-2018)
Desarrollador: Viviana Rodas
Descripción: Controlador de personas
---------------------------------------
Versión: 001
Fecha: Fecha en formato (05-06-2018)
Desarrollador: Oscar David Lopez
Descripción: Se agrega el campo RH
---------------------------------------

*/
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
use app\models\Personas;
use app\models\PersonasBuscar;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\models\TiposIdentificaciones;
use app\models\EstadosCiviles;
use app\models\Generos;
use app\models\Estados;
use app\models\Municipios;
use app\models\BarriosVeredas;
use app\models\ComunasCorregimientos;
use app\models\Perfiles;
use app\models\PerfilesXPersonas;

use yii\helpers\ArrayHelper;

use yii\helpers\Html;

use yii\helpers\Url;

use yii\grid\ActionColumn;

/**
 * PersonasController implements the CRUD actions for Personas model.
 */
class PersonasController extends Controller
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
	
	public function actionConsultarPersonas(){
		
		$start 	= $_GET['start'];
		$len 	= $_GET['length'];
		$search	= $_GET['search']['value'];
		
		$searchModel = new PersonasBuscar();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		// $datas = $dataProvider->query->andWhere('estado=1'); 
		
		if( !empty($search) ){
			$dataProvider->query
				->orWhere("nombres ILIKE '%".$search."%'" )
				->orWhere("apellidos ILIKE '%".$search."%'" )
				->orWhere("identificacion ILIKE '%".$search."%'")
				->orWhere("correo ILIKE '%".$search."%'" );
		}
		
		$datas = $dataProvider->query->andWhere('estado=1')->limit($len)->offset($start)->all(); 
		
		$data = [];
		
		$i = $start;
		foreach( $datas as $d ){
			
			$a = new ActionColumn();
			$url = $a->renderDataCell( $d, $d->id, $i );

			$data[] = [
					'0'	=> ++$i,
					'1'	=> $d->identificacion,
					'2' => $d->nombres,
					'3' => $d->apellidos,
					'4' => $d->correo,
					'5' => $url,
				];
		}
		
		return json_encode( [ 'data' => $data ] );
	}

    /**
     * Lists all Personas models.
     * @return mixed
     */
	
	public function grupoSanguineo(){
		$arrayGrupoSanguineo =
		[
			"A"=>"A",
			"B"=>"B",
			"AB"=>"AB",
			"O"=>"O",
		]; 
		return $arrayGrupoSanguineo;
	}
	 
	public function rh()
	{
		$arrayRH = 
		[
			"-"=>"-",
			"+"=>"+",		
		];
		
		return $arrayRH;
	}
	 
	public function actionComunas($idMunicipio)
	{
		$comunasCorregimientos = new ComunasCorregimientos();
		$comunasCorregimientos = $comunasCorregimientos->find()->where("id_municipios=$idMunicipio")->all();
		$comunasCorregimientos = ArrayHelper::map($comunasCorregimientos,'id','descripcion');
				
		foreach ($comunasCorregimientos as $c => $v)
		{
			$data[]="<option value=$c>$v</option>";
		}
		
		echo json_encode( $data);
	}
	
	public function actionBarrios($idComunas)
	{
		$barriosVeredas = new BarriosVeredas();
		$barriosVeredas = $barriosVeredas->find()->where("id_comunas_corregimientos=$idComunas")->all();
		$barriosVeredas = ArrayHelper::map($barriosVeredas,'id','descripcion');
				
		$data = array();
		foreach ($barriosVeredas as $c => $v)
		{
			$data[]="<option value=$c>$v</option>";
		}
		
		echo json_encode( $data);
	}
	 
    public function actionIndex()
    {
        $searchModel = new PersonasBuscar();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$dataProvider ->query->andWhere('estado=1')->limit(20); 

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Personas model.
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

    /**
     * Creates a new Personas model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        //se crea una instancia del modelo tipoIdentificaciones
		$identificacionesTable 		 	= new TiposIdentificaciones();
		//se traen los datos de identificaciones
		$dataIdentificaciones		 	= $identificacionesTable->find()->all();
		//se guardan los datos en un array
		$identificaciones	 	 	 	= ArrayHelper::map( $dataIdentificaciones, 'id', 'descripcion' );
		
		
		//se crea una instancia del modelo estados civiles
		$estadosCivilesTable 		 	= new EstadosCiviles();
		//se traen los datos de estados civiles
		$dataestadosCiviles		 	= $estadosCivilesTable->find()->all();
		//se guardan los datos en un array
		$estadosCiviles	 	 	 	= ArrayHelper::map( $dataestadosCiviles, 'id', 'descripcion' );
		
		
		//se crea una instancia del modelo generos
		$generosTable 		 	= new Generos();
		//se traen los datos de generos
		$datageneros		 	= $generosTable->find()->all();
		//se guardan los datos en un array
		$generos	 	 	 	= ArrayHelper::map( $datageneros, 'id', 'descripcion' );
		
		//se crea una instancia del modelo estados
		$estadosTable 		 	= new Estados();
		//se traen los datos de estados
		$dataestados		 	= $estadosTable->find()->where( 'id=1' )->all();
		//se guardan los datos en un array
		$estados	 	 	 	= ArrayHelper::map( $dataestados, 'id', 'descripcion' );
		
		//se crea una instancia del modelo municipios
		$municipiosTable 		 	= new Municipios();
		//se traen los datos de municipios del valle
		$datamunicipios		 	= $municipiosTable->find()->where( 'id_departamentos = 24' )->all();
		//se guardan los datos en un array
		$municipios	 	 	 	= ArrayHelper::map( $datamunicipios, 'id', 'descripcion' );
		
		//se crea una instancia del modelo perfiles
		$perfilesTable 		 	= new Perfiles();
		//se traen los datos de los perfiles
		$dataPerfiles		 	= $perfilesTable->find()->where( 'estado = 1' )->all();
		//se guardan los datos en un array
		$perfiles	 	 	 	= ArrayHelper::map( $dataPerfiles, 'id', 'descripcion' );
		
		$model = new Personas();

		
		//el campo psw se encripta con sha256 y se agrega a post que se envia a guardar
		if (isset($_POST['Personas']['psw'])){
			$psw = hash('sha256', @$_POST['Personas']['psw']);
			$_POST['Personas']['psw'] = $psw;
		}
		
		@$idPerfiles = $_POST['Perfiles']['id'];
		
		if ($model->load($_POST) && $model->save()) {
			
		}
		
		if ($model->id != '') {
			//se crea una instancia del modelo perfiles
			// $perfilesxPersona 		 	= new PerfilesXPersonas();
			
			//variable con la conexion a la base y traer id sede
			$connection = Yii::$app->getDb();
			
			foreach($idPerfiles as $perfilesPersonas)
			{
				$arrayPerfiles[]="($model->id, $perfilesPersonas,1)";
		
			}
					
					/**
					* Se inserta en perfiles por personas
					*/
					
					$command = $connection->createCommand("INSERT INTO public.perfiles_x_personas(
															 id_personas, id_perfiles,estado)
															VALUES".implode(",",$arrayPerfiles)."");
															
					$result = $command->queryAll();
		
			
				return $this->redirect(['index']);
		}
		
		
        return $this->render('create', [
            'model' => $model,
			'identificaciones'=>$identificaciones,
			'estadosCiviles'=>$estadosCiviles,
			'generos'=>$generos,
			'estados'=>$estados,
			'municipios'=>$municipios,
			'perfiles'=>$perfiles,
			'perfilesTable'=>$perfilesTable,
			'arrayGrupoSanguineo'=>$this->grupoSanguineo(),
			'arrayRH'=>$this->rh(),
			
        ]);
    }

    /**
     * Updates an existing Personas model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        
		//se crea una instancia del modelo tipoIdentificaciones
		$identificacionesTable 		 	= new TiposIdentificaciones();
		//se traen los datos de identificaciones
		$dataIdentificaciones		 	= $identificacionesTable->find()->all();
		//se guardan los datos en un array
		$identificaciones	 	 	 	= ArrayHelper::map( $dataIdentificaciones, 'id', 'descripcion' );
		
		
		//se crea una instancia del modelo estados civiles
		$estadosCivilesTable 		 	= new EstadosCiviles();
		//se traen los datos de identificaciones
		$dataestadosCiviles		 	= $estadosCivilesTable->find()->all();
		//se guardan los datos en un array
		$estadosCiviles	 	 	 	= ArrayHelper::map( $dataestadosCiviles, 'id', 'descripcion' );
		
		//se crea una instancia del modelo generos
		$generosTable 		 	= new Generos();
		//se traen los datos de estadosCiviles
		$datageneros		 	= $generosTable->find()->all();
		//se guardan los datos en un array
		$generos	 	 	 	= ArrayHelper::map( $datageneros, 'id', 'descripcion' );
		
		//se crea una instancia del modelo estados
		$estadosTable 		 	= new Estados();
		//se traen los datos de estadosCiviles
		$dataestados		 	= $estadosTable->find()->all();
		//se guardan los datos en un array
		$estados	 	 	 	= ArrayHelper::map( $dataestados, 'id', 'descripcion' );
		
		//se crea una instancia del modelo municipios
		$municipiosTable 		 	= new Municipios();
		//se traen los datos de municipios
		$datamunicipios		 	= $municipiosTable->find()->where( 'id_departamentos = 24' )->all();
		//se guardan los datos en un array
		$municipios	 	 	 	= ArrayHelper::map( $datamunicipios, 'id', 'descripcion' );
		
	
		
		/**
		* Se trae el id perfiles por persona //-----------------------------------------
		*/
		//se crea una instancia del modelo perfiles
		$perfilesTable 		 	= new Perfiles();
		//se traen los datos de los perfiles
		$dataPerfiles		 	= $perfilesTable->find()->where( 'estado = 1' )->all();
		//se guardan los datos en un array
		$perfiles	 	 	 	= ArrayHelper::map( $dataPerfiles, 'id', 'descripcion' );
		
		/**
		* Concexion a la db, llenar selected de perfiles por persona
		*/
		//variable con la conexion a la base de datos  pe.id=10 es el perfil docente
		$connection = Yii::$app->getDb();
		$perfilesSelected =array();
		$command = $connection->createCommand("select p.id, p.descripcion
											  from perfiles as p, perfiles_x_personas as pp, personas as pe
											  where p.id = pp.id_perfiles
											  and pe.id = pp.id_personas
											  and pe.estado = 1
											  and p.estado = 1
											  and pp.estado = 1
											  and pe.id = $id");
		$result = $command->queryAll();
		//se formatea para que lo reconozca el select
		foreach($result as $key){
			$perfilesSelected[]=$key['id'];
		}
		
		$model = $this->findModel($id);
		
		// echo "<pre>";print_r($_POST);echo "</pre>";
		@$idPerfiles = $_POST['Perfiles']['id'];
		
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            
				if ($model->id != '') {
				//se crea una instancia del modelo perfiles
				// $perfilesxPersona 		 	= new PerfilesXPersonas();
				
				
				/*
				* Antes de insertar se debe verificar si es un perfil que se va a inactivar o a insertar
				* se buscan los perfiles que trae en la tabla pefiles por persona si no se encuentra
				* se inserta y si tiene tiene 4 almacenados y llegan tres el sobrante se inactiva
				*/
						/**
						* Se consultan todos los perfiles de la persona
						*/
						
							
							$command = $connection->createCommand("SELECT id, id_perfiles
																	FROM public.perfiles_x_personas
																	WHERE id_personas =".$model->id." 
																	AND estado = 1");
																	
							$result = $command->queryAll();
							
							
							$arrayPerfilesConsultar=array();
							if (count($result) > 0) {
								foreach($result as $perfilesPersonasConsultar)
								{
									//se guardan los resultados en $arrayPerfilesConsultar
									$arrayPerfilesConsultar[]=$perfilesPersonasConsultar['id_perfiles'];
								}
								
							}
						
						
						//si se encuentran resultados se compara los que tiene con los que trae para saber que inactivar
						if (count($arrayPerfilesConsultar) > 0){
							
							
							//array con datos del post $idPerfiles, array con datos de la consulta $arrayPerfilesConsultar
							$resultado = array_diff($idPerfiles,$arrayPerfilesConsultar); //los que trae del post que no esten en la consulta se insertan
							
							if(count($resultado) > 0){
								foreach($resultado as $perfilesPersonasNuevos)
								{
									$arrayPerfilesNuevos[]="($model->id, $perfilesPersonasNuevos,1)";
							
								}
								/**
								* Se inserta en perfiles por personas
								*/
								
								$command = $connection->createCommand("INSERT INTO public.perfiles_x_personas(
																		 id_personas, id_perfiles, estado)
																		VALUES".implode(",",$arrayPerfilesNuevos)."");
								$result = $command->queryAll();
							}
							
									
								//array con datos de la consulta $arrayPerfilesConsultar, array con datos del post $idPerfiles
								$resultado1 = array_diff($arrayPerfilesConsultar,$idPerfiles); //los que trae del la consulta que no esten en la $post se inactivan
								
								if(count($resultado1) > 0){
									foreach($resultado1 as $perfilesPersonasInactivar)
									{
										// $perfilesPersonasInactivar[]="($model->id, $perfilesPersonasInactivar,1)";
										
										/**
										* Se inactiva en perfiles por personas
										*/
										
										$command = $connection->createCommand("UPDATE public.perfiles_x_personas
																				 SET estado = 2 
																				 WHERE id_perfiles = $perfilesPersonasInactivar
																				 AND id_personas =".$model->id. "");
																				
										$result = $command->queryAll();
									}
								}
							
						} 
						else{		//si no se encuentran resultados se insertan					
							
							foreach($idPerfiles as $perfilesPersonas)
							{
								$arrayPerfiles[]="($model->id, $perfilesPersonas,1)";
						
							}
							/**
							* Se inserta en perfiles por personas
							*/
							
							$command = $connection->createCommand("INSERT INTO public.perfiles_x_personas(
																	 id_personas, id_perfiles, estado)
																	VALUES".implode(",",$arrayPerfiles)."");
							$result = $command->queryAll();
							
						}
							
					
			}
			return $this->redirect(['view', 'id' => $model->id]);
        }
		
		

        return $this->render('update', [
            'model' => $model,
			'identificaciones'=>$identificaciones,
			'estadosCiviles'=>$estadosCiviles,
			'generos'=>$generos,
			'estados'=>$estados,
			'municipios'=>$municipios,
			'perfiles'=>$perfiles,
			'perfilesTable'=>$perfilesTable,
			'perfilesSelected'=>$perfilesSelected,
			'arrayGrupoSanguineo'=>$this->grupoSanguineo(),
			'arrayRH'=>$this->rh(),
        ]);
    }

    /**
     * Deletes an existing Personas model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        // $this->findModel($id)->delete();

        // return $this->redirect(['index']);
		$model = Personas::findOne($id);
		$model->estado = 2;
		$model->update(false);

        return $this->redirect(['index']);
    }

    /**
     * Finds the Personas model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Personas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Personas::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
