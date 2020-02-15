<?php
/**********
Versión: 001
Fecha: 13-04-2018
Persona encargada: Viviana Rodas
Controller de grupos de apoyo
---------------------------------------
Modificaciones:
Fecha: 18-06-2018
Persona encargada: Edwin Molina Grisales
Cambios realizados: Se deja instición y sede según la SESSION
---------------------------------------
Fecha: 12-06-2018
Persona encargada: Viviana Rodas
En el create y update se agregan parametros para mostrar el mensaje de guardado existoso, antes de mostrar la vista view.
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
use app\models\GruposSoporte;
use app\models\GruposSoporteBuscar;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\models\TiposGruposSoporte;
use app\models\Estados;
use yii\helpers\ArrayHelper;
use app\models\Sedes;
use app\models\SedesJornadas;
use app\models\Personas;




/**
 * GruposSoporteController implements the CRUD actions for GruposSoporte model.
 */
class GruposSoporteController extends Controller
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
     * Lists all GruposSoporte models.
     * @return mixed
     */
    // public function actionIndex($idInstitucion = 0, $idSedes = 0)
    public function actionIndex()
    {
		$idInstitucion 	= $_SESSION['instituciones'][0];
		$idSedes 		= $_SESSION['sede'][0];
		
        // Si existe id sedes e institución se muestra la listas de todas las jornadas correspondientes
		if( $idInstitucion != 0 && $idSedes != 0 )
		{
			
			$searchModel = new GruposSoporteBuscar();
			$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
			$dataProvider ->query->andWhere('estado=1'); 
			$dataProvider ->query->andWhere('id_sede='.$idSedes); 

			return $this->render('index', [
				'searchModel' => $searchModel,
				'dataProvider' => $dataProvider,
				'idSedes' => $idSedes,
				'idInstitucion' => $idInstitucion,
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
     * Displays a single GruposSoporte model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        //para traer datos del modelo que ya se tiene
	    $model = $this->findModel($id);
		$idSedes = $model->id_sede;
		
		//se crea una instancia del modelo sedes
		$sedesTable 		 	= new Sedes();
		//se traen los datos de sedes
		$datasedes	 	= $sedesTable->find()->where( 'id='.$idSedes )->all();
		//se guardan los datos en un array
		$sedes	 	 	 	= ArrayHelper::map( $datasedes, 'id', 'descripcion' );
		//se trae el id de la institucion
		$idInstitucion = ArrayHelper::map($datasedes,'id','id_instituciones');
		$idInstitucion = $idInstitucion[$idSedes];
		
		return $this->render('view', [
            'model' => $this->findModel($id),
			'idInstitucion'=>$idInstitucion,
			'idSedes'=>$idSedes,
			'sedes'=>$sedes,
        ]);
    }

    /**
     * Creates a new GruposSoporte model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($idInstitucion, $idSedes)
    {
		$model = new GruposSoporte();
		
		//se crea una instancia del modelo tipos
		$gruposTable 		 	= new TiposGruposSoporte();
		//se traen los datos de identificaciones
		$dataGrupos		 	= $gruposTable->find()->all();
		//se guardan los datos en un array
		$tipoGruposSoporte	 	 	 	= ArrayHelper::map( $dataGrupos, 'id', 'descripcion' );
		
		//se crea una instancia del modelo sedes
		$sedesTable 		 	= new Sedes();
		//se traen los datos de sedes
		$datasedes	 	= $sedesTable->find()->where( 'id='.$idSedes )->all();
		//se guardan los datos en un array
		$sedes	 	 	 	= ArrayHelper::map( $datasedes, 'id', 'descripcion' );
		
		
		//variable con la conexion a la base de datos  pe.id=10 es el perfil docente
		$connection = Yii::$app->getDb();
		/**
		* Llenar select de sedes jornadas
		*/
		$command = $connection->createCommand("SELECT sj.id, j.descripcion
												FROM jornadas as j, sedes_jornadas as sj
												WHERE sj.id_sedes = $idSedes
												AND j.id = sj.id_jornadas");
		$result = $command->queryAll();
		//se formatea para que lo reconozca el select
		foreach($result as $key){
			$sedesJornadas[$key['id']]=$key['descripcion'];
		}
		
		/**
		* Concexion a la db, llenar select de docentes
		*/
		
		//se pasa a otra accion
		$command = $connection->createCommand("select d.id_perfiles_x_personas as id, concat(p.nombres,' ',p.apellidos) as nombres
												from personas as p, perfiles_x_personas as pp, docentes as d, perfiles as pe
												where p.id= pp.id_personas
												and p.estado=1
												and pp.id_perfiles=pe.id
												and pe.id=10
												and pe.estado=1
												and pp.id= d.id_perfiles_x_personas");
		$result = $command->queryAll();
		
		$docentes = [];
		//se formatea para que lo reconozca el select
		foreach($result as $key){
			$docentes[$key['id']]=$key['nombres'];
		}
		
		
		//se crea una instancia del modelo estados
		$estadosTable 		 	= new Estados();
		//se traen los datos de estados
		$dataestados		 	= $estadosTable->find()->where( 'id=1' )->all();
		//se guardan los datos en un array
		$estados	 	 	 	= ArrayHelper::map( $dataestados, 'id', 'descripcion' );
		
		
	   

        if ($model->load(Yii::$app->request->post()) && $model->save()) 
		{
			// print_r(Yii::$app->request->post());die();
			$tiposGruposSoporte = TiposGruposSoporte::findOne($model->id_tipo_grupos);
		    $tiposGruposSoporte = $tiposGruposSoporte ? $tiposGruposSoporte->descripcion:'';
		
            return $this->redirect(['view', 'id' => $model->id,'save'=>true,'descripcion'=>$model->descripcion,'tipoGrupo'=>$tiposGruposSoporte]);
        }

        return $this->render('create', [
            'model' => $model,
			'tipoGruposSoporte' => $tipoGruposSoporte,
			'estados' => $estados,
			'sedes' => $sedes,
			'sedesJornadas' => $sedesJornadas,
			'docentes'=>$docentes,
			'idInstitucion'=>$idInstitucion,
			'idSedes'=>$idSedes,
        ]);
    }

    /**
     * Updates an existing GruposSoporte model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
       //para traer datos del modelo que ya se tiene
	    $model = $this->findModel($id);
		$idSedes = $model->id_sede;
		
		
		//se crea una instancia del modelo tipos
		$gruposTable 		 	= new TiposGruposSoporte();
		//se traen los datos de identificaciones
		$dataGrupos		 	= $gruposTable->find()->all();
		//se guardan los datos en un array
		$tipoGruposSoporte	 	 	 	= ArrayHelper::map( $dataGrupos, 'id', 'descripcion' );
		
		//se crea una instancia del modelo sedes
		$sedesTable 		 	= new Sedes();
		//se traen los datos de sedes
		$datasedes	 	= $sedesTable->find()->where( 'id='.$idSedes )->all();
		//se guardan los datos en un array
		$sedes	 	 	 	= ArrayHelper::map( $datasedes, 'id', 'descripcion' );
		//se trae el id de la institucion
		$idInstitucion = ArrayHelper::map($datasedes,'id','id_instituciones');
		$idInstitucion = $idInstitucion[$idSedes];
		
		
		//variable con la conexion a la base de datos  pe.id=10 es el perfil docente
		$connection = Yii::$app->getDb();
		/**
		* Llenar select de sedes jornadas
		*/
		$command = $connection->createCommand("SELECT sj.id, j.descripcion
												FROM jornadas as j, sedes_jornadas as sj
												WHERE sj.id_sedes = $idSedes
												AND j.id = sj.id_jornadas");
		$result = $command->queryAll();
		//se formatea para que lo reconozca el select
		foreach($result as $key){
			$sedesJornadas[$key['id']]=$key['descripcion'];
		}
		
		/**
		* Concexion a la db, llenar select de docentes
		*/
		
		
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
		
		
		//se crea una instancia del modelo estados
		$estadosTable 		 	= new Estados();
		//se traen los datos de estados
		$dataestados		 	= $estadosTable->find()->all();
		//se guardan los datos en un array
		$estados	 	 	 	= ArrayHelper::map( $dataestados, 'id', 'descripcion' );
		
		
		$tiposGruposSoporte = TiposGruposSoporte::findOne($model->id_tipo_grupos);
		$tiposGruposSoporte = $tiposGruposSoporte ? $tiposGruposSoporte->descripcion:'';
		

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			// print_r(Yii::$app->request->post());die();
				$tiposGruposSoporte = TiposGruposSoporte::findOne($model->id_tipo_grupos);
				$tiposGruposSoporte = $tiposGruposSoporte ? $tiposGruposSoporte->descripcion:'';
				
            return $this->redirect(['view', 'id' => $model->id,'save'=>true,'descripcion'=>$model->descripcion,'tipoGrupo'=>$tiposGruposSoporte]);
        }

        return $this->render('update', [
            'model' => $model,
			'tipoGruposSoporte' => $tipoGruposSoporte,
			'estados' => $estados,
			'sedes' => $sedes,
			'sedesJornadas' => $sedesJornadas,
			'docentes'=>$docentes,
			'idInstitucion'=>$idInstitucion,
			'idSedes'=>$idSedes,
        ]);
    }

    /**
     * Deletes an existing GruposSoporte model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = GruposSoporte::findOne($id);
		$model->estado = 2;
		$model->update(false);

        return $this->redirect(['index']);
    }

    /**
     * Finds the GruposSoporte model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return GruposSoporte the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = GruposSoporte::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
	public function actionListarInstituciones( $idInstitucion = 0, $idSedes = 0 )
	{
		return $this->render('listarInstituciones',[

		'idSedes' =>$idSedes,
		'idInstitucion' =>$idInstitucion,
		] );

	}
	
	/*
	* Se busca un docente 
	*/
	public function actionDocentes($filtro){
		$personasData= Personas::find()
							->select( "personas.id, ( nombres || apellidos ) as nombres" )
							->innerJoin( "perfiles_x_personas pp", "pp.id_personas=personas.id" )
							->andWhere('personas.estado=1')
							->andWhere( "pp.estado=1" )
							->andWhere( "pp.id_perfiles=10" )
							->andWhere(
							['or',
								['ILIKE', 'personas.nombres', '%'. $filtro . '%', false],
								['ILIKE', 'personas.apellidos', '%'. $filtro . '%', false],
								['ILIKE', 'personas.identificacion', '%'. $filtro . '%', false]
							])
							->orderby('personas.id')
							->all();
		$personas		= ArrayHelper::map( $personasData, 'id', 'nombres' );
			
		
		return json_encode($personas);
	}
	
	
}
