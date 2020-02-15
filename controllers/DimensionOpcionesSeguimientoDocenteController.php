<?php

namespace app\controllers;

use Yii;
use app\models\DimensionOpcionesSeguimientoDocente;
use app\models\DimensionOpcionesSeguimientoDocenteBuscar;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\models\Parametro;
use yii\helpers\ArrayHelper;
use yii\helpers\Estados;

/**
 * DimensionOpcionesSeguimientoDocenteController implements the CRUD actions for DimensionOpcionesSeguimientoDocente model.
 */
class DimensionOpcionesSeguimientoDocenteController extends Controller
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
     * Lists all DimensionOpcionesSeguimientoDocente models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DimensionOpcionesSeguimientoDocenteBuscar();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$dataProvider->query
			->andWhere( 'estado=1' )
			->orderby( 'id_tipo_dimension' );
		
		$dataParametros = Parametro::find()
						->where( 'id_tipo_parametro=4' )
						->andWhere( 'estado=1' )
						->orderby( 'id' )
						->all();
						
		$parametros		= ArrayHelper::map( $dataParametros, 'id', 'descripcion' );
		
		$dataDimensiones = Parametro::find()
								->select( 'id, descripcion' )
								->where( 'id_tipo_parametro=3' )
								->andWhere( 'estado=1' )
								->orderby( 'descripcion' )
								->all();
						
		$dimensiones		= ArrayHelper::map( $dataDimensiones, 'id', 'descripcion' );

        return $this->render('index', [
            'searchModel' 	=> $searchModel,
            'dataProvider' 	=> $dataProvider,
            'parametros' 	=> $parametros,
            'dimensiones' 	=> $dimensiones,
        ]);
    }

    /**
     * Displays a single DimensionOpcionesSeguimientoDocente model.
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
     * Creates a new DimensionOpcionesSeguimientoDocente model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DimensionOpcionesSeguimientoDocente();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing DimensionOpcionesSeguimientoDocente model.
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
     * Deletes an existing DimensionOpcionesSeguimientoDocente model.
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
     * Finds the DimensionOpcionesSeguimientoDocente model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return DimensionOpcionesSeguimientoDocente the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DimensionOpcionesSeguimientoDocente::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
