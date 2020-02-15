<?php
/**********
Versión: 001
Fecha: Fecha en formato (15-08-2018)
Desarrollador: Viviana Rodas
Descripción: diario de campo semilleros tic
******************/

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
use app\models\SemillerosTicDiarioDeCampo;
use app\models\SemillerosTicDiarioDeCampoBuscar;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\models\Fases;
use yii\helpers\ArrayHelper;
use app\models\Parametro;


/**
 * SemillerosTicDiarioDeCampoController implements the CRUD actions for SemillerosTicDiarioDeCampo model.
 */
class SemillerosTicDiarioDeCampoController extends Controller
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
     * Lists all SemillerosTicDiarioDeCampo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SemillerosTicDiarioDeCampoBuscar();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SemillerosTicDiarioDeCampo model.
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
     * Creates a new SemillerosTicDiarioDeCampo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SemillerosTicDiarioDeCampo();

		//se crea una instancia del modelo fases
		$fasesModel 		 	= new Fases();
		//se traen los datos de fases
		$dataFases		 	= $fasesModel->find()->all();
		//se guardan los datos en un array
		$fases	 	 	 	= ArrayHelper::map( $dataFases, 'id', 'descripcion' );
		
		
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'fases' => $fases,
            'fasesModel' => $fasesModel,
        ]);
    }

    /**
     * Updates an existing SemillerosTicDiarioDeCampo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

		//se crea una instancia del modelo fases
		$fasesModel 		 	= new Fases();
		//se traen los datos de fases
		$dataFases		 	= $fasesModel->find()->all();
		//se guardan los datos en un array
		$fases	 	 	 	= ArrayHelper::map( $dataFases, 'id', 'descripcion' );
		
		
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'fases' => $fases,
            'fasesModel' => $fasesModel,
        ]);
    }

    /**
     * Deletes an existing SemillerosTicDiarioDeCampo model.
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
     * Finds the SemillerosTicDiarioDeCampo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return SemillerosTicDiarioDeCampo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SemillerosTicDiarioDeCampo::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
	/**
     * Esta funcion lista las opciones de la ejecución diario de campo
     * 
     * @param Recibe id fase
     * @return la lista de los campos
     * @throws no tiene excepciones
     */	
	public function actionOpcionesEjecucionDiarioCampo($idFase)
    {
       $data = array('mensaje'=>'','html'=>'','contenido'=>'');
	   
	   //se crea una instancia del modelo parametro
		$parametroTable 		 	= new Parametro();
		//se traen los datos de paramero								  
		$dataParametro		 	= $parametroTable->find()->where('estado=1 and id_tipo_parametro ='.$idFase)->all();										  
		//se guardan los datos en un array
		$opcionesEjecucion	 	 	 = ArrayHelper::map( $dataParametro, 'id', 'descripcion' );

        
		$data['html']="";
		$data['contenido']="";
		foreach ($opcionesEjecucion as $key => $value)
		{
			// print_r($key."-".$value);
			
			$data['html'].="<div class='col-sm-1' style='padding:0px;'>";
			$data['html'].="<span total class='form-control' style='background-color:#ccc;height:110px;'>".$value."</span>";
			$data['html'].="</div>";
			
			$data['contenido'].="<div class='col-sm-1' style='padding:0px;background-color:#fff;height:100px'>";
			$data['contenido'].="&nbsp;&nbsp;&nbsp;&nbsp;";
			$data['contenido'].="</div>";
		}
        
		echo json_encode( $data );
    }
}
