<?php

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
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;


use app\models\Niveles;
use app\models\Estados;
use app\models\NivelesBuscar;
/**
 * NivelesController implements the CRUD actions for Niveles model.
 */
 
 
/**********
Versión: 001
Fecha: 05-03-2018
Desarrollador: Oscar David Lopez Villa
Descripción: CRUD de Niveles
---------------------------------------
Modificaciones:
Fecha: 05-03-2018
Persona encargada: Oscar David Lopez Villa
Cambios realizados: Se muestran los niveles con estado activo - Funcion actionIndex()
---------------------------------------
Modificaciones:
Fecha: 12-03-2018
Persona encargada: Oscar David Lopez Villa
Cambios realizados: Se incorpora la opcion de buscar
------------
**********/
class NivelesController extends Controller
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
     * Lists all Niveles models.
     * @return mixed
     */
     public function actionIndex()
    {
		$searchModel = new NivelesBuscar();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$dataProvider->query->andwhere( 'estado=1');

        return $this->render('index', [
            'dataProvider' => $dataProvider,
			'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single Niveles model.
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
     * Creates a new Niveles model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
		
		$estados = new Estados();
		$estados = $estados->find()->where( 'id=1' )->all();
		$estados = ArrayHelper::map( $estados, 'id', 'descripcion' );
		
        $model = new Niveles();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
			'estado'=>$estados,
        ]);
    }

    /**
     * Updates an existing Niveles model.
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
     * Deletes an existing Niveles model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        
		//$this->findModel($id)->delete();

		// se cambia el borrar por inactivar modificando el campo esta en la tabla niveles
        $model = Niveles::findOne($id);
		$model->estado = 2;
		$model->update(false);

       
        return $this->redirect(['index']);
    }

    /**
     * Finds the Niveles model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Niveles the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Niveles::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
