<?php

/**********
Versión: 001
Fecha: 10-04-2018
Desarrollador: Oscar David Lopez
Descripción: CRUD Recursos Infraestructura Fisica
---------------------------------------
Modificaciones:
Fecha: 10-04-2018
Persona encargada: Oscar David Lopez
Cambios realizados: - muestra solo los activos
Desactiva los registro en lugar de borrarlos
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
use app\models\RecursosInfraestructuraFisica;
use app\models\RecursosInfraestructuraFisicaBuscar;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RecursosInfraestructuraFisicaController implements the CRUD actions for RecursosInfraestructuraFisica model.
 */
class RecursosInfraestructuraFisicaController extends Controller
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
     * Lists all RecursosInfraestructuraFisica models.
     * @return mixed
     */
    // public function actionIndex($idInstitucion = 0, $idSedes = 0)
    public function actionIndex()
    {
		$idInstitucion 	= $_SESSION['instituciones'][0];
		$idSedes 		= $_SESSION['sede'][0];
		
		if( $idInstitucion != 0 && $idSedes != 0 )
		{
			$searchModel = new RecursosInfraestructuraFisicaBuscar();
			$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
			$dataProvider->query->andWhere('estado=1');
			$dataProvider->query->andWhere("id_sede=$idSedes");

			return $this->render('index', [
				'searchModel' 	=> $searchModel,
				'dataProvider' 	=> $dataProvider,
				'idSedes' 		=> $idSedes,
				'idInstitucion' => $idInstitucion,
				// 'idSedes' => $this->findModel($id),
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
     * Displays a single RecursosInfraestructuraFisica model.
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
     * Creates a new RecursosInfraestructuraFisica model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($idSedes, $idInstitucion)
    {
        $model = new RecursosInfraestructuraFisica();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
			'idSedes'=>$idSedes,
			'idInstitucion'=>$idInstitucion,
        ]);
    }

    /**
     * Updates an existing RecursosInfraestructuraFisica model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing RecursosInfraestructuraFisica model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
		$model = $this->findModel($id);
		$idSedes= $model->id_sede;
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
		
		$model->estado = 2;
		$model->update(false);
		
		return $this->redirect(['index', 'idInstitucion' => $idInstituciones,'idSedes'=>$idSedes]);	
    }

    /**
     * Finds the RecursosInfraestructuraFisica model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return RecursosInfraestructuraFisica the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RecursosInfraestructuraFisica::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
