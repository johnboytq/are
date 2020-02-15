<?php
/**********
Versión: 001
---------------------------------------
Fecha: 07-06-2018
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
use app\models\Aulas;
use app\models\AulasBuscar;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\models\Sedes;
use app\models\TiposAulas;
use yii\helpers\ArrayHelper;

/**
 * AulasController implements the CRUD actions for Aulas model.
 */
class AulasController extends Controller
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
     * Lists all Aulas models.
     * @return mixed
     */
    // public function actionIndex( $idInstitucion = 0, $idSedes = 0 )
    public function actionIndex()
    {
		$idInstitucion 	= $_SESSION['instituciones'][0];
		$idSedes 		= $_SESSION['sede'][0];
		
		if( $idInstitucion != 0 && $idSedes != 0 ){
			
			$aulasSearchModel= new AulasBuscar();
			$dataProvider 	 = $aulasSearchModel->search(Yii::$app->request->queryParams);
			$dataProvider->query->andWhere( 'id_sedes='.$idSedes ); 
			
			// $dataProvider = new ActiveDataProvider([
				// 'query' => Aulas::find()->where( 'id_sedes='.$idSedes ),
			// ]);

			return $this->render('index', [
				'dataProvider' 	=> $dataProvider,
				'searchModel' 	=> $aulasSearchModel,
				'idInstitucion' => $idInstitucion,
				'idSedes' 		=> $idSedes,
			]);
		}
		else{
			return $this->render('listarInstituciones', [
				'idInstitucion' => $idInstitucion,
				'idSedes' => $idSedes,
			]);
		}
    }

    /**
     * Displays a single Aulas model.
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
     * Creates a new Aulas model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate( $idSedes = 0 )
    {
		
		$sedesTable 		= new Sedes();
		$dataSedes	 		= $sedesTable->find()->where( 'id='.$idSedes )->andWhere( 'estado=1' )->all();
		$sedes				= ArrayHelper::map( $dataSedes, 'id', 'descripcion' );
		
		$tiposAulasTable 	= new TiposAulas();
		$dataTiposAulas	 	= $tiposAulasTable->find()->all();
		$tiposAulas			= ArrayHelper::map( $dataTiposAulas, 'id', 'descripcion' );
		
        $model = new Aulas();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' 	 => $model,
            'sedes' 	 => $sedes,
            'tiposAulas' => $tiposAulas,
            'idSedes' 	 => $idSedes,
        ]);
    }

    /**
     * Updates an existing Aulas model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		
		$sedesTable 		= new Sedes();
		$dataSedes	 		= $sedesTable->find()->where( 'id='.$model->id_sedes )->all();
		$sedes				= ArrayHelper::map( $dataSedes, 'id', 'descripcion' );
		
		$tiposAulasTable 	= new TiposAulas();
		$dataTiposAulas	 	= $tiposAulasTable->find()->all();
		$tiposAulas			= ArrayHelper::map( $dataTiposAulas, 'id', 'descripcion' );
		

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' 	 => $model,
			'sedes' 	 => $sedes,
            'tiposAulas' => $tiposAulas,
        ]);
    }

    /**
     * Deletes an existing Aulas model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
		$model 			= $this->findModel($id);
		
		$modelSedes 	= Sedes::findOne( $model->id_sedes );
		
		$idInstitucion  = $modelSedes->id_instituciones;
		$idSedes 		= $modelSedes->id;
		
        $this->findModel($id)->delete();

        return $this->redirect(['index', 'idInstitucion' => $idInstitucion, 'idSedes' => $idSedes ]);
    }

    /**
     * Finds the Aulas model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Aulas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Aulas::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
