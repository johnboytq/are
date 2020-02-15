<?php

namespace app\controllers;

use Yii;
use app\models\SedesCobertura;
use app\models\SedesCoberturaBuscar;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\models\CategoriasCobertura;
use app\models\SubCategoriasCobertura;
use app\models\TemasCobertura;
use app\models\Sedes;
use yii\helpers\ArrayHelper;

/**
 * SedesCoberturaController implements the CRUD actions for SedesCobertura model.
 */
class SedesCoberturaController extends Controller
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
     * Lists all SedesCobertura models.
     * @return mixed
     */
    public function actionIndex()
    {
		// $sedesTable 		= new Sedes();
		// $dataSedes	 		= $sedesTable->find()->where( 'id='.$idSedes )->andWhere( 'estado=1' )->all();
		// $sedes				= ArrayHelper::map( $dataSedes, 'id', 'descripcion' );
		
		
        $searchModel = new SedesCoberturaBuscar();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		
		$idInstitucion 	= $_SESSION['instituciones'][0];
		$sede 			= $_SESSION['sede'][0];
		
		$sedeData			= Sedes::findOne( $sede );
		
		$categoriasTable	= new CategoriasCobertura();
		$datacategorias		= $categoriasTable->find()->where( 'estado=1' )->orderby([ 'id' => SORT_DESC ])->all();
		$categorias			= ArrayHelper::map( $datacategorias, 'id', 'descripcion' );
		
		$subCategoriasTable	= new SubCategoriasCobertura;
		$dataSubCategorias	= $subCategoriasTable->find()->where( 'estado=1' )->all();
		$subCategorias		= ArrayHelper::map( $dataSubCategorias, 'id', 'descripcion', 'id_categoria' );
		
		$temasTable			= new TemasCobertura;
		$dataTemas	 		= $temasTable->find()->where( 'estado=1' )->all();
		$temas				= ArrayHelper::map( $dataTemas, 'id', 'descripcion', 'id_subCategoria' );
		
		$dataSaveTable		= new SedesCobertura();
		$dataSave			= $dataSaveTable->find()
								->where( 'estado=1' )
								->andWhere( 'id_sede='.$sede );
		

        return $this->render('edition', [
            'searchModel' 	=> $searchModel,
            'dataProvider' 	=> $dataProvider,
            'sede' 			=> $sede,
            'sedeData'		=> $sedeData,
            'categorias'	=> $categorias,
            'subCategorias'	=> $subCategorias,
            'temas'			=> $temas,
            'dataSave'		=> $dataSave,
        ]);

		// return $this->render('index', [
            // 'searchModel' => $searchModel,
            // 'dataProvider' => $dataProvider,
        // ]);
    }

    /**
     * Displays a single SedesCobertura model.
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
     * Creates a new SedesCobertura model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        // $model = new SedesCobertura();

        // if ($model->load(Yii::$app->request->post()) && $model->save()) {
            // return $this->redirect(['view', 'id' => $model->id]);
        // }

        // return $this->render('create', [
            // 'model' => $model,
        // ]);
		
		
		
		
		
		
		
		
		// var_dump( Yii::$app->request->post('data') );
		$data	=  Yii::$app->request->post('data');
		$count 	= count(Yii::$app->request->post('data'));
		
		$models = [];
		for( $i = 0; $i < $count; $i++ )
		{
			if( $data[$i]['id'] != 0 )
				$models[] = SedesCobertura::findOne( $data[$i]['id'] );
			else
				$models[] = new SedesCobertura();
		}
		
		
		if( SedesCobertura::loadMultiple($models, Yii::$app->request->post(), 'data' ) && SedesCobertura::validateMultiple($models) )
		{
            foreach ($models as $model)
			{
                $model->save(false);
            }
        }
		else
		{
			 
			 foreach( $models as $model )
			 {
				 foreach( $model->errors as $error )
				 {
					 var_dump( $error );
				 }
			 }
			 
			 return;
		}
		
		//Devuelo la lista de los ids
		$val = [];
		
		foreach( $models as $model )
		{
			 $val[]=[ 
						"id" => $model->id,
					];
		}
		
		echo json_encode( $val );
		
		
		
		
    }

    /**
     * Updates an existing SedesCobertura model.
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
     * Deletes an existing SedesCobertura model.
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
     * Finds the SedesCobertura model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return SedesCobertura the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SedesCobertura::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
