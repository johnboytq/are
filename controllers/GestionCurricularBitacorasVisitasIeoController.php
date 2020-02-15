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
use app\models\GestionCurricularBitacorasVisitasIeo;
use app\models\GestionCurricularBitacorasVisitasIeoBuscar;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\models\Jornadas;
use app\models\Estados;
use app\models\GestionCurricularSemanas;
use app\models\GestionCurricularCiclos;
use app\models\GestionCurricularObjetivos;
use app\models\GestionCurricularActividadesPlaneadas;
use app\models\GestionCurricularResultadosEsperados;
use app\models\GestionCurricularProductosEsperados;
use app\models\GestionCurricularVisitasAcompanamiento;
use app\models\GestionCurricularActividadesEjecutadas;
use app\models\Parametro;
use app\models\GestionCurricularInformeMensualAcompanamiento;
use app\models\GestionCurricularJustificacion;
use app\models\gestionCurricularOpcionesNivelesAvanceMomento4;
use	yii\helpers\ArrayHelper;

/**
 * GestionCurricularBitacorasVisitasIeoController implements the CRUD actions for GestionCurricularBitacorasVisitasIeo model.
 */
class GestionCurricularBitacorasVisitasIeoController extends Controller
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
     * Lists all GestionCurricularBitacorasVisitasIeo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new GestionCurricularBitacorasVisitasIeoBuscar();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

	public function obtenerJornadas()
	{
		$jornadas = new Jornadas();
		$jornadas = $jornadas->find()->orderby("id")->all();
		$jornadas = ArrayHelper::map($jornadas,'id','descripcion');
		
		return $jornadas;
	}
	
	public function obtenerEstados()
	{
		$estados = new Estados();
		$estados = $estados->find()->orderby("id")->all();
		$estados = ArrayHelper::map($estados,'id','descripcion');
		
		return $estados;
	}
	
	public function obtenerObjetivos($idmomento)
	{
		$objetivos = new GestionCurricularObjetivos();
		$objetivos = $objetivos->find()->orderby("id")->all();
		$objetivos = ArrayHelper::map($objetivos,'id','descripcion');
		
		return $objetivos;
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

    /**
     * Displays a single GestionCurricularBitacorasVisitasIeo model.
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
     * Creates a new GestionCurricularBitacorasVisitasIeo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
				
        $model  = new GestionCurricularBitacorasVisitasIeo();
		$model2 = new GestionCurricularSemanas();		
		$model3 = new GestionCurricularActividadesPlaneadas();
		$model4 = new GestionCurricularResultadosEsperados();
		$model5 = new GestionCurricularProductosEsperados();
		$model6 = new GestionCurricularVisitasAcompanamiento();
		$model7 = new GestionCurricularActividadesEjecutadas();
		$model8 = new GestionCurricularJustificacion();
		$model9 = new GestionCurricularInformeMensualAcompanamiento();
		$model10 = new GestionCurricularCiclos();
		
		$datosCiclos =  GestionCurricularCiclos::find()->orderby( 'id' )->all();		
		$datosCiclos	= ArrayHelper::map( $datosCiclos, 'id', 'descripcion' );
		
		$datosSemanas =  GestionCurricularSemanas::find()->orderby( 'id' )->all();		
		$datosSemanas	= ArrayHelper::map( $datosSemanas, 'id', 'descripcion' );
		
		$dataParametros = Parametro::find()
						->where( 'id_tipo_parametro=2' )
						->andWhere( 'estado=1' )
						->orderby( 'id' )
						->all();
						
		$parametro	= ArrayHelper::map( $dataParametros, 'id', 'descripcion' );
		
		$titulos = gestionCurricularOpcionesNivelesAvanceMomento4::find()
						->where( 'id_tipo_opciones=5' )
						->andWhere( 'estado=1' )
						->orderby( 'id' )
						->all();
						
		$titulos	= ArrayHelper::map( $titulos, 'id', 'descripcion' );
		
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' 	=> $model,
			'model2' 	=> $model2,
			'model3' 	=> $model3,
			'model4' 	=> $model4,
			'model5' 	=> $model5,
			'model6' 	=> $model6,
			'model7' 	=> $model7,
			'model8' 	=> $model8,
			'model9' 	=> $model9,
			'model10' 	=> $model10,
			'titulos'	=> $titulos,
			'datosCiclos'=> $datosCiclos,
			'datosSemanas'=> $datosSemanas,
			'parametro'	=> $parametro,
			'jornadas' 	=>$this->obtenerJornadas(),
			'estados' 	=>$this->obtenerEstados(),
			'docentes' 	=>$this->obtenerDocentes(),
			'momento1Sem1'	=>$this->obtenerObjetivos(1),
        ]);
    }

    /**
     * Updates an existing GestionCurricularBitacorasVisitasIeo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		$model2 = new GestionCurricularSemanas();	
		$model3 = new GestionCurricularActividadesPlaneadas();
		$model4 = new GestionCurricularResultadosEsperados();
		$model5 = new GestionCurricularProductosEsperados();
		$model6 = new GestionCurricularVisitasAcompanamiento();
		$model7 = new GestionCurricularActividadesEjecutadas();
		$model8 = new GestionCurricularJustificacion();
		$model9 = new GestionCurricularInformeMensualAcompanamiento();
		$model10 = new GestionCurricularCiclos();
		
		$datosCiclos =  GestionCurricularCiclos::find()->orderby( 'id' )->all();		
		$datosCiclos	= ArrayHelper::map( $datosCiclos, 'id', 'descripcion' );
		
		$datosSemanas =  GestionCurricularSemanas::find()->orderby( 'id' )->all();		
		$datosSemanas	= ArrayHelper::map( $datosSemanas, 'id', 'descripcion' );
		
		
		$dataParametros = Parametro::find()
						->where( 'id_tipo_parametro=1' )
						->andWhere( 'estado=1' )
						->orderby( 'id' )
						->all();
						
		$parametro	= ArrayHelper::map( $dataParametros, 'id', 'descripcion' );
		
		$titulos = gestionCurricularOpcionesNivelesAvanceMomento4::find()
						->where( 'id_tipo_opciones=5' )
						->andWhere( 'estado=1' )
						->orderby( 'id' )
						->all();
						
		$titulos	= ArrayHelper::map( $titulos, 'id', 'descripcion' );
		

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
			'model2' 	=> $model2,
			'model3' 	=> $model3,
			'model4' 	=> $model4,
			'model5' 	=> $model5,
			'model6' 	=> $model6,
			'model7' 	=> $model7,
			'model8' 	=> $model8,
			'model9' 	=> $model9,
			'model10' 	=> $model10,
			'titulos'	=> $titulos,
			'datosCiclos'=> $datosCiclos,
			'datosSemanas'=> $datosSemanas,
			'parametro'	=> $parametro,
			'jornadas' =>$this->obtenerJornadas(),
			'estados' =>$this->obtenerEstados(),
			'docentes' =>$this->obtenerDocentes(),
			'momento1Sem1'	=>$this->obtenerObjetivos(1),
        ]);
    }

    /**
     * Deletes an existing GestionCurricularBitacorasVisitasIeo model.
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
     * Finds the GestionCurricularBitacorasVisitasIeo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return GestionCurricularBitacorasVisitasIeo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = GestionCurricularBitacorasVisitasIeo::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
