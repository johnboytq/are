<?php
/**********
Versión: 001
Fecha: 06-03-2018
---------------------------------------
Modificaciones:
Fecha: 18-06-2018
Persona encargada: Edwin Molina Grisales
Cambios realizados: Se deja instición y sede según la SESSION
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
use app\models\ParticipacionProyectosMaestro;
use app\models\ParticipacionProyectosMaestroBuscar;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\models\Estados;
use app\models\NombresProyectosParticipacion;
use app\models\Instituciones;
use app\models\Sedes;
use app\models\Personas;
use app\models\Perfiles;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;


/**
 * ParticipacionProyectosMaestroController implements the CRUD actions for ParticipacionProyectosMaestro model.
 */
class ParticipacionProyectosMaestroController extends Controller
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
	
	public function actionGetPerfil( $persona ){
		
		$perfilesTable 		= new Perfiles();
		$dataPerfiles	 	= $perfilesTable->find()
								->innerJoin( 'perfiles_x_personas pp', 'pp.id_perfiles=perfiles.id' )
								->where( 'pp.id_personas='.$persona )
								->one();
		
		return Json::encode([ 
								'codigo' 		=> $dataPerfiles->id, 
								'descripcion' 	=> $dataPerfiles->descripcion,
							]);
	}

    /**
     * Lists all ParticipacionProyectosMaestro models.
     * @return mixed
     */
    // public function actionIndex( $idInstitucion = 0, $idSedes = 0 )
    public function actionIndex()
    {
		$idInstitucion 	= $_SESSION['instituciones'][0];
		$idSedes 		= $_SESSION['sede'][0];
		
		if( $idInstitucion != 0 && $idSedes != 0 )
		{
			
			$searchModel = new ParticipacionProyectosMaestroBuscar();
			$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
			$dataProvider->query->andWhere( 'estado=1' );

			return $this->render('index', [
				'searchModel' 	=> $searchModel,
				'dataProvider' 	=> $dataProvider,
				'idSedes' 		=> $idSedes,
				'idInstitucion'	=> $idInstitucion,
			]);
		}
		else
		{
			return $this->render('listarInstituciones', [
				'idInstitucion' => $idInstitucion,
				'idSedes' => $idSedes,
			]);
		}
    }

    /**
     * Displays a single ParticipacionProyectosMaestro model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView( $id, $idInstitucion = 0, $idSedes = 0 )
    {
        return $this->render('view', [
            'model' 		=> $this->findModel($id),
			'idSedes' 		=> $idSedes,
			'idInstitucion'	=> $idInstitucion,
        ]);
    }

    /**
     * Creates a new ParticipacionProyectosMaestro model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate( $idSedes = 0 )
    {
        $model = new ParticipacionProyectosMaestro();
		
		
		$sedesTable 		= new Sedes();
		$dataSedes	 		= $sedesTable->find()->where( 'id='.$idSedes )->andWhere( 'estado=1' )->one();
		$sedes				= ArrayHelper::map( $dataSedes, 'id', 'descripcion' );
		// var_dump( $dataSedes->id_instituciones );
		// exit();
		
		$institucionesTable	= new Instituciones();
		$dataInstituciones	= $institucionesTable->find()->where( 'id='.$dataSedes->id_instituciones )->andWhere( 'estado=1' )->all();
		$instituciones		= ArrayHelper::map( $dataInstituciones, 'id', 'descripcion' );
		
		$estadosTable 		= new Estados();
		$dataEstados 		= $estadosTable->find()->where( 'id=1' )->all();
		$estados			= ArrayHelper::map( $dataEstados, 'id', 'descripcion' );
		
		$personasTable 		= new Personas();
		//se pasa a otra accion
		// $dataPersonas 		= $personasTable->find()
								// ->select( ( "personas.id, ( personas.nombres || ' ' || personas.apellidos ) nombres" ) )
								// ->innerJoin( 'perfiles_x_personas pp', 'pp.id_personas=personas.id'  )
								// ->innerJoin( 'perfiles_x_personas_institucion ppi', 'ppi.id_institucion='.$dataSedes->id_instituciones )
								// ->where( 'pp.estado=1' )
								// ->andWhere( 'personas.estado=1' )
								// ->andWhere( 'ppi.estado=1' )
								// ->all();
		// $personas			= ArrayHelper::map( $dataPersonas, 'id', 'nombres' );
		$personas			=[];;
		
		$nombresProyectos = new NombresProyectosParticipacion();
		$nombresProyectos = $nombresProyectos->find()->orderby("id")->all();
		$nombresProyectos = ArrayHelper::map($nombresProyectos,'id','descripcion');
		

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect([
										'view', 
										'id' 			=> $model->id,
										'idSedes' 		=> $idSedes,
										'idInstitucion'	=> $dataSedes->id_instituciones,
									]);
        }

        return $this->render('create', [
            'model' 			=> $model,
            'idSedes' 			=> $idSedes,
            'idInstitucion'		=> $dataSedes->id_instituciones,
			'instituciones'		=> $instituciones,
			'sedes' 			=> $sedes,
			'estados' 			=> $estados,
			'nombresProyectos' 	=> $nombresProyectos,
			'personas' 			=> $personas,
			'perfiles' 			=> [],
        ]);
    }

    /**
     * Updates an existing ParticipacionProyectosMaestro model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate( $id, $idInstitucion = 0, $idSedes = 0 )
    {
        $model = $this->findModel($id);
		
		$sedesTable 		= new Sedes();
		$dataSedes	 		= $sedesTable->find()->where( 'id='.$idSedes )->andWhere( 'estado=1' )->one();
		$sedes				= ArrayHelper::map( $dataSedes, 'id', 'descripcion' );
		// var_dump( $dataSedes->id_instituciones );
		// exit();
		$institucionesTable	= new Instituciones();
		$dataInstituciones	= $institucionesTable->find()->where( 'id='.$idInstitucion )->andWhere( 'estado=1' )->all();
		$instituciones		= ArrayHelper::map( $dataInstituciones, 'id', 'descripcion' );
		
		$estadosTable 		= new Estados();
		$dataEstados 		= $estadosTable->find()->where( 'id=1' )->all();
		$estados			= ArrayHelper::map( $dataEstados, 'id', 'descripcion' );
		
		$personasTable 		= new Personas();
		$dataPersonas 		= $personasTable->find()
								->select( ( "personas.id, ( personas.nombres || ' ' || personas.apellidos ) nombres" ) )
								->innerJoin( 'perfiles_x_personas pp', 'pp.id_personas=personas.id'  )
								->innerJoin( 'perfiles_x_personas_institucion ppi', 'ppi.id_institucion='.$idInstitucion )
								->where( 'pp.estado=1' )
								->andWhere( 'personas.estado=1' )
								->andWhere( 'ppi.estado=1' )
								->all();
		$personas			= ArrayHelper::map( $dataPersonas, 'id', 'nombres' );
		
		$perfilesTable 		= new Perfiles();
		$dataPerfiles	 	= $perfilesTable->find()
								->innerJoin( 'perfiles_x_personas pp', 'pp.id_perfiles=perfiles.id' )
								->where( 'pp.id_personas='.$model->participante )
								->all();
		$perfiles 	  		= ArrayHelper::map( $dataPerfiles, 'id', 'descripcion' );
		
		$nombresProyectos = new NombresProyectosParticipacion();
		$nombresProyectos = $nombresProyectos->find()->orderby("id")->all();
		$nombresProyectos = ArrayHelper::map($nombresProyectos,'id','descripcion');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect([
										'view', 
										'id' 			=> $model->id,
										'idSedes' 		=> $idSedes,
										'idInstitucion'	=> $dataSedes->id_instituciones,]);
        }

        return $this->render('update', [
            'model' 			=> $model,
			'idSedes' 			=> $idSedes,
            'idInstitucion'		=> $idInstitucion,
			'instituciones'		=> $instituciones,
			'sedes' 			=> $sedes,
			'estados' 			=> $estados,
			'nombresProyectos' 	=> $nombresProyectos,
			'personas' 			=> $personas,
			'perfiles' 			=> $perfiles,
        ]);
    }

    /**
     * Deletes an existing ParticipacionProyectosMaestro model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete( $id, $idInstitucion = 0, $idSedes = 0 )
    {
        // $this->findModel($id)->delete();
        $model = $this->findModel($id);
        $model->estado = 2;
		$model->update(false);

        return $this->redirect([
				'index',
				'idSedes' 		=> $idSedes,
				'idInstitucion'	=> $idInstitucion,
		]);
    }

    /**
     * Finds the ParticipacionProyectosMaestro model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return ParticipacionProyectosMaestro the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ParticipacionProyectosMaestro::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
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
