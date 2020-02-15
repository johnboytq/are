<?php

/**********
Versión: 001
Fecha: 27-03-2018
Desarrollador: Edwin Molina Grisales
Descripción: CRUD Dcoentes por áreas de trabajo
---------------------------------------
Modificaciones:
Fecha: 27-03-2018
Persona encargada: Edwin Molina Grisales
Se hacen cambios para que no se muestren docentes inactivos se corrige los queries respectivos,
ya que se repetía varias veces los metodos ->where() en una sola consulta
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
use app\models\DocentesXAreasTrabajos;
use app\models\DocentesXAreasTrabajosBuscar;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\models\Personas;
use app\models\AreasTrabajos;
use yii\helpers\ArrayHelper;

/**
 * DocentesXAreasTrabajosController implements the CRUD actions for DocentesXAreasTrabajos model.
 */
class DocentesXAreasTrabajosController extends Controller
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
     * Lists all DocentesXAreasTrabajos models.
     * @return mixed
     */
    public function actionIndex()
    {	
		
        $searchModel = new DocentesXAreasTrabajosBuscar();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		
		//Muestro los docentes que están activos
		$dataProvider->query
							->select( "docentes_x_areas_trabajos.*" )
							->innerJoin('perfiles_x_personas pf', 'pf.id=docentes_x_areas_trabajos.id_perfiles_x_personas_docentes' )
							->innerJoin('docentes d', 'd.id_perfiles_x_personas=pf.id' )
							->andWhere( 'd.estado=1' )
							->one();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DocentesXAreasTrabajos model.
     * @param string $id_perfiles_x_personas_docentes
     * @param string $id_areas_trabajos
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_perfiles_x_personas_docentes, $id_areas_trabajos)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_perfiles_x_personas_docentes, $id_areas_trabajos),
        ]);
    }

    /**
     * Creates a new DocentesXAreasTrabajos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
		$areasTrabajoData= AreasTrabajos::find()->all();
		$areasTrabajo	 = ArrayHelper::map( $areasTrabajoData, 'id', 'descripcion' );
		
		$personasData 	= Personas::find()
										->select( "d.id_perfiles_x_personas as id, ( personas.nombres || ' ' || personas.apellidos ) nombres " )
										->innerJoin('perfiles_x_personas pf', 'personas.id=pf.id_personas' )
										->innerJoin('docentes d', 'd.id_perfiles_x_personas=pf.id' )
										->where( 'personas.estado=1' )
										->andWhere( 'd.estado=1' )
										->all();
		$personas	 	= ArrayHelper::map( $personasData, 'id', 'nombres' );
		
        $model = new DocentesXAreasTrabajos();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id_perfiles_x_personas_docentes' => $model->id_perfiles_x_personas_docentes, 'id_areas_trabajos' => $model->id_areas_trabajos]);
        }

        return $this->render('create', [
            'model' 		=> $model,
            'personas' 		=> $personas,
            'areasTrabajo' 	=> $areasTrabajo,
        ]);
    }

    /**
     * Updates an existing DocentesXAreasTrabajos model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id_perfiles_x_personas_docentes
     * @param string $id_areas_trabajos
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_perfiles_x_personas_docentes, $id_areas_trabajos)
    {
		$areasTrabajoData= AreasTrabajos::find()->all();
		$areasTrabajo	 = ArrayHelper::map( $areasTrabajoData, 'id', 'descripcion' );
		
		$personasData 	= Personas::find()
										->select( "d.id_perfiles_x_personas as id, ( personas.nombres || ' ' || personas.apellidos ) nombres " )
										->innerJoin('perfiles_x_personas pf', 'personas.id=pf.id_personas' )
										->innerJoin('docentes d', 'd.id_perfiles_x_personas=pf.id' )
										->where( 'personas.estado=1' )
										->andWhere( 'd.estado=1' )
										->all();
		$personas	 	= ArrayHelper::map( $personasData, 'id', 'nombres' );
		
        $model = $this->findModel($id_perfiles_x_personas_docentes, $id_areas_trabajos);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id_perfiles_x_personas_docentes' => $model->id_perfiles_x_personas_docentes, 'id_areas_trabajos' => $model->id_areas_trabajos]);
        }

        return $this->render('update', [
            'model' 		=> $model,
			'personas' 		=> $personas,
            'areasTrabajo' 	=> $areasTrabajo,
        ]);
    }

    /**
     * Deletes an existing DocentesXAreasTrabajos model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id_perfiles_x_personas_docentes
     * @param string $id_areas_trabajos
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_perfiles_x_personas_docentes, $id_areas_trabajos)
    {
        $this->findModel($id_perfiles_x_personas_docentes, $id_areas_trabajos)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the DocentesXAreasTrabajos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id_perfiles_x_personas_docentes
     * @param string $id_areas_trabajos
     * @return DocentesXAreasTrabajos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_perfiles_x_personas_docentes, $id_areas_trabajos)
    {
        if (($model = DocentesXAreasTrabajos::findOne(['id_perfiles_x_personas_docentes' => $id_perfiles_x_personas_docentes, 'id_areas_trabajos' => $id_areas_trabajos])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
