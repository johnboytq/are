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
use app\models\GestionCurricularDocenteTutorAcompanamiento;
use app\models\GestionCurricularDocenteTutorAcompanamientoBuscar;
use app\models\Sedes;
use app\models\Instituciones;
use app\models\GestionCurricularDimensionOpcionesInstrumentoSeguimiento;
use yii\web\Controller;
use app\models\Parametro;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use	yii\helpers\ArrayHelper;

/**
 * GestionCurricularDocenteTutorAcompanamientoController implements the CRUD actions for GestionCurricularDocenteTutorAcompanamiento model.
 */
class GestionCurricularDocenteTutorAcompanamientoController extends Controller
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
     * Lists all GestionCurricularDocenteTutorAcompanamiento models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new GestionCurricularDocenteTutorAcompanamientoBuscar();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
public function obtenerDocentes()
	{
		$idInstitucion = $_SESSION['instituciones'][0];
		$connection = Yii::$app->getDb();
		//saber el nombre del docente
		$command = $connection->createCommand("
			SELECT d.id_perfiles_x_personas as id, concat(p.nombres,' ',p.apellidos) as nombres
			FROM public.docentes as d, public.perfiles_x_personas as per, public.personas as p, 
			perfiles_x_personas_institucion as ppi
			where d.id_perfiles_x_personas = per.id
			and per.id_personas = p.id
			and d.estado =1
			and ppi.id_perfiles_x_persona =  per.id
			and ppi.id_institucion = $idInstitucion
		");
		
		$result = $command->queryAll();
		$docentes = array();
		foreach ($result as $key)
		{
			$id = $key['id'];
			$nombres = $key['nombres'];
			$docentes[$id] =  $nombres;
		}
		return $docentes;
	}
	
	public function obtenerSedes()
	{
		$idInstitucion = $_SESSION['instituciones'][0];
		$sedes = new Sedes();
		$sedes = $sedes->find()->where("id_instituciones=$idInstitucion")->all();
		$sedes = ArrayHelper::map($sedes,'id','descripcion');
		
		return $sedes;
	}
	
	public function obtenerInstituciones()
	{
		$idInstitucion = $_SESSION['instituciones'][0];
		$instituciones = new Instituciones();
		$instituciones = $instituciones->find()->where("id = $idInstitucion")->all();
		$instituciones = ArrayHelper::map($instituciones,'id','descripcion');
		
		return $instituciones;
	}
	
    /**
     * Displays a single GestionCurricularDocenteTutorAcompanamiento model.
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
     * Creates a new GestionCurricularDocenteTutorAcompanamiento model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new GestionCurricularDocenteTutorAcompanamiento();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
		
		$dataParametros1 = Parametro::find()
						->where( 'id_tipo_parametro=4' )
						->andWhere( 'estado=1' )
						->orderby( 'id' )
						->all();
						
			//texto en los radios			
		$parametro1	= ArrayHelper::map( $dataParametros1, 'id', 'descripcion' );

		//titulos de las preguntas de los radios
		$titulos1 = GestionCurricularDimensionOpcionesInstrumentoSeguimiento::find()
						->where( 'id_tipo_dimension=7' )
						->andWhere( 'estado=1' )
						->orderby( 'id' )
						->all();
						
		$titulos1	= ArrayHelper::map( $titulos1, 'id', 'descripcion' );
		
		$titulos2 = GestionCurricularDimensionOpcionesInstrumentoSeguimiento::find()
						->where( 'id_tipo_dimension=6' )
						->andWhere( 'estado=1' )
						->orderby( 'id' )
						->all();
						
		$titulos2	= ArrayHelper::map( $titulos2, 'id', 'descripcion' );
		
		$titulos3 = GestionCurricularDimensionOpcionesInstrumentoSeguimiento::find()
						->where( 'id_tipo_dimension=5' )
						->andWhere( 'estado=1' )
						->orderby( 'id' )
						->all();
						
		$titulos3	= ArrayHelper::map( $titulos3, 'id', 'descripcion' );
		
        return $this->render('create', [
            'model' 	=> $model,
			'docentes'	=> $this->obtenerDocentes(),
			'sedes'		=> $this->obtenerSedes(),
			'instituciones'=> $this->obtenerInstituciones(),
			'parametro1'=> $parametro1,
			'titulos1'	=> $titulos1,
			'titulos2'	=> $titulos2,
			'titulos3'	=> $titulos3,
        ]);
    }

    /**
     * Updates an existing GestionCurricularDocenteTutorAcompanamiento model.
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
     * Deletes an existing GestionCurricularDocenteTutorAcompanamiento model.
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
     * Finds the GestionCurricularDocenteTutorAcompanamiento model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return GestionCurricularDocenteTutorAcompanamiento the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = GestionCurricularDocenteTutorAcompanamiento::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
