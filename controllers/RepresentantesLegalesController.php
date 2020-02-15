<?php
/**********
Versión: 001
Fecha: 27-03-2018
Desarrollador: Oscar David Lopez
Descripción: CRUD de Representantes Legales (Estudiantes)
---------------------------------------
Modificaciones:
Fecha: 27-03-2018
Persona encargada: Oscar David Lopez
Cambios realizados: - Ajustes a las diferentes funciones del CRUD
---------------------------------------
Modificaciones:
Fecha: 27-03-2018
Persona encargada: Oscar David Lopez
Cambios realizados: - Cambio en la funcion actionDelete
---------------------------------------
Fecha: 25-04-2018
Persona encargada: Viviana Rodas
Cambios realizados: - En la accion create y update se listan las personas con perfil de estudiante y las personas con perfil de representante legal
					  Ya no se guarda en perfiles por persona, solo en estudiantes y representantes legales
					  En el delete ya se borra en representantes legales y en estudiantes se inactiva, en perfiles por persona no se hace nada
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
use	yii\helpers\ArrayHelper;


use app\models\RepresentantesLegales;
use app\models\RepresentantesLegalesBuscar;
use app\models\Personas;
use app\models\Estudiantes;
use app\models\PerfilesXPersonas;
use app\models\PerfilesXPersonasBuscar;


/**
 * RepresentantesLegalesController implements the CRUD actions for RepresentantesLegales model.
 */
class RepresentantesLegalesController extends Controller
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
     * Lists all RepresentantesLegales models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RepresentantesLegalesBuscar();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single RepresentantesLegales model.
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
     * Creates a new RepresentantesLegales model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        //se consultan las personas que esten en la base de datos		
		// $personas 	= Personas::find()->select( "id, ( nombres || ' ' || apellidos ) nombres" )->where( 'estado=1' )->all();
		// $personas 		= ArrayHelper::map( $personas, 'id' , 'nombres' );
		
		/**
		* Concexion a la db, llenar select de estudiantes
		*/
		//variable con la conexion a la base de datos  pe.id=11 es el perfil estudiante
		$connection = Yii::$app->getDb();
		
		$command = $connection->createCommand("select pp.id as id, concat(p.nombres,' ',p.apellidos) as nombres
												from personas as p, perfiles_x_personas as pp, perfiles as pe
												where p.id= pp.id_personas
												and p.estado=1
												and pp.id_perfiles=pe.id
												and pe.id=11
												and pe.estado=1
												");
		$result = $command->queryAll();
		//se formatea para que lo reconozca el select
		foreach($result as $key){
			$estudiantes[$key['id']]=$key['nombres'];
		}
		
		/**
		* Concexion a la db, llenar select de representantes legales
		*/
		//variable con la conexion a la base de datos  pe.id=12 es el perfil representante legal
		$connection = Yii::$app->getDb();
		
		$command = $connection->createCommand("select p.id as id, concat(p.nombres,' ',p.apellidos) as nombres
												from personas as p, perfiles_x_personas as pp, perfiles as pe
												where p.id= pp.id_personas
												and p.estado=1
												and pp.id_perfiles=pe.id
												and pe.id=12
												and pe.estado=1
												");
		$result = $command->queryAll();
		//se formatea para que lo reconozca el select
		$representantesLegales=array();
		foreach($result as $key){
			$representantesLegales[$key['id']]=$key['nombres'];
		}
		
		
		// //para el agregar estudiante y representante Legal se muestran todas las personas de la base de datos
		// $estudiantes			= $personas;
		// $representantesLegales	= $personas;
		
				
		$model = new RepresentantesLegales();

		
		
        if( $model->load(Yii::$app->request->post()) && $model->save() ){
			$modelEstudiantes 				= new Estudiantes();
			
			$modelEstudiantes->id_perfiles_x_personas = $model->id_perfiles_x_personas;
			$modelEstudiantes->estado = 1;
			$modelEstudiantes->save();
			return $this->redirect(['view', 'id' => $model->id]);
			
        }

        return $this->render('create', [
            'model' 					=> $model,
			'estudiantes'				=> $estudiantes,
			'representantesLegales'		=> $representantesLegales,
			// 'modelRepresentantesLegales'=> $modelRepresentantesLegales,
			
			
        ]);
    }

    /**
     * Updates an existing RepresentantesLegales model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
		 $model = $this->findModel($id);
		
		//consulta el nombre de la persona partiendo desde la tabla representantes_legales ESTUDIATE
		$connection = Yii::$app->getDb();
		$command = $connection->createCommand("
			select pp.id as id, concat(p.nombres,' ',p.apellidos) as nombres
												from personas as p, perfiles_x_personas as pp, perfiles as pe
												where p.id= pp.id_personas
												and p.estado=1
												and pp.id_perfiles=pe.id
												and pe.id=11
												and pe.estado=1
		
		");
		$result = $command->queryAll();
		
		//se envia el estudiantes guardado, no se edita el estudiante solo el representante Legal el estudiante
		foreach($result as $key){
			$estudiantes[$key['id']]=$key['nombres'];
		}
		
		
		
		//----------
		
		//consulta el nombre de la persona partiendo desde la tabla representantes_legales REPRESENTANTE LEGAL
		$connection = Yii::$app->getDb();
		$command = $connection->createCommand("select p.id as id, concat(p.nombres,' ',p.apellidos) as nombres
												from personas as p, perfiles_x_personas as pp, perfiles as pe
												where p.id= pp.id_personas
												and p.estado=1
												and pp.id_perfiles=pe.id
												and pe.id=12
												and pe.estado=1
												");
		$result = $command->queryAll();
		
		//se envia el estudiantes guardado, no se edita el estudiante solo el representante Legal el estudiante
		$representantesLegales=array();
		foreach($result as $key){
			$representantesLegales[$key['id']]=$key['nombres'];
		}
		// print_r($result);
		
		
		// //se consultan las personas que esten en la base de datos		
		// $personas 	= Personas::find()->select( "id, ( nombres || ' ' || apellidos ) nombres" )->where( 'estado=1' )->all();
		// $personas 		= ArrayHelper::map( $personas, 'id' , 'nombres' );
		
		// //para editar el representante Legal se muestran todas las personas de la base de datos
		// // $estudiantes			= $personas;
		// $representantesLegales	= $personas;
		
				
		$modelRepresentantesLegales = new RepresentantesLegales();
		
		
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' 					=> $model,
			'estudiantes'				=> $estudiantes,
			'representantesLegales'		=> $representantesLegales,
			'modelRepresentantesLegales'=> $modelRepresentantesLegales,

        ]);
    }

    /**
     * Deletes an existing RepresentantesLegales model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
		
		$model = $this->findModel($id);
		//id de PerfilesXPersonas que esta en la tabla representantes_legales para borrar el registro
		$idPerfilesXPersonas = $model->id_perfiles_x_personas;
		
		$modelEstudiantes = Estudiantes::findOne($idPerfilesXPersonas);
		$modelEstudiantes->estado = 2;
		$modelEstudiantes->update(false);
		
		
		// //se borra el registro de PerfilesXPersonas que tenga el id representantes_legales.id_perfiles_x_personas
		// $modelPerfilesXPersonas = PerfilesXPersonas::findOne($idPerfilesXPersonas);
		// $modelPerfilesXPersonas->delete();
		// // print_r($idPerfilesXPersonas);
		// // die;	
		
		//con esto se elimina en representantes legales
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the RepresentantesLegales model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return RepresentantesLegales the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RepresentantesLegales::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
