<?php
/**********
Versión: 001
---------------------------------------
Fecha: 10-06-2018
Persona encargada: Edwin MG
Cambios realizados: Se quita los select de institucion y sede se deja los datos por defecto que vienen de _SESSION
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
use app\models\SedesAreasEnsenanza;
use app\models\SedesAreasEnsenanzaBuscar;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


use app\models\AreasEnsenanza;
use app\models\Instituciones;
use app\models\Sedes;
use yii\helpers\ArrayHelper;

/**
 * SedesAreasEnsenanzaController implements the CRUD actions for SedesAreasEnsenanza model.
 */
class SedesAreasEnsenanzaController extends Controller
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
     * Lists all SedesAreasEnsenanza models.
     * @return mixed
     */
    // public function actionIndex( $idInstitucion = 0, $idSedes = 0 )
    public function actionIndex()
    {
		$idInstitucion 	= $_SESSION['instituciones'][0];
		$idSedes 		= $_SESSION['sede'][0];
		
		if( $idInstitucion != 0 && $idSedes != 0 )
		{
			$modelSedes 		= Sedes::findOne($idSedes);
			$modelInstitucion 	= Instituciones::findOne($idInstitucion);
			
			$searchModel = new SedesAreasEnsenanzaBuscar();
			$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
			$dataProvider ->query->andWhere( 'id_sedes='.$idSedes ); 

			return $this->render('index', [
				'searchModel' 		=> $searchModel,
				'dataProvider' 		=> $dataProvider,
				'modelInstitucion' 	=> $modelInstitucion,
				'modelSedes' 		=> $modelSedes,
			]);
		}
		else{
			return $this->render('listarInstituciones', [
				'idInstitucion' => $idInstitucion,
				'idSedes' 		=> $idSedes,
			]);
		}
    }

    /**
     * Displays a single SedesAreasEnsenanza model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
		$model				= $this->findModel($id);
		$modelSedes 		= Sedes::findOne($model->id_sedes);
		$modelInstitucion 	= Instituciones::findOne($modelSedes->id_instituciones);
		
        return $this->render('view', [
            'model' 			=> $model,
            'modelSedes' 		=> $modelSedes,
            'modelInstitucion'	=> $modelInstitucion,
        ]);
    }

    /**
     * Creates a new SedesAreasEnsenanza model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate( $idSedes )
    {
		$modelSedes 	 = Sedes::findOne( $idSedes );
		$modelInstitucion= Instituciones::findOne( $modelSedes->id_instituciones );
		
		$dataSedes		= Sedes::find()->where( 'estado=1' )->andWhere( 'id='.$idSedes )->all();
		$sedes			= ArrayHelper::map( $dataSedes, 'id', 'descripcion' );
		
		$dataAreas		= AreasEnsenanza::find()->where( 'estado=1' )->all();
		$areas			= ArrayHelper::map( $dataAreas, 'id', 'descripcion' );
		
        $model = new SedesAreasEnsenanza();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' 			=> $model,
            'modelSedes' 		=> $modelSedes,
            'modelInstitucion' 	=> $modelInstitucion,
			'sedes' 			=> $sedes,
            'areas'				=> $areas,
        ]);
    }

    /**
     * Updates an existing SedesAreasEnsenanza model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		
		$modelSedes 	 = Sedes::findOne( $model->id_sedes );
		$modelInstitucion= Instituciones::findOne( $modelSedes->id_instituciones );
		
		$dataSedes		= Sedes::find()->where( 'estado=1' )->andWhere( 'id='.$model->id_sedes )->all();
		$sedes			= ArrayHelper::map( $dataSedes, 'id', 'descripcion' );
		
		$dataAreas		= AreasEnsenanza::find()->where( 'estado=1' )->all();
		$areas			= ArrayHelper::map( $dataAreas, 'id', 'descripcion' );

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' 			=> $model,
            'modelSedes' 		=> $modelSedes,
            'modelInstitucion' 	=> $modelInstitucion,
            'sedes' 			=> $sedes,
            'areas'				=> $areas,
        ]);
    }

    /**
     * Deletes an existing SedesAreasEnsenanza model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
		$model = $this->findModel($id);
		
		$modelSedes 		= Sedes::findOne( $model->id_sedes );
		$modelInstitucion 	= Instituciones::findOne( $modelSedes->id_instituciones );
		
        $model->delete();

        return $this->redirect(['index', 'idInstitucion' => $modelInstitucion->id, 'idSedes' => $modelSedes->id ]);
    }

    /**
     * Finds the SedesAreasEnsenanza model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return SedesAreasEnsenanza the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SedesAreasEnsenanza::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
