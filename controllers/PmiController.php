<?php

/**********
Versión: 001
Fecha: 12-07-2018
Desarrollador: Edwin Molina Grisales
Descripción: CRUD PMI
---------------------------------------
**********/

namespace app\controllers;

use Yii;
use app\models\Pmi;
use app\models\PmiBuscar;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\models\SubProcesoEvaluacion;
use app\models\ProcesoEspecifico;
use app\models\AreaGestion;
use app\models\Estados;
use app\models\Instituciones;
use app\models\Zonificaciones;
use app\models\ComunasCorregimientos;
use yii\helpers\ArrayHelper;

/**
 * PmiController implements the CRUD actions for Pmi model.
 */
class PmiController extends Controller
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
     * Lists all Pmi models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PmiBuscar();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere( 'estado=1' );

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Pmi model.
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
     * Creates a new Pmi model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Pmi();
		
		$idInstitucion = $_SESSION[ 'instituciones' ][0];
		
		$institucion = Instituciones::findOne( $idInstitucion );
		
		$dataEstados= Estados::find()
						->where( 'id=1' )
						->all();
		$estados	= ArrayHelper::map( $dataEstados, 'id', 'descripcion' );
		
		$dataProcesos	= ProcesoEspecifico::find()
							->where( 'estado=1' )
							->all();
		$procesos		= ArrayHelper::map( $dataProcesos, 'id', 'descripcion' );
		
		$dataZonas		= Zonificaciones::find()
							->where( 'estado=1' )
							->all();
		$zonas		= ArrayHelper::map( $dataZonas, 'id', 'descripcion' );
		
		$dataComunas= ComunasCorregimientos::find()
							->where( 'estado=1' )
							->all();
		$comunas	= ArrayHelper::map( $dataComunas, 'id', 'descripcion' );
		
		$dataAreaGestion= AreaGestion::find()
							->where( 'estado=1' )
							->all();
		$areasGestion	= ArrayHelper::map( $dataAreaGestion, 'id', 'descripcion' );
		
		$dataSubProcesoEvaluacion= SubProcesoEvaluacion::find()
										->select( 'id, descripcion, id_area_gestion' )
										->where( 'estado=1' )
										->all();
		$subProcesoEvaluacion	 = ArrayHelper::map( $dataSubProcesoEvaluacion, 'id', 'descripcion' );
		
		$subProcesoEvaluacionData = [];
		foreach( $dataSubProcesoEvaluacion as $key => $value ){
			$subProcesoEvaluacionData[ $value->id ] = [ 'data-area' => $value->id_area_gestion ];
		}
		
		$procesosData = [];
		foreach( $dataProcesos as $key => $value ){
			$procesosData[ $value->id ] = [ 'data-sub-proceso' => $value->id_sub_proceso ];
		}
		

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' 		=> $model,
            'institucion' 	=> $institucion,
            'estados' 		=> $estados,
            'procesos' 		=> $procesos,
            'zonas' 		=> $zonas,
            'comunas' 		=> $comunas,
            'areasGestion'	=> $areasGestion,
            'subProcesoEvaluacion'	=> $subProcesoEvaluacion,
            'subProcesoEvaluacionData'	=> $subProcesoEvaluacionData,
            'procesosData'	=> $procesosData,
        ]);
    }

    /**
     * Updates an existing Pmi model.
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
		
		$dataEstados= Estados::find()
						->where( 'id=1' )
						->all();
		$estados	= ArrayHelper::map( $dataEstados, 'id', 'descripcion' );
		
		$dataProcesos	= ProcesoEspecifico::find()
							->where( 'estado=1' )
							->all();
		$procesos		= ArrayHelper::map( $dataProcesos, 'id', 'descripcion' );
		
		$dataZonas		= Zonificaciones::find()
							->where( 'estado=1' )
							->all();
		$zonas		= ArrayHelper::map( $dataZonas, 'id', 'descripcion' );
		
		$dataComunas= ComunasCorregimientos::find()
							->where( 'estado=1' )
							->all();
		$comunas	= ArrayHelper::map( $dataComunas, 'id', 'descripcion' );
		
		$dataAreaGestion= AreaGestion::find()
							->where( 'estado=1' )
							->all();
		$areasGestion	= ArrayHelper::map( $dataAreaGestion, 'id', 'descripcion' );
		
		$dataSubProcesoEvaluacion= SubProcesoEvaluacion::find()
										->where( 'estado=1' )
										->all();
		$subProcesoEvaluacion	 = ArrayHelper::map( $dataSubProcesoEvaluacion, 'id', 'descripcion' );
		
		$subProcesoEvaluacionData = [];
		foreach( $dataSubProcesoEvaluacion as $key => $value ){
			$subProcesoEvaluacionData[ $value->id ] = [ 'data-area' => $value->id_area_gestion ];
		}
		
		$procesosData = [];
		foreach( $dataProcesos as $key => $value ){
			$procesosData[ $value->id ] = [ 'data-sub-proceso' => $value->id_sub_proceso ];
		}

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'institucion' 	=> $institucion,
            'estados' 		=> $estados,
            'procesos' 		=> $procesos,
            'zonas' 		=> $zonas,
            'comunas' 		=> $comunas,
            'areasGestion'	=> $areasGestion,
            'subProcesoEvaluacion'	=> $subProcesoEvaluacion,
            'subProcesoEvaluacionData'	=> $subProcesoEvaluacionData,
            'procesosData'	=> $procesosData,
        ]);
    }

    /**
     * Deletes an existing Pmi model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
		$model = $this->findModel($id);
		$model->estado = 2;
		$model->update(false);

		return $this->redirect(['index']);
    }

    /**
     * Finds the Pmi model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Pmi the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Pmi::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
