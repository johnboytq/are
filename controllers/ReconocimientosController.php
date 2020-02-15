<?php
/**********
Versión: 001
Fecha: Fecha en formato (12-03-2018)
Desarrollador: Viviana Rodas
Descripción: Controlador de Reconocimientos
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
use app\models\Reconocimientos;
use app\models\ReconocimientosBuscar;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\models\Personas;
use app\models\Estados;

use yii\helpers\ArrayHelper;

/**
 * ReconocimientosController implements the CRUD actions for Reconocimientos model.
 */
class ReconocimientosController extends Controller
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
     * Lists all Reconocimientos models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ReconocimientosBuscar();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$dataProvider ->query->andWhere('estado=1');
		

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Reconocimientos model.
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
     * Creates a new Reconocimientos model.
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
		
		//se crea una instancia del modelo estados
		$estadosTable 		 	= new Estados();
		//se traen los datos de tipos formaciones										  
		$dataEstados		 	= $estadosTable->find()->where( 'id=1' )->all();										  
		//se guardan los datos en un array
		$estados	 	 	 	= ArrayHelper::map( $dataEstados, 'id', 'descripcion' );
		
		
		$model = new Reconocimientos();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
			'personas' => $personas,
            'estados' => $estados,
        ]);
    }

    /**
     * Updates an existing Reconocimientos model.
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
		
		//se crea una instancia del modelo estados
		$estadosTable 		 	= new Estados();
		//se traen los datos de tipos formaciones										  
		$dataEstados		 	= $estadosTable->find()->all();										  
		//se guardan los datos en un array
		$estados	 	 	 	= ArrayHelper::map( $dataEstados, 'id', 'descripcion' );
		
		
		
		$model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
			'personas' => $personas,
            'estados' => $estados,
        ]);
    }

    /**
     * Deletes an existing Reconocimientos model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        // $this->findModel($id)->delete();

        // return $this->redirect(['index']);
		$model = Reconocimientos::findOne($id);
		$model->estado = 2;
		$model->update(false);

        return $this->redirect(['index']);
    }

    /**
     * Finds the Reconocimientos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Reconocimientos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Reconocimientos::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
