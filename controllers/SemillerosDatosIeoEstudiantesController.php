<?php

/**********
Versión: 001
Fecha: 2018-08-16
Desarrollador: Edwin Molina Grisales
Descripción: Controlador para el formulario CONFORMACION SEMILLEROS TIC ESTUDIANTES
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
	echo "<script> window.location=\"index.php?r=site%2Flogin\";</script>";
	die;
}

use Yii;
use app\models\SemillerosDatosIeoEstudiantes;
use app\models\SemillerosDatosIeoEstudiantesBuscar;
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

/**
 * SemillerosDatosIeoEstudiantesController implements the CRUD actions for SemillerosDatosIeoEstudiantes model.
 */
class SemillerosDatosIeoEstudiantesController extends Controller
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
		
		// $institucion 	= Yii::$app->request->post()['institucion'];
		// $sede 			= Yii::$app->request->post()['sede'];
		// $docente		= Yii::$app->request->post()['docente'];
		// $asignatura		= Yii::$app->request->post()['asignatura'];
		// $nivel			= Yii::$app->request->post()['nivel'];
		
		// $idPE = InstrumentoPoblacionDocentes::findOne([
					// 'id_institucion' 				=> $institucion,
					// 'id_sede' 		 				=> $sede,
					// 'id_persona' 					=> $docente,
					// 'id_asignaturas_niveles_sedes'	=> $asignatura,
					// 'id_niveles' 					=> $nivel,
					// 'estado' 						=> 1,
				// ]);
				
		$fases	= Fases::find()
					->where('estado=1')
					->orderby( 'descripcion' )
					->all();
		
		return $this->renderPartial('fases', [
			'idPE' 	=> null,
			'fases' => $fases,
        ]);
		
	}

    /**
     * Lists all SemillerosDatosIeoEstudiantes models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SemillerosDatosIeoEstudiantesBuscar();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SemillerosDatosIeoEstudiantes model.
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
     * Creates a new SemillerosDatosIeoEstudiantes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
		$id_sede 		= $_SESSION['sede'][0];
		$id_institucion	= $_SESSION['instituciones'][0];
		
        $model = new SemillerosDatosIeoEstudiantes();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
		
		$institucion = Instituciones::findOne($id_institucion);
		$sede 		 = Sedes::findOne($id_sede);
		
		// $dataPersonas 		= Personas::find()
								// ->select( "( nombres || ' ' || apellidos ) as nombres, personas.id" )
								// ->innerJoin( 'perfiles_x_personas pp', 'pp.id_personas=personas.id' )
								// ->innerJoin( 'docentes d', 'd.id_perfiles_x_personas=pp.id' )
								// ->innerJoin( 'perfiles_x_personas_institucion ppi', 'ppi.id_perfiles_x_persona=pp.id' )
								// ->where( 'personas.estado=1' )
								// ->andWhere( 'id_institucion='.$id_institucion )
								// ->all();
								
		$dataPersonas 		= Personas::find()
								->select( "( nombres || ' ' || apellidos ) as nombres, personas.id" )
								->where( 'personas.estado=1' )
								->all();
		
		$docentes		= ArrayHelper::map( $dataPersonas, 'id', 'nombres' );

        return $this->render('create', [
            'model' 		=> $model,
            'institucion' 	=> $institucion,
            'sede' 			=> $sede,
            'docentes' 		=> $docentes,
            'controller'	=> $this,
        ]);
    }

    /**
     * Updates an existing SemillerosDatosIeoEstudiantes model.
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
     * Deletes an existing SemillerosDatosIeoEstudiantes model.
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
     * Finds the SemillerosDatosIeoEstudiantes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return SemillerosDatosIeoEstudiantes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SemillerosDatosIeoEstudiantes::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
