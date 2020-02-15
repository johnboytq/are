<?php

use yii\helpers\Html;
// use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;

// use yii\bootstrap\Collapse;
use nex\chosen\Chosen;

use app\models\AcuerdosInstitucionales;

use app\models\SemillerosDatosIeo;
use app\models\SemillerosDatosIeoBuscar;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


use app\models\Instituciones;
use app\models\Sedes;
use app\models\Personas;
use app\models\Estados;
use app\models\Fases;
use app\models\Sesiones;
use app\models\EstudiantesOperativoSesion;
use app\models\Escalafones;
use app\models\Docentes;
use app\models\DistribucionesAcademicas;
use app\models\Parametro;
use app\models\Jornadas;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

use yii\db\Query;


// $form1 = ActiveForm::begin(
	// [
		// 'layout' => 'horizontal',
		// 'fieldConfig' => [
			// 'template' => "{beginWrapper}\n{input}\n{endWrapper}",
			// 'horizontalCssClasses' => [
				// 'label' 	=> 'col-sm-0',
				// 'offset' 	=> 'col-sm-offset-2',
				// 'wrapper' 	=> 'col-sm-1',
				// 'error' 	=> '',
				// 'hint' 		=> '',
				// 'input' 	=> 'col-sm-1',
			// ],
		// ],
	// ]
	// );

// foreach( $sesiones as $keySesion =>$sesion ){
		
	// if( !$idPE ){
		$acuerdos = new AcuerdosInstitucionales();
		$idPE = 0;
	// }
	// else{
		// $acuerdos = AcuerdosInstitucionales::findOne([ 
						// 'id_poblacion_docentes' 	=> $idPE->id,
						// 'id_sesion'					=> $sesion->id,
					// ]);
	// }
	
	// echo Html::activeHiddenInput( $acuerdos, "[$index]id_sesion", [ 'value' => $sesion->id ] );
	
	// echo $form->field( $acuerdos, "[$index]valor" )->textInput( ['autocomplete' => 'ñññ' ])->label( $sesion->descripcion );
	
	$index++;
// }

$id_sede 		= $_SESSION['sede'][0];
$id_institucion	= $_SESSION['instituciones'][0];

$dataPersonas 	= Personas::find()
						->select( "( nombres || ' ' || apellidos ) as nombres, personas.id" )
						->innerJoin( 'perfiles_x_personas pp', 'pp.id_personas=personas.id' )
						->innerJoin( 'docentes d', 'd.id_perfiles_x_personas=pp.id' )
						->innerJoin( 'perfiles_x_personas_institucion ppi', 'ppi.id_perfiles_x_persona=pp.id' )
						->where( 'personas.estado=1' )
						->andWhere( 'id_institucion='.$id_institucion )
						->all();

$docentes		= ArrayHelper::map( $dataPersonas, 'id', 'nombres' );


$dataParametro 	= Parametro::find()
						->where( 'id_tipo_parametro=6' )
						->andWhere( 'estado=1' )
						->orderby( 'id' )
						->all();

$parametros		= ArrayHelper::map( $dataParametro, 'id', 'descripcion' );

$dataJornadas 	= Parametro::find()
						->where( 'id_tipo_parametro=7' )
						->andWhere( 'estado=1' )
						->all();

$jornadas		= ArrayHelper::map( $dataJornadas, 'id', 'descripcion' );

$dataRecursos 	= Parametro::find()
						->where( 'id_tipo_parametro=8' )
						->andWhere( 'estado=1' )
						->all();

$recursos		= ArrayHelper::map( $dataRecursos, 'id', 'descripcion' );


?>

<div class="container-fluid">

	<div class=row style='text-align:center;'>
		<div class="col-sm-1" style='padding:0px;'>
			<span total class='form-control' style='background-color:#ccc;height:70px;'>Nombre del docente</span>
		</div>
		<div class="col-sm-1" style='padding:0px;'>
			<span total class='form-control' style='background-color:#ccc;height:70px'>Nombre de las asignaturas asignadas</span>
		</div>
		<div class="col-sm-1" style='padding:0px;'>
			<span total class='form-control' style='background-color:#ccc;height:70px'>Especialidad de la Media Técnica o Técnica</span>
		</div>
		<div class="col-sm-1" style='padding:0px;'>
			<span total class='form-control' style='background-color:#ccc;height:70px'>Frecuencia sesiones</span>
		</div>
		<div class="col-sm-1" style='padding:0px;'>
			<span total class='form-control' style='background-color:#ccc;height:70px'>Jornada</span>
		</div>
		<div class="col-sm-1" style='padding:0px;'>
			<span total class='form-control' style='background-color:#ccc;height:70px'>Recursos requeridos</span>
		</div>
		<div class="col-sm-1" style='padding:0px;'>
			<span total class='form-control' style='background-color:#ccc;height:70px'>Total Docentes</span>
		</div>
		<div class="col-sm-2" style='padding:0px;'>
			<span total class='form-control' style='background-color:#ccc;height:70px'>OBSERVACIONES</span>
		</div>
	</div>
	
	<div class=row>
		<div class="col-sm-1" style='padding:0px;'>
			<?= Html::activeDropDownList($acuerdos, '[$index]id_docente', $docentes, [ 'class' => 'form-control', 'prompt' => 'Seleccione...' ] ) ?>
		</div>
		<div class="col-sm-1" style='padding:0px;'>
			<?=  Html::activeTextInput($acuerdos, '[$index]asignatura', [ 'class' => 'form-control'] ) ?>
		</div>
		<div class="col-sm-1" style='padding:0px;'>
			<?=  Html::activeTextInput($acuerdos, '[$index]especialidad', [ 'class' => 'form-control'] ) ?>
		</div>
		<div class="col-sm-1" style='padding:0px;'>
			<?=  Html::activeDropDownList($acuerdos, '[$index]frecuencias_sesiones', $parametros, [ 'class' => 'form-control', 'prompt' => 'Seleccione...' ] ) ?>
		</div>
		<div class="col-sm-1" style='padding:0px;'>
			<?=  Html::activeDropDownList($acuerdos, '[$index]jornada', $jornadas, [ 'class' => 'form-control', 'prompt' => 'Seleccione...' ] ) ?>
		</div>
		<div class="col-sm-1" style='padding:0px;'>
			<?= Html::activeDropDownList($acuerdos, '[$index]recursos_requeridos', $recursos, [ 'class' => 'form-control', 'prompt' => 'Seleccione...' ]) ?>
		</div>
		<div class="col-sm-1" style='padding:0px;'>
			<?= Html::activeTextInput($acuerdos, '[$index]total_docentes', [ 'class' => 'form-control']) ?>
		</div>
		<div class="col-sm-2" style='padding:0px;'>
			<?= Html::activeTextInput($acuerdos, '[$index]observaciones', [ 'class' => 'form-control']) ?>
		</div>
	</div>
	
	<div class=row>
		<div class="col-sm-1" style='padding:0px;'>
			<?= Html::activeDropDownList($acuerdos, '[$index]id_docente', $docentes, [ 'class' => 'form-control', 'prompt' => 'Seleccione...' ] ) ?>
		</div>
		<div class="col-sm-1" style='padding:0px;'>
			<?=  Html::activeTextInput($acuerdos, '[$index]asignatura', [ 'class' => 'form-control'] ) ?>
		</div>
		<div class="col-sm-1" style='padding:0px;'>
			<?=  Html::activeTextInput($acuerdos, '[$index]especialidad', [ 'class' => 'form-control'] ) ?>
		</div>
		<div class="col-sm-1" style='padding:0px;'>
			<?=  Html::activeDropDownList($acuerdos, '[$index]frecuencias_sesiones', $parametros, [ 'class' => 'form-control', 'prompt' => 'Seleccione...' ] ) ?>
		</div>
		<div class="col-sm-1" style='padding:0px;'>
			<?=  Html::activeDropDownList($acuerdos, '[$index]jornada', $jornadas, [ 'class' => 'form-control', 'prompt' => 'Seleccione...' ] ) ?>
		</div>
		<div class="col-sm-1" style='padding:0px;'>
			<?= Html::activeDropDownList($acuerdos, '[$index]recursos_requeridos', $recursos, [ 'class' => 'form-control', 'prompt' => 'Seleccione...' ]) ?>
		</div>
		<div class="col-sm-1" style='padding:0px;'>
			<?= Html::activeTextInput($acuerdos, '[$index]total_docentes', [ 'class' => 'form-control']) ?>
		</div>
		<div class="col-sm-2" style='padding:0px;'>
			<?= Html::activeTextInput($acuerdos, '[$index]observaciones', [ 'class' => 'form-control']) ?>
		</div>
	</div>
	
	<div class=row>
		<div class="col-sm-1" style='padding:0px;'>
			<?= Html::activeDropDownList($acuerdos, '[$index]id_docente', $docentes, [ 'class' => 'form-control', 'prompt' => 'Seleccione...' ] ) ?>
		</div>
		<div class="col-sm-1" style='padding:0px;'>
			<?=  Html::activeTextInput($acuerdos, '[$index]asignatura', [ 'class' => 'form-control'] ) ?>
		</div>
		<div class="col-sm-1" style='padding:0px;'>
			<?=  Html::activeTextInput($acuerdos, '[$index]especialidad', [ 'class' => 'form-control'] ) ?>
		</div>
		<div class="col-sm-1" style='padding:0px;'>
			<?=  Html::activeDropDownList($acuerdos, '[$index]frecuencias_sesiones', $parametros, [ 'class' => 'form-control', 'prompt' => 'Seleccione...' ] ) ?>
		</div>
		<div class="col-sm-1" style='padding:0px;'>
			<?=  Html::activeDropDownList($acuerdos, '[$index]jornada', $jornadas, [ 'class' => 'form-control', 'prompt' => 'Seleccione...' ] ) ?>
		</div>
		<div class="col-sm-1" style='padding:0px;'>
			<?= Html::activeDropDownList($acuerdos, '[$index]recursos_requeridos', $recursos, [ 'class' => 'form-control', 'prompt' => 'Seleccione...' ]) ?>
		</div>
		<div class="col-sm-1" style='padding:0px;'>
			<?= Html::activeTextInput($acuerdos, '[$index]total_docentes', [ 'class' => 'form-control']) ?>
		</div>
		<div class="col-sm-2" style='padding:0px;'>
			<?= Html::activeTextInput($acuerdos, '[$index]observaciones', [ 'class' => 'form-control']) ?>
		</div>
	</div>
	
	<div class=row>
		<div class="col-sm-1" style='padding:0px;'>
			<?= Html::activeDropDownList($acuerdos, '[$index]id_docente', $docentes, [ 'class' => 'form-control', 'prompt' => 'Seleccione...' ] ) ?>
		</div>
		<div class="col-sm-1" style='padding:0px;'>
			<?=  Html::activeTextInput($acuerdos, '[$index]asignatura', [ 'class' => 'form-control'] ) ?>
		</div>
		<div class="col-sm-1" style='padding:0px;'>
			<?=  Html::activeTextInput($acuerdos, '[$index]especialidad', [ 'class' => 'form-control'] ) ?>
		</div>
		<div class="col-sm-1" style='padding:0px;'>
			<?=  Html::activeDropDownList($acuerdos, '[$index]frecuencias_sesiones', $parametros, [ 'class' => 'form-control', 'prompt' => 'Seleccione...' ] ) ?>
		</div>
		<div class="col-sm-1" style='padding:0px;'>
			<?=  Html::activeDropDownList($acuerdos, '[$index]jornada', $jornadas, [ 'class' => 'form-control', 'prompt' => 'Seleccione...' ] ) ?>
		</div>
		<div class="col-sm-1" style='padding:0px;'>
			<?= Html::activeDropDownList($acuerdos, '[$index]recursos_requeridos', $recursos, [ 'class' => 'form-control', 'prompt' => 'Seleccione...' ]) ?>
		</div>
		<div class="col-sm-1" style='padding:0px;'>
			<?= Html::activeTextInput($acuerdos, '[$index]total_docentes', [ 'class' => 'form-control']) ?>
		</div>
		<div class="col-sm-2" style='padding:0px;'>
			<?= Html::activeTextInput($acuerdos, '[$index]observaciones', [ 'class' => 'form-control']) ?>
		</div>
	</div>
	
	<div class=row>
		<div class="col-sm-1" style='padding:0px;'>
			<?= Html::activeDropDownList($acuerdos, '[$index]id_docente', $docentes, [ 'class' => 'form-control', 'prompt' => 'Seleccione...' ] ) ?>
		</div>
		<div class="col-sm-1" style='padding:0px;'>
			<?=  Html::activeTextInput($acuerdos, '[$index]asignatura', [ 'class' => 'form-control'] ) ?>
		</div>
		<div class="col-sm-1" style='padding:0px;'>
			<?=  Html::activeTextInput($acuerdos, '[$index]especialidad', [ 'class' => 'form-control'] ) ?>
		</div>
		<div class="col-sm-1" style='padding:0px;'>
			<?=  Html::activeDropDownList($acuerdos, '[$index]frecuencias_sesiones', $parametros, [ 'class' => 'form-control', 'prompt' => 'Seleccione...' ] ) ?>
		</div>
		<div class="col-sm-1" style='padding:0px;'>
			<?=  Html::activeDropDownList($acuerdos, '[$index]jornada', $jornadas, [ 'class' => 'form-control', 'prompt' => 'Seleccione...' ] ) ?>
		</div>
		<div class="col-sm-1" style='padding:0px;'>
			<?= Html::activeDropDownList($acuerdos, '[$index]recursos_requeridos', $recursos, [ 'class' => 'form-control', 'prompt' => 'Seleccione...' ]) ?>
		</div>
		<div class="col-sm-1" style='padding:0px;'>
			<?= Html::activeTextInput($acuerdos, '[$index]total_docentes', [ 'class' => 'form-control']) ?>
		</div>
		<div class="col-sm-2" style='padding:0px;'>
			<?= Html::activeTextInput($acuerdos, '[$index]observaciones', [ 'class' => 'form-control']) ?>
		</div>
	</div>
	
	
</div>


	

