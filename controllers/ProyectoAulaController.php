<?php

namespace app\controllers;

use Yii;
use app\models\ProyectoAula;
use app\models\ProyectoAulaBuscar;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\models\Sedes;
use app\models\Personas;
use app\models\Jornadas;
use app\models\Paralelos;
use app\models\Estados;
use app\models\Instituciones;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

/**
 * ProyectoAulaController implements the CRUD actions for ProyectoAula model.
 */
class ProyectoAulaController extends Controller
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
     * Lists all ProyectoAula models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProyectoAulaBuscar();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere( 'estado=1' );

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProyectoAula model.
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
     * Creates a new ProyectoAula model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ProyectoAula();
		
		$idSede 		= $_SESSION['sede'][0];
		$idInstitucion 	= $_SESSION['instituciones'][0];
		
		$sede		= Sedes::findOne( $idSede );
		
		//se pasa a una accion
		$personasData= Personas::find()
							->select( "personas.id, ( nombres || apellidos ) as nombres" )
							->innerJoin( "perfiles_x_personas pp", "pp.id_personas=personas.id" )
							->innerJoin( "distribuciones_academicas da", "da.id_perfiles_x_personas_docentes=pp.id" )
							->innerJoin( "aulas_x_paralelos ap", "ap.id_paralelos=da.id_paralelo_sede" )
							->innerJoin( "aulas a", "a.id=ap.id_aulas" )
							->innerJoin( "perfiles_x_personas_institucion ppi", "ppi.id_perfiles_x_persona=pp.id" )
							->where('personas.estado=1')
							->andWhere( "a.id_sedes=".$idSede )
							->andWhere( "a.estado=1" )
							->andWhere( "pp.estado=1" )
							->andWhere( "pp.id_perfiles=10" )
							->andWhere( "personas.estado=1" )
							->andWhere( "id_institucion=".$idInstitucion )
							->orderby('descripcion')
							->all();
		$personas		= ArrayHelper::map( $personasData, 'id', 'nombres' );
		
		$jornadasData	= Jornadas::find()
							->select( 'id, descripcion' )
							->where( 'estado=1' )
							->all();
		$jornadas	= ArrayHelper::map( $jornadasData, 'id', 'descripcion' );
						
		$paralelosData= Paralelos::find()
							->select( 'paralelos.id, paralelos.descripcion' )
							->innerJoin( 'sedes_jornadas as sj', 'sj.id=id_sedes_jornadas' )
							->where( 'estado=1' )
							->andWhere( 'id_sedes='.$idSede )
							->all();
		$paralelos		= ArrayHelper::map( $paralelosData, 'id', 'descripcion' );
		
		$estadoData		= Estados::find()
							->where( 'id=1' )
							->all();
		$estados		= ArrayHelper::map( $estadoData, 'id', 'descripcion' );

        // if ($model->load(Yii::$app->request->post()) && $model->save()) {
        if ($model->load(Yii::$app->request->post()) ){
			
			$file = UploadedFile::getInstance( $model, "file" );
			
			$model->archivo = '';
			
			if( $file ){
				
				//Si no existe la carpeta se crea
				$carpeta = "../documentos/proyectos-aula/";
				if (!file_exists($carpeta)) {
					mkdir($carpeta, 0777, true);
				}
				
				//Construyo la ruta completa del archivo a guardar
				$rutaFisicaDirectoriaUploads  = "../documentos/proyectos-aula/";
				$rutaFisicaDirectoriaUploads .= $file->baseName;
				$rutaFisicaDirectoriaUploads .= date( "_Y_m_d_His" ) . '.' . $file->extension;
				
				$save = $file->saveAs( $rutaFisicaDirectoriaUploads );//$file->baseName puede ser cambiado por el nombre que quieran darle al archivo en el servidor.
			
				if( $save ){
					$model->archivo = $rutaFisicaDirectoriaUploads;
				}
			}
			
			if( $model->save()){
				return $this->redirect(['view', 'id' => $model->id]);
			}
        }
		
        return $this->render('create', [
            'model' 		=> $model,
            'sede' 			=> $sede,
            'personas' 		=> $personas,
            'jornadas' 		=> $jornadas,
            'paralelos' 	=> $paralelos,
            'estados' 		=> $estados,
        ]);
    }

    /**
     * Updates an existing ProyectoAula model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		
		$idSede 		= $_SESSION['sede'][0];
		$idInstitucion 	= $_SESSION['instituciones'][0];
		
		$sede		= Sedes::findOne( $idSede );
		
		//se paso a otra accion
		$personasData= Personas::find()
							->select( "personas.id, ( nombres || apellidos ) as nombres" )
							->innerJoin( "perfiles_x_personas pp", "pp.id_personas=personas.id" )
							->innerJoin( "distribuciones_academicas da", "da.id_perfiles_x_personas_docentes=pp.id" )
							->innerJoin( "aulas_x_paralelos ap", "ap.id_paralelos=da.id_paralelo_sede" )
							->innerJoin( "aulas a", "a.id=ap.id_aulas" )
							->innerJoin( "perfiles_x_personas_institucion ppi", "ppi.id_perfiles_x_persona=pp.id" )
							->where('personas.estado=1')
							->andWhere( "a.id_sedes=".$idSede )
							->andWhere( "a.estado=1" )
							->andWhere( "pp.estado=1" )
							->andWhere( "pp.id_perfiles=10" )
							->andWhere( "personas.estado=1" )
							->andWhere( "id_institucion=".$idInstitucion )
							->orderby('descripcion')
							->all();
		$personas		= ArrayHelper::map( $personasData, 'id', 'nombres' );
		
		$jornadasData	= Jornadas::find()
							->select( 'id, descripcion' )
							->where( 'estado=1' )
							->all();
		$jornadas	= ArrayHelper::map( $jornadasData, 'id', 'descripcion' );
						
		$paralelosData= Paralelos::find()
							->select( 'paralelos.id, paralelos.descripcion' )
							->innerJoin( 'sedes_jornadas as sj', 'sj.id=id_sedes_jornadas' )
							->where( 'estado=1' )
							->andWhere( 'id_sedes='.$idSede )
							->all();
		$paralelos		= ArrayHelper::map( $paralelosData, 'id', 'descripcion' );
		
		$estadoData		= Estados::find()
							->all();
		$estados		= ArrayHelper::map( $estadoData, 'id', 'descripcion' );

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
			
            'sede' 			=> $sede,
            'personas' 		=> $personas,
            'jornadas' 		=> $jornadas,
            'paralelos' 	=> $paralelos,
            'estados' 		=> $estados,
        ]);
    }

    /**
     * Deletes an existing ProyectoAula model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->estado = 2;
        $model->update( false );

        return $this->redirect(['index']);
    }

    /**
     * Finds the ProyectoAula model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return ProyectoAula the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProyectoAula::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
	/*
	* Se busca un docente 
	*/
	public function actionDocentes($filtro){
		$personasData= Personas::find()
							->select( "personas.id, ( nombres || apellidos ) as nombres" )
							->innerJoin( "perfiles_x_personas pp", "pp.id_personas=personas.id" )
							->andWhere('personas.estado=1')
							->andWhere( "pp.estado=1" )
							->andWhere( "pp.id_perfiles=10" )
							->andWhere(
							['or',
								['ILIKE', 'personas.nombres', '%'. $filtro . '%', false],
								['ILIKE', 'personas.apellidos', '%'. $filtro . '%', false],
								['ILIKE', 'personas.identificacion', '%'. $filtro . '%', false]
							])
							->orderby('personas.id')
							->all();
		$personas		= ArrayHelper::map( $personasData, 'id', 'nombres' );
			
		
		return json_encode($personas);
	}
}
