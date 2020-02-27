<?php

namespace app\controllers;

use Yii;
use app\models\AulasXParalelos;
use app\models\AulasXParalelosBuscar;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use	yii\helpers\ArrayHelper;
use app\models\Paralelos;
use app\models\ParalelosBuscar;
use app\models\Aulas;
use app\models\NivelesBuscar;
use app\models\Niveles;
use app\models\Jornadas;
use app\models\SedesJornadas;
use app\models\SedesNiveles;

/**
 * AulasXParalelosController implements the CRUD actions for AulasXParalelos model.
 */
class AulasXParalelosController extends Controller
{
    /**
     * {@inheritdoc}
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
     * Lists all AulasXParalelos models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AulasXParalelosBuscar();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AulasXParalelos model.
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
     * Creates a new AulasXParalelos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
		$idInstitucion 	= $_SESSION['instituciones'][0];
		$idSedes 		= $_SESSION['sede'][0];
		
        $paralelosSearch 	= new ParalelosBuscar();
		$paralelosSearch->load(Yii::$app->request->post());
		
        $nivelesSearch 		= new NivelesBuscar();
		$nivelesSearch->load(Yii::$app->request->post());
		
        $model = new AulasXParalelos();
		
		$model->fecha_ingreso = date( "Y-m-d H:i:s" );
		
        if($nivelesSearch->id && $model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
		
		//Jornadas
		$jornadasSearch = SedesJornadas::find()
								->alias('sj')
								->select([ 'sj.id', 'sj.id_jornadas'])
								->innerJoin( "jornadas j", "j.id=sj.id_jornadas" )
								->andWhere( 'sj.id_sedes='.$idSedes )
								->andWhere( 'j.estado=1' )
								->all();
								
		// $jornadas		= ArrayHelper::map( $jornadasSearch, 'id', 'id_jornadas' );
		$jornadas		= ArrayHelper::map( $jornadasSearch, 'id', function( $value ){ 
											return Jornadas::findOne( $value['id_jornadas'] )->descripcion; 
										});
		
		//Obteniendo las aulas
		$aulas 	= Aulas::find()
						->where( 'estado=1' )
						->all();
						
		$aulas	= ArrayHelper::map( $aulas, 'id', 'descripcion' );
		
		
		
		$grupos 	= [];
		$niveles 	= [];
		if( $paralelosSearch->id_sedes_jornadas ){
			
			//Obteniendo los grupos
			$grupos = $paralelosSearch->search(Yii::$app->request->queryParams)->query
							->andWhere( 'estado=1' )
							->all();
			$grupos	= ArrayHelper::map( $grupos, 'id', 'descripcion' );
							
			//Obteniendo los niveles
			$niveles 	= $nivelesSearch->search(Yii::$app->request->queryParams)->query
								->alias('n')
								->innerJoin( 'sedes_niveles sn', 'sn.id_niveles=n.id' )
								->where( 'estado=1' )
								->andWhere( 'sn.id_sedes='.$idSedes )
								->andWhere( 'sn.id_sedes_jornadas='.$paralelosSearch->id_sedes_jornadas )
								->orderby( 'descripcion' )
								->all();
			$niveles	= ArrayHelper::map( $niveles, 'id', 'descripcion' );
		}

        return $this->render('create', [
            'model' 			=> $model,
			'grupos' 			=> $grupos,
			'aulas' 			=> $aulas,
			'niveles' 			=> $niveles,
			'paralelosSearch' 	=> $paralelosSearch,
			'nivelesSearch' 	=> $nivelesSearch,
			'jornadas' 			=> $jornadas,
        ]);
    }

    /**
     * Updates an existing AulasXParalelos model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
		// echo "<pre>"; var_dump(Yii::$app->request->post()); echo "</pre>";
		$idInstitucion 	= $_SESSION['instituciones'][0];
		$idSedes 		= $_SESSION['sede'][0];
		
        $paralelosSearch 	= new ParalelosBuscar();
		
        $nivelesSearch 		= new NivelesBuscar();
		
        $model = $this->findModel($id);
		
		$is_save = Yii::$app->request->post('is_save');

		if( $is_save !== NULL ){
			
			if ($model->load(Yii::$app->request->post()) && $model->save()) {
				return $this->redirect(['view', 'id' => $model->id]);
			}
		}
		
		$paralelosSearch = ParalelosBuscar::findOne( $model->id_paralelos );
		if( $paralelosSearch ){
			$nivelesSearch	 = NivelesBuscar::findOne( SedesNiveles::findOne( $paralelosSearch->id_sedes_niveles )->id_niveles );
		}
		
		$paralelosSearch->load(Yii::$app->request->post());
		$nivelesSearch->load(Yii::$app->request->post());
		
		$grupos 	= [];
		$niveles 	= [];
		$aulas 		= [];
		$jornadas	= [];
		
		//Jornadas
		$jornadasSearch = SedesJornadas::find()
								->alias('sj')
								->select([ 'sj.id', 'sj.id_jornadas'])
								->innerJoin( "jornadas j", "j.id=sj.id_jornadas" )
								->andWhere( 'sj.id_sedes='.$idSedes )
								->andWhere( 'j.estado=1' )
								->all();
								
		// $jornadas		= ArrayHelper::map( $jornadasSearch, 'id', 'id_jornadas' );
		$jornadas		= ArrayHelper::map( $jornadasSearch, 'id', function( $value ){ 
											return Jornadas::findOne( $value['id_jornadas'] )->descripcion; 
										});
		
		//Obteniendo las aulas
		$aulas 	= Aulas::find()
						->where( 'estado=1' )
						->all();
						
		$aulas	= ArrayHelper::map( $aulas, 'id', 'descripcion' );
		
		// if( Yii::$app->request->post() ){
			
			
			if( $paralelosSearch->id_sedes_jornadas ){
				
				//Obteniendo los grupos
				$paralelosSearch2 	= new ParalelosBuscar();
				$paralelosSearch2->id_sedes_jornadas	= $paralelosSearch->id_sedes_jornadas;
				$grupos = $paralelosSearch2->search(Yii::$app->request->queryParams)->query
								->andWhere( 'estado=1' )
								->all();
				$grupos	= ArrayHelper::map( $grupos, 'id', 'descripcion' );
				
				$nivelesSearch2 		= new NivelesBuscar();
								
				//Obteniendo los niveles
				$niveles 	= $nivelesSearch2->search(Yii::$app->request->queryParams)->query
									->alias('n')
									->innerJoin( 'sedes_niveles sn', 'sn.id_niveles=n.id' )
									->where( 'estado=1' )
									->andWhere( 'sn.id_sedes='.$idSedes )
									->andWhere( 'sn.id_sedes_jornadas='.$paralelosSearch->id_sedes_jornadas )
									->orderby( 'descripcion' )
									->all();
				$niveles	= ArrayHelper::map( $niveles, 'id', 'descripcion' );
			}
		// }

        return $this->render('update', [
            'model' 			=> $model,
			'grupos' 			=> $grupos,
			'aulas' 			=> $aulas,
			'niveles' 			=> $niveles,
			'paralelosSearch' 	=> $paralelosSearch,
			'nivelesSearch' 	=> $nivelesSearch,
			'jornadas' 			=> $jornadas,
        ]);
    }

    /**
     * Deletes an existing AulasXParalelos model.
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
     * Finds the AulasXParalelos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return AulasXParalelos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AulasXParalelos::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
