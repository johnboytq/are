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
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use nex\chosen\Chosen;
/* @var $this yii\web\View */
/* @var $model app\models\ProyectoAula */
/* @var $form yii\widgets\ActiveForm */

$this->registerJs( "

	$( document ).ready(function() 
	{
		//informacion de tercero 
		$('#proyectoaula_id_persona_coordinador_chosen').on( 'keydown', function(event) {
				if(event.which == 13)
				{
					
					var info ='';
					filtro = $(this).children('div').children().children().val();
					$.get( 'index.php?r=proyecto-aula/docentes&filtro='+filtro,
					function( data )
					{
						$.each(data, function( index, datos) 
							{	
								info = info + '<option value='+index+'>'+datos+'</option>';
								
							});
							
						select = $('#proyectoaula-id_persona_coordinador');	
						select.html('');
						select.trigger('chosen:updated');
						
						select.append(info);
						select.trigger('chosen:updated');
						
						
					},'json'
						);
						
						
				}
		});
		


		
	});
		
");

?>




<div class="proyecto-aula-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_sede')->dropDownList( [ $sede->id => $sede->descripcion ] ) ?>
	
    <?= $form->field($model, 'id_grupo')->dropDownList( $paralelos, [ 'prompt' => 'Seleccione...' ] ) ?>

    <?= $form->field($model, 'nombre_proyecto')->textInput() ?>

    <?= $form->field($model, 'id_jornada')->dropDownList( $jornadas, [ 'prompt' => 'Seleccione...' ] ) ?>

	
	<?= $form->field($model, "id_persona_coordinador")->widget(
						Chosen::className(), [
							'items' => [],
							'disableSearch' => 0, // Search input will be disabled while there are fewer than 5 items
							'multiple' => false,
							'clientOptions' => [
								'search_contains' => true,
								'single_backstroke_delete' => false,
							],
                            'placeholder' => 'Seleccione un coordinador',
							'noResultsText' => "Enter para buscar",
					])?>
	

    <?= $form->field($model, 'correo')->textInput() ?>

    <?= $form->field($model, 'celular')->textInput() ?>

    <?= $form->field($model, 'descripcion')->textInput() ?>

	<?= $form->field($model, 'file')->label('Archivo')->fileInput([ 'accept' => ".doc, .docx, .pdf, .xls" ]) ?>
	
    <?= $form->field($model, 'avance_1')->textInput() ?>

    <?= $form->field($model, 'avance_2')->textInput() ?>

    <?= $form->field($model, 'avance_3')->textInput() ?>

    <?= $form->field($model, 'avance_4')->textInput() ?>
	
    <?= $form->field($model, 'estado')->dropDownList($estados) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
