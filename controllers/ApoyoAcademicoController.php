<?php

/**********
Versión: 001
Fecha: 16-04-2018
Desarrollador: Oscar David Lopez
Descripción: CRUD de Apoyo Academico
---------------------------------------
Modificaciones:
Fecha: 12-06-2018
Persona encargada: Edwin Molina Grisales
Cambios realizados: Solo se muestra los doctores y estudiantes correspondientes a la institución seleccionada
---------------------------------------
Modificaciones:
Fecha: 16-04-2018
Persona encargada: Oscar David Lopez
Cambios realizados: - se agrega el listar sede e institucion
muestra solo los apoyos academicos de la sede seleccionada
---------------------------------------
Modificaciones:
Fecha: 7-04-2018
Persona encargada: Oscar David Lopez
Cambios realizados: - se modificar la funcion ActionUpdate
---------------------------------------
Modificaciones:
Fecha: 21-06-2018
Persona encargada: Oscar David Lopez
Cambios realizados: - reestructuracion del crud
---------------------------------------
Modificaciones:
Fecha: 22-06-2018
Persona encargada: Oscar David Lopez
Cambios realizados: - reestructuracion del crud
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
use app\models\ApoyoAcademico;
use app\models\TiposApoyoAcademico;
use app\models\ApoyoAcademicoBuscar;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Sedes;
use	yii\helpers\ArrayHelper;
/**
 * ApoyoAcademicoController implements the CRUD actions for ApoyoAcademico model.
 */
class ApoyoAcademicoController extends Controller
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
     * Lists all ApoyoAcademico models.
     * @return mixed
     */
    public function actionIndex($idEstudiante = 0)
    {
		//si alguno es 0 lo regresa a la vista para que seleccione
		if( $idEstudiante!=0 )
		{
			$idInstitucion = $_SESSION['instituciones'][0];
			$idSedes = $_SESSION['sede'][0];
		
			//muestra solo los de la sede actual y estado activo
			$searchModel = new ApoyoAcademicoBuscar();
			$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
			$dataProvider->query->andWhere('id_sede='.$idSedes);
			$dataProvider->query->andWhere('estado=1');
			$dataProvider->query->andWhere('id_persona_estudiante='.$idEstudiante);

			return $this->render('index', [
				'searchModel' 	=> $searchModel,
				'dataProvider' 	=> $dataProvider,
				'idInstitucion' => $idInstitucion,
				'idSedes' 		=> $idSedes,
				'idEstudiante'	=>$idEstudiante,
				]);
		}
		else
		{
			// Si el idEstudiante es 0 se llama a la vista listarEstudiantes
			 return $this->render('listarEstudiantes',[
				'$idEstudiante' => $idEstudiante,
				
			] );
		}

    }

    /**
     * Displays a single ApoyoAcademico model.
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
     * Creates a new ApoyoAcademico model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($idEstudiante)
    {
		$idInstitucion = $_SESSION['instituciones'][0];
		$idSedes = $_SESSION['sede'][0];
				
		
		/**
		* Llenar nombre del estudiante
		*/
		//variable con la conexion a la base de datos 
		$connection = Yii::$app->getDb();
		$command = $connection->createCommand("
			SELECT es.id_perfiles_x_personas as id, concat(pe.nombres,' ',pe.apellidos) as nombres
			  FROM estudiantes as es, perfiles_x_personas as pp, personas as pe, 
			  perfiles_x_personas_institucion ppi
			 WHERE es.id_perfiles_x_personas = pp.id
			   AND pp.id_personas = pe.id
			   AND pp.id_perfiles = 11
			   AND ppi.id_perfiles_x_persona = pp.id
			   AND ppi.id_institucion = $idInstitucion
			   AND pp.id = $idEstudiante
		");
		$result = $command->queryAll();
		$estudiantes = array();
		foreach ($result as $r)
		{
			$estudiantes[$r['id']]= $r['nombres'];
		}
		
		$AAcademico = new TiposApoyoAcademico();
		$AAcademico = $AAcademico->find()->all();
		$AAcademico = ArrayHelper::map($AAcademico,'id','descripcion');
		
		
        $model = new ApoyoAcademico();
		
		
		$datoPost  = Yii::$app->request->post();
        if ($datoPost)
		{
			
			//el nivel y jornada del estudiante
			$command = $connection->createCommand("
			SELECT n.descripcion as paralelo, j.descripcion as jornada
			FROM estudiantes as e, paralelos as pa, sedes_jornadas as sj, jornadas as j, sedes_niveles as sn, niveles as n
			where e.id_paralelos = pa.id
			and e.id_perfiles_x_personas = $idEstudiante
			and pa.id_sedes_jornadas = sj.id
			and sj.id_jornadas = j.id
			and pa.id_sedes_niveles = sn.id
			and sn.id_niveles = n.id
			
			");
			$nivelJornada = $command->queryAll();
			
			
			//saber que tipo de apoyo academicos 
			$idTipoApoyo = $datoPost['ApoyoAcademico']['id_tipo_apoyo'];
			
			//consecutivo de la consulta psicologica o enfermeria
			$command = $connection->createCommand("
			select consecutivo from apoyo_academico
			where id = (SELECT max(id)	FROM apoyo_academico where id_tipo_apoyo = $idTipoApoyo)
			");
			$consecutivo = $command->queryAll();
			
			$consecutivo = @$consecutivo[0]['consecutivo'];
			$consecutivo = substr($consecutivo,4);
			$consecutivo = str_pad($consecutivo+1,4,"0",STR_PAD_LEFT);
			
			//consecutivo a insertar
			if ($idTipoApoyo == 4 )
				$consecutivo = "HCP-".$consecutivo;
			
			if ($idTipoApoyo == 5 )
				$consecutivo = "HCE-".$consecutivo;
			
			
			// echo "<pre>"; print_r($datoPost); echo "</pre>";	
			// die;
			$model->load($datoPost);
			$model->save();
			
			//se guarda la hora en que termina la cita
			date_default_timezone_set('America/Bogota');
			$hora = date('H:i:s');
			$horaSalida = date('h:i A', strtotime($hora));
			
			$model->hora_salida =$horaSalida;
			$model->save(false);
			
			
			$model->consecutivo = $consecutivo;
			$model->paralelo = $nivelJornada[0]['paralelo'];
			$model->jornada  = $nivelJornada[0]['jornada'];
			$model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' 		=> $model,
			'estudiantes'	=> $estudiantes,
			'idSedes' 		=> $idSedes,
			'idInstitucion' => $idInstitucion,
			'AAcademico' 	=> $AAcademico,
			'idEstudiante'	=>$idEstudiante,
        ]);
    }

    /**
     * Updates an existing ApoyoAcademico model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
		$model = $this->findModel($id);
		
		$AAcademico = new TiposApoyoAcademico();
		$AAcademico = $AAcademico->find()->all();
		$AAcademico = ArrayHelper::map($AAcademico,'id','descripcion');
		
		$idSedes = $model->id_sede;
		$institucion = Sedes::findOne($idSedes);
		
		/**
		* Llenar nombre de los doctores
		*/
		//variable con la conexion a la base de datos 
		$connection = Yii::$app->getDb();
		$command = $connection->createCommand("
		SELECT pp.id as id, concat(pe.nombres,' ',pe.apellidos) as nombres
		FROM public.perfiles_x_personas as pp, public.personas as pe
		where pp.id_personas = pe.id
		and pp.id_perfiles = 16
		");
		$result = $command->queryAll();
		$doctores = array();
		foreach ($result as $r)
		{
			$doctores[$r['id']]= $r['nombres'];
		}
		
		//variable con la conexion a la base de datos 
		$connection = Yii::$app->getDb();
		$command = $connection->createCommand("
		SELECT es.id_perfiles_x_personas as id, concat(pe.nombres,' ',pe.apellidos) as nombres
		FROM public.estudiantes as es, public.perfiles_x_personas as pp, public.personas as pe
		where es.id_perfiles_x_personas = pp.id
		and pp.id_personas = pe.id
		and pp.id_perfiles = 11
		");
		$result = $command->queryAll();
		$estudiantes = array();
		foreach ($result as $r)
		{
			$estudiantes[$r['id']]= $r['nombres'];
		}
		

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' 		=> $model,
			'estudiantes'	=> $estudiantes,
			'doctores' 		=> $doctores,
			'idSedes' 		=> $idSedes,
			'idInstitucion' => $institucion->id_instituciones,
			'AAcademico'	=> $AAcademico,
        ]);
    }

    /**
     * Deletes an existing ApoyoAcademico model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
	 
	//cambia el estado a 2 para borrar los datos
    public function actionDelete($id)
    {
       
		$model = $this->findModel($id);
		$model->estado = 2;
		$model->update(false);
		
		
		return $this->redirect(['index', 'idEstudiante' => $model->id_persona_estudiante]);
		
    }

    /**
     * Finds the ApoyoAcademico model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return ApoyoAcademico the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ApoyoAcademico::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
