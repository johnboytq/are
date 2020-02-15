<?php

/**********
Versión: 001
Fecha: 09-03-2018
---------------------------------------
Modificaciones:
Fecha: 13-06-2018
Persona encargada: Edwin Molina
Cambios realizados: Se deja por defecto la institución y sede de la SESSION
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
use app\models\DirectorParalelo;
use app\models\DirectorParaleloBuscar;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


use app\models\Estados;
use app\models\Sedes;
use	yii\helpers\ArrayHelper;
use app\models\Docentes;

/**
 * DirectorParaleloController implements the CRUD actions for DirectorParalelo model.
 */
class DirectorParaleloController extends Controller
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
     * Lists all DirectorParalelo models.
     * @return mixed
     */
    // public function actionIndex($idInstitucion = 0, $idSedes = 0)
    public function actionIndex()
    {
		$idInstitucion 	= $_SESSION['instituciones'][0];
		$idSedes 		= $_SESSION['sede'][0];
		
		if( $idInstitucion != 0 && $idSedes != 0 )
		{

        $searchModel = new DirectorParaleloBuscar();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$dataProvider->query->andWhere('estado=1');

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

	public function actionListarInstituciones( $idInstitucion = 0, $idSedes = 0 )
    {
        return $this->render('listarInstituciones',[
			'idSedes' 		=> $idSedes,
			'idInstitucion' => $idInstitucion,
		] );
    }
	
    /**
     * Displays a single DirectorParalelo model.
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
     * Creates a new DirectorParalelo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($idSedes, $idInstitucion)
    {
		$connection = Yii::$app->getDb();
		
		
		//grupos que tiene la sede
		$command = $connection->createCommand("
		SELECT pa.id, pa.descripcion as grupo
		FROM paralelos as pa, sedes_jornadas as sj, sedes as s,instituciones as i,sedes_niveles sn
		WHERE pa.id_sedes_jornadas 		= sj.id
		AND sj.id_sedes 				= $idSedes
		AND s.id_instituciones 			= i.id
		AND i.id 						= $idInstitucion
		AND sn.id 						= pa.id_sedes_niveles
		AND sn.id_sedes 				= s.id		
		");
		$result = $command->queryAll();
		
		$grupos=array();
		foreach ($result as $r)
				{
					$grupos[$r['id']]=$r['grupo'];					
				}
						
		$connection = Yii::$app->getDb();
		//docentes que tiene la institucion
		$command = $connection->createCommand("
				select d.id_perfiles_x_personas as id, concat(p.nombres,' ',p.apellidos) as nombre
				from personas as p, perfiles_x_personas as pp, docentes as d, perfiles as pe, perfiles_x_personas_institucion as ppi
				where p.id= pp.id_personas
				and p.estado=1
				and pp.id_perfiles=pe.id
				and pe.id=10
				and pe.estado=1
				and pp.id= d.id_perfiles_x_personas
				and ppi.id_institucion = $idInstitucion
				and pp.id = ppi.id_perfiles_x_persona		
		");
		$result = $command->queryAll();
		
		$docentes=array();
		foreach ($result as $d)
			{
				
				$docentes[$d['id']]=$d['nombre'];					
			}
		
        $model = new DirectorParalelo();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' 	=> $model,
			'idSedes'	=> $idSedes,
			'idInstitucion'=>$idInstitucion,
			'grupos'	=>$grupos,
			'docentes'	=>$docentes
        ]);
    }

    /**
     * Updates an existing DirectorParalelo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
		
		$connection = Yii::$app->getDb();
		
		
		//la sede y la institucion para la miga de pan
		$command = $connection->createCommand("
		SELECT sj.id_sedes as idsedes, s.id_instituciones as institucion
		FROM director_paralelo  as dp, paralelos as p, sedes_jornadas as sj, sedes as s
		where dp.id_paralelo = p.id
		and p.id_sedes_jornadas = sj.id
		and sj.id_sedes = s.id
		and dp.id = $id
		group by sj.id_sedes, s.id_instituciones
		");
		$result = $command->queryAll();

		$idSedes = $result[0]['idsedes'];
		$idInstitucion = $result[0]['institucion'];
		
		//grupos que tiene la sede
		$command = $connection->createCommand("
		SELECT pa.id, pa.descripcion as grupo
		FROM paralelos as pa, sedes_jornadas as sj, sedes as s,instituciones as i,sedes_niveles sn
		WHERE pa.id_sedes_jornadas 		= sj.id
		AND sj.id_sedes 				= $idSedes
		AND s.id_instituciones 			= i.id
		AND i.id 						= $idInstitucion
		AND sn.id 						= pa.id_sedes_niveles
		AND sn.id_sedes 				= s.id		
		");
		$result = $command->queryAll();
		
		$grupos=array();
		foreach ($result as $r)
				{
					$grupos[$r['id']]=$r['grupo'];					
				}
					
		$connection = Yii::$app->getDb();
		//docente que tiene la institucion
		$command = $connection->createCommand("
			select d.id_perfiles_x_personas as id, concat(p.nombres,' ',p.apellidos) as nombre
			from personas as p, perfiles_x_personas as pp, docentes as d, perfiles as pe, perfiles_x_personas_institucion as ppi
			where p.id= pp.id_personas
			and p.estado=1
			and pp.id_perfiles=pe.id
			and pe.id=10
			and pe.estado=1
			and pp.id= d.id_perfiles_x_personas
			and ppi.id_institucion = $idInstitucion
			and pp.id = ppi.id_perfiles_x_persona			
		");
		$result = $command->queryAll();
		
		$docentes=array();
		foreach ($result as $d)
			{
				
				$docentes[$d['id']]=$d['nombre'];					
			}
			
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' 	=> $model,
			'idSedes'	=> $idSedes,
			'idInstitucion'=>$idInstitucion,
			'grupos'	=>$grupos,
			'docentes'	=>$docentes
        ]);
    }

    /**
     * Deletes an existing DirectorParalelo model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
		// $connection = Yii::$app->getDb();
		// //la sede y la institucion para la miga de pan
		// $command = $connection->createCommand("
		// SELECT sj.id_sedes as idsedes, s.id_instituciones as institucion
		// FROM director_paralelo  as dp, paralelos as p, sedes_jornadas as sj, sedes as s
		// where dp.id_paralelo = p.id
		// and p.id_sedes_jornadas = sj.id
		// and sj.id_sedes = s.id
		// and dp.id = $id
		// group by sj.id_sedes, s.id_instituciones
		// ");
		// $result = $command->queryAll();

		// $idSedes = $result[0]['idsedes'];
		// $idInstitucion = $result[0]['institucion'];
		
		$model = $this->findModel($id);
		$model->estado = 2;
		$model->update(false);
		

       // return $this->redirect(['index', 'idInstitucion' => $idInstitucion, 'idSedes' => $idSedes ]);
       return $this->redirect(['index']);
    }

    /**
     * Finds the DirectorParalelo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return DirectorParalelo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DirectorParalelo::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
