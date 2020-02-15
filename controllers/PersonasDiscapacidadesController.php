<?php

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
use app\models\PersonasDiscapacidades;
use app\models\PersonasDiscapacidadesBuscar;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\models\Personas;
use app\models\TiposDiscapacidades;
use yii\helpers\ArrayHelper;

/**
 * PersonasDiscapacidadesController implements the CRUD actions for PersonasDiscapacidades model.
 */
class PersonasDiscapacidadesController extends Controller
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
     * Lists all PersonasDiscapacidades models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PersonasDiscapacidadesBuscar();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PersonasDiscapacidades model.
     * @param string $id_personas
     * @param string $id_tipos_discapacidades
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_personas, $id_tipos_discapacidades)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_personas, $id_tipos_discapacidades),
        ]);
    }

    /**
     * Creates a new PersonasDiscapacidades model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        //se crea una instancia del modelo personas
		$personasTable 		 	= new Personas();
		//se traen los datos de personas
		// $dataPersonas		 	= $personasTable->find()->where(['concat(nombre,apellidos) as name'])->all();										  
		$dataPersonas		 	= $personasTable->find()->select(["id, CONCAT(nombres, ' ', apellidos) AS nombres"])->where('estado=1')->all();										  
		//se guardan los datos en un array
		$personas	 	 	 	= ArrayHelper::map( $dataPersonas, 'id', 'nombres' );
		
		//se crea una instancia del modelo tipos discapacidades
		$tiposDiscapacidadesTable 		 	= new TiposDiscapacidades();
		//se traen los datos de tipos formaciones										  
		$datatiposDiscapacidades		 	= $tiposDiscapacidadesTable->find()->all();										  
		//se guardan los datos en un array
		$discapacidades	 	 	 	= ArrayHelper::map( $datatiposDiscapacidades, 'id', 'descripcion' );
		
		
		$model = new PersonasDiscapacidades();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id_personas' => $model->id_personas, 'id_tipos_discapacidades' => $model->id_tipos_discapacidades]);
        }

        return $this->render('create', [
            'model' => $model,
            'personas' => $personas,
            'discapacidades' => $discapacidades,
        ]);
    }

    /**
     * Updates an existing PersonasDiscapacidades model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id_personas
     * @param string $id_tipos_discapacidades
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_personas, $id_tipos_discapacidades)
    {
        
		//se crea una instancia del modelo personas
		$personasTable 		 	= new Personas();
		//se traen los datos de personas
		// $dataPersonas		 	= $personasTable->find()->where(['concat(nombre,apellidos) as name'])->all();										  
		$dataPersonas		 	= $personasTable->find()->select(["id, CONCAT(nombres, ' ', apellidos) AS nombres"])->where('estado=1')->all();										  
		//se guardan los datos en un array
		$personas	 	 	 	= ArrayHelper::map( $dataPersonas, 'id', 'nombres' );
		
		//se crea una instancia del modelo tipos discapacidades
		$tiposDiscapacidadesTable 		 	= new TiposDiscapacidades();
		//se traen los datos de tipos formaciones										  
		$datatiposDiscapacidades		 	= $tiposDiscapacidadesTable->find()->all();										  
		//se guardan los datos en un array
		$discapacidades	 	 	 	= ArrayHelper::map( $datatiposDiscapacidades, 'id', 'descripcion' );
		
		
		$model = $this->findModel($id_personas, $id_tipos_discapacidades);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id_personas' => $model->id_personas, 'id_tipos_discapacidades' => $model->id_tipos_discapacidades]);
        }

        return $this->render('update', [
            'model' => $model,
			'personas' => $personas,
            'discapacidades' => $discapacidades,
        ]);
    }

    /**
     * Deletes an existing PersonasDiscapacidades model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id_personas
     * @param string $id_tipos_discapacidades
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_personas, $id_tipos_discapacidades)
    {
        $this->findModel($id_personas, $id_tipos_discapacidades)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the PersonasDiscapacidades model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id_personas
     * @param string $id_tipos_discapacidades
     * @return PersonasDiscapacidades the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_personas, $id_tipos_discapacidades)
    {
        if (($model = PersonasDiscapacidades::findOne(['id_personas' => $id_personas, 'id_tipos_discapacidades' => $id_tipos_discapacidades])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
