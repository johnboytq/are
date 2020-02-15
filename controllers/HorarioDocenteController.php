<?php
/**********
Versión: 001
Fecha: 27-03-2018
Desarrollador: Oscar David Lopez
Descripción: CRUD de Representantes Legales (Estudiantes)
---------------------------------------
Modificaciones:
Fecha: 27-04-2018
Persona encargada: Oscar David Lopez
Cambios realizados: - Horario del Docente con datatables
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
use app\models\HorarioDocente;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\SqlDataProvider;
use yii\data\ArrayDataProvider;

/**
 * HorarioDocenteController implements the CRUD actions for HorarioDocente model.
 */
class HorarioDocenteController extends Controller
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
     * Lists all HorarioDocente models.
     * @return mixed
     */
    public function actionIndex($idDocente = 0)
    {
		
		// $idDocente = $_SESSION['perfilesxpersonas'];
		// $idDocente = $_SESSION['perfilesxpersonas'];
		$idInstitucion = $_SESSION['instituciones'][0];
		$idSedes = $_SESSION['sede'][0];		
		
		$data = [[],[],];		
		//se usa para que la clase dataTables este disponible en yii	
		$dataProvider = new ArrayDataProvider([
			'allModels' => $data,
		]);
				
		
		//modelo para el form
		$model = new HorarioDocente();
		 $perfilesxpersonas = $_SESSION['perfilesxpersonas'];
		//variable con la conexion a la base de datos  pe.id=10 es el perfil docente
		$connection = Yii::$app->getDb();
		//llenar los docente
		$command = $connection->createCommand("
			select pp.id, concat(p.nombres,' ',p.apellidos) as nombres
			from personas as p, perfiles_x_personas as pp
			where p.id= pp.id_personas
			and pp.id = $perfilesxpersonas");
		$result = $command->queryAll();
		//se formatea para que lo reconozca el select
		$docentes=array();
		foreach($result as $key)
		{
			$docentes[$key['id']]=$key['nombres'];
		}
		
		
		if ($idDocente != 0)
		{
			//que materias se dan y en que dias en la sede actual
		$command = $connection->createCommand("
		select dbd.id_distribuciones_academicas as id, d.descripcion as dias, b.descripcion as bloques, a.descripcion as asignatura,
			pa.descripcion as grupo, au.descripcion as aula
			from distribuciones_x_bloques_x_dias as dbd, asignaturas_x_niveles_sedes as ans, distribuciones_academicas as da, 
			sedes_niveles as sn, dias as d, bloques as b, sedes_x_bloques as sb, asignaturas as a, paralelos as pa, aulas as au
			Where dbd.id_distribuciones_academicas = da.id
			and dbd.id_dias = d.id
			and dbd.id_bloques_sedes = sb.id
			and sb.id_sedes = $idSedes
			and da.id_perfiles_x_personas_docentes = $idDocente
			and da.id_asignaturas_x_niveles_sedes = ans.id
			and ans.id_asignaturas = a.id
			and ans.id_sedes_niveles = sn.id
			and sb.id_bloques = b.id 
			and da.id_paralelo_sede =pa.id
			and dbd.id_aulas_sedes = au.id");
			$result = $command->queryAll();
		
			$command = $connection->createCommand("SELECT id, descripcion
			FROM dias
			where estado  =1
			order by id");
			$dias = $command->queryAll();
			
			
			$command = $connection->createCommand("
			SELECT b.id, b.descripcion
			FROM bloques as b, sedes_x_bloques as sb 
			where b.estado  =1
			and sb.id_sedes =$idSedes
			and sb.id_bloques = b.id
			order by id asc");
			$bloques = $command->queryAll();
			
			$arrayHorario=array();
			//se crea un array con los bloque de la sede VS los dias de la semana con el valor no asignado
			foreach ($dias as $dia)
			{
				foreach ($bloques as $bloque)
				{
					//$bloque['descripcion'] nombre del bloque 
					//$dia['descripcion'] dia de la semana
					$arrayHorario[$bloque['descripcion']][$dia['descripcion']]="-"."</insertar>";
				}
				
				
			}			
			
			//en la ubicacion bloque - dia se pone el nombrede la asignatura - group - aula que da ese docente $idDocente
			foreach($result as $r)
			{
				
				$arrayHorario[$r['bloques']][$r['dias']]=$r['asignatura']." |".$r['grupo']."|".$r['aula']."</actualizar=".$r['id']."";
			}
			
			
			//se construye el formato json para llenar el dataTable
			$data='[';
			$data.='{"bloques":" BLOQUE ","LUNES":"LUNES","MARTES":"MARTES","MIERCOLES":"MIERCOLES","JUEVES":"JUEVES","VIERNES":"VIERNES","SABADO":"SABADO","DOMINGO":"DOMINGO"},';
			foreach($arrayHorario as $arrayHorarioJson=>$valor) 
			{
				$data.='{"bloques":"'.$arrayHorarioJson.'",';
				foreach($valor as $v=>$value)
				{
					// print_r($v);
					$arraydata[]='"'.$v.'":"'.$value.'"';
				}
				$data.=implode(",",$arraydata);
				unset($arraydata);
				$data.='},';
			}
			$data = substr($data, 0, -1);
			$data.=']';
			echo $data;
			die;
		}
		
		
		
        return $this->render('index', [
            // 'dataProvider' => $dataProvider,
			'model'=>$model,
			'docentes'=>$docentes,
			'idSedes' 	=> $idSedes,
			'idInstitucion' => $idInstitucion,
			'dataProvider'=>$dataProvider,
			]);
		

    }

    /**
     * Displays a single HorarioDocente model.
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
     * Creates a new HorarioDocente model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new HorarioDocente();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing HorarioDocente model.
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
     * Deletes an existing HorarioDocente model.
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
     * Finds the HorarioDocente model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return HorarioDocente the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = HorarioDocente::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
