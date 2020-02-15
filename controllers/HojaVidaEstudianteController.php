<?php
/**********
Versión: 001
Fecha: Fecha modificacion (06-06-2018)
Desarrollador: Edwin Molina Grisales
Descripción: Se validan datos que puedan no existir en la base de datos para el estudiante que se busca
---------------------------------------
*/

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
use app\models\HojaVidaEstudiante;
use app\models\HojaVidaEstudianteBuscar;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * HojaVidaEstudianteController implements the CRUD actions for HojaVidaEstudiante model.
 */
class HojaVidaEstudianteController extends Controller
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
     * Lists all HojaVidaEstudiante models.
     * @return mixed
     */
    public function actionIndex()
    {
		// if( Yii::$app->request->queryParams['HojaVidaEstudianteBuscar']['id'] )
			// echo "Mmm....". Yii::$app->request->queryParams['HojaVidaEstudianteBuscar']['id'];
		
		// var_dump( Yii::$app->request->queryParams );
		// exit();
		
        $searchModel = new HojaVidaEstudianteBuscar();
        $dataProvider = $searchModel->search('');
        $dataProvider->query
			->select( 	'personas.identificacion, 
						 personas.nombres, 
						 personas.apellidos, 
						 personas.fecha_nacimiento, 
						 personas.id_tipos_identificaciones, 
						 personas.id_generos, 
						 i.id as institucion,
						 s.id as sede,
						 j.id as jornada,
						 p.descripcion as grupo,
						 prl.id,
						 ( \'SI\' ) as mio
						 ' 
						 )
			->leftJoin( 'perfiles_x_personas pp', 'pp.id_personas=personas.id' )
			->leftJoin( 'estudiantes e', 'e.id_perfiles_x_personas=pp.id' )
			->leftJoin( 'representantes_legales rl', 'rl.id_perfiles_x_personas=pp.id' )
			->leftJoin( 'personas prl', 'prl.id=rl.id_personas' )
			->leftJoin( 'perfiles_x_personas_institucion ppi', 'ppi.id_perfiles_x_persona=pp.id' )
			->leftJoin( 'instituciones i', 'i.id=ppi.id_institucion' )
			->leftJoin( 'paralelos p', 'p.id=e.id_paralelos' )
			->leftJoin( 'sedes_jornadas sj', 'sj.id=p.id_sedes_jornadas' )
			->leftJoin( 'jornadas j', 'j.id=sj.id_jornadas' )
			->leftJoin( 'sedes s', 's.id=sj.id_sedes' )
			->andWhere( 'personas.estado=1' )
			->andWhere( 'e.estado=1' )
			// ->andWhere( 'prl.estado=1' )
			->andWhere( 'ppi.estado=1' )
			->andWhere( 'pp.estado=1' );
		if( Yii::$app->request->queryParams && array_key_exists( 'HojaVidaEstudianteBuscar', Yii::$app->request->queryParams ) && Yii::$app->request->queryParams['HojaVidaEstudianteBuscar']['id'] )
			$dataProvider->query->andWhere( 'personas.id='.Yii::$app->request->queryParams['HojaVidaEstudianteBuscar']['id'] );
		else
			$dataProvider->query->andWhere( 'personas.id=-1' );

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single HojaVidaEstudiante model.
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
     * Creates a new HojaVidaEstudiante model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new HojaVidaEstudiante();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing HojaVidaEstudiante model.
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
     * Deletes an existing HojaVidaEstudiante model.
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
     * Finds the HojaVidaEstudiante model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return HojaVidaEstudiante the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = HojaVidaEstudiante::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
