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
use app\models\ParticipantesGruposSoporte;
use app\models\Estados;
use app\models\GruposSoporte;
use	yii\helpers\ArrayHelper;
use yii\data\SqlDataProvider;
use app\models\ParticipantesGruposSoporteBuscar;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ParticipantesGruposSoporteController implements the CRUD actions for ParticipantesGruposSoporte model.
 */
class ParticipantesGruposSoporteController extends Controller
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

    /**
     * Lists all ParticipantesGruposSoporte models.
     * @return mixed
     */
    public function actionIndex($TiposGruposSoporte = 0, $idGruposSoporte = 0,$idJornadas=0)
    {
		if( $TiposGruposSoporte != 0 && $idGruposSoporte != 0 && $idJornadas != 0 )
		{

			//cupos disponibles y docente a cargo y rango de edad
			$sql ="
				SELECT gs.descripcion, gs.cantidad_participantes as \"Cantidad Participantes\", concat(p.nombres,' ',p.apellidos) as docente,
				cantidad_participantes - (select count(id) from participantes_grupos_soporte Where id_grupo_soporte = $idGruposSoporte and estado = 1 ) as \"Cupos Disponibles\",
				gs.edad_minima as \"Edad Minima\", gs.edad_maxima as \"Edad Maxima\"
				FROM grupos_soporte as gs, perfiles_x_personas as pp, personas as p
				where gs.id = $idGruposSoporte
				and gs.estado = 1
				and gs.id_docentes = pp.id
				and pp.id_personas = p.id
			 ";		
			$provider = new SqlDataProvider(
			['sql' => $sql,
			]);
	
			//participantes que estan en el grupo
			$sql ="
				SELECT pgs.id, concat(p.nombres,' ',p.apellidos) as \"Participantes\", extract(year from age(p.fecha_nacimiento)) as edad, 
				pa.descripcion as \"Grado\", s.descripcion as \"Sede\", pgs.nombre_equipo as \"Nombre Equipo\"
				FROM participantes_grupos_soporte as pgs, personas as p, perfiles_x_personas as pp,estudiantes as e, paralelos as pa,
				sedes as s, grupos_soporte as gs
				WHERE pgs.estado = 1
				and pgs.id_persona = p.id
				and pp.id_personas = p.id
				and pp.id_perfiles = 11
				and e.id_perfiles_x_personas = pp.id
				and e.id_paralelos = pa.id
				and pgs.id_sede = s.id
				and pgs.id_grupo_soporte = gs.id
			 ";		
			$dataProvider = new SqlDataProvider(
			['sql' => $sql,
			'key' => 'id',
			]);
	
			
	
			
			$searchModel = new ParticipantesGruposSoporteBuscar();
			// $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
			
			
			
			return $this->render('index', [
				'searchModel' => $searchModel,
				'dataProvider' => $dataProvider,
				'provider' => $provider,
				'idGruposSoporte' 	=> $idGruposSoporte,
				'TiposGruposSoporte' => $TiposGruposSoporte,
				'idJornadas'=>$idJornadas,
				
				]);
		}
		else
		{
			// Si el id de institucion o de sedes es 0 se llama a la vista listarInstituciones
			 return $this->render('listarInstituciones',[
				'idGruposSoporte' 		=> $idGruposSoporte,
				'TiposGruposSoporte' => $TiposGruposSoporte,
				'idJornadas'=>$idJornadas,
			] );
		}

    }

    /**
     * Displays a single ParticipantesGruposSoporte model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id, $TiposGruposSoporte, $idGruposSoporte,$idJornadas)
    {
		$model = $this->findModel($id);
		
		$connection = Yii::$app->getDb();
		
		//datos del grupos
		$command = $connection->createCommand("
		SELECT pgs.id, concat(p.nombres,' ',p.apellidos) as \"Participantes\", extract(year from age(p.fecha_nacimiento)) as edad, 
			pa.descripcion as \"Grado\", s.descripcion as \"Sede\", pgs.nombre_equipo as \"Nombre Equipo\"
			FROM participantes_grupos_soporte as pgs, personas as p, perfiles_x_personas as pp,estudiantes as e, paralelos as pa,
			sedes as s, grupos_soporte as gs
			WHERE pgs.estado = 1
			and pgs.id_persona = p.id
			and pp.id_personas = p.id
			and pp.id_perfiles = 11
			and e.id_perfiles_x_personas = pp.id
			and e.id_paralelos = pa.id
			and pgs.id_sede = s.id
			and pgs.id_grupo_soporte = gs.id
			and pgs.id = $id
		");
		$result = $command->queryAll();
		
		//si el participantes_grupos_soporte no existe o tiene estado = 2 lo redirecciona al index
		if (count($result)==0)
		{
			echo $this->actionIndex($TiposGruposSoporte, $idGruposSoporte,$idJornadas);
			$model2="";
		}
		else
		{
			//se formatea para mostrar los datos en el view
			foreach($result[0] as $r => $v)
			{
				$model2[$r] = $v;
			}
		}
		
        return $this->render('view', [
            // 'model' => $this->findModel($id),
            'model' => $model,
            'model2' => $model2,
			'TiposGruposSoporte'=>$TiposGruposSoporte,
			'idGruposSoporte'=>$idGruposSoporte,
			'idJornadas'=>$idJornadas,
        ]);
    }

    /**
     * Creates a new ParticipantesGruposSoporte model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($TiposGruposSoporte, $idGruposSoporte,$idJornadas)
    {
        $model = new ParticipantesGruposSoporte();		
		
		$idSedes = $_SESSION['sede'][0];
		
		$connection = Yii::$app->getDb();
		//estudiantes de la sede y la jornada seleccionada y cumplen con la edad requerida
		$command = $connection->createCommand("
		SELECT p.id, concat(p.nombres,' ',p.apellidos) as nombres,  extract(year from age(p.fecha_nacimiento)) as edad
		FROM estudiantes as e, perfiles_x_personas as pp,
		personas as p, paralelos as pa, sedes_jornadas as sj
		where e.id_perfiles_x_personas = pp.id
		and pp.id_perfiles = 11
		and pp.id_personas = p.id
		and e.id_paralelos = pa.id
		and pa.id_sedes_jornadas = sj.id
		and sj.id_sedes = $idSedes
		and sj.id_jornadas = $idJornadas
		and extract(year from age(p.fecha_nacimiento)) >= (select edad_minima from grupos_soporte where id=$idGruposSoporte)
		and extract(year from age(p.fecha_nacimiento)) <= (select edad_maxima from grupos_soporte where id=$idGruposSoporte)
		");
		$result = $command->queryAll();
		
		
		
		
		$estudiantes = array();
		foreach ($result as $r)
		{
			$estudiantes[$r['id']]=$r['nombres'];
		}
		
		$grupoSoporte = GruposSoporte::findOne("$idGruposSoporte");
		$grupoSoporte = $grupoSoporte ? $grupoSoporte->descripcion : '';
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id,'TiposGruposSoporte'=>$TiposGruposSoporte,'idGruposSoporte'=>$idGruposSoporte,'idJornadas'=>$idJornadas,]);
        }

        return $this->render('create', [
            'model' => $model,
			'estados'=>$this->obtenerEstados(),
			'estudiantes'=>$estudiantes,
			'TiposGruposSoporte'=>$TiposGruposSoporte,
			'idGruposSoporte'=>$idGruposSoporte,
			'idJornadas'=>$idJornadas,
			'grupoSoporte'=>$grupoSoporte,
        ]);
    }

    /**
     * Updates an existing ParticipantesGruposSoporte model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id,$idJornadas,$TiposGruposSoporte,$idGruposSoporte)
    {
        $model = $this->findModel($id);
		
		$idSedes = $_SESSION['sede'][0];
				
		$connection = Yii::$app->getDb();
		//estudiantes de la sede y la jornada seleccionada
		$command = $connection->createCommand("
		SELECT p.id, concat(p.nombres,' ',p.apellidos) as nombres,  extract(year from age(p.fecha_nacimiento)) as edad
		FROM estudiantes as e, perfiles_x_personas as pp,
		personas as p, paralelos as pa, sedes_jornadas as sj
		where e.id_perfiles_x_personas = pp.id
		and pp.id_perfiles = 11
		and pp.id_personas = p.id
		and e.id_paralelos = pa.id
		and pa.id_sedes_jornadas = sj.id
		and sj.id_sedes = $idSedes
		and sj.id_jornadas = $idJornadas
		and extract(year from age(p.fecha_nacimiento)) >= (select edad_minima from grupos_soporte where id=$idGruposSoporte)
		and extract(year from age(p.fecha_nacimiento)) <= (select edad_maxima from grupos_soporte where id=$idGruposSoporte)
		
		");
		$result = $command->queryAll();	
		
		$estudiantes = array();
		foreach ($result as $r)
		{
			$estudiantes[$r['id']]=$r['nombres'];
		}
		
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id,'TiposGruposSoporte'=>$TiposGruposSoporte,'idGruposSoporte'=>$idGruposSoporte,'idJornadas'=>$idJornadas,]);
        }
		
		$grupoSoporte = GruposSoporte::findOne("$idGruposSoporte");
		$grupoSoporte = $grupoSoporte ? $grupoSoporte->descripcion : '';
        return $this->render('update', [
            'model' => $model,
			'estados'=>$this->obtenerEstados(),
			'estudiantes'=>$estudiantes,
			'TiposGruposSoporte'=>$TiposGruposSoporte,
			'idGruposSoporte'=>$idGruposSoporte,
			'idJornadas'=>$idJornadas,
			'grupoSoporte'=>$grupoSoporte,
        ]);
    }

    /**
     * Deletes an existing ParticipantesGruposSoporte model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id,$idJornadas,$TiposGruposSoporte,$idGruposSoporte)
    {
        $model = $this->findModel($id);
		$model->estado = 2;
		$model->update(false);
		return $this->redirect(['index', 'idJornadas' => $idJornadas, 'TiposGruposSoporte' => $TiposGruposSoporte, 'idGruposSoporte' => $idGruposSoporte ]);
        
    }

    /**
     * Finds the ParticipantesGruposSoporte model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return ParticipantesGruposSoporte the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ParticipantesGruposSoporte::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
	public function pre($valor)
	{
		echo "<pre>"; print_r( $valor); echo "</pre>";	
	}

}
