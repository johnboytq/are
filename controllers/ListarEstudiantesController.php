<?php

/**********
Versión: 001
---------------------------------------
Modificaciones
Fecha: 2019-10-15
Desarrollador: Edwin Molina Grisales
Descripción: se definen la variable jornada
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
use app\models\ListarEstudiantes;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\SqlDataProvider;



// $this->registerJsFile(Yii::$app->request->baseUrl.'/js/listarEstudiantes.js',['depends' => [\yii\web\JqueryAsset::className()]]);

/**
 * ListarEstudiantesController implements the CRUD actions for ListarEstudiantes model.
 */
class ListarEstudiantesController extends Controller
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
     * Lists all ListarEstudiantes models.
     * @return mixed
     */
    public function actionIndex($idParalelo = 0, $idJornada = 0)
    {
		$idInstitucion = $_SESSION['instituciones'][0];
		$idSedes = $_SESSION['sede'][0];
       
		//si no selecciona ningun paralelos los muestra todos
		if ($idParalelo == 0 && $idJornada == 0)
		{
			$sql ="
			SELECT p.identificacion, concat(p.nombres,' ',p.apellidos) as nombres, p.domicilio, j.descripcion, pa.descripcion as grupo, n.descripcion as nivel
				FROM personas as p, 
					  perfiles_x_personas as pp, 
					  estudiantes as e,
					  paralelos as pa, 
					  sedes_jornadas as sj, 
					  jornadas as j, 
					  sedes as s,
					  instituciones as i,
					  sedes_niveles sn,
					  niveles n
				WHERE p.estado 					= 1
				  AND e.estado 					= 1
				  AND e.id_perfiles_x_personas 	= pp.id
				  AND pp.id_perfiles			= 11
				  AND pp.id_personas 			= p.id
				  AND e.id_paralelos 			= pa.id
				  AND pa.id_sedes_jornadas 		= sj.id
				  AND sj.id_jornadas 			= j.id
				  AND sj.id_sedes 				= $idSedes
				  AND s.id_instituciones 		= i.id
				  AND i.id 						= $idInstitucion
				  AND sn.id 					= pa.id_sedes_niveles
				  AND sn.id_sedes 				= s.id
				  AND n.id						= sn.id_niveles
				  AND n.estado 					= 1
			";
		}
		elseif($idParalelo > 0 && $idJornada == 0)
		{
			$sql ="
			SELECT p.identificacion, concat(p.nombres,' ',p.apellidos) as nombres, p.domicilio, j.descripcion, pa.descripcion as grupo, n.descripcion as nivel
				FROM personas as p, 
					  perfiles_x_personas as pp, 
					  estudiantes as e,
					  paralelos as pa, 
					  sedes_jornadas as sj, 
					  jornadas as j, 
					  sedes as s,
					  instituciones as i,
					  sedes_niveles sn,
					  niveles n
				WHERE p.estado 					= 1
				  AND e.estado 					= 1
				  AND e.id_perfiles_x_personas 	= pp.id
				  AND pp.id_perfiles			= 11
				  AND pp.id_personas 			= p.id
				  AND e.id_paralelos 			= pa.id
				  AND pa.id_sedes_jornadas 		= sj.id
				  AND sj.id_jornadas 			= j.id
				  AND sj.id_sedes 				= $idSedes
				  AND s.id_instituciones 		= i.id
				  AND i.id 						= $idInstitucion
				  AND sn.id 					= pa.id_sedes_niveles
				  AND sn.id_sedes 				= s.id
				  AND n.id						= sn.id_niveles
				  AND n.estado 					= 1
				  AND pa.id 					=$idParalelo
			";
		}
		elseif($idParalelo == 0 && $idJornada > 0)
		{
			$sql ="
			SELECT p.identificacion, concat(p.nombres,' ',p.apellidos) as nombres, p.domicilio, j.descripcion, pa.descripcion as grupo, n.descripcion as nivel
				FROM personas as p, 
					  perfiles_x_personas as pp, 
					  estudiantes as e,
					  paralelos as pa, 
					  sedes_jornadas as sj, 
					  jornadas as j, 
					  sedes as s,
					  instituciones as i,
					  sedes_niveles sn,
					  niveles n
				WHERE p.estado 					= 1
				  AND e.estado 					= 1
				  AND e.id_perfiles_x_personas 	= pp.id
				  AND pp.id_perfiles			= 11
				  AND pp.id_personas 			= p.id
				  AND e.id_paralelos 			= pa.id
				  AND pa.id_sedes_jornadas 		= sj.id
				  AND sj.id_jornadas 			= j.id
				  AND sj.id_sedes 				= $idSedes
				  AND s.id_instituciones 		= i.id
				  AND i.id 						= $idInstitucion
				  AND sn.id 					= pa.id_sedes_niveles
				  AND sn.id_sedes 				= s.id
				  AND n.id						= sn.id_niveles
				  AND n.estado 					= 1
				  AND j.id 						= $idJornada
			";
		}
		elseif($idParalelo > 0 && $idJornada > 0)
		{
			$sql ="
			SELECT p.identificacion, concat(p.nombres,' ',p.apellidos) as nombres, p.domicilio, j.descripcion, pa.descripcion as grupo, n.descripcion as nivel
				FROM personas as p, 
					  perfiles_x_personas as pp, 
					  estudiantes as e,
					  paralelos as pa, 
					  sedes_jornadas as sj, 
					  jornadas as j, 
					  sedes as s,
					  instituciones as i,
					  sedes_niveles sn,
					  niveles n
				WHERE p.estado 					= 1
				  AND e.estado 					= 1
				  AND e.id_perfiles_x_personas 	= pp.id
				  AND pp.id_perfiles			= 11
				  AND pp.id_personas 			= p.id
				  AND e.id_paralelos 			= pa.id
				  AND pa.id_sedes_jornadas 		= sj.id
				  AND sj.id_jornadas 			= j.id
				  AND sj.id_sedes 				= $idSedes
				  AND s.id_instituciones 		= i.id
				  AND i.id 						= $idInstitucion
				  AND sn.id 					= pa.id_sedes_niveles
				  AND sn.id_sedes 				= s.id
				  AND n.id						= sn.id_niveles
				  AND n.estado 					= 1
				  AND j.id 						= $idJornada
				  AND pa.id 					= $idParalelo
			";
		}
	
			$dataProvider = new SqlDataProvider([
				'sql' => $sql,
			]);
			
			$connection = Yii::$app->getDb();
			//que paralelos o grupos tiene esa sede
			$command = $connection->createCommand("
				SELECT p.id, p.descripcion
				FROM paralelos as p, sedes_jornadas as sj
				where p.id_sedes_jornadas = sj.id
				and sj.id_sedes = $idSedes
				order by p.id
				");
			$result = $command->queryAll();
			
			$paralelos = array();
			
			foreach ($result as $r)
			{
				$paralelos[$r['id']]=$r['descripcion'];
			}
			$command = $connection->createCommand("
			SELECT j.id,j.descripcion
			FROM paralelos as p, sedes_jornadas as sj, jornadas as j
			where p.id_sedes_jornadas = sj.id
			and sj.id_sedes = 48
			and sj.id_jornadas = j.id
			group by j.id
				");
			$result = $command->queryAll();
			
			$jornadas = [];
			foreach ($result as $r)
			{
				$jornadas[$r['id']]=$r['descripcion'];
			}
			$model = new ListarEstudiantes();
			return $this->render('index', [
				'dataProvider' 	=> $dataProvider,
				'idSedes' 		=> $idSedes,
				'idInstitucion' => $idInstitucion,
				'model'			=> $model,
				'paralelos'		=> $paralelos,
				'idParalelo'	=> $idParalelo,
				'idJornada'		=> $idJornada,
				'jornadas'		=> $jornadas,
				]);

    }

    /**
     * Displays a single ListarEstudiantes model.
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
     * Creates a new ListarEstudiantes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ListarEstudiantes();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_perfiles_x_personas]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ListarEstudiantes model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_perfiles_x_personas]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ListarEstudiantes model.
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
     * Finds the ListarEstudiantes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return ListarEstudiantes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ListarEstudiantes::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
