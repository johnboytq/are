<?php

namespace app\controllers;

use Yii;
use app\models\IndiceSinteticoCalidad;
use app\models\IndiceSinteticoCalidadBuscar;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\helpers\ArrayHelper;
use app\models\IndiceEspecifico;
use app\models\Estados;

/**
 * IndiceSinteticoCalidadController implements the CRUD actions for IndiceSinteticoCalidad model.
 */
class IndiceSinteticoCalidadController extends Controller
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
     * Lists all IndiceSinteticoCalidad models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new IndiceSinteticoCalidadBuscar();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere( 'estado=1' );

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single IndiceSinteticoCalidad model.
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
     * Creates a new IndiceSinteticoCalidad model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new IndiceSinteticoCalidad();
		
		$dataEstados= Estados::find()
						->where( 'id=1' )
						->all();
		$estados	= ArrayHelper::map( $dataEstados, 'id', 'descripcion' );
		
		$dataIndicesEspecificos = IndiceEspecifico::find()
									->where( 'estado=1' )
									->all();
		$indicesEspecificos		= ArrayHelper::map( $dataIndicesEspecificos, 'id', 'descripcion' );

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' 			=> $model,
            'estados' 			=> $estados,
            'indicesEspecificos'=> $indicesEspecificos,
        ]);
    }

    /**
     * Updates an existing IndiceSinteticoCalidad model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		
		$dataEstados= Estados::find()
						->where( 'id=1' )
						->all();
		$estados	= ArrayHelper::map( $dataEstados, 'id', 'descripcion' );
		
		$dataIndicesEspecificos = IndiceEspecifico::find()
									->where( 'estado=1' )
									->all();
		$indicesEspecificos		= ArrayHelper::map( $dataIndicesEspecificos, 'id', 'descripcion' );

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' 			=> $model,
            'estados' 			=> $estados,
            'indicesEspecificos'=> $indicesEspecificos,
        ]);
    }

    /**
     * Deletes an existing IndiceSinteticoCalidad model.
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
     * Finds the IndiceSinteticoCalidad model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return IndiceSinteticoCalidad the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = IndiceSinteticoCalidad::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
