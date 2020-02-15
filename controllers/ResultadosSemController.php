<?php

namespace app\controllers;

use Yii;
use app\models\ResultadosSem;
use app\models\ResultadosSemBuscar;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Estados;
use app\models\Instituciones;
use	yii\helpers\ArrayHelper;


/**
 * ResultadosSemController implements the CRUD actions for ResultadosSem model.
 */
class ResultadosSemController extends Controller
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
     * Lists all ResultadosSem models.
     * @return mixed
     */
    public function actionIndex()
    {
		$idInstitucion = $_SESSION['instituciones'][0];
        $searchModel = new ResultadosSemBuscar();
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
     * Displays a single ResultadosSem model.
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
     * Creates a new ResultadosSem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ResultadosSem();

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
     * Updates an existing ResultadosSem model.
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
     * Deletes an existing ResultadosSem model.
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
     * Finds the ResultadosSem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return ResultadosSem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ResultadosSem::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
