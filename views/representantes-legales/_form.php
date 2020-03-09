<?php
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
Fecha: 27-03-2018
Desarrollador: Oscar David Lopez
Descripción: CRUD de Representantes Legales (Estudiantes)
---------------------------------------
Modificaciones:
Fecha: 27-03-2018
Persona encargada: Oscar David Lopez
Cambios realizados: - se cambian los campos a dropDownList
cambio en el modelo para guardar en la tabla representante_legales
Nombre de los botones
---------------------------------------
Modificaciones:
Fecha: 28-03-2018
Persona encargada: Oscar David Lopez
Cambios realizados: - se le agrega la opcion selected a los campos 
**********/


use yii\helpers\Html;
use yii\widgets\ActiveForm;
use nex\chosen\Chosen;
/* @var $this yii\web\View */
/* @var $model app\models\RepresentantesLegales */
/* @var $form yii\widgets\ActiveForm */

$idEstudiante = @key($estudiantes);
$nombreEstudiante = @$estudiantes[ $idEstudiante  ] ;

$idRepresentante = @key($representantesLegales);
$nombreRepresentante  = @$representantesLegales[ $idRepresentante  ] ;

// echo $nombreEstudiante;
$this->registerJs( "

	$( document ).ready(function() 
	{
		
		var url = window.location.href; 
		if (url.indexOf('update')!=-1) 
		{	
			idEstudiante = '" . $idEstudiante . "';
			nombreEstudiante = '" . $nombreEstudiante . "';
			
			var info ='';
			info = '<option value='+idEstudiante+'>'+nombreEstudiante+'</option>';
			select = $('#representanteslegales-id_perfiles_x_personas');	
			select.html('');
			select.trigger('chosen:updated');
			
			select.append(info);
			select.val(idEstudiante);
			select.trigger('chosen:updated');
			
			idRepresentante = '" . $idRepresentante . "';
			nombreRepresentante = '" . $nombreRepresentante . "';
			
			
			var info ='';
			info = info + '<option value='+idRepresentante+'>'+nombreRepresentante+'</option>';
			
			select = $('#representanteslegales-id_personas');	
			select.html('');
			select.trigger('chosen:updated');

			select.append(info);
			select.val(idRepresentante);
			select.trigger('chosen:updated');
			
			
		}
		
		//estudiantes
		$('#representanteslegales_id_perfiles_x_personas_chosen').on( 'keydown', function(event) {
				if(event.which == 13)
				{
					var info ='';
					filtro = $(this).children('div').children().children().val();
					if (filtro.length > 3)
					{
					
						$.get( 'index.php?r=representantes-legales/personas&filtro='+filtro,
						function( data )
						{
							$.each(data, function( index, datos) 
								{	
									info = info + '<option value='+datos.id+'>'+datos.nombres+'</option>';
									
								});
								
							select = $('#representanteslegales-id_perfiles_x_personas');	
							select.html('');
							select.trigger('chosen:updated');
							
							select.append(info);
							select.trigger('chosen:updated');
							
							
						},'json'
							);
					
					}
				}
		});
		
		
		
		//representantes_legales
		$('#representanteslegales_id_personas_chosen').on( 'keydown', function(event) {
				if(event.which == 13)
				{
					var info ='';
					filtro = $(this).children('div').children().children().val();
					if (filtro.length > 3)
					{
						$.get( 'index.php?r=representantes-legales/representante&filtro='+filtro,
						function( data )
						{
							$.each(data, function( index, datos) 
								{	console.log(datos.identificacion);
									info = info + '<option value='+datos.id+'>'+datos.nombres+'</option>';
									
								});
								
							select = $('#representanteslegales-id_personas');	
							select.html('');
							select.trigger('chosen:updated');
							
							select.append(info);
							select.trigger('chosen:updated');
							
							
						},'json'
							);
						
					}
						
				}
		});

		
	});
		
");
?>

<div class="representantes-legales-form">

    <?php $form = ActiveForm::begin(); ?>
    
		
	<?= $form->field($model, "id_perfiles_x_personas")->widget(
						Chosen::className(), [
							 'items' => [0 => ''],
							'disableSearch' => 0, // Search input will be disabled while there are fewer than 5 items
							'multiple' => false,
							'clientOptions' => [
								'search_contains' => true,
								'single_backstroke_delete' => false,
							],
                            'placeholder' => 'Seleccione un Estudiante',
							'noResultsText' => "Enter para buscar",
					])?>	
		
		
	
	<?= $form->field($model, "id_personas")->widget(
						Chosen::className(), [
							'items' => [],
							'disableSearch' => 0, // Search input will be disabled while there are fewer than 5 items
							'multiple' => false,
							'clientOptions' => [
								'search_contains' => true,
								'single_backstroke_delete' => false,
							],
                            'placeholder' => 'Seleccione un representante',
							'noResultsText' => "Enter para buscar",
					])?>
	
	
	
	<?php //= $form->field( $model, 'id_personas' )->dropDownList( [] , [ 'prompt' => 'Seleccione...'] ) ?>
																					
    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
