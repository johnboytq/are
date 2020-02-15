<?php


/**********
Versión: 001
Fecha: 27-03-2018
Desarrollador: Oscar David Lopez
Descripción: CRUD infraestructura educativa
---------------------------------------
Modificaciones:
Fecha: 27-03-2018
Persona encargada: Oscar David Lopez
Cambios realizados: - eliminacion de seleccion de institucion
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
use app\models\InfraestructuraEducativaBuscar;
use app\models\InfraestructuraEducativa;
use app\models\Sedes;
use app\models\Estados;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\SqlDataProvider;
use	yii\helpers\ArrayHelper;
/**
 * InfraestructuraEducativaController implements the CRUD actions for InfraestructuraEducativa model.
 */
class InfraestructuraEducativaController extends Controller
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
	
	
	
	public function obtenerSedes()
	{
		$idInstitucion = $_SESSION['instituciones'][0];
		$idSedes = $_SESSION['sede'][0];
		$sedes = new Sedes();
		$sedes = $sedes->find()->where("id_instituciones=$idInstitucion and id =$idSedes ")->all();
		$sedes = ArrayHelper::map($sedes,'id','descripcion');
		
		return $sedes;
	}

	public function obtenerEstados()
	{
		$estados = new Estados();
		$estados = $estados->find()->orderby("id")->all();
		$estados = ArrayHelper::map($estados,'id','descripcion');
		
		return $estados;
	}
	
	

    /**
     * Lists all InfraestructuraEducativa models.
     * @return mixed
     */
    public function actionIndex()
    {
		$idInstitucion = $_SESSION['instituciones'][0];
			
		//Muestra solo las sedes que tenga esa institucion
		$searchModel = new InfraestructuraEducativaBuscar();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);			
		$dataProvider->query->select 	("ie.*");
		$dataProvider->query->from	 	( 'infraestructura_educativa as ie, sedes as se');
		$dataProvider->query->andwhere	( " ie.id_sede = se.id
											AND se.id_instituciones = $idInstitucion
											AND ie.estado = 1
										");
	

		return $this->render('index', [
			'dataProvider' => $dataProvider,
			'searchModel' => $searchModel,
			'idInstitucion' => $idInstitucion,
			]);
		

    }

    /**
     * Displays a single InfraestructuraEducativa model.
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
     * Creates a new InfraestructuraEducativa model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
		$idInstitucion = $_SESSION['instituciones'][0];
        $model = new InfraestructuraEducativa();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
	
		$sedes = $this->obtenerSedes($idInstitucion);
		$estados = $this->obtenerEstados();
		
        return $this->render('create', [
            'model' => $model,
			'sedes'=> $sedes,
			'estados'=>$estados,
			'idInstitucion'=>$idInstitucion,
        ]);
    }

    /**
     * Updates an existing InfraestructuraEducativa model.
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
		
		$idInstitucion = $_SESSION['instituciones'][0]; 
		
		
		$sedes = $this->obtenerSedes($idInstitucion);
		$estados = $this->obtenerEstados();
		
		
		
        return $this->render('update', [
            'model' => $model,
			'sedes'=> $sedes,
			'estados'=>$estados,
			'idInstitucion'=>$idInstitucion,
        ]);
    }

    /**
     * Deletes an existing InfraestructuraEducativa model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
		
		$idInstitucion = $_SESSION['instituciones'][0];
		
		$model->estado = 2;
		$model->update(false);
		return $this->redirect(['index', 'idInstitucion' => $idInstitucion]);
		
		
    }

    /**
     * Finds the InfraestructuraEducativa model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return InfraestructuraEducativa the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = InfraestructuraEducativa::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
