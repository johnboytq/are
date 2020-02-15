<?php
/**********
Versión: 001
Fecha: 17-03-2018
Desarrollador: Oscar David Lopez
Descripción: CRUD de ponderacion de resultados
---------------------------------------
Modificaciones:
Fecha: 12-04-2018
Persona encargada: Edwin Molina Grisales
Cambios realizados: - Se deja institución y sede por defecto las seleccionadas al inicio de SESSION
---------------------------------------
Fecha: 17-03-2018
Persona encargada: Oscar David Lopez
Cambios realizados: - se elimina el campo id para mostrar
---------------------------------------
Modificaciones:
Fecha: 27-04-2018
Persona encargada: Oscar David Lopez
Cambios realizados: - se agrega el seleccionar la sede y la institucion
---------------------------------------
Modificaciones:
Fecha: 28-04-2018
Persona encargada: Oscar David Lopez
Cambios realizados: - no se pude agregar una ponderacion de mas del 100%
Se corrige la redireccion al index cuando se inactiva una ponderacion
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
use app\models\PonderacionResultados;
use app\models\PonderacionResultadosBuscar;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Periodos;
use app\models\Estados;
use app\models\Sedes;
use	yii\helpers\ArrayHelper;


/**
 * PonderacionResultadosController implements the CRUD actions for PonderacionResultados model.
 */
class PonderacionResultadosController extends Controller
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

	
	//saber cuanto porcentaje han asignado a la ponderacion no pueder ser mas de 100
	
	public function actionCantidadPonderacion($idSede, $ponderacion = 0,$idPonderacion = 0)
	{
		$cantidadPonderacion = new PonderacionResultados();
		$cantidadPonderacion = $cantidadPonderacion->find()
								->where('id_sede='.$idSede)
								->andWhere( 'estado=1')
								->all();
		$cantidadPonderacion = ArrayHelper::map($cantidadPonderacion,'id','calificacion');
		// 
											// ->all();
		//saber si $idPonderacion es diferente de 0 o que se esta actualizando una ponderacion
		if($idPonderacion !=0)
		{
			unset($cantidadPonderacion[$idPonderacion]);
			
		}

		$totalPonderacion=0;
		foreach( $cantidadPonderacion as $c)
		{
			//cuanto porcentaje han asignado a la ponderacion
			$totalPonderacion +=$c;
		}
		// print_r($cantidadPonderacion);
		$total = $totalPonderacion + $ponderacion;
		
		if ($total >100)
		{
			$data = array('error'=>1,'total'=>$total);
			echo json_encode($data);
			
		}
		die();
	}
	
	public function actionListarInstituciones( $idInstitucion = 0, $idSedes = 0 )
    {
        return $this->render('listarInstituciones',[
			'idSedes' 		=> $idSedes,
			'idInstitucion' => $idInstitucion,
		] );
    }

    /**
     * Lists all PonderacionResultados models.
     * @return mixed
     */
    // public function actionIndex($idInstitucion = 0, $idSedes = 0)
    public function actionIndex()
    {
		
		$idInstitucion 	= $_SESSION['instituciones'][0];
		$idSedes 		= $_SESSION['sede'][0];
		
		if( $idInstitucion != 0 && $idSedes != 0 )
		{

		
        $searchModel = new PonderacionResultadosBuscar();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andwhere( 'estado=1');
        $dataProvider->query->andwhere( 'id_sede='.$idSedes);

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
     * Displays a single PonderacionResultados model.
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
     * Creates a new PonderacionResultados model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($idSedes, $idInstitucion)
    {
		//se envia la variable periodos con los valores de la tabla periodos
		$periodos = new Periodos();
		$periodos = $periodos->find()->where("id_sedes=".$idSedes)->all();
		$periodos = ArrayHelper::map($periodos,'id','descripcion');
		
		
		//se envia la variable estados con los valores de la tabla estado, siempre es activo
		$estados = new Estados();
		$estados = $estados->find()->where('id=1')->all();
		$estados = ArrayHelper::map($estados,'id','descripcion');
		
        $model = new PonderacionResultados();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
			'periodos'=>$periodos,
			'estados'=>$estados,
			'idSedes'=>$idSedes,
			'idInstitucion' => $idInstitucion
        ]);
    }

    /**
     * Updates an existing PonderacionResultados model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {	
		$model = $this->findModel($id);
		
		//se envia la variable periodos con los valores de la tabla periodos
		$periodos = new Periodos();
		$periodos = $periodos->find()->where("id_sedes=".$model->id_sede)->all();
		$periodos = ArrayHelper::map($periodos,'id','descripcion');
		
		
		//se envia la variable estados con los valores de la tabla estado, siempre es activo
		$estados = new Estados();
		$estados = $estados->find()->all();
		$estados = ArrayHelper::map($estados,'id','descripcion');
		
        

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
			'periodos'=>$periodos,
			'estados'=>$estados,
        ]);
    }

    /**
     * Deletes an existing PonderacionResultados model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
		
		$model = PonderacionResultados::findOne($id);
		$model->estado = 2;
		$idSedes = $model->id_sede;
		
		$model->update(false);
		
        // $this->findModel($id)->delete();
		$idInstitucion = Sedes::find()->where('id='.$idSedes)->one();
		$idInstitucion = $idInstitucion->id_instituciones;

		return $this->redirect(['index', 'idInstitucion' => $idInstitucion, 'idSedes' => $idSedes ]);
        // return $this->redirect(['index']);
    }

    /**
     * Finds the PonderacionResultados model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PonderacionResultados the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PonderacionResultados::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
