<?php
/**********
Versión: 001
Fecha: 04-04-2018
---------------------------------------
Modificaciones:
Fecha: 16-10-2019
Persona encargada: Edwin Molina Grisales
Se hacen cambios varios para guardar la información y generar pdf
---------------------------------------
Fecha: 09-07-2018
Persona encargada: Edwin Molina Grisales
Se consulta las faltas del estudiante y se asocia el perido a las califiaciones
---------------------------------------
Fecha: 27-03-2018
Persona encargada: Edwin Molina Grisales
Al guardar una nota se deja la fecha de modificación a la actual
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

use app\models\Docentes;
use app\models\ObservacionesCalificaciones;
use app\models\Paralelos;
use app\models\PerfilesXPersonas;
use app\models\Personas;
use app\models\Periodos;
use Mpdf\Mpdf;
use Mpdf\MpdfException;
use Mpdf\Output\Destination;
use Yii;
use app\models\Calificaciones;
use app\models\CalificacionesBuscar;
use yii\base\InvalidConfigException;
use yii\db\Exception;
use yii\db\Expression;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;

/**
 * CalificacionesController implements the CRUD actions for Calificaciones model.
 */
class CalificacionesController extends Controller
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

    //retorna todos los docentes de la base de datos
    public function actionConsultarInasitencias( $docente, $grupo, $asignatura, $periodo )
    {
        // echo '-'.$docente, '-'.$grupo, '-'.$asignatura, '-'.$periodo;
        // exit();

        if( empty($periodo) || $periodo == 0 ){
            $sql = "SELECT i.id_perfiles_x_personas_estudiantes, count(*) as total
					  FROM perfiles_x_personas as pp,
						   asignaturas_x_niveles_sedes as ans,
						   distribuciones_academicas as da,
						   inasistencias as i
					 WHERE da.id_paralelo_sede=".$grupo."
					   AND da.estado=1
					   AND ans.id_asignaturas=".$asignatura."
					   AND da.id_perfiles_x_personas_docentes=".$docente."
					   AND pp.id=i.id_perfiles_x_personas_estudiantes
					   AND ans.id=da.id_asignaturas_x_niveles_sedes
					   AND i.id_distribuciones_academicas=da.id
					   AND i.estado=1
				  GROUP BY i.id_perfiles_x_personas_estudiantes
				";
        }
        else{
            $sql = "SELECT i.id_perfiles_x_personas_estudiantes, count(*) as total
					  FROM perfiles_x_personas as pp,
						   asignaturas_x_niveles_sedes as ans,
						   distribuciones_academicas as da,
						   inasistencias as i,
						   periodos as p
					 WHERE da.id_paralelo_sede=".$grupo."
					   AND da.estado=1
					   AND ans.id_asignaturas=".$asignatura."
					   AND da.id_perfiles_x_personas_docentes=".$docente."
					   AND pp.id=i.id_perfiles_x_personas_estudiantes
					   AND ans.id=da.id_asignaturas_x_niveles_sedes
					   AND i.id_distribuciones_academicas=da.id
					   AND i.estado=1
					   AND p.id=".$periodo."
					   AND i.fecha::DATE BETWEEN p.fecha_inicio::DATE AND p.fecha_fin::DATE
				  GROUP BY i.id_perfiles_x_personas_estudiantes
				";
        }
        // echo "<pre>$sql</pre>";
        $connection = Yii::$app->getDb();
        //saber el nombre del docente
        $command = $connection->createCommand($sql);

        $result = $command->queryAll();

        $faltas = [];
        foreach ($result as $value)
        {
            $id 		= $value['id_perfiles_x_personas_estudiantes'];
            $total 		= $value['total'];
            $faltas[] 	= [ 'id' => $id, 'total' => $total ];
        }

        echo json_encode($faltas);
    }

    public function actionConsultarCalificaciones( $idDocente, $idIndicadorDesempeno, $periodo ){

        $val = [];

        // $calificaciones = Calificaciones::find()
        // ->select( "calificaciones.id as id, ( p.nombres || ' ' || p.apellidos ) as nombres, calificaciones.calificacion as calificacion, pp.id as id_personas " )
        // ->innerJoin( 'perfiles_x_personas pp', 'pp.id = calificaciones.id_perfiles_x_personas_estudiantes' )
        // ->innerJoin( 'personas p', 'p.id = pp.id_personas' )
        // ->where( 'calificaciones.estado=1' )
        // ->andWhere( 'calificaciones.id_perfiles_x_personas_docentes='.$idDocente )
        // ->andWhere( 'calificaciones.id_distribuciones_x_indicador_desempeno='.$idIndicadorDesempeno )
        // ->all();

        $connection = Yii::$app->getDb();
        //saber el nombre del docente
        $command = $connection->createCommand("
			SELECT c.id as id, ( p.nombres || ' ' || p.apellidos ) as nombres, c.calificacion as calificacion, pp.id as id_personas
			  FROM calificaciones c, perfiles_x_personas pp, personas p
			 WHERE c.estado=1
			   AND c.id_perfiles_x_personas_docentes=".$idDocente."
			   AND c.id_distribuciones_x_indicador_desempeno=".$idIndicadorDesempeno."
			   AND pp.id = c.id_perfiles_x_personas_estudiantes
			   AND p.id = pp.id_personas
			   AND c.id_periodo = ".$periodo."
		");

        $calificaciones = $command->queryAll();

        foreach( $calificaciones as $calificacion ){
            // echo "<pre>"; var_dump( $calificacion ); echo "</pre>";
            $val[] = [
                "id" 			=> $calificacion[ 'id' ],
                "calificacion" 	=> $calificacion[ 'calificacion' ],
                "estudiante" 	=> $calificacion[ 'id_personas' ],
                "nombres" 		=> $calificacion[ 'nombres' ],
                "indicador" 	=> $idIndicadorDesempeno,
            ];
        }

        echo json_encode( $val );
    }

    //retorna todos los docentes de la base de datos
    public function actionListarDocentes()
    {

        $connection = Yii::$app->getDb();
        //saber el nombre del docente
        $command = $connection->createCommand("
		SELECT d.id_perfiles_x_personas as id, concat(p.nombres,' ',p.apellidos) as nombres
			FROM public.docentes as d, public.perfiles_x_personas as per, public.personas as p
			where d.id_perfiles_x_personas = per.id
			and per.id_personas = p.id
			and d.estado =1
		");
        $result = $command->queryAll();

        $docente[] = "<option value=''>Seleccione...</option>";
        foreach ($result as $key)
        {
            $id = $key['id'];
            $nombres = $key['nombres'];
            $docente[] = "<option value='$id'>$nombres</option>";
        }

        return json_encode($docente);
        // return Json::encode( $algo);
    }

    //retorna los niveles que tiene el docente
    public function actionNivelesDocente($idDocente)
    {

        $connection = Yii::$app->getDb();
        //retorno los id_asignaturas_x_niveles_sedes para saber que niveles tiene ese docente
        $command = $connection->createCommand("
		SELECT id_asignaturas_x_niveles_sedes as id FROM public.distribuciones_academicas
		where id_perfiles_x_personas_docentes = $idDocente
		");
        $result = $command->queryAll();

        //se pasan los ids retornados por la consulta en un string

        foreach ($result as $dato)
        {
            $idANS[]=$dato['id'];
        }
        $idANS= implode(",",$idANS);

        //tabla intermedia para saber cuales son lo niveles que tiene ese docente
        $command = $connection->createCommand("
		SELECT id_sedes_niveles as id
		FROM public.asignaturas_x_niveles_sedes
		where id in ($idANS) group by id_sedes_niveles 
		");
        $result = $command->queryAll();


        //se pasan los ids retornados por la consulta en un string

        foreach ($result as $dato)
        {
            $idSN[]=$dato['id'];
        }

        $idSN= implode(",",$idSN);


        //se obtiene los id de los niveles a lo que dicta el docente
        $command = $connection->createCommand("
		SELECT id_niveles as id
		FROM public.sedes_niveles
		where id in ($idSN) group by id_niveles
		");
        $result = $command->queryAll();

        //se pasan los ids retornados por la consulta en un string

        foreach ($result as $dato)
        {
            $idN[]=$dato['id'];
        }

        $idN= implode(",",$idN);
        //nombre de los niveles
        $command = $connection->createCommand("
		SELECT id, descripcion
		FROM public.niveles
		where id in ($idN) group by id
		");
        $result = $command->queryAll();


        $docente[] = "<option value=''>Seleccione...</option>";
        foreach ($result as $key)
        {
            $id = $key['id'];
            $descripcion = $key['descripcion'];
            $docente[] = "<option value='$id'>$descripcion</option>";
        }


        return json_encode($docente);
        // return Json::encode( $algo);
    }

    //retorna los grupo que tien ese nivele que tiene el docente
    public function actionGrupoNivelesDocente($idDocente,$idNivel)
    {

        $connection = Yii::$app->getDb();
        //retorno los id_paralelo_sede para saber que paralelos tiene esa el docente y comparalos con el nivel
        $command = $connection->createCommand("
		SELECT p.id, p.descripcion 
		FROM public.paralelos as p, public.sedes_niveles as sn, public.distribuciones_academicas as da
		where p.id_sedes_niveles = sn.id
		and sn.id_niveles=$idNivel
		and da.id_paralelo_sede=p.id
		and da.id_perfiles_x_personas_docentes = $idDocente
		group by p.id, p.descripcion
		");
        $result = $command->queryAll();

        //se formatea para llenar el combo
        $grupo[] = "<option value=''>Seleccione...</option>";
        foreach ($result as $key)
        {
            $id = $key['id'];
            $descripcion = $key['descripcion'];
            $grupo[] = "<option value='$id'>$descripcion</option>";
        }

        echo json_encode($grupo);

    }

    //que materia da el docente en ese paralelo
    public function actionMateriaGrupo($idDocente,$idParalelo)
    {

        $connection = Yii::$app->getDb();

        $command = $connection->createCommand("
		SELECT id_asignaturas_x_niveles_sedes as id
		FROM public.distribuciones_academicas
		where id_perfiles_x_personas_docentes = $idDocente
		and id_paralelo_sede = $idParalelo
		and estado = 1
		");
        $result = $command->queryAll();

        //se pasan los ids retornados por la consulta en un string

        foreach ($result as $dato)
        {
            $idAXNS[]=$dato['id'];
        }

        $idAXNS= implode(",",$idAXNS);


        //se consulta el id y la descripcion de las materias que tiene el docente
        $command = $connection->createCommand("
		SELECT a.id, a.descripcion
		FROM public.asignaturas_x_niveles_sedes as ans, asignaturas as a
		where ans.id in ($idAXNS)
		and ans.id_asignaturas = a.id
		");
        $result = $command->queryAll();
        $materia[] = "<option value=''>Seleccione...</option>";
        foreach ($result as $key)
        {
            $id = $key['id'];
            $descripcion = $key['descripcion'];
            $materia[] = "<option value='$id'>$descripcion</option>";
        }

        echo json_encode($materia);
    }


    //retorna la sede y la jornada donde esta ese docente
    public function actionSedeJornadaPeriodo($idDocente)
    {
        $data= array();

        $connection = Yii::$app->getDb();

        $command = $connection->createCommand("
		SELECT id_paralelo_sede as id
		FROM public.distribuciones_academicas
		where id_perfiles_x_personas_docentes =$idDocente 
		group by id_paralelo_sede
		");
        $result = $command->queryAll();

        //se pasan los ids retornados por la consulta en un string

        foreach ($result as $dato)
        {
            $idPS[]=$dato['id'];
        }

        $idPS= implode(",",$idPS);

        //nombre id y nombre de la sede
        $command = $connection->createCommand("
		SELECT s.id , s.descripcion
		FROM public.paralelos as p, public.sedes_jornadas as sj, public.sedes as s
		where p.id in($idPS)
		and p.id_sedes_jornadas = sj.id
		and sj.id_sedes=s.id
		group by s.id , s.descripcion
		");
        $result = $command->queryAll();

        $idSede = $result[0]['id'];
        $nombreSede = $result[0]['descripcion'];

        $data['nombreSede'] = $nombreSede ;
        //nombre id y nombre de la sede
        $command = $connection->createCommand("		
		SELECT j.id,j.descripcion
		FROM public.sedes_jornadas as sj, jornadas as j
		where sj.id_sedes= $idSede
		and sj.id_jornadas = j.id
		");
        $result = $command->queryAll();

        $jornadas[] = "<option value=''>Seleccione...</option>";
        foreach ($result as $key)
        {
            $id = $key['id'];
            $descripcion = $key['descripcion'];
            $jornadas[] = "<option value='$id'>$descripcion</option>";
        }

        $data['jornadas']=$jornadas;
        //los periodos de esa sede
        $command = $connection->createCommand("		
		SELECT id, descripcion
		FROM public.periodos
		where id_sedes = $idSede
		");
        $result = $command->queryAll();

        $periodos[] = "<option value=''>Seleccione...</option>";
        foreach ($result as $key)
        {
            $id = $key['id'];
            $descripcion = $key['descripcion'];
            $periodos[] = "<option value='$id'>$descripcion</option>";
        }

        $data['periodos']=$periodos;
        echo json_encode($data);


    }


    public function actionPersonas($idParalelo)
    {

        $varHtml ='<td>
							<div class="form-group field-calificacionesbuscar-observaciones">
<label class="control-label" for="calificacionesbuscar-observaciones"></label>
<input type="text" id="calificacionesbuscar-observaciones" class="form-control nota" name="saber" onkeyup="notaFinal(this)">

<div class="help-block"></div>
</div>							<input type="hidden" value="" name="idsaber">
						</td>
						<td>
							<div class="form-group field-calificacionesbuscar-observaciones">
<label class="control-label" for="calificacionesbuscar-observaciones"></label>
<input type="text" id="calificacionesbuscar-observaciones" class="form-control nota" name="hacer" onkeyup="notaFinal(this)">

<div class="help-block"></div>
</div>							<input type="hidden" value="" name="idhacer">
						</td>
						<td>
							<div class="form-group field-calificacionesbuscar-observaciones">
<label class="control-label" for="calificacionesbuscar-observaciones"></label>
<input type="text" id="calificacionesbuscar-observaciones" class="form-control nota" name="ser" onkeyup="notaFinal(this)">

<div class="help-block"></div>
</div>							<input type="hidden" value="" name="idser">
						</td>
						<td>
							<div class="form-group field-calificacionesbuscar-observaciones">
<label class="control-label" for="calificacionesbuscar-observaciones"></label>
<input type="text" id="calificacionesbuscar-observaciones" class="form-control nota" name="personal">

<div class="help-block"></div>
</div>							<input type="hidden" value="" name="idpersonal" >
						</td>
						<td>
							<div class="form-group field-calificacionesbuscar-observaciones">
<label class="control-label" for="calificacionesbuscar-observaciones"></label>
<input type="text" id="calificacionesbuscar-observaciones" class="form-control nota" name="social" onkeyup="notaFinal(this)">

<div class="help-block"></div>
</div>							<input type="hidden" value="" name="idsocial">
						</td>
						<td>
							<div class="form-group field-calificacionesbuscar-observaciones">
<label class="control-label" for="calificacionesbuscar-observaciones"></label>
<input type="text" id="calificacionesbuscar-observaciones" class="form-control nota" name="ae" onkeyup="notaFinal(this)">

<div class="help-block"></div>
</div>							<input type="hidden" value="" name="idae">
						</td>
						<td>
							<div class="form-group field-calificacionesbuscar-observaciones">
<label class="control-label" for="calificacionesbuscar-observaciones"></label>
<input type="text" id="calificacionesbuscar-observaciones" class="form-control" name="CalificacionesBuscar[observaciones]" disabled="disabled">

<div class="help-block"></div>
</div>						</td>
						<td>
							<div class="form-group field-calificacionesbuscar-observaciones">
<label class="control-label" for="calificacionesbuscar-observaciones"></label>
<input type="text" id="calificacionesbuscar-observaciones" class="form-control falta" name="CalificacionesBuscar[observaciones]">

<div class="help-block"></div>
</div>						</td>
						<td>
							<div class="form-group field-calificacionesbuscar-observaciones">
<label class="control-label" for="calificacionesbuscar-observaciones"></label>
<input type="text" id="calificacionesbuscar-observaciones" class="form-control coevaluacion" name="CalificacionesBuscar[observaciones]">

<div class="help-block"></div>
</div>						</td>
					';




        $connection = Yii::$app->getDb();
        //los periodos de esa sede
        $command = $connection->createCommand("		
		SELECT e.id_perfiles_x_personas as id, concat(p.nombres,' ',p.apellidos) as nombres
		FROM public.estudiantes as e, public.perfiles_x_personas as pp, public.personas as p
		where e.id_paralelos = $idParalelo
		and e.estado = 1
		and e.id_perfiles_x_personas = pp.id
		and pp.id_personas =p.id
		");
        $result = $command->queryAll();

        $con=0;

        $data=[];

        foreach ($result as $datos)
        {
            $con++;
            $id 		= $datos['id'];
            $nombres 	= $datos['nombres'];
            // $data.="<tr estudiante='$id'>";
            // $data.= "<td><b>#$con</b></td>";
            // $data.= "<td><b>$nombres</b><input type='hidden' value='$id' name='idPersona'></td>";
            // $data.=$varHtml;
            $data[] = array(
                'id' 		=> $id,
                'nombres' 	=> $nombres,
            );

        }
        // $data.="</tr>";


        return json_encode($data);
    }




    /**
     * Lists all Calificaciones models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CalificacionesBuscar();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Calificaciones model.
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
     * Creates a new Calificaciones model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @throws \Mpdf\MpdfException
     */
    public function actionCreate()
    { 
        // var_dump( Yii::$app->request->post('data') );
        $data	=  Yii::$app->request->post('data');
        $observaciones =  Yii::$app->request->post('observacion');

        $count 	= count(Yii::$app->request->post('data'));

        $models = [];
        for( $i = 0; $i < $count; $i++ )
        {
            if( $data[$i]['id'] != 0 )
                $models[] = Calificaciones::findOne( $data[$i]['id'] );
            else
                $models[] = new Calificaciones();
        }


        if (Calificaciones::loadMultiple($models, Yii::$app->request->post(), 'data' ) && Calificaciones::validateMultiple($models)) {
            foreach ($models as $model) {
                $model->fecha_modificacion = date( "Y-m-d" );
                $model->save(false);
            }
        }
        else{

            foreach( $models as $model ){
                foreach( $model->errors as $error ){
                    var_dump( $error );
                }
            }

            return;
        }

        //Devuelo la lista de los ids
        $val = [];

        foreach( $models as $model ){
            $val[$model->id_perfiles_x_personas_estudiantes][]=[
                "id" 				=> $model->id,
                "indicadorDesempeno"=> $model->id_distribuciones_x_indicador_desempeno,
            ];
            $estudiante = $model->id_perfiles_x_personas_estudiantes;

        }


		if( !empty($observaciones) > 0 ){
			
			foreach ($observaciones as $observacion_data){
				$observacion = ObservacionesCalificaciones::find()->where([
						'id_estudiante' => $observacion_data["id_estudiante"],
						'id_asignatura' => $data[0]['id_asignatura'],
						'id_periodo' => $data[0]['id_periodo']
					]
				)->one();

				if (is_null($observacion)){
					$observacion = new ObservacionesCalificaciones();
				}

				$observacion->id_estudiante = $observacion_data["id_estudiante"];
				$observacion->id_jornada = $data[0]['id_sede_jornada'];
				$observacion->id_paralelo = $data[0]['id_paralelo'];
				$observacion->id_asignatura = $data[0]['id_asignatura'];
				$observacion->id_periodo = $data[0]['id_periodo'];
				$observacion->observacion_conocer = $observacion_data['observacion_conocer'] ? $observacion_data['observacion_conocer']: " ";
				$observacion->observacion_hacer = $observacion_data['observacion_hacer'] ? $observacion_data['observacion_hacer']: " ";
				$observacion->observacion_saber = $observacion_data['observacion_saber'] ? $observacion_data['observacion_saber']: " ";

				if ($observacion->observacion_conocer != '' || $observacion->observacion_hacer != '' || $observacion->observacion_saber){
					$observacion->save();
				}
			}
		}

        return json_encode( $val );
    }

    /**
     * Updates an existing Calificaciones model.
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
     * Deletes an existing Calificaciones model.
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
     * Esta funcion lista los indicadores de desempeño.
     *
     * @param Recibe id sedes nivel
     * @return la lista de asignaturas
     * @throws no tiene excepciones
     */
    public function actionListarI($idDocente, $idParalelo, $idAsignatura)
    {

		$resultado = [];

        //variable con la conexion a la base de datos
        $connection = Yii::$app->getDb();
        //traer el id distribucion
        $command = $connection->createCommand("select da.id
												from distribuciones_academicas as da, paralelos as p, asignaturas as a, asignaturas_x_niveles_sedes as ans
												where da.id_perfiles_x_personas_docentes = $idDocente
												and da.id_paralelo_sede = p.id
												and p.id = $idParalelo
												and a.id = $idAsignatura
												and da.id_asignaturas_x_niveles_sedes = ans.id
												and ans.id_asignaturas  = a.id");
        // $result = $command->queryAll();
        $idDistribucion = $command->queryAll();
        $idDistribucion = $idDistribucion[0]['id'];

        //traer indicadores de desempeño de la distribucion
        $command = $connection->createCommand("select did.id, id.id as codigo
												from distribuciones_academicas as da, distribuciones_x_indicador_desempeno as did, paralelos as p, indicador_desempeno as id
												where da.id_perfiles_x_personas_docentes = $idDocente
												and da.id_paralelo_sede = p.id
												and p.id = $idParalelo
												and did.id_distribuciones = da.id
												and id_distribuciones = $idDistribucion
												and id_indicador_desempeno = id.id");
        $result = $command->queryAll();

        // return Json::encode( $result );

        $i = 0;
        foreach( $result as $key => $value )
        {
            // echo "<pre>"; var_dump($value); echo "</pre>";
            $valor = $i;
            if( $i > 5 ){
                $valor = $i % 3;
            }
            $i++;

            switch( $valor )
            {
                case 0:
                    $resultado[ 'conocer' ][] 	= $value;
                    break;
                case 1:
                    $resultado[ 'hacer' ][] 	= $value;
                    break;
                case 2:
                    $resultado[ 'ser' ][] 		= $value;
                    break;
                case 3:
                    $resultado[ 'personal' ][] 	= $value;
                    break;
                case 4:
                    $resultado[ 'social' ][] 	= $value;
                    break;
                case 5:
                    $resultado[ 'ae' ][] 		= $value;
                    break;
                default: break;
            }
        }

        return Json::encode( $resultado );

    }


    /**
     * Finds the Calificaciones model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Calificaciones the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Calificaciones::findOne($id)) !== null) {
            return $model;
        }

        return 'The requested page does not exist.';
    }

    public function actionGeneratePdf(){
        try {

            $institucion = Yii::$app->request->post("institucionSede");
            $idDocente = Yii::$app->request->post("docente");
            $idParalelo = Yii::$app->request->post("paralelo");
            $estudiante_id = json_decode(Yii::$app->request->post("estudiante"));
            $idsAsignaturas = Yii::$app->request->post("materias");

            $perfilxpersona = PerfilesXPersonas::findOne($estudiante_id);
            $estudiante = Personas::findOne($perfilxpersona->id_personas);

            $paralelo = Paralelos::findOne($idParalelo);
            // $docente = Docentes::findOne($idDocente);
            $docente = PerfilesXPersonas::findOne($idDocente);
            $docente = Personas::findOne($docente->id_personas);
			
			$periodos = Periodos::find()
								->where('estado=1')
								->andWhere('id_sedes='.$_SESSION['sede'][0])
								->orderby('descripcion')
								->all();

            unset($idsAsignaturas[0]);
            $result_array = "";

            foreach ($idsAsignaturas as $each_number) {
                $result_array = $each_number.",".$result_array;
            }

            $idsAsignaturas = substr($result_array, 0, -1);

            #Creamos el objeto pdf (con medidas en milímetros):
            $pdf = new Mpdf();

            //variable con la conexion a la base de datos
            $connection = Yii::$app->getDb();
            //traer el id distribucion
            $command = $connection->createCommand("select da.id
												from distribuciones_academicas as da, paralelos as p, asignaturas as a, asignaturas_x_niveles_sedes as ans
												where da.id_perfiles_x_personas_docentes = $idDocente
												and da.id_paralelo_sede = p.id
												and p.id = $idParalelo
												and a.id in($idsAsignaturas)
												and da.id_asignaturas_x_niveles_sedes = ans.id
												and ans.id_asignaturas  = a.id");
            // $result = $command->queryAll();
            $idDistribucion = $command->queryAll();

            $result_array = "";

            foreach ($idDistribucion as $each_number) {
                foreach ($each_number as $each) {
                    $result_array = $each.",".$result_array;
                }
            }

            $idDistribucion = substr($result_array, 0, -1);

            $calificaciones = $connection->createCommand("SELECT 
                  personas.nombres || ' ' || personas.apellidos AS nombre,
                  avg(\"public\".calificaciones.calificacion) AS calificacion,
                  \"public\".calificaciones.id_periodo,
                  \"public\".calificaciones.id_distribuciones_x_indicador_desempeno AS indicador_desempeno,
                  \"public\".asignaturas.descripcion AS materia,
                  \"public\".indicador_desempeno.codigo AS porcentaje
                FROM (((((((((calificaciones
                  JOIN estudiantes ON ((calificaciones.id_perfiles_x_personas_estudiantes = estudiantes.id_perfiles_x_personas)))
                  JOIN perfiles_x_personas ON ((estudiantes.id_perfiles_x_personas = perfiles_x_personas.id)))
                  JOIN personas ON ((perfiles_x_personas.id_personas = personas.id)))
                  JOIN distribuciones_x_indicador_desempeno ON ((calificaciones.id_distribuciones_x_indicador_desempeno = distribuciones_x_indicador_desempeno.id)))
                  JOIN indicador_desempeno ON ((distribuciones_x_indicador_desempeno.id_indicador_desempeno = indicador_desempeno.id)))
                  JOIN distribuciones_academicas ON ((distribuciones_x_indicador_desempeno.id_distribuciones = distribuciones_academicas.id)))
                  JOIN asignaturas_x_niveles_sedes ON ((distribuciones_academicas.id_asignaturas_x_niveles_sedes = asignaturas_x_niveles_sedes.id)))
                  JOIN asignaturas ON ((asignaturas_x_niveles_sedes.id_asignaturas = asignaturas.id)))
                  JOIN observaciones_calificaciones ON (((observaciones_calificaciones.id_asignatura = asignaturas.id) AND (observaciones_calificaciones.id_estudiante = estudiantes.id_perfiles_x_personas))))
                  WHERE estudiantes.id_perfiles_x_personas = $perfilxpersona->id
                  GROUP BY materia, nombre, \"public\".calificaciones.id_periodo, calificaciones.id_distribuciones_x_indicador_desempeno,\"public\".indicador_desempeno.codigo
                 ORDER BY indicador_desempeno");

			// $observacion_calificacion = $connection->createCommand("SELECT 
                  // personas.nombres || ' ' || personas.apellidos AS nombre,
                  // calificaciones.calificacion AS calificacion,
                  // calificaciones.id_periodo AS periodo,
                  // calificaciones.id_distribuciones_x_indicador_desempeno AS indicador_desempeno,
                  // asignaturas.descripcion AS materia
                // FROM (((((((((calificaciones
                  // JOIN estudiantes ON ((calificaciones.id_perfiles_x_personas_estudiantes = estudiantes.id_perfiles_x_personas)))
                  // JOIN perfiles_x_personas ON ((estudiantes.id_perfiles_x_personas = perfiles_x_personas.id)))
                  // JOIN personas ON ((perfiles_x_personas.id_personas = personas.id)))
                  // JOIN distribuciones_x_indicador_desempeno ON ((calificaciones.id_distribuciones_x_indicador_desempeno = distribuciones_x_indicador_desempeno.id)))
                  // JOIN indicador_desempeno ON ((distribuciones_x_indicador_desempeno.id_indicador_desempeno = indicador_desempeno.id)))
                  // JOIN distribuciones_academicas ON ((distribuciones_x_indicador_desempeno.id_distribuciones = distribuciones_academicas.id)))
                  // JOIN asignaturas_x_niveles_sedes ON ((distribuciones_academicas.id_asignaturas_x_niveles_sedes = asignaturas_x_niveles_sedes.id)))
                  // JOIN asignaturas ON ((asignaturas_x_niveles_sedes.id_asignaturas = asignaturas.id)))
                  // JOIN observaciones_calificaciones ON (((observaciones_calificaciones.id_asignatura = asignaturas.id) AND (observaciones_calificaciones.id_estudiante = estudiantes.id_perfiles_x_personas))))
									// WHERE estudiantes.id_perfiles_x_personas = $perfilxpersona->id
                  // GROUP BY materia, nombre, calificaciones.id_periodo,calificaciones.calificacion, indicador_desempeno
                 // ORDER BY indicador_desempeno");

            $observaciones_calificaciones = [];
            $array_key_periodo = [];
            $key_periodo_1 = 0;
            $key_periodo_2 = 0;
            $materia = '';
			
			$resultadoCalificaiones = $calificaciones->queryAll();
            foreach ($resultadoCalificaiones as $key => $obj_calificacion){
                if ($materia !== $obj_calificacion["materia"]){
                    $key_periodo_1 = 0;
                    $key_periodo_2 = 0;
                    $materia = $obj_calificacion["materia"];
                }
				
				if( empty( $array_key_periodo[$obj_calificacion["id_periodo"]] ) )
					$array_key_periodo[$obj_calificacion["id_periodo"]] = 0;

				$observaciones_calificaciones[$obj_calificacion["materia"]][$obj_calificacion["id_periodo"]][] = $obj_calificacion["calificacion"];
                $array_key_periodo[$obj_calificacion["id_periodo"]]++;
					
                // if ($obj_calificacion["id_periodo"] == 8){
                    // $observaciones_calificaciones[$obj_calificacion["materia"]][$obj_calificacion["id_periodo"]][$key_periodo_1] = $obj_calificacion["calificacion"];
                    // $key_periodo_1++;
                // }
                // if ($obj_calificacion["id_periodo"] == 9){
                    // $observaciones_calificaciones[$obj_calificacion["materia"]][$obj_calificacion["id_periodo"]][$key_periodo_2] = $obj_calificacion["calificacion"];
                    // $key_periodo_2++;
                // }
				
            }
	// print_r($observaciones_calificaciones);
            $calificacion_periodos = [];
            $definitiva = [];
            // $indicadores = [59 => 0.3*0.7, 60=>0.4*0.7, 61=>0.3*0.7, 62=>0.1, 63=>0.1,64=>0.1,   65 => 0.3*0.7, 66=>0.4*0.7, 67=>0.3*0.7, 68=>0.1,69=>0.1,70=>0.1];
			
			// echo "<pre>"; print_r($calificaciones->queryAll()); echo "</pre>"; 
			
			// echo 1*"0.3 * 0.7";
			
			
			$ordenarPeriodos = true;
			
            foreach ($calificaciones->queryAll() as $key => $calificacion){
				
				if( $ordenarPeriodos ){
					foreach( $periodos as $key => $periodo ){
						if( !isset($definitiva[$calificacion["materia"]][ $periodo->id ]) )
							$definitiva[$calificacion["materia"]][ $periodo->id ] = 0;
						
						if( !isset($calificacion_periodos[$calificacion["materia"]][ $periodo->id ]["calificacion"] ) )
							$calificacion_periodos[$calificacion["materia"]][ $periodo->id ]["calificacion"] = 0;
					}
					$ordenarPeriodos = false;
				}
				
				// if( !is_numeric( $calificacion['porcentaje'] ) ) exit( print_r($calificacion) );
				$porcentaje =  $calificacion['porcentaje'] * 1;
				
				if( !isset($definitiva[$calificacion["materia"]][$calificacion['id_periodo']]) )
					$definitiva[$calificacion["materia"]][$calificacion['id_periodo']] = 0;
				
                $definitiva[$calificacion["materia"]][$calificacion['id_periodo']] += $calificacion["calificacion"] * $porcentaje; 

                $calificacion_periodos[$calificacion["materia"]][$calificacion['id_periodo']]["calificacion"] = $definitiva[$calificacion["materia"]][$calificacion['id_periodo']];
               
            }
			

     //       Yii::$app->get('db')->createCommand("COPY (".$calificaciones->getRawSql().") TO '" . __DIR__ . "/../web/".trim($estudiante->nombres, '-').".csv' DELIMITER';' NULL '';")->queryAll();

            $asignaturas = ObservacionesCalificaciones::find()->where('id_estudiante=:estudiante', [':estudiante'=>$perfilxpersona->id])->all();
// print_r($asignaturas); die();

            $contentend = $this->renderPartial('generatePdf', [
                'institucion' => $institucion,
                'docente' => $docente->nombres." ".$docente->apellidos,
                'estudiante' => $estudiante->nombres." ".$estudiante->apellidos,
                'paralelo' => $paralelo->descripcion,
                'asignaturas' => $asignaturas,
                'materia_calificacion' => $calificacion_periodos,
                'observacion_calificacion' => $observaciones_calificaciones
            ]);

            $pdf->WriteHTML($contentend);

            $pdf->Output("../web/".trim( trim($estudiante->nombres, '-') ).".pdf", \Mpdf\Output\Destination::FILE);

            return trim($estudiante->nombres).".pdf";
        } catch (MpdfException $e) {
            var_dump($e);
            die();
        } catch (Exception $e) {
            var_dump($e);
            die();
        } catch (InvalidConfigException $e) {
            var_dump($e);
            die();
        }
    }

    public function actionObservationPerson()
    {
        $id = intval(Yii::$app->request->post("id"));
        $periodo = intval(Yii::$app->request->post("periodo"));
        $asignatura = intval(Yii::$app->request->post("asignatura"));
        $observacion = ObservacionesCalificaciones::find()
            ->where('id_estudiante=:estudiante', [':estudiante'=>$id])
            ->andWhere('id_periodo=:periodo', [':periodo'=>$periodo])
            ->andWhere('id_asignatura=:asignatura', [':asignatura'=>$asignatura])->one();
        $observaciones = [];
        $observaciones["id_estudiante"] = $id;
        $observaciones["observacion_conocer"] = $observacion["observacion_conocer"];
        $observaciones["observacion_hacer"] = $observacion["observacion_hacer"];
        $observaciones["observacion_saber"] = $observacion["observacion_saber"];

        return json_encode($observaciones);
    }


}

