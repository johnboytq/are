<?php

/**********
Versión: 001
Fecha modificación: 24-04-2018
Desarrollador: Oscar David Lopez
Descripción: se agrega el campo estado a las consultas con la tabla perfiles por persona
---------------------------------------
Modificaciones:
Fecha: 12-04-2018
Persona encargada: Edwin Molina Grisales
Cambios realizados: - Se deja institución y sede por defecto las seleccionadas al inicio de SESSION
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
use app\models\Estudiantes;
use app\models\EstudiantesBuscar;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Estados;
use app\models\Paralelos;
use	yii\helpers\ArrayHelper;
use yii\helpers\Json;
/**
 * EstudiantesController implements the CRUD actions for Estudiantes model.
 */
class EstudiantesController extends Controller
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

	
	public function actionListarParalelosSedes($idNivel,$idSede)
    {		
		
		$connection = Yii::$app->getDb();
		$command = $connection->createCommand("SELECT p.id, p.descripcion
		FROM public.sedes_niveles as sn, paralelos as p
		where sn.id_sedes=$idSede
		and sn.id = p.id_sedes_niveles
		and sn.id = $idNivel
		");
		$result = $command->queryAll();
		
		
		$paralelosSedes[] = "<option value=''>Seleccione...</option>";
		foreach ($result as $key)
		{
			$id = $key['id'];
			$descripcion = $key['descripcion'];
			$paralelosSedes[] = "<option value='$id'>$descripcion</option>";
		}
		
		return Json::encode( $paralelosSedes );
        
    }
	

    /**
     * Lists all Estudiantes models.
     * @return mixed
     */
    // public function actionIndex($idInstitucion = 0, $idSedes = 0)
    public function actionIndex()
    {
		$idInstitucion 	= $_SESSION['instituciones'][0];
		$idSedes 		= $_SESSION['sede'][0];
		
		if( $idInstitucion != 0 && $idSedes != 0 )
		{

        $searchModel = new EstudiantesBuscar();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		
		$dataProvider->query->select ("e.id_perfiles_x_personas, e.id_paralelos");
		$dataProvider->query->from( 'estudiantes as e, paralelos as p, sedes_niveles as sn');
		$dataProvider->query->andwhere("e.id_paralelos = p.id
										and p.id_sedes_niveles =sn.id
										and sn.id_sedes = $idSedes										
										");
		
        
		
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			'idSedes' 	=> $idSedes,
			'idInstitucion' => $idInstitucion,
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
     * Displays a single Estudiantes model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
		$model = $this->findModel($id);
		
		$connection = Yii::$app->getDb();
		
		$command = $connection->createCommand("
		SELECT sn.id_sedes, p.id_sedes_niveles as niveles_sede
		FROM public.paralelos as p, public.sedes_niveles as sn
		where p.id_sedes_niveles = sn.id
		and p.id = $model->id_paralelos
		");
		$result = $command->queryAll();
		$idSedes = $result[0]['id_sedes'];
        
		
		return $this->render('view', [
            'model' => $model,
			'idSedes' =>$idSedes,
        ]);
    }

    /**
     * Creates a new Estudiantes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($idSedes, $idInstitucion)
    {
        $model = new Estudiantes();		
		
		$connection = Yii::$app->getDb();
		$command = $connection->createCommand("
		SELECT es.id_perfiles_x_personas, concat(pe.nombres,' ',pe.apellidos) as nombres
		FROM public.estudiantes as es, public.perfiles_x_personas as pp, public.personas as pe
		where es.id_perfiles_x_personas = pp.id
		and pp.id_personas = pe.id
        and pp.estado = 1		
		");
		$result = $command->queryAll();
		$estudiantes = array();
		foreach ( $result as $key)
		{
			$estudiantes[$key['id_perfiles_x_personas']] = $key['nombres']; 
		}
		
		$estados = new Estados();
		$estados = $estados->find()->where('id=1')->all();
		$estados = ArrayHelper::map($estados,'id','descripcion');
		

        if ($model->load(Yii::$app->request->post())) 
		{
			
			
			$id = $_POST['Estudiantes']['id_perfiles_x_personas'];
			$model = Estudiantes::findOne($id);
			
			$idParalelos =$_POST['Estudiantes']['id_paralelos'];
			$model->id_paralelos = $idParalelos;
			$model->update(false);
		
			
            return $this->redirect(['view', 'id' => $model->id_perfiles_x_personas]);
        }

        return $this->render('create', [
            'model' => $model,
			'estudiantes'=>$estudiantes,
			'idSedes'=>$idSedes,
			'estados'=>$estados,
			'idInstitucion'=>$idInstitucion,
        ]);
    }

    /**
     * Updates an existing Estudiantes model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
		
		$model = $this->findModel($id);
		
		$estados = new Estados();
		$estados = $estados->find()->all();
		$estados = ArrayHelper::map($estados,'id','descripcion');

		$paralelos = $model->id_paralelos;
		
		$connection = Yii::$app->getDb();
		
		
		
		$command = $connection->createCommand("
		SELECT sn.id_sedes, p.id_sedes_niveles as niveles_sede
		FROM public.paralelos as p, public.sedes_niveles as sn
		where p.id_sedes_niveles = sn.id
		and p.id = $model->id_paralelos
		");
		$result = $command->queryAll();
		$idSedes = $result[0]['id_sedes'];
		$niveles_sede = $result[0]['niveles_sede'];
		
		$command = $connection->createCommand("
		SELECT es.id_perfiles_x_personas, concat(pe.nombres,' ',pe.apellidos) as nombres
		FROM public.estudiantes as es, public.perfiles_x_personas as pp, public.personas as pe
		where es.id_perfiles_x_personas = pp.id
		and pp.id_personas = pe.id
		and pp.estado = 1
		");
		$result = $command->queryAll();
		
		foreach ( $result as $key)
		{
			$estudiantes[$key['id_perfiles_x_personas']] = $key['nombres']; 
		}	
		

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_perfiles_x_personas]);
        }

        return $this->render('update', [
            'model' => $model,
			'estados'=>$estados,
			'paralelos'=>$paralelos,
			'estudiantes'=>$estudiantes,
			'idSedes'=>$idSedes,
			'niveles_sede'=>$niveles_sede,
        ]);
    }

    /**
     * Deletes an existing Estudiantes model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
		
		$model = $this->findModel($id);
		$connection = Yii::$app->getDb();

		//consultas para redireccionar a la vista con la institucion y la sede correspondiente
		
		//selecciona la sede desde sedes_jornadas que pertenece a ese paralelo
		$command = $connection->createCommand
		("
			SELECT sn.id_sedes
			FROM public.paralelos as p, public.sedes_niveles as sn
			WHERE p.id_sedes_niveles = sn.id
			and p.id=$model->id_paralelos
		");		
		$result = $command->queryAll();
		$idSedes = $result[0]['id_sedes'];
		//se obtiene el de la institucion de esa sede
		$command = $connection->createCommand("
		SELECT i.id
		FROM instituciones as i,sedes as s
		WHERE s.id_instituciones = i.id
		and s.id = $idSedes
		");
		$result = $command->queryAll();
		$idInstituciones = $result[0]['id'];	
		
		$model = Estudiantes::findOne($id);
		$model->id_paralelos = '';
		$model->update(false);
		
		
        // $this->findModel($id)->delete();
		return $this->redirect(['index', 'idInstitucion' => $idInstituciones,'idSedes'=>$idSedes]);	
    }

    /**
     * Finds the Estudiantes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Estudiantes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Estudiantes::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
