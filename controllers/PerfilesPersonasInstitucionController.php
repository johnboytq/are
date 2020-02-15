<?php
/**********
Versión: 001
Fecha: 25-04-2018
Desarrollador: Maria Viviana Rodas
Descripción: controlador de perfiles persona institucion
---------------------------------------
*/

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
use app\models\PerfilesPersonasInstitucion;
use app\models\PerfilesPersonasInstitucionBuscar;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\data\SqlDataProvider;
use app\models\Estados;
use app\models\Perfiles;
use app\models\PerfilesXPersonas;
use app\models\Instituciones;
use yii\helpers\Json;

/**
 * PerfilesPersonasInstitucionController implements the CRUD actions for PerfilesPersonasInstitucion model.
 */
class PerfilesPersonasInstitucionController extends Controller
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
     * Lists all PerfilesPersonasInstitucion models.
     * @return mixed
     */
    public function actionIndex()
    {
		$idInstitucion 	= $_SESSION['instituciones'][0];
		
        $searchModel = new PerfilesPersonasInstitucionBuscar();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$dataProvider ->query->andWhere("estado=1 and id_institucion = $idInstitucion "); 

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PerfilesPersonasInstitucion model.
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
     * Creates a new PerfilesPersonasInstitucion model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        
		 //se crea una instancia del modelo perfiles
		$perfilesTable 		 	= new Perfiles();
		//se traen los datos de perfiles
		$dataPerfiles		 	= $perfilesTable->find()->where( 'estado=1' )->all();
		//se guardan los datos en un array
		$perfiles	 	 	 	= ArrayHelper::map( $dataPerfiles, 'id', 'descripcion' );
		
		//se crea una instancia del modelo instituciones
		$institucionesTable 		 	= new Instituciones();
		//se traen los datos de estados
		$dataInstituciones		 	= $institucionesTable->find()->where( 'estado=1' )->all();
		//se guardan los datos en un array
		$instituciones	 	 	 	= ArrayHelper::map( $dataInstituciones, 'id', 'descripcion' );
		
		//Falta perfiles por persona

		//se crea una instancia del modelo estados
		$estadosTable 		 	= new Estados();
		//se traen los datos de estados
		$dataestados		 	= $estadosTable->find()->where( 'id=1' )->all();
		//se guardan los datos en un array
		$estados	 	 	 	= ArrayHelper::map( $dataestados, 'id', 'descripcion' );
		
		$perfilesSelected[0]['id'] = "";
        $PerfilesXPersonas[0]['id'] = "";
        $modificar= false;
		
		$model = new PerfilesPersonasInstitucion();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'perfilesTable' => $perfilesTable,
            'perfiles' => $perfiles,
            'instituciones' => $instituciones,
            'estados' => $estados,
			'perfilesSelected' => $perfilesSelected,
            'PerfilesXPersonas' => $PerfilesXPersonas,
            'modificar' => $modificar,
        ]);
    }

    /**
     * Updates an existing PerfilesPersonasInstitucion model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        //se crea una instancia del modelo perfiles
		$perfilesTable 		 	= new Perfiles();
		//se traen los datos de perfiles
		$dataPerfiles		 	= $perfilesTable->find()->where( 'estado=1' )->all();
		//se guardan los datos en un array
		$perfiles	 	 	 	= ArrayHelper::map( $dataPerfiles, 'id', 'descripcion' );
		
		//perfil seleccionado
		//variable con la conexion a la base de datos 
		$connection = Yii::$app->getDb();
		/**
		* Llenar select perfiles selected
		*/
		$command = $connection->createCommand("SELECT p.id, p.descripcion
											FROM public.perfiles_x_personas_institucion as ppi, perfiles as p, perfiles_x_personas as pp
											WHERE ppi.id_perfiles_x_persona = pp.id
											AND pp.id_perfiles = p.id
											and p.estado = 1
											and pp.estado = 1
											and ppi.estado = 1
											and ppi.id = $id");
		$perfilesSelected = $command->queryAll();
		
		
		/**
		* Llenar select perfiles  por personas selected
		*/
		$command = $connection->createCommand(" SELECT pp.id
											FROM public.perfiles_x_personas_institucion as ppi, perfiles as p, perfiles_x_personas as pp
											WHERE ppi.id_perfiles_x_persona = pp.id
											AND pp.id_perfiles = p.id
											and p.estado = 1
											and pp.estado = 1
											and ppi.estado = 1
											and ppi.id = $id");
		$PerfilesXPersonas = $command->queryAll();
		
		
		//se crea una instancia del modelo instituciones
		$institucionesTable 		 	= new Instituciones();
		//se traen los datos de estados
		$dataInstituciones		 	= $institucionesTable->find()->where( 'estado=1' )->all();
		//se guardan los datos en un array
		$instituciones	 	 	 	= ArrayHelper::map( $dataInstituciones, 'id', 'descripcion' );
		
		

		//se crea una instancia del modelo estados
		$estadosTable 		 	= new Estados();
		//se traen los datos de estados
		$dataestados		 	= $estadosTable->find()->all();
		//se guardan los datos en un array
		$estados	 	 	 	= ArrayHelper::map( $dataestados, 'id', 'descripcion' );
		
		$modificar = true;
		
		$model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
			'perfilesTable' => $perfilesTable,
            'perfiles' => $perfiles,
            'instituciones' => $instituciones,
            'estados' => $estados,
            'perfilesSelected' => $perfilesSelected,
            'PerfilesXPersonas' => $PerfilesXPersonas,
            'modificar' => $modificar,
			
			
        ]);
    }

    /**
     * Deletes an existing PerfilesPersonasInstitucion model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = PerfilesPersonasInstitucion::findOne($id);
		$model->estado = 2;
		$model->update(false);


        return $this->redirect(['index']);
    }

    /**
     * Finds the PerfilesPersonasInstitucion model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PerfilesPersonasInstitucion the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PerfilesPersonasInstitucion::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
	 /**
     * Esta funcion lista los perfiles por persona
     * 
     * @param Recibe id sedes nivel
     * @return la lista de asignaturas
     * @throws no tiene excepciones
     */		
  public function actionListarP($idPerfiles )
	{
		
		
		//variable con la conexion a la base de datos
		$connection = Yii::$app->getDb();
		//saber el id de la sede para redicionar al index correctamente
		$command = $connection->createCommand("SELECT pp.id, concat(p.nombres,' ',p.apellidos) as nombres
												FROM public.perfiles_x_personas as pp, personas as p, perfiles as pe
												WHERE pe.id = $idPerfiles
												AND p.id = pp.id_personas
												AND pe.id = pp.id_perfiles
												AND pp.estado = 1
												AND p.estado = 1
												AND pe.estado = 1");
		$result = $command->queryAll();
		
		 return Json::encode( $result );
		
	
	}
}
