<?php

namespace app\controllers;

if(@$_SESSION['sesion']=="si")
{ 
	// echo $_SESSION['nombre'];
} 
//si no tiene sesion se redirecciona al login
else
{
	echo "<script> window.location=\"index.php?r=site%2Flogin\";</script>";
	die;
}

use Yii;
use app\models\DimensionOpcionesSeguimientoDirectivos;
use app\models\DimensionOpcionesSeguimientoDirectivosBuscar;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\models\Parametro;
use app\models\Personas;
use app\models\Instituciones;
use yii\helpers\ArrayHelper;

/**
 * DimensionOpcionesSeguimientoDirectivosController implements the CRUD actions for DimensionOpcionesSeguimientoDirectivos model.
 */
class DimensionOpcionesSeguimientoDirectivosController extends Controller
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
     * Lists all DimensionOpcionesSeguimientoDirectivos models.
     * @return mixed
     */
    public function actionIndex()
    {
		$sede 			= $_SESSION['sede'][0];
		$institucion	= $_SESSION['instituciones'][0];
		
        $searchModel = new DimensionOpcionesSeguimientoDirectivosBuscar();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$dataProvider->query
			->andWhere( 'estado=1' )
			->orderby( 'id_tipo_dimension' );
		
		$dataInstituciones = Instituciones::find()
								->where( 'id='.$institucion )
								->all();
						
		$instituciones	= ArrayHelper::map( $dataInstituciones, 'id', 'descripcion' );
		
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
						
		$dimensiones	= ArrayHelper::map( $dataDimensiones, 'id', 'descripcion' );
		
		
		$dataDocentes		= Personas::find()
								->select( "personas.id, ( personas.nombres || ' ' || personas.apellidos ) as nombres" )
								->innerJoin( 'perfiles_x_personas pp', 'pp.id_personas=personas.id' )
								->innerJoin( 'perfiles_x_personas_institucion ppi', 'ppi.id_perfiles_x_persona=pp.id' )
								->where( 'pp.estado=1' )
								->andWhere( 'ppi.estado=1' )
								->andWhere( 'personas.estado=1' )
								->andWhere( 'ppi.id_institucion='.$institucion )
								->all();
		
		$docentes	= ArrayHelper::map( $dataDocentes, 'id', 'nombres' );
        
		return $this->render('index', [
            'searchModel' 	=> $searchModel,
            'dataProvider' 	=> $dataProvider,
            'parametros' 	=> $parametros,
            'dimensiones' 	=> $dimensiones,
            'docentes' 		=> $docentes,
            'instituciones' => $instituciones,
        ]);
    }

    /**
     * Displays a single DimensionOpcionesSeguimientoDirectivos model.
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
     * Creates a new DimensionOpcionesSeguimientoDirectivos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DimensionOpcionesSeguimientoDirectivos();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing DimensionOpcionesSeguimientoDirectivos model.
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
     * Deletes an existing DimensionOpcionesSeguimientoDirectivos model.
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
     * Finds the DimensionOpcionesSeguimientoDirectivos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return DimensionOpcionesSeguimientoDirectivos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DimensionOpcionesSeguimientoDirectivos::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
