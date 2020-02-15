<?php
/**********
Versión: 001
Fecha: 27-03-2018
Desarrollador: Oscar David Lopez
Descripción: CRUD de Resultados Pruebas Externas
---------------------------------------
Modificaciones:
Fecha: 27-03-2018
Persona encargada: Oscar David Lopez
Cambios realizados: Creacion del las funciones estado y institucion
modificaciones en las funciones ActionCreate y ActionUpdate
Se muestran los resultado de la sede actual
---------------------------------------
**********/
namespace app\controllers;

use Yii;
use app\models\ResultadosPruebasExternas;
use app\models\ResultadosPruebasExternasBuscar;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\models\Estados;
use app\models\Instituciones;

use	yii\helpers\ArrayHelper;

/**
 * ResultadosPruebasExternasController implements the CRUD actions for ResultadosPruebasExternas model.
 */
class ResultadosPruebasExternasController extends Controller
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
     * Lists all ResultadosPruebasExternas models.
     * @return mixed
     */
    public function actionIndex()
    {
		$idInstitucion = $_SESSION['instituciones'][0];
		
        $searchModel = new ResultadosPruebasExternasBuscar();
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
     * Displays a single ResultadosPruebasExternas model.
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
     * Creates a new ResultadosPruebasExternas model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ResultadosPruebasExternas();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' 	=> $model,
			'estados'	=> $this->estados(),
			'institucion'	=> $this->institucion(),
        ]);
    }

    /**
     * Updates an existing ResultadosPruebasExternas model.
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
     * Deletes an existing ResultadosPruebasExternas model.
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
     * Finds the ResultadosPruebasExternas model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return ResultadosPruebasExternas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ResultadosPruebasExternas::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
