<?php
/**********
Versión: 001
Fecha: (23-03-2018)
Desarrollador: Viviana Rodas
Descripción: Controlador distribuciones academicas - indicador de desempeño
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
use app\models\DistribucionesIndicadorDesempeno;
use app\models\DistribucionesIndicadorDesempenoBuscar;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

use app\models\Estados;

/**
 * DistribucionesIndicadorDesempenoController implements the CRUD actions for DistribucionesIndicadorDesempeno model.
 */
class DistribucionesIndicadorDesempenoController extends Controller
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
     * Lists all DistribucionesIndicadorDesempeno models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DistribucionesIndicadorDesempenoBuscar();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$dataProvider ->query->andWhere('estado=1');
		$dataProvider->query->orderby( 'id' );

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DistribucionesIndicadorDesempeno model.
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
     * Creates a new DistribucionesIndicadorDesempeno model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        //se crea una instancia del modelo estados
		$estadosTable 		 	= new Estados();
		//se traen los datos de estados
		$dataestados		 	= $estadosTable->find()->where( 'id=1' )->all();
		//se guardan los datos en un array
		$estados	 	 	 	= ArrayHelper::map( $dataestados, 'id', 'descripcion' );
		
		
		$model = new DistribucionesIndicadorDesempeno();

        /**
		* Concexion a la db, llenar select de distribuciones academicas
		*/
		//variable con la conexion a la base de datos  
		$connection = Yii::$app->getDb();          //FALTARIA EL DOCENTE
		
		$command = $connection->createCommand("select da.id, concat(a.descripcion,' ',p.descripcion) as distribucion  
												from distribuciones_academicas as da, asignaturas as a, asignaturas_x_niveles_sedes as ans,paralelos as p
												where da.id_asignaturas_x_niveles_sedes = ans.id
												and ans.id_asignaturas = a.id
												and da.id_paralelo_sede = p.id
                                                and da.estado = 1
												group by a.descripcion, p.descripcion, da.id
                                                order by da.id");
		$result = $command->queryAll();
		//se formatea para que lo reconozca el select
		foreach($result as $key){
			$distribuciones[$key['id']]=$key['distribucion'];
		}
		
		/**
		* Llenar select indicadores de desempeño
		*/
		$command = $connection->createCommand("SELECT id, descripcion
												FROM public.indicador_desempeno
												WHERE estado = 1");
		$result = $command->queryAll();
		//se formatea para que lo reconozca el select
		foreach($result as $key){
			$indicadores[$key['id']]=$key['descripcion'];
		}
		
		
		if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
			'distribuciones' => $distribuciones,
			'indicadores'=>$indicadores,
			'estados'=>$estados,
        ]);
    }

    /**
     * Updates an existing DistribucionesIndicadorDesempeno model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        
		//se crea una instancia del modelo estados
		$estadosTable 		 	= new Estados();
		//se traen los datos de estadosCiviles
		$dataestados		 	= $estadosTable->find()->all();
		//se guardan los datos en un array
		$estados	 	 	 	= ArrayHelper::map( $dataestados, 'id', 'descripcion' );
		
		
		$model = $this->findModel($id);
		
		/**
		* Concexion a la db, llenar select de distribuciones academicas
		*/
		//variable con la conexion a la base de datos  
		$connection = Yii::$app->getDb();          //FALTARIA EL DOCENTE and did.id = $id
		
		$command = $connection->createCommand("select da.id, concat(a.descripcion,' ',p.descripcion) as distribucion  
												from distribuciones_x_indicador_desempeno as did, distribuciones_academicas as da, asignaturas as a, asignaturas_x_niveles_sedes as ans,paralelos as p
												where did.id_distribuciones = da.id
												and da.id_asignaturas_x_niveles_sedes = ans.id
												and ans.id_asignaturas = a.id
												and da.id_paralelo_sede = p.id
												
												group by a.descripcion, p.descripcion, da.id");
		$result = $command->queryAll();
		//se formatea para que lo reconozca el select
		foreach($result as $key){
			$distribuciones[$key['id']]=$key['distribucion'];
		}
		
		/**
		* Llenar select indicadores de desempeño AND did.id = $id
		*/
		$command = $connection->createCommand("SELECT id.id, id.descripcion
												FROM indicador_desempeno as id, distribuciones_x_indicador_desempeno as did
												WHERE id.estado = 1
												AND id.id = did.id_indicador_desempeno
												");
		$result = $command->queryAll();
		//se formatea para que lo reconozca el select
		foreach($result as $key){
			$indicadores[$key['id']]=$key['descripcion'];
		}

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
			'distribuciones' => $distribuciones,
			'indicadores'=>$indicadores,
			'estados'=>$estados,
        ]);
    }

    /**
     * Deletes an existing DistribucionesIndicadorDesempeno model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        // $this->findModel($id)->delete();
		$model = DistribucionesIndicadorDesempeno::findOne($id);
		$model->estado = 2;
		$model->update(false);

        return $this->redirect(['index']);
    }

    /**
     * Finds the DistribucionesIndicadorDesempeno model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return DistribucionesIndicadorDesempeno the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DistribucionesIndicadorDesempeno::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
