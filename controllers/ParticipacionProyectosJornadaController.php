<?php
/**********
Versión: 001
Fecha: 27-03-2018
Desarrollador: Oscar David Lopez
Descripción: CRUD de Representantes Legales (Estudiantes)
---------------------------------------
Modificaciones:
Fecha: 18-06-2018
Persona encargada: Edwin Molina Grisales
Cambios realizados: Se deja instición y sede según la SESSION
---------------------------------------
Fecha: 27-03-2018
Persona encargada: Oscar David Lopez
Cambios realizados: - 
funciones para obtener los nombre de los campos relacionados
Funcion actionCreate
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
use app\models\ParticipacionProyectosJornada;
use app\models\ParticipacionProyectosJornadaBuscar;
use app\models\NombresProyectosParticipacion;
use app\models\Personas;
use app\models\Perfiles;
use app\models\Instituciones;
use app\models\Estados;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use	yii\helpers\ArrayHelper;

/**
 * ParticipacionProyectosJornadaController implements the CRUD actions for ParticipacionProyectosJornada model.
 */
class ParticipacionProyectosJornadaController extends Controller
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
	
	// public function actionListarInstituciones( $idInstitucion = 0 )
	// {
		// return $this->render('listarInstituciones',[
			// 'idInstitucion' => $idInstitucion,
		// ] );
	// }
	
	
	public function obtenerEstados()
	{
		$estados = new Estados();
		$estados = $estados->find()->orderby("id")->all();
		$estados = ArrayHelper::map($estados,'id','descripcion');
		
		return $estados;
	}
	
	public function obtenerNombrePrograma()
	{
		$nombresProyectos = new NombresProyectosParticipacion();
		$nombresProyectos = $nombresProyectos->find()->orderby("id")->all();
		$nombresProyectos = ArrayHelper::map($nombresProyectos,'id','descripcion');
		
		return $nombresProyectos;
	}
	
	public function actionNombrePersona($idInstitucion,$idPerfil)
	{	
	
		$connection = Yii::$app->getDb();
		//saber el id de la sede para redicionar al index correctamente
		$command = $connection->createCommand("
		SELECT p.id, concat (p.nombres, ' ' ,p.apellidos) as nombre
		FROM personas as p, perfiles_x_personas_institucion as ppi, perfiles_x_personas as pp
		WHERE ppi.id_institucion = $idInstitucion
		AND ppi.id_perfiles_x_persona = pp.id
		AND pp.id_personas = p.id
		AND pp.id_perfiles = $idPerfil
		");
		$nombrePersonas = $command->queryAll();
		
		// $nombrePersona = ArrayHelper::map($nombrePersona,'id','nombres');
		
		echo json_encode ( $nombrePersonas );
	}
	
	public function obtenerPerfil()
	{
		$perfiles = new Perfiles();
		$perfiles = $perfiles->find()->orderby("id")->all();
		$perfiles = ArrayHelper::map($perfiles,'id','descripcion');
		
		return $perfiles;
	}
	
	public function obtenerNombreInstitucion($id)
	{
		$nombreInstitucion = Instituciones::find()->where(['id' => $id])->one();
		$nombreInstitucion = $nombreInstitucion->descripcion;
		
		return $nombreInstitucion;
	}
	
	
    /**
     * Lists all ParticipacionProyectosJornada models.
     * @return mixed
     */
	 
	//muestra solo los registros activos y de la institucion seleccionada 
    // public function actionIndex($idInstitucion = 0)
    public function actionIndex()
    {
		$idInstitucion 	= $_SESSION['instituciones'][0];
		
		if( $idInstitucion != 0 )
		{

			$searchModel = new ParticipacionProyectosJornadaBuscar();
			$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
			$dataProvider->query->andWhere('id_institucion='.$idInstitucion);
			$dataProvider->query->andWhere('estado=1');

			$nombreInstitucion = Instituciones::findOne($idInstitucion);
			$nombreInstitucion = $nombreInstitucion ? $nombreInstitucion->descripcion : ''; 
			
			return $this->render('index', [
				'searchModel' => $searchModel,
				'dataProvider' => $dataProvider,
				'idInstitucion' => $idInstitucion,
				'nombreInstitucion' =>$nombreInstitucion,
				]);
		}
		else
		{
			// Si el id de institucion 0 se llama a la vista listarInstituciones
			 return $this->render('listarInstituciones',[
				'idInstitucion' => $idInstitucion,
			] );
		}

    }

    /**
     * Displays a single ParticipacionProyectosJornada model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
		$model = $this->findModel($id);
		$idInstitucion 		= $model->id_institucion;
		$nombreInstitucion 	= $this->obtenerNombreInstitucion($idInstitucion);
		
        return $this->render('view', [
            'model' => $model,
			'idInstitucion'		=> $idInstitucion,
			'nombreInstitucion'	=> $nombreInstitucion,
			
        ]);
    }

    /**
     * Creates a new ParticipacionProyectosJornada model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($idInstitucion)
    {
        $model = new ParticipacionProyectosJornada();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

		$nombrePrograma 	= $this->obtenerNombrePrograma();
		$tipo 				= $this->obtenerPerfil();
		$nombreInstitucion 	= $this->obtenerNombreInstitucion($idInstitucion);
		$estado 			= $this->obtenerEstados();
		
        return $this->render('create', [
            'model' 		=> $model,
			'nombrePrograma'=> $nombrePrograma,
			'tipo'			=> $tipo,
			'nombreInstitucion'	=> $nombreInstitucion,
			'idInstitucion'	=> $idInstitucion,
			'estado'		=> $estado,
        ]);
    }

    /**
     * Updates an existing ParticipacionProyectosJornada model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
		
		$model = $this->findModel($id);
		$idInstitucion 		= $model->id_institucion;
		$nombrePrograma 	= $this->obtenerNombrePrograma();
		$tipo 				= $this->obtenerPerfil();
		$nombreInstitucion 	= $this->obtenerNombreInstitucion($idInstitucion);
		$estado 			= $this->obtenerEstados();
        
		$idParticipante = $model->nombre_participante;
		//se asigna el idParticipante para que este disponible en el archivo js y ponerlo como selected
		echo "<script>idParticipante = $idParticipante ;</script>";
		
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' 		=> $model,
			'nombrePrograma'=> $nombrePrograma,
			'tipo'			=> $tipo,
			'nombreInstitucion'	=> $nombreInstitucion,
			'idInstitucion'	=> $idInstitucion,
			'estado'		=> $estado,
        ]);
    }

    /**
     * Deletes an existing ParticipacionProyectosJornada model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
		
		$model = $this->findModel($id);
		$model->estado = 2;
		$idInstitucion = $model->id_institucion;
		$model->update(false);
		return $this->redirect(['index', 'idInstitucion' => $idInstitucion]);
        
    }

    /**
     * Finds the ParticipacionProyectosJornada model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return ParticipacionProyectosJornada the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ParticipacionProyectosJornada::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
