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
Fecha: Fecha en formato (13-04-2018)
Desarrollador: Viviana Rodas
Descripción: Formulario grupos soporte
---------------------------------------
*******/

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
use nex\chosen\Chosen;

/* @var $this yii\web\View */
/* @var $model app\models\GruposSoporte */
/* @var $form yii\widgets\ActiveForm */

$this->registerJs( "

	$( document ).ready(function() 
	{
		//informacion de tercero 
		$('#grupossoporte_id_docentes_chosen').on( 'keydown', function(event) {
				if(event.which == 13)
				{
					
					var info ='';
					filtro = $(this).children('div').children().children().val();
					$.get( 'index.php?r=grupos-soporte/docentes&filtro='+filtro,
					function( data )
					{
						$.each(data, function( index, datos) 
							{	
								info = info + '<option value='+index+'>'+datos+'</option>';
								
							});
							
						select = $('#grupossoporte-id_docentes');	
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

<div class="grupos-soporte-form"> 

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_tipo_grupos')->dropDownList($tipoGruposSoporte, ['prompt'=>'Seleccione...']) ?>

    <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true,'placeholder'=> 'Digite la descripción']) ?>

    <?= $form->field($model, 'id_sede')->dropDownList($sedes) ?>

    <?= $form->field($model, 'id_jornada_sede')->dropDownList($sedesJornadas, ['prompt'=>'Seleccione...']) ?>

    <?= $form->field($model, 'edad_minima')->textInput() ?>

    <?= $form->field($model, 'edad_maxima')->textInput() ?>

    <?= $form->field($model, 'cantidad_participantes')->textInput() ?>

	<?= $form->field($model, "id_docentes")->widget(
						Chosen::className(), [
							'items' => [],
							'disableSearch' => 0, // Search input will be disabled while there are fewer than 5 items
							'multiple' => false,
							'clientOptions' => [
								'search_contains' => true,
								'single_backstroke_delete' => false,
							],
                            'placeholder' => 'Seleccione un docente',
							'noResultsText' => "Enter para buscar",
					])?>


    <?= $form->field($model, 'observaciones')->textarea(['rows' => '6']) ?>

    <?= $form->field($model, 'estado')->dropDownList($estados, ['prompt'=>'Seleccione...']) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
