<?php
/**********
Versión: 001
Fecha: 16-03-2018
Desarrollador: Oscar David Lopez
Descripción: CRUD de AsignaturasNivelesSedes
---------------------------------------
Modificaciones:
Fecha: 10-06-2018
Persona encargada: Edwin MG
Cambios realizados: Se quita los select de institucion y sede se deja los datos por defecto que vienen de _SESSION
---------------------------------------
Fecha: 16-03-2018
Persona encargada: Oscar David Lopez
Cambios realizados: - se debe seleccionar la sede y la institucion
Solo muestra los peridos de la sede seleccionada
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
use app\models\Periodos;
use app\models\PeridosBuscar;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Sedes;
use app\models\Estados;
use app\models\Institucion;
use	yii\helpers\ArrayHelper;



/**
 * PeriodosController implements the CRUD actions for Periodos model.
 */
class PeriodosController extends Controller
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
	public function actionListarInstituciones( $idInstitucion = 0, $idSedes = 0 )
    {
        return $this->render('listarInstituciones',[
			'idSedes' 		=> $idSedes,
			'idInstitucion' => $idInstitucion,
		] );
    }

    /**
     * Lists all Periodos models.
     * @return mixed
     */
    // public function actionIndex($idInstitucion = 0, $idSedes = 0)
    public function actionIndex()
    {
		$idInstitucion 	= $_SESSION['instituciones'][0];
		$idSedes 		= $_SESSION['sede'][0];
		
		// Si existe id sedes e institución se muestra la listas de todas las jornadas correspondientes
		if( $idInstitucion != 0 && $idSedes != 0 )
		{
		
			$searchModel = new PeridosBuscar();
			$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
			$dataProvider->query->andwhere( 'id_sedes='.$idSedes);
			$dataProvider->query->andwhere( 'estado=1');

			return $this->render('index', [
				'searchModel' => $searchModel,
				'dataProvider' => $dataProvider,
				'idSedes' 	=> $idSedes,
				'idInstitucion' => $idInstitucion,
			]);
		}
		else
		{
			// Si el id de institucion o de sedes es 0 se llama a la vista listarInstituciones
			 return $this->render('listarInstituciones',[
				'idSedes' 		=> $idSedes,
				'idInstitucion' => $idInstitucion,
			] );
		}
    }

    /**
     * Displays a single Periodos model.
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
     * Creates a new Periodos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($idSedes, $idInstitucion)
    {
		//se muestra el valor del estado siempre activo
		$estados = new Estados();
		$estados = $estados->find()->where('id=1')->all();
		$estados = ArrayHelper::map($estados,'id','descripcion');
       
	   $model = new Periodos();

		
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
			'idSedes'=>$idSedes,
			'idInstitucion'=>$idInstitucion,
			'estados'=>$estados,
        ]);
    }

    /**
     * Updates an existing Periodos model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
		$model = $this->findModel($id);
		
		//se consultan los estados para mostrarlos en el campos estados como un lista
		$estados = new Estados();
		$estados = $estados->find()->all();
		$estados = ArrayHelper::map($estados,'id','descripcion');
				
		//se consulta el id de la sede para usarlo en la miga de pan
		$idSedes = $model->id_sedes;
		
		//consulta la sede por id para saber el id de la institucion
		$sede = new Sedes();
		$sede = $sede->find()->where('id='.$idSedes)->all();
		$idInstitucion = ArrayHelper::getColumn($sede, 'id_instituciones' );
		//se consulta el id de la institucion para usarlo en la miga de pan
		$idInstitucion=$idInstitucion[0];
 
				

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
			'estados'=>$estados,
			'idSedes'=>$idSedes,
			'idInstitucion'=>$idInstitucion,
        ]);
    }

    /**
     * Deletes an existing Periodos model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
		
		$model = $this->findModel($id);
		//se consulta el id de la sede para usarlo en la miga de pan
		$idSedes = $model->id_sedes;
		
		//consulta la sede por id para saber el id de la institucion
		$sede = new Sedes();
		$sede = $sede->find()->where('id='.$idSedes)->all();
		$idInstitucion = ArrayHelper::getColumn($sede, 'id_instituciones' );
		//se consulta el id de la institucion para usarlo como datos para que regrese correctamente al index
		$idInstitucion=$idInstitucion[0];
		$model = Periodos::findOne($id);
		$model->estado = 2;
		$model->update(false);
        // $this->findModel($id)->delete();
	
        return $this->redirect(['index', 'idInstitucion' => $idInstitucion,'idSedes'=>$idSedes]);		
    }

    /**
     * Finds the Periodos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Periodos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Periodos::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
