<?php
/**********
Versión: 001
Fecha: 19-06-2018
---------------------------------------
Modificaciones:
Fecha: 18-06-2018
Persona encargada: Edwin Molina Grisales
Cambios realizados: Se deja institución y sede por defecto según la session 
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
use app\models\Inasistencias;
use app\models\InasistenciasBuscar;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;

/**
 * InasistenciasController implements the CRUD actions for Inasistencias model.
 */
class InasistenciasController extends Controller
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
     * Lists all Inasistencias models.
     * @return mixed
     */
    // public function actionIndex( $idInstitucion = 0, $idSedes = 0, $idDocente = 0, $idGrupo = 0, $idAsignatura = 0, $idPeriodo = 0 )
    public function actionIndex(  $idDocente = 0, $idGrupo = 0, $idAsignatura = 0, $idPeriodo = 0 )
    {
		$idInstitucion 	= $_SESSION['instituciones'][0];
		$idSedes 		= $_SESSION['sede'][0];
		
		if( $idInstitucion == 0 || $idSedes == 0 || $idDocente == 0 || $idGrupo == 0 || $idAsignatura == 0 || $idPeriodo == 0 ){
			
			$searchModel = new InasistenciasBuscar();
			$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
			
			return $this->render('listarInstituciones', [
				'searchModel' => $searchModel,
				'dataProvider' => $dataProvider,
				
				'idInstitucion' => $idInstitucion,
				'idSedes' 		=> $idSedes,
				'idDocente' 	=> $idDocente,
				'idGrupo' 		=> $idGrupo,
				'idAsignatura' 	=> $idAsignatura,
				'idPeriodo' 	=> $idPeriodo,
			]);
		}
		else{
			
			$searchModel = new InasistenciasBuscar();
			$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

			
			return $this->render('index', [
				'searchModel' => $searchModel,
				'dataProvider' => $dataProvider,
				
				'idInstitucion' => $idInstitucion,
				'idSedes' 		=> $idSedes,
				'idDocente' 	=> $idDocente,
				'idGrupo' 		=> $idGrupo,
				'idAsignatura' 	=> $idAsignatura,
				'idPeriodo' 	=> $idPeriodo,
			]);
		}
    }

    /**
     * Displays a single Inasistencias model.
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
     * Creates a new Inasistencias model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
		$data = [
			'error' => 0,
			'msg' 	=> "",
			'html' 	=> "",
		];
		
        $model = new Inasistencias();

        if ($model->load(Yii::$app->request->post())) {
            // return $this->redirect(['view', 'id' => $model->id]);
			
			$inasistencia = Inasistencias::find()
									->where( "id_perfiles_x_personas_estudiantes=".$model->id_perfiles_x_personas_estudiantes )
									->andWhere( "id_distribuciones_academicas=".$model->id_distribuciones_academicas )
									->andWhere( "fecha='".$model->fecha."'" )
									->andWhere( "estado=1" );
									
			if( $inasistencia->count() == 0  )
			{
				if( $model->save() )
				{
					$data['error'] 	= 0;
					$data['msg'] 	= "faltó";
					// return 1;
				}
			}
			else
			{
				$model = $inasistencia->one();
				$model->estado = 2;
				$model->update(false);
				
				$data['error'] 	= 1;
				$data['msg'] 	= "asistió";
				
				// return 2;
			}
			
        }
		else{
			$data['error'] 	= 2;
			$data['msg'] 	= $model->errors;
			// return json_encode( $model->errors );
		}
		
		return Json::encode( $data );
    }

    /**
     * Updates an existing Inasistencias model.
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
     * Deletes an existing Inasistencias model.
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
     * Finds the Inasistencias model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Inasistencias the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Inasistencias::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
