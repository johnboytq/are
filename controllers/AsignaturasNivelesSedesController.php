<?php

/**********
Versión: 001
Fecha: 27-03-2018
---------------------------------------
Modificaciones:
Fecha: 01-05-2018
Persona encargada: Edwin Molina Grisales
Cambios realizados: Se agrega filtro por AREAS DE ENSEÑANZA al CRUD
---------------------------------------
Modificaciones:
Fecha: 27-03-2018
Se agrega método actionAsignaturasXNivelesSedes
---------------------------------------
Modificaciones:
Fecha: 27-03-2018
Se agrega método actionAsignaturasXNivelesSedes
---------------------------------------
Modificaciones:
Fecha: 05-06-2018
Persona encargada: Oscar David Lopez Villa
Cambios realizados:cambio en el ActionIndex por SqlDataProvider
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
use app\models\AsignaturasNivelesSedes;
use app\models\Sedes;
use app\models\SedesNiveles;
use app\models\AsignaturasNivelesSedesBuscar;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Asignaturas;
use	yii\helpers\ArrayHelper;
use	yii\helpers\Json;
use yii\data\SqlDataProvider;

/**
 * AsignaturasNivelesSedesController implements the CRUD actions for AsignaturasNivelesSedes model.
 */
class AsignaturasNivelesSedesController extends Controller
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
	
	
	public function actionAsignaturasXNivelesSedes( $idNivel ){
		
		$asignaturasData = Asignaturas::find()
									  ->innerJoin( 'asignaturas_x_niveles_sedes ans', 'ans.id_asignaturas=asignaturas.id' )
									  ->innerJoin( 'sedes_niveles sn', 'sn.id=ans.id_sedes_niveles' )
									  ->innerJoin( 'niveles n', 'n.id=sn.id_niveles' )
									  ->where( 'n.id='.$idNivel )
									  ->andWhere( 'asignaturas.estado=1' )
									  ->all();
									  
		$asignaturas = ArrayHelper::map( $asignaturasData, 'id', 'descripcion' );
		
		echo json_encode( $asignaturas );
	}

    /**
     * Lists all AsignaturasNivelesSedes models.
     * @return mixed
     */
    public function actionIndex()
    {
        // $searchModel = new AsignaturasNivelesSedesBuscar();
        // $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
       
	   $sql ="
		SELECT ans.id,s.descripcion as sede,n.descripcion as niveles, a.descripcion as asignaturas, ans.intensidad as intensidad
		FROM asignaturas_x_niveles_sedes as ans, asignaturas as \"a\", sedes_niveles as sn, sedes as s, niveles as n 
		WHERE ans.id_asignaturas = a.id
		AND ans.id_sedes_niveles = sn.id
		AND sn.id_sedes = s.id
		AND s.id = 48
		AND sn.id_niveles = n.id
		group by ans.id,s.descripcion ,n.descripcion, a.descripcion
		order by ans.id
			 
		   ";		
		$dataProvider = new SqlDataProvider([
				'sql' => $sql,
				'key'=>'id',
				
			]);

        return $this->render('index', [
            
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AsignaturasNivelesSedes model.
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
     * Creates a new AsignaturasNivelesSedes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AsignaturasNivelesSedes();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing AsignaturasNivelesSedes model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
	
	public function actionAreasEnsenanza( $sede, $idModelo ){
		
		$connection = Yii::$app->getDb();
		
		$data = array( 'error' => 0, 'areas' );
		
		if ($idModelo!=0)
		{
			$model = $this->findModel($idModelo);
			$asignatura = Asignaturas::findOne( $model->id_asignaturas );
			$data["selectAreas"] = $asignatura->id_areas_ensenanza;
		}
		
		//consulta las asignaturas de la sede
		$command = $connection->createCommand("
						SELECT ae.id, ae.descripcion
						  FROM sedes_areas_ensenanza sae, areas_ensenanza ae
						 WHERE sae.id_sedes=$sede
						   AND ae.id 	= sae.id_areas_ensenanza
						   AND ae.estado= 1
					");
		$result = $command->queryAll();
		
		
		$data['areas'][]="<option value=''>Seleccione..</option>";
		foreach ($result as $row) {
			$id 		 = $row['id'];
			$descripcion = $row['descripcion'];
			$data['areas'][]="<option value=$id>$descripcion</option>";
		}
		
		echo Json::encode($data);
	}
	 
	public function actionNivelesSedes($idSede,$idModelo,$area)
	{
		
		$data = array('error'=>0,'niveles','asignaturas');
		$connection = Yii::$app->getDb();
		if ($idModelo!=0)
		{
			//id del nivel seleccionado
			// $command = $connection->createCommand("
			// SELECT sn.id_niveles
			// FROM public.asignaturas_x_niveles_sedes ans, sedes_niveles sn
			// where ans.id_sedes_niveles = sn.id
			// and ans.id =$idModelo
			// ");
			// $result = $command->queryAll();
			$model = $this->findModel($idModelo);
			$data["selectNiveles"]= $model->id_sedes_niveles;
			$data["selectAsignatura"]= $model->id_asignaturas;
		}
		
		
		
		//consulta los niveles de la sede
		$command = $connection->createCommand("
		SELECT sn.id, n.descripcion
		FROM public.sedes_niveles as sn, public.niveles as n
		where sn.id_sedes=$idSede
		and sn.id_niveles = n.id
		");
		$result = $command->queryAll();
		
		
		$data['niveles'][]="<option value=''>Seleccione..</option>";
		foreach ($result as $row) {
			$id =  $row['id'];
			$descripcion = $row['descripcion'];
			$data['niveles'][]="<option value=$id>$descripcion</option>";
		}
		
		
		//consulta las asignaturas de la sede
		$command = $connection->createCommand("
		SELECT id,descripcion
		  FROM public.asignaturas
		 WHERE id_sedes=$idSede
		   AND id_areas_ensenanza=$area
		");
		$result = $command->queryAll();
		
		
		$data['asignaturas'][]="<option value=''>Seleccione..</option>";
		foreach ($result as $row) {
			$id =  $row['id'];
			$descripcion = $row['descripcion'];
			$data['asignaturas'][]="<option value=$id>$descripcion</option>";
		}
		
		if(@count($data['asignaturas'])==1 || count(@$data['niveles'])==1)
			$data['error']=1;

		echo json_encode($data);
	}	
	 
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		
		$idSedesNiveles = SedesNiveles::find()->where('id='.$model->id_sedes_niveles)->all();
		$idSedes = ArrayHelper::getColumn($idSedesNiveles, 'id_sedes' );
		$idNiveles = ArrayHelper::getColumn($idSedesNiveles, 'id_niveles' );
		$idSedes=$idSedes[0];
		$idNiveles = $idNiveles[0];		
		$idAsignaturas = $model->id_asignaturas;
		
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
			'idSedes' =>$idSedes,
			'idNiveles'=>$idNiveles,
			'idAsignaturas'=>$idAsignaturas,
        ]);
    }

    /**
     * Deletes an existing AsignaturasNivelesSedes model.
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
     * Finds the AsignaturasNivelesSedes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return AsignaturasNivelesSedes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AsignaturasNivelesSedes::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
