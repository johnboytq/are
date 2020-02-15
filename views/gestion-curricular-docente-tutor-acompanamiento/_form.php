<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Collapse;
use dosamigos\datepicker\DatePicker;
use yii\bootstrap\ActiveField;
/**********
Versión: 001
Fecha: 07-08-2018
Desarrollador: Oscar David Lopez
Descripción: formulario de Instrumento de autoevaluación al Docente-Tutor en el proceso de acompañamiento
---------------------------------------
Modificaciones:
Fecha: 07-08-2018
Persona encargada: Oscar David Lopez
Cambios realizados: - creacion del formulario
---------------------------------------
**********/
/* @var $this yii\web\View */
/* @var $model app\models\GestionCurricularDocenteTutorAcompanamiento */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="gestion-curricular-docente-tutor-acompanamiento-form">

    <?php $form = ActiveForm::begin(); ?>
	
	
	
	<?php 
	
	$content="";
	$content.=
	 $form->field($model, 'fecha')->widget(
			DatePicker::className(), [
				
			 // modify template for custom rendering
			'template' 		=> '{addon}{input}',
			'language' 		=> 'es',
			'clientOptions' => [
				'autoclose' 	=> true,
				'format' 		=> 'yyyy-mm-dd'
			],
		]). 
    $form->field($model, 'nombre_profesional_acompanamiento')->textInput(['maxlength' => true])->label("Nombres y apellidos del profesional de acompañamiento asignado"). 
    $form->field($model, 'id_docente')->dropDownList($docentes,['prompt'=>'Seleccione...'])->label("Nombres y apellidos del Docente-Tutor") .
    $form->field($model, 'id_institucion')->dropDownList($instituciones)->label("IEO asignada") . 
    $form->field($model, 'id_sede')->dropDownList($sedes,['prompt'=>'Seleccione...'])->label("Sede o sedes asignadas")
	;
	
	
	$items[] = 
				[
					'label'=> "Docente Tutor",
					'content'=>$content,
					'contentOptions'=> []
				];
		
	$content1="<h2>Dimensión del SER</h2>
	<br />
	A continuación encontrará una serie de afirmaciones sobre aspectos relacionados con el SER del Docente-Tutor; califique de 1 a 4 siendo 1 Nunca y 4 Siempre, de acuerdo a la frecuencia en que usted considera que se evidencian estas características.
	<br />
	<br />";
	
	foreach ($titulos1 as $titulo1)
	{
		$content1.= $form->field( $model , 'id' )->radioList( $parametro1, array( 'separator' => "<br />"))->label(  $titulo1 );	
	}
	
	$items[] = 
				[
					'label'=> "SER",
					'content'=>$content1,
					'contentOptions'=> []
				];
				
	$content2="<h2>Dimensión del HACER</h2>
	<br />
	A continuación encontrará una serie de afirmaciones sobre aspectos relacionados con el HACER del Docente-Tutor; califique de 1 a 4 siendo 1 Nunca y 4 Siempre, de acuerdo a la frecuencia en que usted considera que se evidencian estas características.
	<br />
	<br />";
	
	
	
	foreach ($titulos2 as $titulo2)
	{
		$content2.= $form->field( $model , 'id' )->radioList( $parametro1, array( 'separator' => "<br />"))->label(  $titulo2 );
	}
	$items[] = 
				[
					'label'=> "HACER",
					'content'=>$content2,
					'contentOptions'=> []
				];
	$content3="<h2>Dimensión del SABER</h2>
	<br />
	A continuación encontrará una serie de afirmaciones sobre aspectos relacionados con el SABER del Docente-Tutor; califique de 1 a 4 siendo 1 Nunca y 4 Siempre, de acuerdo a la frecuencia en que usted considera que se evidencian estas características.
	<br />
	<br />";
	foreach ($titulos3 as $titulo3)
	{
		$content3.= $form->field( $model , 'id' )->radioList( $parametro1, array( 'separator' => "<br />") )->label(  $titulo3 );
	}
		
	$items[] = 
				[
					'label'=> "SABER",
					'content'=>$content3,
					'contentOptions'=> []
				];
	
		echo Collapse::widget([
		'items' => $items,
		]); ?>

   
    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
