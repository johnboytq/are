<?php

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
use app\models\VinculacionDocentes;
use app\models\VinculacionDocentesBuscar;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


use app\models\Personas;
use app\models\PerfilesPersonas;
use app\models\Estados;
use app\models\TiposContratos;
use yii\helpers\ArrayHelper;

/**
 * VinculacionDocentesController implements the CRUD actions for VinculacionDocentes model.
 */
class VinculacionDocentesController extends Controller
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
     * Lists all VinculacionDocentes models.
     * @return mixed
     */
    public function actionIndex()
    {
		$tiposContratosData = TiposContratos::find()->where( 'estado=1' )->all();
		$tiposContratos	 	= ArrayHelper::map( $tiposContratosData, 'id', 'descripcion' );
		
		$personasData 	= Personas::find()
										->innerJoin('perfiles_x_personas pf', 'personas.id=pf.id_personas' )
										->innerJoin('docentes d', 'd.id_perfiles_x_personas=pf.id' )
										->where( 'personas.estado=1' )
										->where( 'd.estado=1' )
										->all();
		$personas	 	= ArrayHelper::map( $personasData, 'id', 'nombres' );
		
        $searchModel = new VinculacionDocentesBuscar();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere( 'estado=1' );

        return $this->render('index', [
            'searchModel' 	=> $searchModel,
            'dataProvider' 	=> $dataProvider,
            'tiposContratos'=> $tiposContratos,
            'personas' 		=> $personas,
        ]);
    }

    /**
     * Displays a single VinculacionDocentes model.
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
     * Creates a new VinculacionDocentes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
		$estadosData 	= Estados::find()->where( 'id=1' )->all();
		$estados		= ArrayHelper::map( $estadosData, 'id', 'descripcion' );
		
		$tiposContratosData = TiposContratos::find()->where( 'estado=1' )->all();
		$tiposContratos	 	= ArrayHelper::map( $tiposContratosData, 'id', 'descripcion' );
		
		$personasData 	= Personas::find()
										->select( "d.id_perfiles_x_personas as id, ( personas.nombres || ' ' || personas.apellidos ) nombres " )
										->innerJoin('perfiles_x_personas pf', 'personas.id=pf.id_personas' )
										->innerJoin('docentes d', 'd.id_perfiles_x_personas=pf.id' )
										->where( 'personas.estado=1' )
										->where( 'd.estado=1' )
										->all();
		$personas	 	= ArrayHelper::map( $personasData, 'id', 'nombres' );
		
        $model = new VinculacionDocentes();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' 			=> $model,
            'estados' 			=> $estados,
            'personas' 			=> $personas,
            'tiposContratos' 	=> $tiposContratos,
        ]);
    }

    /**
     * Updates an existing VinculacionDocentes model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		
		$estadosData 	= Estados::find()->all();
		$estados		= ArrayHelper::map( $estadosData, 'id', 'descripcion' );
		
		$tiposContratosData = TiposContratos::find()->where( 'estado=1' )->all();
		$tiposContratos	 	= ArrayHelper::map( $tiposContratosData, 'id', 'descripcion' );
		
		$personasData 	= Personas::find()
										->select( "d.id_perfiles_x_personas as id, ( personas.nombres || ' ' || personas.apellidos ) nombres " )
										->innerJoin('perfiles_x_personas pf', 'personas.id=pf.id_personas' )
										->innerJoin('docentes d', 'd.id_perfiles_x_personas=pf.id' )
										->where( 'personas.estado=1' )
										->where( 'd.estado=1' )
										->all();
		$personas	 	= ArrayHelper::map( $personasData, 'id', 'nombres' );
		

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' 			=> $model,
			'estados' 			=> $estados,
            'personas' 			=> $personas,
            'tiposContratos' 	=> $tiposContratos,
        ]);
    }

    /**
     * Deletes an existing VinculacionDocentes model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
		$model->estado=2;
		$model->update(false);

        return $this->redirect(['index']);
    }

    /**
     * Finds the VinculacionDocentes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return VinculacionDocentes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = VinculacionDocentes::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
