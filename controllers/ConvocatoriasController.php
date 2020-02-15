<?php

namespace app\controllers;

use Yii;
use app\models\Convocatorias;
use app\models\ConvocatoriasBuscar;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\models\Sedes;
use app\models\Estados;
use yii\helpers\ArrayHelper;

/**
 * ConvocatoriasController implements the CRUD actions for Convocatorias model.
 */
class ConvocatoriasController extends Controller
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
     * Lists all Convocatorias models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ConvocatoriasBuscar();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere( 'estado=1' );

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Convocatorias model.
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
     * Creates a new Convocatorias model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Convocatorias();
		
		$idSede 		= $_SESSION['sede'][0];
		$idInstitucion 	= $_SESSION['instituciones'][0];
		
		$sede		= Sedes::findOne( $idSede );
		
		$estadoData		= Estados::find()
							->where( 'id=1' )
							->all();
		$estados		= ArrayHelper::map( $estadoData, 'id', 'descripcion' );

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' 	=> $model,
            'sede' 		=> $sede,
            'estados' 	=> $estados,
        ]);
    }

    /**
     * Updates an existing Convocatorias model.
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
		
		$idSede 		= $_SESSION['sede'][0];
		$idInstitucion 	= $_SESSION['instituciones'][0];
		
		$sede		= Sedes::findOne( $idSede );
		
		$estadoData		= Estados::find()
							->where( 'id=1' )
							->all();
		$estados		= ArrayHelper::map( $estadoData, 'id', 'descripcion' );

        return $this->render('update', [
            'model' 	=> $model,
            'sede' 		=> $sede,
            'estados' 	=> $estados,
        ]);
    }

    /**
     * Deletes an existing Convocatorias model.
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
     * Finds the Convocatorias model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Convocatorias the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Convocatorias::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
