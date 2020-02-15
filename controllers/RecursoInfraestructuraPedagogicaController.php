<?php

/**********
Versión: 001
Fecha: 09-04-2018
Persona encargada: Edwin Molina Grisales
CRUD de RECURSOS DE INFRAESTRUCTURA PEDAGOGICA
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
use app\models\RecursoInfraestructuraPedagogica;
use app\models\RecursoInfraestructuraPedagogicaBuscar;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\models\Sedes;
use app\models\Estados;
use yii\helpers\ArrayHelper;

/**
 * RecursoInfraestructuraPedagogicaController implements the CRUD actions for RecursoInfraestructuraPedagogica model.
 */
class RecursoInfraestructuraPedagogicaController extends Controller
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
     * Lists all RecursoInfraestructuraPedagogica models.
     * @return mixed
     */
    // public function actionIndex( $idInstitucion = 0, $idSedes = 0 )
    public function actionIndex()
    {
		$idInstitucion 	= $_SESSION['instituciones'][0];
		$idSedes 		= $_SESSION['sede'][0];
		
		if( $idInstitucion != 0 && $idSedes != 0 ){
			
			$searchModel = new RecursoInfraestructuraPedagogicaBuscar();
			$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
			$dataProvider->query->andWhere( 'id_sede='.$idSedes )->andWhere( 'estado=1' );

			return $this->render('index', [
				'searchModel' 	=> $searchModel,
				'dataProvider' 	=> $dataProvider,
				'idInstitucion' => $idInstitucion,
				'idSedes' 		=> $idSedes,
			]);
		}
		else{
			return $this->render('listarInstituciones', [
				'idInstitucion' => $idInstitucion,
				'idSedes' => $idSedes,
			]);
		}
    }

    /**
     * Displays a single RecursoInfraestructuraPedagogica model.
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
     * Creates a new RecursoInfraestructuraPedagogica model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate( $idSedes = 0 )
    {
		
		$sedesTable 		= new Sedes();
		$dataSedes	 		= $sedesTable->find()->where( 'id='.$idSedes )->andWhere( 'estado=1' )->all();
		$sedes				= ArrayHelper::map( $dataSedes, 'id', 'descripcion' );
		
		$dataEstados		= Estados::find()->where( 'id=1' )->all();
		$estados			= ArrayHelper::map( $dataEstados, 'id', 'descripcion' );
		
        $model = new RecursoInfraestructuraPedagogica();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' 	=> $model,
			'sedes' 	=> $sedes,
			'estados'	=> $estados,
			'id_sede'	=> $idSedes,
        ]);
    }

    /**
     * Updates an existing RecursoInfraestructuraPedagogica model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		
		$sedesTable 		= new Sedes();
		$dataSedes	 		= $sedesTable->find()->where( 'id='.$model->id_sede )->all();
		$sedes				= ArrayHelper::map( $dataSedes, 'id', 'descripcion' );
		
		$dataEstados		= Estados::find()->all();
		$estados			= ArrayHelper::map( $dataEstados, 'id', 'descripcion' );

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' 	=> $model,
			'sedes' 	=> $sedes,
			'estados'	=> $estados,
        ]);
    }

    /**
     * Deletes an existing RecursoInfraestructuraPedagogica model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
		$model = $this->findModel($id);
		
		$modelSedes 	= Sedes::findOne( $model->id_sede );
		
		$idInstitucion  = $modelSedes->id_instituciones;
		$idSedes 		= $modelSedes->id;
		
		$model->estado = 2;
		$model->update( false );

        return $this->redirect(['index', 'idInstitucion' => $idInstitucion, 'idSedes' => $idSedes]);
    }

    /**
     * Finds the RecursoInfraestructuraPedagogica model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return RecursoInfraestructuraPedagogica the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RecursoInfraestructuraPedagogica::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
