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
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

use app\models\Jornadas;
use app\models\Niveles;
use app\models\Paralelos;
use app\models\ParalelosBuscar;
use app\models\Sedes;
use app\models\SedesJornadas;
use app\models\SedesNiveles;
use app\models\Estados;


/**********
Versión: 001
Fecha: 09-03-2018
Desarrollador: Oscar David Lopez
Descripción: CRUD de Paralelos
---------------------------------------
Modificaciones:
Fecha: 13-06-2018
Persona encargada: Edwin Molina
Cambios realizados: Se deja por defecto la institución y sede de la SESSION
---------------------------------------
Fecha: 09-03-2018
Persona encargada: Oscar David Lopez
Cambios realizados: - Cambios en todas las funciones excepto "behaviors()" y se agrega la actionListarInstituciones()
---------------------------------------
**********/

/**
 * ParalelosController implements the CRUD actions for Paralelos model.
 */
class ParalelosController extends Controller
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
     * Muestra los paralelos 
     * @return mixed
     */	
	 
	// se encargar de renderisar la vista listarInstituciones, la cual se encarga de selecionar la institucion y la sede
	public function actionListarInstituciones( $idInstitucion = 0, $idSedes = 0 )
    {
        return $this->render('listarInstituciones',[
			'idSedes' 		=> $idSedes,
			'idInstitucion' => $idInstitucion,
		] );
    }
	
    /**
     * Lists all Paralelos models.
     * @return mixed
     */
	 
	//lista los paralelos que le corresponen a la sede ($idSedes)
	//la funcion cambia de no tener parametros a tener 2
    // public function actionIndex($idInstitucion = 0, $idSedes = 0)
    public function actionIndex()
    {
		$idInstitucion 	= $_SESSION['instituciones'][0];
		$idSedes 		= $_SESSION['sede'][0];
		
		// Si existe id sedes e institución se muestra la listas de todas las jornadas correspondientes
		if( $idInstitucion != 0 && $idSedes != 0 )
		{	
	
			
			//se obtiene los ids de los paralelos que tenga la sede seleccionada o dada por $idSedes
			
			//en caso de no existir paralelos en la consulta siempre tenga un 0 el array
			$idParalelos[]=0;
			//variable de conexion
			$connection = Yii::$app->getDb();
			
			$command = $connection->createCommand("
			SELECT p.id
			FROM public.sedes_jornadas as sj, public.jornadas as j, public.sedes as s,public.paralelos as p, public.niveles as n, public.sedes_niveles as sn
			where sj.id_jornadas = j.id
			and sj.id_sedes = s.id
			and s.id  = $idSedes
			and sj.id = p.id_sedes_jornadas
			and s.id  = sn.id_sedes
			and sn.id = p.id_sedes_niveles
			and n.id  = sn.id_niveles");
			$result = $command->queryAll();
			
			// la consulta se debe formatear 
			//
			
			foreach( $result as $j)
			{
				$idParalelos[] = $j['id'];

			}
			
			//buscar 
			$searchModel = new ParalelosBuscar();
			
			$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
			//se pasan los ids de los paralelos para que solo muestre estos en lista
			$dataProvider->query->andWhere('id IN ('.implode(',',$idParalelos).')');
			//solo los paralelos activos o estado =1
			$dataProvider->query->andWhere('estado=1');
			
			return $this->render('index', [
				'searchModel'	=> $searchModel,
				'dataProvider' 	=> $dataProvider,
				'idSedes' 		=> $idSedes,
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
     * Displays a single Paralelos model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
		
		//sirve obtener los estados en un array dado id vs descripcion
		$estados = new Estados();
		$estados = $estados->find()->all();
		$estados = ArrayHelper::map( $estados, 'id', 'descripcion' );
	
		//variable de conexion
		$connection = Yii::$app->getDb();
		
		//consulta para seleccionar la descricion de la jornada para mostrarla en la vista View
		//consulta para seleccionar el id de la sedes para enviarla a la vista View y ser usada en la miga de pan
		$command = $connection->createCommand("
		SELECT j.descripcion, sj.id_sedes
		FROM public.paralelos as p, public.sedes_jornadas as sj, public.jornadas as j
		where p.id_sedes_jornadas = sj.id
		and sj.id_jornadas = j.id
		and p.id=$id");
		$result = $command->queryAll();
		$jornadas = $result[0]['descripcion'];
		$idSedes = $result[0]['id_sedes'];
		
		//consulta para seleccionar el id de la institucion para enviarla a la vista View y ser usada en la miga de pan
		$command = $connection->createCommand("
		SELECT i.id
		FROM instituciones as i,sedes as s
		WHERE s.id_instituciones = i.id
		and s.id = $idSedes
		");
		$result = $command->queryAll();
		$idInstituciones = $result[0]['id'];		
	
		//consulta para seleccionar la descricion del nivel para mostrarla en la vista View
		$command = $connection->createCommand("
		SELECT n.descripcion
		FROM public.paralelos as p, public.sedes_niveles as sn, public.niveles as n
		where p.id_sedes_niveles = sn.id
		and sn.id_niveles = n.id
		and p.id=$id");
		$result = $command->queryAll();
		$niveles = $result[0]['descripcion'];
		

        return $this->render('view', [
            'model' => $this->findModel($id),
			'jornadas' => $jornadas,
			'niveles' => $niveles,
			'estados' => $estados,
			'idSedes' => $idSedes,
			'idInstituciones' =>$idInstituciones,

        ]);
    }

    /**
     * Creates a new Paralelos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($idSedes, $idInstitucion)
    {
		
		
		$estados = new Estados();
		$estados = $estados->find()->where('id=1')->all();
		$estados = ArrayHelper::map($estados,'id','descripcion');
		
			//Busco todas las jornadas disponibles
		$SedesJornadas 	= new SedesJornadas();
		$SedesJornadas	= $SedesJornadas->find()->all();
		$SedesJornadas	= ArrayHelper::map( $SedesJornadas, 'id', 'id_jornadas' );
		
		//lista solo la sede que ya ha sido seleccionada desde la vista listarInstituciones
		$SedesNiveles 	= new SedesNiveles();
		$SedesNiveles	= $SedesNiveles->find()->all();
		$SedesNiveles	= ArrayHelper::map( $SedesNiveles, 'id', 'id_niveles' );
		
		$connection = Yii::$app->getDb();
		$command = $connection->createCommand("
			SELECT sj.id, j.descripcion
			FROM public.sedes_jornadas as sj, public.jornadas as j, public.sedes as s
			where sj.id_jornadas = j.id
			and sj.id_sedes = s.id
			and s.id = $idSedes
		");
		$result = $command->queryAll();
			foreach ($result as $r)
		{
			$jornadas[$r['id']]=$r['descripcion'];
		}
		
		$command = $connection->createCommand("
			SELECT sn.id, n.descripcion
			FROM public.sedes_niveles as sn, public.niveles as n, public.sedes as s
			where sn.id_niveles = n.id
			and sn.id_sedes = s.id
			and s.id = $idSedes");
		$result = $command->queryAll();
				
		
		foreach ($result as $r)
		{
			$niveles[$r['id']]=$r['descripcion'];
		}
				
			
        $model = new Paralelos();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
			'jornadas'=> $jornadas,
			'niveles'=>$niveles,
			'estados'=>$estados,
			'idSedes'=>$idSedes,
			'idInstitucion'=>$idInstitucion,
        ]);
    }

    /**
     * Updates an existing Paralelos model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
		
		$estados = new Estados();
		$estados = $estados->find()->all();
		$estados = ArrayHelper::map( $estados, 'id', 'descripcion' );
		
		$SedeJornadas 		 	= new SedesJornadas();
		$SedeJornadas		 	= $SedeJornadas->find()->all();
		$SedeJornadas	 	 	= ArrayHelper::map( $SedeJornadas, 'id','id_jornadas');
		
		$SedesNiveles 		 	= new SedesNiveles();
		$SedesNiveles		 	= $SedesNiveles->find()->all();
		$SedesNiveles	 	 	= ArrayHelper::map( $SedesNiveles, 'id','id_niveles');
		
		//variable con la conexion a la base de datos
		$connection = Yii::$app->getDb();
		
		$command = $connection->createCommand
		("
			SELECT sj.id_sedes
			FROM public.paralelos as p, public.sedes_jornadas as sj
			WHERE p.id_sedes_jornadas = sj.id
			and p.id=$id
		");		
		$result = $command->queryAll();
		
		$idSedes = $result[0]['id_sedes'];
		
		$command = $connection->createCommand("
			SELECT sj.id, j.descripcion
			FROM public.sedes_jornadas as sj, public.jornadas as j, public.sedes as s
			where sj.id_jornadas = j.id
			and sj.id_sedes = s.id
			and s.id = $idSedes
		");
		$result = $command->queryAll();
			foreach ($result as $r)
		{
			$jornadas[$r['id']]=$r['descripcion'];
		}
		
		$command = $connection->createCommand("
			SELECT sn.id, n.descripcion
			FROM public.sedes_niveles as sn, public.niveles as n, public.sedes as s
			where sn.id_niveles = n.id
			and sn.id_sedes = s.id
			and s.id = $idSedes");
		$result = $command->queryAll();
				
		
		foreach ($result as $r)
		{
			$niveles[$r['id']]=$r['descripcion'];
		}
			
	    $model = $this->findModel($id);
		
		//se selecciona el id de la sede para pasarlo a la vista update y ser usado en la miga de pan
		$command = $connection->createCommand("
		SELECT i.id
		FROM instituciones as i,sedes as s
		WHERE s.id_instituciones = i.id
		and s.id = $idSedes
		");
		$result = $command->queryAll();
		$idInstituciones = $result[0]['id'];
		
		
				
			
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
		

        return $this->render('update', [
            'model' => $model,
			'jornadas'=> $jornadas,
			'niveles'=> $niveles,
			'estados'=> $estados,
			'idSedes'=>$idSedes,
			'idInstituciones'=>$idInstituciones,
			
        ]);
    }

    /**
     * Deletes an existing Paralelos model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
	 
	 
	 //se modifica para que no borre sino para que actualize el campo estado 
    public function actionDelete($id)
    {			
		//variable con la conexion a la base de datos
		$connection = Yii::$app->getDb();

		//consultas para redireccionar a la vista con la institucion y la sede correspondiente
		
		//selecciona la sede desde sedes_jornadas que pertenece a ese paralelo
		$command = $connection->createCommand
		("
			SELECT sj.id_sedes
			FROM public.paralelos as p, public.sedes_jornadas as sj
			WHERE p.id_sedes_jornadas = sj.id
			and p.id=$id
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
		
		
		$model = Paralelos::findOne($id);
		$model->estado = 2;
		$idInstitucion = $model->id;
		$model->update(false);

		return $this->redirect(['index', 'idInstitucion' => $idInstituciones,'idSedes'=>$idSedes]);		
		// return $this->redirect(['index']);		
    }

    /**
     * Finds the Paralelos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Paralelos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
	 
	 //cambio para que muestre otro texto cuando la pagina no este disponibles
    protected function findModel($id)
    {
        if (($model = Paralelos::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('La página que está solicitando no existe .');
    }
}
