<?php

/**********
Versión: 001
Fecha: 12-03-2018
Desarrollador: Oscar David Lopez
Descripción: CRUD de Asignaturas
---------------------------------------
Modificaciones:
Fecha: 13-06-2018
Persona encargada: Edwin Molina
Cambios realizados: Se deja por defecto la institución y sede de la SESSION
---------------------------------------
Fecha: 12-03-2018
Persona encargada: Oscar David Lopez
Cambios realizados: - Modificaciones en todas las funciones
Cambios realizados: - Se crea la funcion actionListarInstituciones()
Cambios realizados: - Se modifica para que muestre solo los Sedes por bloques de la sede seleccionada en la vista
Cambios realizados: - Se modifica para que se deba seleccionar la institucion y la sede

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
use app\models\SedesBloques;
use app\models\SedesBloquesBuscar;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\models\Bloques;
use app\models\Sedes;
use yii\helpers\ArrayHelper;

/**
 * SedesBloquesController implements the CRUD actions for SedesBloques model.
 */
class SedesBloquesController extends Controller
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

	//funcion para renderizar la vista de listarInstituciones
	public function actionListarInstituciones( $idInstitucion = 0, $idSedes = 0 )
    {
        return $this->render('listarInstituciones',[
			'idSedes' 		=> $idSedes,
			'idInstitucion' => $idInstitucion,
		] );
    }

	
	
    /**
     * Lists all SedesBloques models.
     * @return mixed
     */
    
	//cambio de la funcion a que reciba 2 parametros, que sirven para 
	//tener control sobre la vista listarInstituciones que siempre redireccione a esa vista
	// public function actionIndex($idInstitucion = 0, $idSedes = 0)
	public function actionIndex()
    {
		$idInstitucion 	= $_SESSION['instituciones'][0];
		$idSedes 		= $_SESSION['sede'][0];

		
		// Si existe id sedes e institución se muestra la listas de todas las jornadas correspondientes
		if( $idInstitucion != 0 && $idSedes != 0 )
		{
		
			$searchModel = new SedesBloquesBuscar();
			$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
			$dataProvider->query->andwhere( 'id_sedes='.$idSedes);

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
     * Displays a single SedesBloques model.
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
     * Creates a new SedesBloques model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
	
	//recibe 2 parametros que sirve para la miga de pan
	//se consultan los bloques ya que se sabe cual es la sede para su asociacion
	//los bloques se muestran en lista (select)
    public function actionCreate($idSedes, $idInstitucion)
    {
		$bloques = new Bloques(); 
		$bloques = $bloques->find()->all();
		$bloques = ArrayHelper::map($bloques, 'id','descripcion');
		
        $model = new SedesBloques();
		
		//se consulta si esa cambinación de id_bloques e id_sedes ya existe
		//si existe no se guarda no los datos		
        if ($model->load(Yii::$app->request->post()) ) 
		{	
			$idSedesP	= $_POST['SedesBloques']['id_sedes'];
			$idBloquesP	= $_POST['SedesBloques']['id_bloques'];
			
			$sedesbloques = new SedesBloques(); 
			$sedesbloques = $sedesbloques->find()
			->where('id_sedes='.$idSedesP)
			->andwhere('id_bloques='.$idBloquesP)
			->all();
			$sedesbloques = ArrayHelper::map($sedesbloques, 'id_bloques','id_sedes');
						
			if(count($sedesbloques)==0)
			{
				$model->save();
				return $this->redirect(['view', 'id' => $model->id]);
			}
			else
			{
				echo "<script>alert('La sede ya tiene ese bloque asociado');</script>";
			}
			   
        }
		
        return $this->render('create', [
            'model' => $model,
			'bloques'=>$bloques,
			'idSedes'=>$idSedes, 
			'idInstitucion'=>$idInstitucion,

        ]);
    }

    /**
     * Updates an existing SedesBloques model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
	 
	//se consultan los bloques ya que se sabe cual es la sede para su asociacion
	//los bloques se muestran en lista (select)
    public function actionUpdate($id)
    {
		
		$bloques = new Bloques(); 
		$bloques = $bloques->find()->all();
		$bloques  = ArrayHelper::map($bloques, 'id','descripcion');
				
        $model = $this->findModel($id);

		//se consulta si esa cambinación de id_bloques e id_sedes ya existe
		//si existe no se guarda no los datos
        if ($model->load(Yii::$app->request->post()) ) 
		{	
			$idSedesP	= $_POST['SedesBloques']['id_sedes'];
			$idBloquesP	= $_POST['SedesBloques']['id_bloques'];
			
			$sedesbloques = new SedesBloques(); 
			$sedesbloques = $sedesbloques->find()
			->where('id_sedes='.$idSedesP)
			->andwhere('id_bloques='.$idBloquesP)
			->all();
			$sedesbloques = ArrayHelper::map($sedesbloques, 'id_bloques','id_sedes');
						
			if(count($sedesbloques)==0)
			{
				$model->save();
				return $this->redirect(['view', 'id' => $model->id]);
			}
			else
			{
				echo "<script>alert('La sede ya tiene ese bloque asociado');</script>";
			}
			   
        }

        return $this->render('update', [
            'model' => $model,
			'bloques'=>$bloques,
			'idSedes'=>$model->id_sedes,
        ]);
    }

    /**
     * Deletes an existing SedesBloques model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
	 //se redirecciona al index con idInstitucion e idSedes
    public function actionDelete($id)
    {
       
		$model=$this->findModel($id);
		
		$sedes = new Sedes();
		$sedes = $sedes->find()->where('id='.$model->id_sedes)->all();
		$sedes = ArrayHelper::map($sedes,'descripcion','id_instituciones');
		$nombreSede = key($sedes);
		$idInstitucion = $sedes[$nombreSede];
		
		$model->delete();
		// $this->findModel($id)->delete();
						
		return $this->redirect(['index', 'idInstitucion' => $idInstitucion,'idSedes'=>$model->id_sedes]);	
        
		
    }

    /**
     * Finds the SedesBloques model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return SedesBloques the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SedesBloques::findOne($id)) !== null) {
            return $model;
        }
		//se cambia el texto cuando la pagina no existe
        throw new NotFoundHttpException('La páguina requerida no está disponible.');
    }
}
