<?php
/**********
Versión: 001
Fecha: 06-03-2018
---------------------------------------
Modificaciones:
Fecha: 18-06-2018
Persona encargada: Edwin Molina Grisales
Cambios realizados: Se deja instición y sede según la SESSION
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
use app\models\ParticipacionProyectosIE;
use app\models\ParticipacionProyectosIEBuscar;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


use app\models\Estados;
use app\models\NombresProyectosParticipacion;
use app\models\Instituciones;
use yii\helpers\ArrayHelper;

/**
 * ParticipacionProyectosIEController implements the CRUD actions for ParticipacionProyectosIE model.
 */
class ParticipacionProyectosIEController extends Controller
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
     * Lists all Sedes models.
     * @return mixed
     */
    public function actionListarInstituciones()
    {
        return $this->render( "listarInstituciones" );
    }

    /**
     * Lists all ParticipacionProyectosIE models.
     * @return mixed
     */
    // public function actionIndex( $idInstitucion = 0 )
    public function actionIndex( $idInstitucion = 0 )
    {
		$idInstitucion 	= $_SESSION['instituciones'][0];
		
		if( $idInstitucion > 0 )
		{
			$searchModel = new ParticipacionProyectosIEBuscar();
			$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
			$dataProvider->query->andWhere( 'estado=1' );

			return $this->render('index', [
				'searchModel' 	=> $searchModel,
				'dataProvider' 	=> $dataProvider,
				'idInstitucion'	=> $idInstitucion,
			]);
		}
		else{
			return $this->render( "listarInstituciones" );
		}
    }

    /**
     * Displays a single ParticipacionProyectosIE model.
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
     * Creates a new ParticipacionProyectosIE model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate( $idInstitucion = 0 )
    {
        $model = new ParticipacionProyectosIE();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
		
		$dataEstados  = Estados::find()->where( 'id=1' )->all();
		$estados 	  = ArrayHelper::map( $dataEstados, 'id', 'descripcion' );
		
		$dataNombresProyectos	= NombresProyectosParticipacion::find()
									->innerJoin( 'tipos_participacion tp', 'tp.id=tipo' )
									->where( 'nombres_proyectos_participacion.estado=1' )
									->andWhere( 'tipo=2' )
									->andWhere( 'tp.estado=1' )
									->all();
		$nombresProyectos 	  	= ArrayHelper::map( $dataNombresProyectos, 'id', 'descripcion' );
		
		$dataInstitucion  = Instituciones::find()->where( 'id='.$idInstitucion )->all();
		$institucion 	  = ArrayHelper::map( $dataInstitucion, 'id', 'descripcion' );

        return $this->render('create', [
            'model' 			=> $model,
            'idInstitucion' 	=> $idInstitucion,
            'estados' 			=> $estados,
            'nombresProyectos' 	=> $nombresProyectos,
            'institucion' 		=> $institucion,
        ]);
    }

    /**
     * Updates an existing ParticipacionProyectosIE model.
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
		
		$dataEstados  = Estados::find()->where( 'id=1' )->all();
		$estados 	  = ArrayHelper::map( $dataEstados, 'id', 'descripcion' );
		
		$dataNombresProyectos	= NombresProyectosParticipacion::find()
									->innerJoin( 'tipos_participacion tp', 'tp.id=tipo' )
									->where( 'nombres_proyectos_participacion.estado=1' )
									->andWhere( 'tipo=2' )
									->andWhere( 'tp.estado=1' )
									->all();
		$nombresProyectos 	  	= ArrayHelper::map( $dataNombresProyectos, 'id', 'descripcion' );
		
		$dataInstitucion  = Instituciones::find()->where( 'id='.$model->id_institucion )->all();
		$institucion 	  = ArrayHelper::map( $dataInstitucion, 'id', 'descripcion' );

        return $this->render('update', [
            'model' => $model,
			'idInstitucion' 	=> $model->id_institucion,
            'estados' 			=> $estados,
            'nombresProyectos' 	=> $nombresProyectos,
            'institucion' 		=> $institucion,
        ]);
    }

    /**
     * Deletes an existing ParticipacionProyectosIE model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        // $this->findModel($id)->delete();
        $model = $this->findModel($id);
		$model->estado = 2;
		$model->update( false );

        return $this->redirect(['index', 'idInstitucion' => $model->id_institucion ]);
    }

    /**
     * Finds the ParticipacionProyectosIE model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return ParticipacionProyectosIE the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ParticipacionProyectosIE::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
