<?php

namespace app\controllers;

use Yii;
use app\models\ResultadosEvaluacionDocente;
use app\models\ResultadosEvaluacionDocenteBuscar;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Estados;
use app\models\Instituciones;
use	yii\helpers\ArrayHelper;

/**
 * ResultadosEvaluacionController implements the CRUD actions for ResultadosEvaluacionDocente model.
 */
class ResultadosEvaluacionController extends Controller
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
     * Lists all ResultadosEvaluacionDocente models.
     * @return mixed
     */
    public function actionIndex()
    {
		$idInstitucion = $_SESSION['instituciones'][0];
        $searchModel = new ResultadosEvaluacionDocenteBuscar();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$dataProvider->query->andWhere("id_institucion=$idInstitucion");
		$dataProvider->query->andWhere("estado=1");

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	
		
	public function estados()
	{
		//se envia la variable estados con los valores de la tabla estado, siempre es activo
		$estados = new Estados();
		$estados = $estados->find()->orderBy("id")->all();
		$estados = ArrayHelper::map($estados,'id','descripcion');
		return $estados;
	}
	
	public function Institucion()
	{
		$idInstitucion = $_SESSION['instituciones'][0];
		
		$institucion = new Instituciones();
		$institucion = $institucion->find()->andWhere("id=$idInstitucion")->all();
		$institucion = ArrayHelper::map($institucion,'id','descripcion');
		return $institucion;
	}

    /**
     * Displays a single ResultadosEvaluacionDocente model.
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
     * Creates a new ResultadosEvaluacionDocente model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ResultadosEvaluacionDocente();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
			'estados'	=> $this->estados(),
			'institucion'	=> $this->institucion(),
        ]);
    }

    /**
     * Updates an existing ResultadosEvaluacionDocente model.
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
			'estados'	=> $this->estados(),
			'institucion'	=> $this->institucion(),
        ]);
    }

    /**
     * Deletes an existing ResultadosEvaluacionDocente model.
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
     * Finds the ResultadosEvaluacionDocente model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return ResultadosEvaluacionDocente the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ResultadosEvaluacionDocente::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
