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
use app\models\SancionesEstudiantes;
use app\models\SancionesEstudiantesBuscar;
use app\models\Estados;
use	yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SancionesEstudiantesController implements the CRUD actions for SancionesEstudiantes model.
 */
class SancionesEstudiantesController extends Controller
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
	
	
	public function obtenerEstados()
	{
		$estados = new Estados();
		$estados = $estados->find()->orderby("id")->all();
		$estados = ArrayHelper::map($estados,'id','descripcion');
		
		return $estados;
	}
	
	//los estudiantes de la sede actual y con el formato para llenar un comboBox
	public function mostrarEstudiantes()
	{
		
		$idInstitucion = $_SESSION['instituciones'][0];
		$idSedes 		= $_SESSION['sede'][0];
		$connection = Yii::$app->getDb();
		//saber el id de la sede para redicionar al index correctamente
		// $command = $connection->createCommand("
			// select pp.id,concat(p.nombres,' ',p.apellidos) as nombre
			// from personas as p, perfiles_x_personas as pp, perfiles_x_personas_institucion as ppi
			// where pp.id_personas  = p.id
			// and pp.id = ppi.id_perfiles_x_persona
			// and ppi.id_institucion = $idInstitucion
			// and pp.id_perfiles = 11
		// ");
		
		$command = $connection->createCommand("
			SELECT
				pp.id,
				concat(p.nombres,' ',p.apellidos) as nombres
			FROM 
				personas as p, 
				perfiles_x_personas as pp, 
				estudiantes as e, 
				perfiles as pe,
				paralelos as pa,
				sedes_niveles as sn
			WHERE
				pp.id_personas = p.id
			AND
				pp.id = e.id_perfiles_x_personas
			AND
				pe.id = 11
			AND
				e.id_paralelos = pa.id
			AND 
				pa.id_sedes_niveles = sn.id
			AND 
				sn.id_sedes = '$idSedes'
		");
		
		
		$result = $command->queryAll();
		$estudiantes = [];
		foreach ($result as $r)
		{
			$estudiantes[$r['id']] = $r['nombres'];
		}
		return $estudiantes;
	}

    /**
     * Lists all SancionesEstudiantes models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SancionesEstudiantesBuscar();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$dataProvider->query->andWhere('estado=1');
		
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SancionesEstudiantes model.
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
     * Creates a new SancionesEstudiantes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SancionesEstudiantes();
		
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
		
        return $this->render('create', [
            'model' => $model,
			'estudiantes'=> $this->mostrarEstudiantes(),
			'estados'=>$this->obtenerEstados(),
        ]);
    }

    /**
     * Updates an existing SancionesEstudiantes model.
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
			'estudiantes'=> $this->mostrarEstudiantes(),
			'estados'=>$this->obtenerEstados(),
        ]);
    }

    /**
     * Deletes an existing SancionesEstudiantes model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
	
		$model->estado = 2;
		$model->update(false);

        return $this->redirect(['index']);
    }

    /**
     * Finds the SancionesEstudiantes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return SancionesEstudiantes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SancionesEstudiantes::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
