<?php

namespace app\controllers;

if(@$_SESSION['sesion']=="si")
{ 
	// echo $_SESSION['nombre'];
} 
//si no tiene sesion se redirecciona al login
else
{
	echo "<script> window.location=\"index.php?r=site%2Flogin\";</script>";
	die;
}

use Yii;
use app\models\InstrumentoPoblacionDocentes;
use app\models\InstrumentoPoblacionDocentesBuscar;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\models\Instituciones;
use app\models\Sedes;
use app\models\Personas;
use app\models\Estados;
use app\models\Fases;
use app\models\Sesiones;
use app\models\PoblacionDocentesSesion;
use app\models\Escalafones;
use app\models\Docentes;
use app\models\DistribucionesAcademicas;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

use yii\db\Query;

use yii\data\ActiveDataProvider;

/**
 * InstrumentoPoblacionDocentesController implements the CRUD actions for InstrumentoPoblacionDocentes model.
 */
class InstrumentoPoblacionDocentesController extends Controller
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
	
	public function actionDataPoblacion(){
		
		$data = [ 'profesion' => '', 'ultimo_nivel' => '' ];
		
		$institucion 	= Yii::$app->request->get()['institucion'];
		$sede 			= Yii::$app->request->get()['sede'];
		$docente		= Yii::$app->request->get()['docente'];
		$asignatura		= Yii::$app->request->get()['asignatura'];
		$nivel			= Yii::$app->request->get()['nivel'];
		
		$model = InstrumentoPoblacionDocentes::findOne([
						'id_institucion' 				=> $institucion,
						'id_sede' 						=> $sede,
						'id_persona' 					=> $docente,
						'id_asignaturas_niveles_sedes' 	=> $asignatura,
						'id_niveles' 					=> $nivel,
						'estado' 						=> '1',
					]);
					
		if( $model ){
			$data = [ 	
						'profesion' 	=> $model->profesion, 
						'ultimo_nivel' 	=> $model->ultimo_nivel ,
					];
		}
					
		return Json::encode( $data );
	}
	
	/**
     * Creates a new instrumentoPoblacionDocentes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionGuardar()
	{
		// echo "<pre>"; var_dump( $_POST );  echo "</pre>"; exit();
		$data = [
					'error' => 0,
					'msg' => '',
					'html' => '',
				];
		
		$instrumentoPoblacionDocentes = Yii::$app->request->post()['InstrumentoPoblacionDocentes'];
		
		$model = InstrumentoPoblacionDocentes::findOne([
						'id_institucion' 				=> $instrumentoPoblacionDocentes[ 'id_institucion' ],
						'id_sede' 						=> $instrumentoPoblacionDocentes[ 'id_sede' ],
						'id_persona' 					=> $instrumentoPoblacionDocentes[ 'id_persona' ],
						'id_asignaturas_niveles_sedes' 	=> $instrumentoPoblacionDocentes[ 'id_asignaturas_niveles_sedes' ],
						'id_niveles' 					=> $instrumentoPoblacionDocentes[ 'id_niveles' ],
						'estado' 						=> '1',
					]);
					
		if( !$model ){
			$model = new InstrumentoPoblacionDocentes();
		}
		
		if( $model->load(Yii::$app->request->post()) )
		{
			$docente = Docentes::find()
							->innerJoin( 'perfiles_x_personas pp', 'pp.id=docentes.id_perfiles_x_personas' )
							->innerJoin( 'personas p', 'p.id=pp.id_personas' )
							->where( 'p.estado=1' )
							->andWhere( 'pp.estado=1' )
							->andWhere( 'docentes.estado=1' )
							->one();
							
			$model->id_escalafon = $docente->id_escalafones;
			
			if( $model->save(false) ){
				
				$poblaciones = Yii::$app->request->post()['PoblacionDocentesSesion'];
				
				foreach( $poblaciones as $key => $poblacion ){
					$modelp	=	PoblacionDocentesSesion::findOne([
									'id_poblacion_docentes' 	=> $model->id,
									'id_sesion' 				=> $poblacion[ 'id_sesion' ],
								]);
					
					if( !$modelp ){
						$modelp	=	new PoblacionDocentesSesion();
					}
					
					$modelp->id_poblacion_docentes	= $model->id;
					$modelp->id_sesion					= $poblacion[ 'id_sesion' ];
					$modelp->valor						= $poblacion[ 'valor' ];
					$modelp->save( false );
				}
			}
			else{
				$data['error'] 	= 2;
				$data['msg'] 	= 'No guarda los datos del docente';
			}
        }
		else{
			$data['error'] 	= 1;
			$data['msg'] 	= 'No carga el modelo instrumentoPoblacionDocentes';
		}
		
		// echo json_encode( $data );
		return Json::encode( $data );
	}
	
	function actionNivelesPorSedesPorDocente(){
		
		$sede 		 = Yii::$app->request->get('sede');
		$institucion = Yii::$app->request->get('institucion');
		$docente 	 = Yii::$app->request->get('docente');
		
		$val 			= [];
		$niveles 		= [];
		$asignaturas 	= [];
		
		$query = new Query;
		
		$data = $query
					->select( 'da.id, a.id as ida, a.descripcion as asignatura, n.id as idn, n.descripcion as nivel' )
					->from( 'distribuciones_academicas da' )
					->innerJoin( 'asignaturas_x_niveles_sedes ans', 'ans.id=da.id_asignaturas_x_niveles_sedes' )
					->innerJoin( 'asignaturas a' , 'a.id=ans.id_asignaturas' )
					->innerJoin( 'perfiles_x_personas pp' , 'pp.id=da.id_perfiles_x_personas_docentes' )
					->innerJoin( 'personas p' , 'p.id=pp.id_personas' )
					->innerJoin( 'sedes_niveles sn' , 'sn.id=ans.id_sedes_niveles' )
					->innerJoin( 'niveles n' , 'n.id=sn.id_niveles' )
					->where( 'a.id_sedes='.$sede )
					->andWhere( 'p.id='.$docente )
					->andWhere( 'sn.id_sedes='.$sede )
					->andWhere( 'da.estado=1' )
					->andWhere( 'a.estado=1' )
					->andWhere( 'pp.estado=1' )
					->andWhere( 'p.estado=1' )
					->andWhere( 'n.estado=1' )
					->all();
		
		// echo $query->createCommand()->sql;
		
		foreach( $data as $key => $value ){
			$niveles[ $value['idn'] ] 		= $value['nivel'];
		}
		
		// $val[
			// 'asignaturas' 	=> $asignaturas,
			// 'niveles' 		=> $niveles,
		// ]
		
		return Json::encode( $val = [
								'niveles' 		=> $niveles,
							]);
	}
	
	function actionAsignaturasPorNivelesSedesPorDocente(){
		
		$sede 		 = Yii::$app->request->get('sede');
		$institucion = Yii::$app->request->get('institucion');
		$docente 	 = Yii::$app->request->get('docente');
		$nivel 	 	 = Yii::$app->request->get('nivel');
		
		$val 			= [];
		$niveles 		= [];
		$asignaturas 	= [];
		
		$query = new Query;
		
		$data = $query
					->select( 'da.id, da.id_asignaturas_x_niveles_sedes as ida, a.descripcion as asignatura, n.id as idn, n.descripcion as nivel' )
					->from( 'distribuciones_academicas da' )
					->innerJoin( 'asignaturas_x_niveles_sedes ans', 'ans.id=da.id_asignaturas_x_niveles_sedes' )
					->innerJoin( 'asignaturas a' , 'a.id=ans.id_asignaturas' )
					->innerJoin( 'perfiles_x_personas pp' , 'pp.id=da.id_perfiles_x_personas_docentes' )
					->innerJoin( 'personas p' , 'p.id=pp.id_personas' )
					->innerJoin( 'sedes_niveles sn' , 'sn.id=ans.id_sedes_niveles' )
					->innerJoin( 'niveles n' , 'n.id=sn.id_niveles' )
					->where( 'a.id_sedes='.$sede )
					->andWhere( 'p.id='.$docente )
					->andWhere( 'sn.id_sedes='.$sede )
					->andWhere( 'n.id='.$nivel )
					->andWhere( 'da.estado=1' )
					->andWhere( 'a.estado=1' )
					->andWhere( 'pp.estado=1' )
					->andWhere( 'p.estado=1' )
					->andWhere( 'n.estado=1' )
					->all();
		
		// echo $query->createCommand()->sql;
		
		foreach( $data as $key => $value ){
			$asignaturas[ $value['ida'] ] 	= $value['asignatura'];
		}
		
		// $val[
			// 'asignaturas' 	=> $asignaturas,
			// 'niveles' 		=> $niveles,
		// ]
		
		return Json::encode( $val = [
								'asignaturas' 	=> $asignaturas,
							]);
	}
	
	function actionSede(){
		
		$sede 		 = Yii::$app->request->post('sede');
		$institucion = Yii::$app->request->post('institucion');
		
		$sede 		 = Sedes::findOne( $sede );
		$institucion = Instituciones::findOne( $institucion );
		
		return $this->renderPartial( 'sede', [
			'sede' 		=> $sede,
			'institucion' 	=> $institucion,
        ]);
	}
	
	function actionDocentes(){
		
		$docente= Yii::$app->request->post('docente');
		$sede 	= Yii::$app->request->post('sede');
		$nivel 	= Yii::$app->request->post('nivel');
		
		$persona = Personas::findOne( $docente );
		
		return $this->renderPartial( 'docentes', [
			'persona' 	=> $persona,
			'sede' 		=> $sede,
			'nivel' 	=> $nivel,
        ]);
	}
	
	function actionDocentesPorInstitucion(){
		
		$institucion = Yii::$app->request->get('institucion');
					
		$data = Personas::find()
					// ->select( "( nombres || ' ' || apellidos ) as nombres, personas.id" )
					->innerJoin( 'perfiles_x_personas pp', 'pp.id_personas=personas.id' )
					->innerJoin( 'docentes d', 'd.id_perfiles_x_personas=pp.id' )
					->innerJoin( 'perfiles_x_personas_institucion ppi', 'ppi.id_perfiles_x_persona=pp.id' )
					->where( 'personas.estado=1' )
					->andWhere( 'id_institucion='.$institucion )
					->all();
		
		return Json::encode( $data );
	}
	
	function actionViewFases(){
		
		$institucion 	= Yii::$app->request->post()['institucion'];
		$sede 			= Yii::$app->request->post()['sede'];
		$docente		= Yii::$app->request->post()['docente'];
		$asignatura		= Yii::$app->request->post()['asignatura'];
		$nivel			= Yii::$app->request->post()['nivel'];
		
		$idPE = InstrumentoPoblacionDocentes::findOne([
					'id_institucion' 				=> $institucion,
					'id_sede' 		 				=> $sede,
					'id_persona' 					=> $docente,
					'id_asignaturas_niveles_sedes'	=> $asignatura,
					'id_niveles' 					=> $nivel,
					'estado' 						=> 1,
				]);
				
		$fases	= Fases::find()
					->where('estado=1')
					->orderby( 'descripcion' )
					->all();
		
		return $this->renderPartial('fases', [
			'idPE' 	=> $idPE,
			'fases' => $fases,
        ]);
		
	}

    /**
     * Lists all InstrumentoPoblacionDocentes models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new InstrumentoPoblacionDocentesBuscar();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single InstrumentoPoblacionDocentes model.
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
     * Creates a new InstrumentoPoblacionDocentes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
		$sede 			= $_SESSION['sede'][0];
		$institucion	= $_SESSION['instituciones'][0];
		
        $model = new InstrumentoPoblacionDocentes();
		
		$dataInstituciones 	= Instituciones::find()
								->where( 'estado=1' )
								->all();
		
		$instituciones		= ArrayHelper::map( $dataInstituciones, 'id', 'descripcion' );
		
		$dataSedes 			= Sedes::find()
								->where( 'estado=1' )
								->all();
		
		$sedes		= ArrayHelper::map( $dataSedes, 'id', 'descripcion' );
		
		$dataPersonas 		= Personas::find()
								->select( "( nombres || ' ' || apellidos ) as nombres, personas.id" )
								->innerJoin( 'perfiles_x_personas pp', 'pp.id_personas=personas.id' )
								->innerJoin( 'docentes d', 'd.id_perfiles_x_personas=pp.id' )
								->innerJoin( 'perfiles_x_personas_institucion ppi', 'ppi.id_perfiles_x_persona=pp.id' )
								->where( 'personas.estado=1' )
								->andWhere( 'id_institucion='.$institucion )
								->all();
		
		$estudiantes		= ArrayHelper::map( $dataPersonas, 'id', 'nombres' );

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' 		=> $model,
            'instituciones' => $instituciones,
            'sedes' 		=> [],
            'estudiantes'	=> [],
            'estados'		=> 1,
        ]);
    }

    /**
     * Updates an existing InstrumentoPoblacionDocentes model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing InstrumentoPoblacionDocentes model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the InstrumentoPoblacionDocentes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return InstrumentoPoblacionDocentes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = InstrumentoPoblacionDocentes::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
