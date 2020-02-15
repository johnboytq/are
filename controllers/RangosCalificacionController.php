<?php

/**********
Versión: 001
Fecha: 13-03-2018
Desarrollador: Oscar David Lopez
Descripción: CRUD de RangosCalificacion
---------------------------------------
Modificaciones:
Fecha: 12-04-2018
Persona encargada: Edwin Molina Grisales
Cambios realizados: - Se deja institución por defecto la seleccionada al inicio de SESSION
---------------------------------------
Fecha: 13-03-2018
Persona encargada: Oscar David Lopez
Cambios realizados: - Modificaciones para que siempre pida la institucion,
cambios en todas las funciones 
Se agrega la funcion  actionListarInstituciones()
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
use app\models\RangosCalificacion;
use app\models\RangosCalificacionBuscar;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Instituciones;
use yii\helpers\ArrayHelper;
use app\models\Estados;
use app\models\TiposCalificacion;


/**
 * RangosCalificacionController implements the CRUD actions for RangosCalificacion model.
 */
class RangosCalificacionController extends Controller
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
	
	//funcion para renderizar la vista listarInstituciones
	public function actionListarInstituciones( $idInstitucion = 0 )
    {
        return $this->render('listarInstituciones',
		[
			'idInstitucion' => $idInstitucion,
		] );
		
    }


    /**
     * Lists all RangosCalificacion models.
     * @return mixed
     */
	 
	 //se obliga siempre a tener una institucion seleccionada
	 //se agrega parametro para validar si esta seleccionada la institucion
    // public function actionIndex($idInstitucion = 0)
    public function actionIndex()
    {
		$idInstitucion 	= $_SESSION['instituciones'][0];
		
		// Si existe id sedes e institución se muestra la listas de todas las jornadas correspondientes
		if( $idInstitucion != 0)
		{
			$searchModel = new RangosCalificacionBuscar();
			$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
			$dataProvider->query->andwhere('estado=1');
			return $this->render('index', [
				'searchModel' => $searchModel,
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
     * Displays a single RangosCalificacion model.
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
     * Creates a new RangosCalificacion model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
	 
	//parametro que sirve para asociar los datos que se ingresan con la institucion 
    public function actionCreate($idInstitucion)
    {
		//se consulta el nombre de la institucion para se insertada simpre es la institucion actual
		$institucionNombre = new Instituciones();
		$institucionNombre = $institucionNombre->find()->where('id='.$idInstitucion)->all();
		$institucionNombre = ArrayHelper::map($institucionNombre,'id','descripcion');
		
		//se consultan los nombres de los tipos calificaciones
		$TiposCalificacion = new TiposCalificacion();
		$TiposCalificacion = $TiposCalificacion->find()->all();
		$TiposCalificacion = ArrayHelper::map($TiposCalificacion,'id','descripcion');
		
		//se consulta el nombre del estado para se insertada siempre inserta activo
		$estados = new Estados();
		$estados = $estados->find()->where('id=1')->all();
		$estados = ArrayHelper::map($estados,'id','descripcion');
		
		
		
        $model = new RangosCalificacion();
		// echo "<pre>"; print_r($_POST); echo "</pre>";
		// die;
		
		
        if ($model->load(Yii::$app->request->post())) 
		{
			
			$valor_minimo	= $_POST['RangosCalificacion']['valor_minimo'];
			$valor_maximo 	= $_POST['RangosCalificacion']['valor_maximo'];
            $descripcion 	= $_POST['RangosCalificacion']['descripcion'];
            
			//variable con la conexion a la base de datos
			$connection = Yii::$app->getDb();
			//saber el id de la sede para redicionar al index correctamente
			$command = $connection->createCommand("
			SELECT valor_minimo, valor_maximo, descripcion
			FROM public.rangos_calificacion
			WHERE valor_minimo = $valor_minimo
			and valor_maximo =$valor_maximo
			and descripcion='$descripcion'
			and estado = 1
			");
			$result = $command->queryAll();			
			if (count($result) == 0)
			{
				$model->save();	
				return $this->redirect(['view', 'id' => $model->id]);
			}
			else
			{				
				echo "<script>alert('el rango Calificacion ya existe');</script>";
				// die("<script>alert('el rango Calificacion ya existe');</script>");
				
			}
						
            
        }

        return $this->render('create', [
            'model' => $model,
			'idInstitucion'=>$idInstitucion,
			'institucionNombre'=>$institucionNombre,
			'estados'=>$estados,
			'TiposCalificacion'=>$TiposCalificacion,
        ]);
    }

    /**
     * Updates an existing RangosCalificacion model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
		 $model = $this->findModel($id);
		 
		 $idInstitucion =$model->id_instituciones;
		//se consulta el nombre de la institucion para se insertada simpre es la institucion actual
		$institucionNombre = new Instituciones();
		$institucionNombre = $institucionNombre->find()->where('id='.$idInstitucion)->all();
		$institucionNombre = ArrayHelper::map($institucionNombre,'id','descripcion');
		
		//se consultan los nombres de los tipos calificaciones
		$TiposCalificacion = new TiposCalificacion();
		$TiposCalificacion = $TiposCalificacion->find()->all();
		$TiposCalificacion = ArrayHelper::map($TiposCalificacion,'id','descripcion');
		
		//se consulta el nombre del estado para se insertada siempre inserta activo
		$estados = new Estados();
		$estados = $estados->find()->all();
		$estados = ArrayHelper::map($estados,'id','descripcion');
		
       

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
			'idInstitucion'=>$idInstitucion,
			'institucionNombre'=>$institucionNombre,
			'estados'=>$estados,
			'TiposCalificacion'=>$TiposCalificacion,
        ]);
    }

    /**
     * Deletes an existing RangosCalificacion model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = RangosCalificacion::findOne($id);
		//no borra se modifica el estado
		// $model = RangosCalificacion::findOne($id);
		$model->estado = 2;
		$model->update(false);

		return $this->redirect(['index', 'idInstitucion' => $model->id_instituciones]);	
    }

    /**
     * Finds the RangosCalificacion model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return RangosCalificacion the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RangosCalificacion::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
