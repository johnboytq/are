<?php
/**********
Versión: 001
Fecha: Fecha en formato (12-03-2018)
Desarrollador: Viviana Rodas
Descripción: Controlador de Escolaridades
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
use app\models\PersonasEscolaridades;
use app\models\PersonasEscolaridadesBuscar;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\models\Personas;
use app\models\Escolaridades;

use yii\helpers\ArrayHelper;

/**
 * PersonasEscolaridadesController implements the CRUD actions for PersonasEscolaridades model.
 */
class PersonasEscolaridadesController extends Controller
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
     * Lists all PersonasEscolaridades models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PersonasEscolaridadesBuscar();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PersonasEscolaridades model.
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
     * Creates a new PersonasEscolaridades model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        //se crea una instancia del modelo personas
		$personasTable 		 	= new Personas();
		//se traen los datos de personas
		// $dataPersonas		 	= $personasTable->find()->where(['concat(nombre,apellidos) as name'])->all();										  
		$dataPersonas		 	= $personasTable->find()->select(["id, CONCAT(nombres, ' ', apellidos) AS nombres"])->where('estado=1')->all();										  
		//se guardan los datos en un array
		$personas	 	 	 	= ArrayHelper::map( $dataPersonas, 'id', 'nombres' );
		
		//se crea una instancia del modelo tipos escolaridades
		$tiposEscolaridadesTable 		 	= new Escolaridades();
		//se traen los datos de tipos formaciones										  
		$datatiposEscolaridades		 	= $tiposEscolaridadesTable->find()->all();										  
		//se guardan los datos en un array
		$escolaridades	 	 	 	= ArrayHelper::map( $datatiposEscolaridades, 'id', 'descripcion' );
		
		$model = new PersonasEscolaridades();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'personas' => $personas,
            'escolaridades' => $escolaridades,
        ]);
    }

    /**
     * Updates an existing PersonasEscolaridades model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        
		//se crea una instancia del modelo personas
		$personasTable 		 	= new Personas();
		//se traen los datos de personas
		// $dataPersonas		 	= $personasTable->find()->where(['concat(nombre,apellidos) as name'])->all();										  
		$dataPersonas		 	= $personasTable->find()->select(["id, CONCAT(nombres, ' ', apellidos) AS nombres"])->where('estado=1')->all();										  
		//se guardan los datos en un array
		$personas	 	 	 	= ArrayHelper::map( $dataPersonas, 'id', 'nombres' );
		
		//se crea una instancia del modelo tipos escolaridades
		$tiposEscolaridadesTable 		 	= new Escolaridades();
		//se traen los datos de tipos formaciones										  
		$datatiposEscolaridades		 	= $tiposEscolaridadesTable->find()->all();										  
		//se guardan los datos en un array
		$escolaridades	 	 	 	= ArrayHelper::map( $datatiposEscolaridades, 'id', 'descripcion' );
		
		
		$model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
			'personas' => $personas,
            'escolaridades' => $escolaridades,
        ]);
    }

    /**
     * Deletes an existing PersonasEscolaridades model.
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
     * Finds the PersonasEscolaridades model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PersonasEscolaridades the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PersonasEscolaridades::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
