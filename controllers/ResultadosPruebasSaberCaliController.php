<?php

namespace app\controllers;

use Yii;
use app\models\ResultadosPruebasSaberCali;
use app\models\ResultadosPruebasSaberCaliBuscar;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\models\Instituciones;
use app\models\AsignaturaEspecifica;
use app\models\AsignaturasEvaluadas;
use app\models\Estados;
use yii\helpers\ArrayHelper;

/**
 * ResultadosPruebasSaberCaliController implements the CRUD actions for ResultadosPruebasSaberCali model.
 */
class ResultadosPruebasSaberCaliController extends Controller
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
     * Lists all ResultadosPruebasSaberCali models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ResultadosPruebasSaberCaliBuscar();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$dataProvider->query->andWhere( 'estado=1' );

        return $this->render('index', [
            'searchModel' 	=> $searchModel,
            'dataProvider' 	=> $dataProvider,
            'title' 		=> 'Resultados Pruebas del Saber Cali',
        ]);
    }

    /**
     * Displays a single ResultadosPruebasSaberCali model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
            'breadcrumbsTitle' 	=> 'Resultados Pruebas del Saber Cali',
        ]);
    }

    /**
     * Creates a new ResultadosPruebasSaberCali model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ResultadosPruebasSaberCali();
		
		$idInstitucion = $_SESSION[ 'instituciones' ][0];
		
		$institucion = Instituciones::findOne( $idInstitucion );
		
		$dataAsignaturas = AsignaturaEspecifica::find()
								->where( 'estado=1' )
								->all();
								
		$asignaturas = ArrayHelper::map( $dataAsignaturas, 'id', 'descripcion' );
		
		$dataEstados= Estados::find()
						->where( 'id=1' )
						->all();
		$estados	= ArrayHelper::map( $dataEstados, 'id', 'descripcion' );
		
		$dataAsignaturasEvaluadas= AsignaturasEvaluadas::find()
										->where( 'estado=1' )
										->all();
		$asignaturasEvaluadas	 = ArrayHelper::map( $dataAsignaturasEvaluadas, 'id', 'descripcion' );
		
		$asignaturasData = [];
		foreach( $dataAsignaturas as $key => $value ){
			$asignaturasData[ $value->id ] = [ 'data-evaluada' => $value->id_asignatura_evaluada ];
		}

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' 				=> $model,
            'institucion' 			=> $institucion,
            'estados' 				=> $estados,
            'asignaturas' 			=> $asignaturas,
            'asignaturasData' 		=> $asignaturasData,
            'asignaturasEvaluadas' 	=> $asignaturasEvaluadas,
        ]);
    }

    /**
     * Updates an existing ResultadosPruebasSaberCali model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		
		$idInstitucion = $_SESSION[ 'instituciones' ][0];
		
		$institucion = Instituciones::findOne( $idInstitucion );
		
		$dataAsignaturas = AsignaturaEspecifica::find()
								->where( 'estado=1' )
								->all();
								
		$asignaturas = ArrayHelper::map( $dataAsignaturas, 'id', 'descripcion' );
		
		$dataEstados= Estados::find()
						->where( 'id=1' )
						->all();
		$estados	= ArrayHelper::map( $dataEstados, 'id', 'descripcion' );
		
		$dataAsignaturasEvaluadas= AsignaturasEvaluadas::find()
										->where( 'estado=1' )
										->all();
		$asignaturasEvaluadas	 = ArrayHelper::map( $dataAsignaturasEvaluadas, 'id', 'descripcion' );
		
		$asignaturasData = [];
		foreach( $dataAsignaturas as $key => $value ){
			$asignaturasData[ $value->id ] = [ 'data-evaluada' => $value->id_asignatura_evaluada ];
		}

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' 				=> $model,
            'institucion' 			=> $institucion,
            'estados' 				=> $estados,
            'asignaturas' 			=> $asignaturas,
            'asignaturasData' 		=> $asignaturasData,
            'asignaturasEvaluadas' 	=> $asignaturasEvaluadas,
        ]);
    }

    /**
     * Deletes an existing ResultadosPruebasSaberCali model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
		$model->estado = 2;
		$model->update( false );

        return $this->redirect(['index']);
    }

    /**
     * Finds the ResultadosPruebasSaberCali model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return ResultadosPruebasSaberCali the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ResultadosPruebasSaberCali::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
