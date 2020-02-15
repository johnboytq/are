<?php

/**********
Versión: 001
Fecha: 06-03-2018
---------------------------------------
Modificaciones:
Fecha: 26-06-2018
Persona encargada: Edwin Molina Grisales
Cambios realizados: - Se muestra la sede
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
use app\models\DocenteInstitucion;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\SqlDataProvider;
/**
 * DocenteInstitucionController implements the CRUD actions for DocenteInstitucion model.
 */
class DocenteInstitucionController extends Controller
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

	public function actionListarInstituciones( $idInstitucion = 0)
    {
        return $this->render('listarInstituciones',[
			'idInstitucion' => $idInstitucion,
		] );
    }

	
    /**
     * Lists all DocenteInstitucion models.
     * @return mixed
     */
    // public function actionIndex($idInstitucion = 0)
    public function actionIndex()
    {
		$idInstitucion 	= $_SESSION['instituciones'][0];
		
		if( $idInstitucion != 0)
		{

			$sql="SELECT p.identificacion, p.nombres, p.apellidos, asig.descripcion as asignatura, s.descripcion as sede
				    FROM personas as p, 
						 perfiles_x_personas_institucion as ppi, 
						 perfiles_x_personas as pp, 
						 distribuciones_academicas as da, 
						 asignaturas_x_niveles_sedes ans, 
						 asignaturas as asig,
						 sedes_niveles as sn,
						 sedes as s
				   WHERE ppi.id_institucion = $idInstitucion
					 AND ppi.id_perfiles_x_persona = pp.id
					 AND pp.id_personas = p.id
					 AND p.estado = 1
					 AND da.id_perfiles_x_personas_docentes = pp.id
					 AND pp.id_perfiles= 10
					 AND da.id_asignaturas_x_niveles_sedes= ans.id
					 AND ans.id_asignaturas = asig.id
					 AND sn.id = ans.id_sedes_niveles
					 AND s.id = sn.id_sedes
					 ";
		
		   $dataProvider = new SqlDataProvider([
					'sql' => $sql,
					
				]);

			return $this->render('index', [
				'dataProvider' => $dataProvider,
					'idInstitucion' => $idInstitucion,
				]);
		}
		else
		{
			// Si el id de institucion o de sedes es 0 se llama a la vista listarInstituciones
			 return $this->render('listarInstituciones',[
				'idInstitucion' => $idInstitucion,
			] );
		}

    }

    /**
     * Displays a single DocenteInstitucion model.
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
     * Creates a new DocenteInstitucion model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DocenteInstitucion();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing DocenteInstitucion model.
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
     * Deletes an existing DocenteInstitucion model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the DocenteInstitucion model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return DocenteInstitucion the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DocenteInstitucion::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
