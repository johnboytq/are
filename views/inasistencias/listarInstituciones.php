<?php
/**********
Versión: 001
Fecha: 19-06-2018
---------------------------------------
Modificaciones:
Fecha: 18-06-2018
Persona encargada: Edwin Molina Grisales
Cambios realizados: Se corrigen queires
---------------------------------------
**********/

if(@$_SESSION['sesion']=="si")
{ 
	// echo $_SESSION['nombre'];
} 
//si no tiene sesion se redirecciona al login
else
{
	echo "<script> window.location=\"index.php?r=site%2Flogin\";</script>";
	die;
}

/**********
Versión: 001
Fecha: 23-04-2018
Desarrollador: Edwin Molina Grisales
Descripción: CRUD de inasistencias
---------------------------------------
**********/


use yii\helpers\Html;
use yii\widgets\ActiveForm;


use app\models\Instituciones;
use app\models\Sedes;
use app\models\Personas;
use app\models\Aulas;
use app\models\Asignaturas;
use app\models\Periodos;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Asistencias';
$this->params['breadcrumbs'][] = $this->title;


//Obterniendo los datos necsarios para las instituciones
$institucionesTable	 = new Instituciones();
$queryInstituciones  = $institucionesTable->find()->orderby('descripcion')->where('estado=1');
$dataInstituciones	 = $queryInstituciones->all();
$instituciones		 = ArrayHelper::map( $dataInstituciones, 'id', 'descripcion' );

//Opciones para el select instituciones
$optionsInstituciones = array( 
							'prompt' 	=> 'Seleccione...', 
							'id'	 	=> 'idInstitucion', 
							'name'	 	=> 'idInstitucion',
							'value'	 	=> $idInstitucion == 0 ? '' : $idInstitucion,
							'onChange'	=> '$( "#idSedes" ).val(\'\'); this.form.submit(); ',
						);




$sedes = [];

//Si se ha seleccionado una institucion se buscan todas las sedes correspondientes a ese id
if( $idInstitucion > 0 ){

	//Obterniendo los datos necesarios para Sedes						
	$sedesTable	 		= new Sedes();
	$querySedes	 		= $sedesTable->find()->orderby('descripcion')->where('estado=1');
	$querySedes->andWhere( 'id_instituciones='.$idInstitucion );
	$dataSedes	 		= $querySedes->all();
	$sedes		 		= ArrayHelper::map( $dataSedes, 'id', 'descripcion' );
}

//Si se ha seleccionado una institucion se buscan todas las sedes correspondientes a ese id

$personas = [];

if( $idSedes > 0 ){

	//Obterniendo los datos necesarios para Sedes						
	$personasTable	 		= new Personas();
	$queryPersonas 			= $personasTable->find()
									->select( "personas.id, ( nombres || ' ' || apellidos ) as nombres" )
									->innerJoin( "perfiles_x_personas pp", "pp.id_personas=personas.id" )
									->innerJoin( "distribuciones_academicas da", "da.id_perfiles_x_personas_docentes=pp.id" )
									->innerJoin( "aulas_x_paralelos ap", "ap.id_paralelos=da.id_paralelo_sede" )
									->innerJoin( "aulas a", "a.id=ap.id_aulas" )
									->innerJoin( "perfiles_x_personas_institucion ppi", "ppi.id_perfiles_x_persona=pp.id" )
									->where('personas.estado=1')
									->andWhere( "a.id_sedes=".$idSedes )
									->andWhere( "a.estado=1" )
									->andWhere( "pp.estado=1" )
									->andWhere( "pp.id_perfiles=10" )
									->andWhere( "personas.estado=1" )
									->andWhere( "id_institucion=".$idInstitucion )
									->orderby('descripcion');
	// $queryPersonas->andWhere( 'id_instituciones='.$idInstitucion );
	$dataPersonas	 		= $queryPersonas->all();
	$personas	 			= ArrayHelper::map( $dataPersonas, 'id', 'nombres' );
}

$grupos = [];
//Si se ha seleccionado una institucion se buscan todas las sedes correspondientes a ese id
// if( $idGrupo > 0 ){
if( $idDocente > 0 ){
	
	//Obterniendo los datos necesarios para Sedes						
	$aulasTable	 		= new Aulas();
	$queryAulas 		= $aulasTable->find()
								->select( "aulas.id, aulas.descripcion" )
								->innerJoin( "aulas_x_paralelos ap", "ap.id_aulas=aulas.id" )
								->innerJoin( "distribuciones_academicas da", "da.id_paralelo_sede=ap.id_paralelos" )
								->innerJoin( "perfiles_x_personas pp", "pp.id=da.id_perfiles_x_personas_docentes" )
								->innerJoin( "personas p", "p.id=pp.id_personas" )
								->where('aulas.estado=1')
								->andWhere( "aulas.id_sedes=".$idSedes )
								->andWhere( "p.id=".$idDocente )
								->andWhere( "pp.estado=1" )
								->orderby('descripcion');
	// $queryPersonas->andWhere( 'id_instituciones='.$idInstitucion );
	$dataAulas	 		= $queryAulas->all();
	$grupos	 			= ArrayHelper::map( $dataAulas, 'id', 'descripcion' );
}


$asignaturas = [];
//Si se ha seleccionado una institucion se buscan todas las sedes correspondientes a ese id
// if( $idAsignatura > 0 ){
if( $idGrupo > 0 ){
	
	//Obterniendo los datos necesarios para Sedes						
	$aulasTable	 		= new Asignaturas();
	$queryAulas 		= $aulasTable->find()
								->select( "asignaturas.id, asignaturas.descripcion" )
								->innerJoin( "asignaturas_x_niveles_sedes ans", "ans.id_asignaturas=asignaturas.id" )
								->innerJoin( "distribuciones_academicas da", "da.id_asignaturas_x_niveles_sedes=ans.id" )
								->innerJoin( "aulas_x_paralelos ap", "ap.id_paralelos=da.id_paralelo_sede" )
								->innerJoin( "aulas a", "a.id=ap.id_aulas" )
								->innerJoin( "perfiles_x_personas pp", "pp.id=da.id_perfiles_x_personas_docentes" )
								->innerJoin( "personas p", "p.id=pp.id_personas" )
								->where('da.estado=1')
								->andWhere( "p.id=".$idDocente )
								->andWhere( "a.id=".$idGrupo )
								->orderby('descripcion');
	// $queryPersonas->andWhere( 'id_instituciones='.$idInstitucion );
	$dataAulas	 		= $queryAulas->all();
	$asignaturas 			= ArrayHelper::map( $dataAulas, 'id', 'descripcion' );
}

//Si se ha seleccionado una institucion se buscan todas las sedes correspondientes a ese id
// if( $idPeriodo > 0 ){
$periodos = [];
if( $idSedes > 0 ){
	
	//Obterniendo los datos necesarios para Sedes						
	$periodosTable		= new Periodos();
	$dataPeriodos 		= $periodosTable->find()
								->where('estado=1')
								->andWhere( "id_sedes=".$idSedes )
								->orderby('descripcion');
	// $queryPeriodos->andWhere( 'id_instituciones='.$idInstitucion );
	$dataPeriodos	 	= $dataPeriodos->all();
	$periodos	 		= ArrayHelper::map( $dataPeriodos, 'id', 'descripcion' );
}

//opciones para el select sedes
$optionsSedes = array( 
					'prompt' 	=> 'Seleccione...', 
					'id'	 	=> 'idSedes', 
					'name'	 	=> 'idSedes',
					'value'	 	=> $idSedes == 0 ? '' : $idSedes,
					'onchange'	=> 'this.form.submit();'
				);

$optionsPersonas = array( 
					'prompt' 	=> 'Seleccione...', 
					'id'	 	=> 'idDocente', 
					'name'	 	=> 'idDocente',
					'value'	 	=> $idDocente == 0 ? '' : $idDocente,
					'onchange'	=> 'this.form.submit();'
				);
				
$optionsGrupos = array( 
					'prompt' 	=> 'Seleccione...', 
					'id'	 	=> 'idGrupo', 
					'name'	 	=> 'idGrupo',
					'value'	 	=> $idGrupo == 0 ? '' : $idGrupo,
					'onchange'	=> 'this.form.submit();'
				);

				
$optionsAsignaturas = array( 
					'prompt' 	=> 'Seleccione...', 
					'id'	 	=> 'idAsignatura', 
					'name'	 	=> 'idAsignatura',
					'value'	 	=> $idAsignatura == 0 ? '' : $idAsignatura,
					'onchange'	=> 'this.form.submit();'
				);
				
$optionsPeriodos = array( 
					'prompt' 	=> 'Seleccione...', 
					'id'	 	=> 'idPeriodo', 
					'name'	 	=> 'idPeriodo',
					'value'	 	=> $idPeriodo == 0 ? '' : $idPeriodo,
					'onchange'	=> 'this.form.submit();'
				);

?>
<div class="sedes-index">

    <h1><?= Html::encode($this->title) ?></h1>
	
	<?php $form = ActiveForm::begin([
		// 'action' => 'index.php?r=distribuciones-academicas/index', 
		'action' => 'index.php?r=inasistencias/index', 
		'method' => 'get',
	]); ?>
	
	<?= $form->field($institucionesTable, 'id')->dropDownList( $instituciones, $optionsInstituciones )->label('Instituciones') ?>
	
	<?= $form->field($institucionesTable, 'id')->dropDownList( $sedes, $optionsSedes )->label('Sedes') ?>
	
	<?= $form->field($institucionesTable, 'id')->dropDownList( $personas, $optionsPersonas )->label('Docentes') ?>
	
	<?= $form->field($institucionesTable, 'id')->dropDownList( $grupos, $optionsGrupos )->label('Grupos') ?>
	
	<?= $form->field($institucionesTable, 'id')->dropDownList( $asignaturas, $optionsAsignaturas )->label('Asignaturas') ?>
	
	<?= $form->field($institucionesTable, 'id')->dropDownList( $periodos, $optionsPeriodos )->label('Periodos') ?>
	
	<?php $form = ActiveForm::end(); ?>
	
</div>