<?php

namespace app\controllers;

use Yii;
use app\models\ProyectosPedagogicosTransversales;
use app\models\ProyectosPedagogicosTransversalesBuscar;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\models\Sedes;
use app\models\Estados;
use app\models\Personas;
use app\models\AreasTrabajos;
use yii\helpers\ArrayHelper;

/**
 * ProyectosPedagogicosTransversalesController implements the CRUD actions for ProyectosPedagogicosTransversales model.
 */
class ProyectosPedagogicosTransversalesController extends Controller
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
     * Lists all ProyectosPedagogicosTransversales models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProyectosPedagogicosTransversalesBuscar();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere( 'estado=1' );

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProyectosPedagogicosTransversales model.
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
     * Creates a new ProyectosPedagogicosTransversales model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ProyectosPedagogicosTransversales();
		
		$idSede 		= $_SESSION['sede'][0];
		$idInstitucion 	= $_SESSION['instituciones'][0];
		
		$sede		= Sedes::findOne( $idSede );
		
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
		
		$estadoData		= Estados::find()
							->where( 'id=1' )
							->all();
		$estados		= ArrayHelper::map( $estadoData, 'id', 'descripcion' );
		
		$areasData		= AreasTrabajos::find()
							->all();
		$areas			= ArrayHelper::map( $areasData, 'id', 'descripcion' );
		

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' 	=> $model,
            'sede'  	=> $sede,
            'personas'  => $personas,
            'estados'   => $estados,
            'areas'  	=> $areas,
        ]);
    }

    /**
     * Updates an existing ProyectosPedagogicosTransversales model.
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
		
		$estadoData		= Estados::find()
							->where( 'id=1' )
							->all();
		$estados		= ArrayHelper::map( $estadoData, 'id', 'descripcion' );
		
		$areasData		= AreasTrabajos::find()
							->all();
		$areas			= ArrayHelper::map( $areasData, 'id', 'descripcion' );

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'sede'  	=> $sede,
            'personas'  => $personas,
            'estados'   => $estados,
            'areas'  	=> $areas,
        ]);
    }

    /**
     * Deletes an existing ProyectosPedagogicosTransversales model.
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
     * Finds the ProyectosPedagogicosTransversales model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return ProyectosPedagogicosTransversales the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProyectosPedagogicosTransversales::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
