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
use app\models\SedesNiveles;
use app\models\SedesNivelesBuscar;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\models\Sedes;
use app\models\Instituciones;
use app\models\Niveles;
use yii\helpers\ArrayHelper;


/**
 * SedesNivelesController implements the CRUD actions for SedesNiveles model.
 */
class SedesNivelesController extends Controller
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
     * Lists all SedesNiveles models.
     * @return mixed
     */
    // public function actionIndex( $idSedes = 0, $idInstitucion = 0 )
    public function actionIndex( $idSedes = 0, $idInstitucion = 0 )
    {
		$idInstitucion 	= $_SESSION['instituciones'][0];
		$idSedes 		= $_SESSION['sede'][0];
		
		if( $idSedes != 0 ){
			
			$modelSedes 	  = Sedes::findOne( $idSedes );
			$modelInstitucion = Instituciones::findOne( $idInstitucion );
			
			$searchModel = new SedesNivelesBuscar();
			$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
			$dataProvider->query->andWhere( 'id_sedes='.$idSedes );

			return $this->render('index', [
				'searchModel' 		=> $searchModel,
				'dataProvider' 		=> $dataProvider,
				'modelInstitucion' 	=> $modelInstitucion,
				'modelSedes' 		=> $modelSedes,
			]);
		}
		else{
			// Si el id de institucion o de sedes es 0 se llama a la vista listarInstituciones
			 return $this->render('listarInstituciones',[
				'idSedes' 		=> $idSedes,
				'idInstitucion' => $idInstitucion,
			] );
		}
    }

    /**
     * Displays a single SedesNiveles model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
		$model 			 = $this->findModel($id);
		
		$modelSedes 	  = Sedes::findOne( $model->id_sedes );
		$modelInstitucion = Instituciones::findOne( $modelSedes->id_instituciones );
		
        return $this->render('view', [
            'model' 			=> $model,
            'modelSedes' 		=> $modelSedes,
            'modelInstitucion' 	=> $modelInstitucion,
        ]);
    }

    /**
     * Creates a new SedesNiveles model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate( $idSedes = 0 )
    {
		$modelSedes 	  = Sedes::findOne( $idSedes );
		$modelInstitucion = Instituciones::findOne( $modelSedes->id_instituciones );
		
		$dataSedes	  = Sedes::find()->where( 'id='.$idSedes )->all();
		$sedes		  = ArrayHelper::map( $dataSedes, 'id', 'descripcion' );
		
		$dataNiveles  = Niveles::find()->where( 'estado=1' )->all();
		$niveles	  = ArrayHelper::map( $dataNiveles, 'id', 'descripcion' );
		
        $model = new SedesNiveles();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' 			=> $model,
            'modelSedes' 		=> $modelSedes,
            'modelInstitucion' 	=> $modelInstitucion,
            'sedes' 			=> $sedes,
            'niveles' 			=> $niveles,
        ]);
    }

    /**
     * Updates an existing SedesNiveles model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		
		$modelSedes 	  = Sedes::findOne( $model->id_sedes );
		$modelInstitucion = Instituciones::findOne( $modelSedes->id_instituciones );
		
		$dataSedes	  = Sedes::find()->where( 'id='.$modelSedes->id )->all();
		$sedes		  = ArrayHelper::map( $dataSedes, 'id', 'descripcion' );
		
		$dataNiveles  = Niveles::find()->where( 'estado=1' )->all();
		$niveles	  = ArrayHelper::map( $dataNiveles, 'id', 'descripcion' );

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' 			=> $model,
			'modelSedes' 		=> $modelSedes,
            'modelInstitucion' 	=> $modelInstitucion,
            'sedes' 			=> $sedes,
            'niveles' 			=> $niveles,
        ]);
    }

    /**
     * Deletes an existing SedesNiveles model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
		$model = $this->findModel($id);
		
		//Busco los modelos de sedes instituciones
		$modelSedes 	  = Sedes::findOne( $model->id_sedes );
		$modelInstitucion = Instituciones::findOne( $modelSedes->id_instituciones );
		
        $this->findModel($id)->delete();

		//envio al index el id de la institucion y la sedes
        return $this->redirect(['index', 'idSedes' => $modelSedes->id, 'idInstitucion' => $modelInstitucion->id ]);
    }

    /**
     * Finds the SedesNiveles model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return SedesNiveles the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SedesNiveles::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
