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
use app\models\EstudiantesOperativo;
use app\models\EstudiantesOperativoBuscar;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


use app\models\Instituciones;
use app\models\Sedes;
use app\models\Personas;
use app\models\Estados;
use app\models\Fases;
use app\models\Sesiones;
use app\models\EstudiantesOperativoSesion;
use app\models\Escalafones;
use app\models\Docentes;
use app\models\DistribucionesAcademicas;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

use yii\db\Query;

use yii\data\ActiveDataProvider;

/**
 * EstudiantesOperativoController implements the CRUD actions for EstudiantesOperativo model.
 */
class EstudiantesOperativoController extends Controller
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
	
	function actionViewFases(){
		
		$institucion 	= Yii::$app->request->post()['institucion'];
		$sede 			= Yii::$app->request->post()['sede'];
		$docente		= Yii::$app->request->post()['docente'];
		// $asignatura		= Yii::$app->request->post()['asignatura'];
		$nivel			= Yii::$app->request->post()['nivel'];
		
		$idPE = EstudiantesOperativo::findOne([
					'id_institucion' 				=> $institucion,
					'id_sede' 		 				=> $sede,
					'id_profesional'				=> $docente,
					'id_nivel'	 					=> $nivel,
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

    /**
     * Lists all EstudiantesOperativo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EstudiantesOperativoBuscar();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single EstudiantesOperativo model.
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
	
	public function actionGuardar()
	{
		// echo "<pre>"; var_dump( $_POST );  echo "</pre>"; exit();
		$data = [
					'error' => 0,
					'msg' => '',
					'html' => '',
				];
		
		$estudiantesOperativo = Yii::$app->request->post()['EstudiantesOperativo'];
		
		$model = EstudiantesOperativo::findOne([
						'id_institucion' 				=> $estudiantesOperativo[ 'id_institucion' ],
						'id_sede' 						=> $estudiantesOperativo[ 'id_sede' ],
						'id_profesional'				=> $estudiantesOperativo[ 'id_profesional' ],
						'id_nivel' 						=> $estudiantesOperativo[ 'id_nivel' ],
						'estado' 						=> '1',
					]);
					
		if( !$model ){
			$model = new EstudiantesOperativo();
		}
		
		if( $model->load(Yii::$app->request->post()) )
		{
			if( $model->save(false) ){
				
				$poblaciones = Yii::$app->request->post()['EstudiantesOperativoSesion'];
				
				foreach( $poblaciones as $key => $poblacion ){
					
					$modelp	=	EstudiantesOperativoSesion::findOne([
									'id_estudiantes_operativo' 	=> $model->id,
									'id_sesion' 				=> $poblacion[ 'id_sesion' ],
								]);
					
					if( !$modelp ){
						$modelp	=	new EstudiantesOperativoSesion();
					}
					
					$modelp->id_estudiantes_operativo	= $model->id;
					$modelp->id_sesion					= $poblacion[ 'id_sesion' ];
					$modelp->asistentes					= $poblacion[ 'asistentes' ];
					$modelp->dificultades_operativas	= $poblacion[ 'dificultades_operativas' ];
					$modelp->estado						= 1;
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

    /**
     * Creates a new EstudiantesOperativo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
		$sede 			= $_SESSION['sede'][0];
		$institucion	= $_SESSION['instituciones'][0];
		
        $model = new EstudiantesOperativo();
		
		$dataInstituciones 	= Instituciones::find()
								->where( 'estado=1' )
								->all();
		
		$instituciones		= ArrayHelper::map( $dataInstituciones, 'id', 'descripcion' );

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'instituciones' => $instituciones,
            'sedes' 		=> [],
            'docentes'		=> [],
            'niveles'		=> [],
            'estados'		=> 1,
        ]);
    }

    /**
     * Updates an existing EstudiantesOperativo model.
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
     * Deletes an existing EstudiantesOperativo model.
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
     * Finds the EstudiantesOperativo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return EstudiantesOperativo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = EstudiantesOperativo::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
