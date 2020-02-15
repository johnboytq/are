<?php
/**********
Versión: 001
Fecha: 10-03-2018
Desarrollador: Oscar David Lopez
Descripción: CRUD de Asignaturas
---------------------------------------
Modificaciones:
Fecha: 10-06-2018
Persona encargada: Edwin MG
Cambios realizados: Se quita los select de institucion y sede se deja los datos por defecto que vienen de _SESSION
---------------------------------------
Fecha: 01-05-2018
Persona encargada: Edwin Molina Grisales
Cambios realizados: Se agrega campo AREAS DE ENSEÑANZA al CRUD
---------------------------------------
Modificaciones:
Fecha: 10-03-2018
Persona encargada: Oscar David Lopez
Cambios realizados: - cambios en todas las funciones y 
se agrega el listar dependiente de institucion y sede
se añade funcion actionListarInstituciones
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
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

use app\models\Asignaturas;
use app\models\AsginaturasBuscar;
use app\models\Estados;
use app\models\Sedes;
use app\models\Instituciones;
use app\models\AreasEnsenanza;




/**
 * AsignaturasController implements the CRUD actions for Asignaturas model.
 */
class AsignaturasController extends Controller
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
     * Lists all Asignaturas models.
     * @return mixed
     */
	 //recibe 2 parametros con la intencion de filtrar por institucion y por sede
    // public function actionIndex($idInstitucion = 0, $idSedes = 0)
    public function actionIndex()
    {
		$idInstitucion 	= $_SESSION['instituciones'][0];
		$idSedes 		= $_SESSION['sede'][0];
		
		// Si existe id sedes e institución se muestra la listas de todas las asignaturas correspondientes
		if( $idInstitucion != 0 && $idSedes != 0 )
		{
			
			//instancia del controlador sedes 
			$sedes = new Sedes();
			//buscar todas las sedes 
			$sedes = $sedes->find()->all();
			//formateo del array 
			$sedes = ArrayHelper::map($sedes,'id', 'descripcion' );
			
			
			$searchModel = new AsginaturasBuscar();
			$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
			//se agregar el andwhere( 'id_sedes='.$idSedes) para que las vista muestre solo las asignatura de la sede seleccionada
			$dataProvider->query->andwhere( 'id_sedes='.$idSedes);
			//y solo los que tengan estado activo
			$dataProvider->query->andwhere( 'estado=1');
				
			return $this->render('index', [
				'searchModel' => $searchModel,
				'dataProvider' => $dataProvider,
				'idSedes' 		=> $idSedes,
				'idInstitucion' => $idInstitucion,
				//se envia la variable sedes a la vista index para mostrar la descripcion de la sede en vez de su Id
				'sedes' 	=>$sedes,
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
     * Displays a single Asignaturas model.
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
     * Creates a new Asignaturas model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($idSedes, $idInstitucion)
    {
				
		//se selecciona el estado activo siempre se crea activo
		$estados = new Estados();
		$estados = $estados->find()->where('id=1')->all();
		$estados = ArrayHelper::map($estados,'id','descripcion');
		
		//se seleccionan solo la sede actual 
		$sedes = new Sedes();
		$sedes = $sedes->find()->where('id='.$idSedes)->all();
		$sedes = ArrayHelper::map($sedes,'id','descripcion');
		
		//se seleccionan solo la sede actual 
		$areas = new AreasEnsenanza();
		$areas = $areas->find()
					->innerJoin( 'sedes_areas_ensenanza sae', 'sae.id_areas_ensenanza=areas_ensenanza.id' )
					->where( 'estado=1' )
					->andWhere( 'sae.id_sedes='.$idSedes )
					->all();
		$areas = ArrayHelper::map($areas,'id','descripcion');
		
        $model = new Asignaturas();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' 	=> $model,
			'estados'	=> $estados,
			'sedes'		=> $sedes,
			'areas'		=> $areas,
			'idSedes'	=> $idSedes,
        ]);
    }

    /**
     * Updates an existing Asignaturas model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
		$model = $this->findModel($id);
		
		//se seleccionan todos los estados para mostrarlos en la vista 
		$estados = new Estados();
		$estados = $estados->find()->all();
		$estados = ArrayHelper::map($estados,'id','descripcion');
		
		//se seleccionan solo la sede actual para mostrar en la vista update
		$sedes = new Sedes();
		$sedes = $sedes->find()->where('id='.$model->id_sedes)->all();
		$sedes = ArrayHelper::map($sedes,'id','descripcion');
		
		//se seleccionan solo la sede actual 
		$areas = new AreasEnsenanza();
		$areas = $areas->find()
					->innerJoin( 'sedes_areas_ensenanza sae', 'sae.id_areas_ensenanza=areas_ensenanza.id' )
					->where( 'estado=1' )
					->andWhere( 'sae.id_sedes='.$model->id_sedes )
					->all();
		$areas = ArrayHelper::map($areas,'id','descripcion');
       
		
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' 	=> $model,
			'estados'	=> $estados,
			'sedes'		=> $sedes,
			'areas'		=> $areas,
        ]);
    }

    /**
     * Deletes an existing Asignaturas model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
	 
	 //Se cambia para que no borre, en cambio actualiza el campo estado a 2;
    public function actionDelete($id)
    {
		
		$model = $this->findModel($id);
		$idSedes= $model->id_sedes;
		//variable con la conexion a la base de datos
		$connection = Yii::$app->getDb();
		//saber el id de la sede para redicionar al index correctamente
		$command = $connection->createCommand("
		SELECT i.id
		FROM instituciones as i,sedes as s
		WHERE s.id_instituciones = i.id
		and s.id = $idSedes
		");
		$result = $command->queryAll();
		$idInstituciones = $result[0]['id'];
		
		$model = Asignaturas::findOne($id);
		$model->estado = 2;
		$idInstitucion = $model->id;
		$model->update(false);

		return $this->redirect(['index', 'idInstitucion' => $idInstituciones,'idSedes'=>$idSedes]);		
		
    }

    /**
     * Finds the Asignaturas model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Asignaturas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Asignaturas::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('La página que está solicitando no existe.');
    }
}
