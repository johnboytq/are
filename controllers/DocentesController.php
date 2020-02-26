<?php

/**********
Versión: 001
Fecha: Fecha modificacion (24-04-2018)
Desarrollador: Viviana Rodas
Descripción: Se modifica el create  y  el update para que solo guarde en docentes, se listan solo los docentes
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
use app\models\Docentes;
use app\models\DocentesBuscar;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


use app\models\Estados;
use app\models\Escalafones;
use app\models\Personas;
use app\models\PerfilesXPersonas;
use yii\helpers\ArrayHelper;

/**
 * DocentesController implements the CRUD actions for Docentes model.
 */
class DocentesController extends Controller
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
     * Lists all Docentes models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DocentesBuscar();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere( 'docentes.estado=1' )
					 ->innerJoin( 'perfiles_x_personas pf', 'docentes.id_perfiles_x_personas=pf.id' )
					 ->innerJoin( 'personas p', 'pf.id_personas=p.id' );

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Docentes model.
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
     * Creates a new Docentes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
		$estadosData 	= Estados::find()->where( 'id=1' )->all();
		$estados 	 	= ArrayHelper::map( $estadosData, 'id', 'descripcion' );
		
		$escalafonesData= Escalafones::find()->where( 'estado=1' )->all();
		$escalafones 	= ArrayHelper::map( $escalafonesData, 'id', 'descripcion' );
		
		/**
		* Concexion a la db, llenar select de docentes
		*/
		//variable con la conexion a la base de datos  pe.id=10 es el perfil docente
		
		
		$result = $this->docentes();
		//se formatea para que lo reconozca el select
		foreach($result as $key){
			$personas[$key['id']]=$key['nombres'];
		}
		
        $model					= new Docentes();
        
		if( $model->load(Yii::$app->request->post()) && $model->save() )
			return $this->redirect(['view', 'id' => $model->id_perfiles_x_personas]);
			
			
        

        return $this->render('create', [
            'model' 	  			=> $model,
            'personas' 	  			=> $personas,
            'escalafones' 			=> $escalafones,
            'estados' 	  			=> $estados,
        ]);
    }

    /**
     * Updates an existing Docentes model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		$modelPerfilesXPersonas = PerfilesXPersonas::findOne($model->id_perfiles_x_personas);
		
		$estadosData 	= Estados::find()->all();
		$estados 	 	= ArrayHelper::map( $estadosData, 'id', 'descripcion' );
		
		$escalafonesData= Escalafones::find()->where( 'estado=1' )->all();
		$escalafones 	= ArrayHelper::map( $escalafonesData, 'id', 'descripcion' );
		
		/**
		* Concexion a la db, llenar select de docentes
		*/
		//variable con la conexion a la base de datos  pe.id=10 es el perfil docente
		$result = $this->docentes();
		//se formatea para que lo reconozca el select
		foreach($result as $key){
			$personas[$key['id']]=$key['nombres'];
		}
		
		if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_perfiles_x_personas]);
        }

        return $this->render('update', [
            'model' 	  			=> $model,
            'personas' 	  			=> $personas,
            'escalafones' 			=> $escalafones,
            'estados' 	  			=> $estados,
        ]);
    }

    /**
     * Deletes an existing Docentes model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
	
	//docentes con id de perfilesXpersonas
	private function docentes()
	{
		$connection = Yii::$app->getDb();
		$command = $connection->createCommand
		("
			select pp.id as id, concat(p.nombres,' ',p.apellidos,' - ', pp.id) as nombres
			from personas as p, perfiles_x_personas as pp, perfiles as pe
			where p.id= pp.id_personas
			and p.estado=1
			and pp.id_perfiles=pe.id
			and pe.id=10
			and pe.estado=1
		");
		$result = $command->queryAll();
		return $result;
	}		
    public function actionDelete($id)
    {
        // $this->findModel($id)->delete();
        $model = $this->findModel($id);
		$model->estado = 2;
		$model->update(false);

        return $this->redirect(['index']);
    }

    /**
     * Finds the Docentes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Docentes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Docentes::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
