<?php

/**********
Versión: 001
Fecha: 06-03-2018
Desarrollador: Edwin Molina Grisales
Descripción: CRUD de sedes-jornadas
---------------------------------------
Modificaciones:
Fecha: 07-06-2018
Persona encargada: Edwin MG
Cambios realizados: Se quita los select de institucion y sede se deja los datos por defecto que vienen de _SESSION
---------------------------------------
Fecha: 06-03-2018
Persona encargada: Edwin Molina Grisales
Cambios realizados: Se crea filtro de sedes por instituciones y a todas las vistas(create, update, view e index) se envían el id de sedes e instituciones
					para que siempre muestre los datos correspondientes a estos
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
use app\models\SedesJornadas;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


use app\models\Sedes;
use app\models\Jornadas;
use app\models\Instituciones;
use yii\helpers\ArrayHelper;
/**
 * SedesJornadasController implements the CRUD actions for SedesJornadas model.
 */
class SedesJornadasController extends Controller
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
     * Lists all SedesJornadas models.
     * @return mixed
     */
    public function actionListarInstituciones( $idInstitucion = 0, $idSedes = 0 )
    {
        return $this->render('listarInstituciones',[
			'idSedes' 		=> $idSedes,
			'idInstitucion' => $idInstitucion,
		] );
    }


	// public function actionIndex( $idInstitucion = 0, $idSedes = 0 )
	public function actionIndex()
    {
		$idInstitucion 	= $_SESSION['instituciones'][0];
		$idSedes 		= $_SESSION['sede'][0];
		
		// Si existe id sedes e institución se muestra la listas de todas las jornadas correspondientes
		if( $idInstitucion != 0 && $idSedes != 0 ){
			
			$dataProvider = new ActiveDataProvider([
				'query' => SedesJornadas::find()->where( 'id_sedes='.$idSedes ),
			]);
			
			return $this->render('index', [
				'dataProvider'  => $dataProvider,
				'idSedes' 		=> $idSedes,
				'idInstitucion' => $idInstitucion,
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
     * Displays a single SedesJornadas model.
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
     * Creates a new SedesJornadas model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($idSedes, $idInstitucion)
    {
		
		//Busco todas las jornadas disponibles
		$jornadasTable 	= new Jornadas();
		$dataJornadas	= $jornadasTable->find()->all();
		$jornadas		= ArrayHelper::map( $dataJornadas, 'id', 'descripcion' );
		
		//listo solo la sede que ya ha sido seleccionada desde la vista listarInstituciones
		$sedesTable 	= new Sedes();
		$dataSedes	 	= $sedesTable->find()->where( 'id='.$idSedes )->all();
		$sedes		 	= ArrayHelper::map( $dataSedes, 'id', 'descripcion' );
		
        $model = new SedesJornadas();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model'			=> $model,
            'jornadas' 		=> $jornadas,
            'sedes' 		=> $sedes,
			'idSedes' 		=> $idSedes,
			'idInstitucion' => $idInstitucion,
        ]);
    }

    /**
     * Updates an existing SedesJornadas model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        
		$model = $this->findModel($id);
		
		//Se busca todas las jornadas disponibles
		$jornadasTable 	= new Jornadas();
		$dataJornadas	= $jornadasTable->find()->all();
		$jornadas		= ArrayHelper::map( $dataJornadas, 'id', 'descripcion' );
		
		//Consulto la sede seleccionada desde la vista listarInstituciones
		$sedesTable 	= new Sedes();
		$dataSedes	 	= $sedesTable->find()->where( 'id='.$model->id_sedes )->all();
		$sedes		 	= ArrayHelper::map( $dataSedes, 'id', 'descripcion' );
		

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' 	=> $model,
            'jornadas' 	=> $jornadas,
            'sedes' 	=> $sedes,
        ]);
    }

    /**
     * Deletes an existing SedesJornadas model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
		
		//Tomo los datos del modelo para enviar a la vista el id de sedes y de instituciones
		
		//Creo modelo sedes para encontrar el id de instituciones
		$modelSedes = Sedes::findOne( $model->id_sedes );
		
		//creo modelo instituciones con el id correspondiente tomado de sedes para encontrar el id de instituciones
		$modelInstitucion = Instituciones::findOne( $modelSedes->id_instituciones );
		
        $model = $model->delete();

		//A la vista index le envia el id de sedes y de instituciones
        return $this->redirect(['index', 'idInstitucion' => $modelInstitucion->id, 'idSedes' => $modelSedes->id ]);
    }

    /**
     * Finds the SedesJornadas model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return SedesJornadas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SedesJornadas::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
