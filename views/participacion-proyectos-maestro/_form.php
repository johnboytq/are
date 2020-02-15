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
/* @var $model app\models\ParticipacionProyectosMaestro */
/* @var $form yii\widgets\ActiveForm */

$this->registerJsFile(Yii::$app->request->baseUrl.'/js/participacionProyectosMaestro.js',['depends' => [\yii\web\JqueryAsset::className()]]);

$this->registerJs( "

	$( document ).ready(function() 
	{
		//informacion de tercero 
		$('#participacionproyectosmaestro_participante_chosen').on( 'keydown', function(event) {
				if(event.which == 13)
				{
					
					var info ='';
					filtro = $(this).children('div').children().children().val();
					$.get( 'index.php?r=participacion-proyectos-maestro/docentes&filtro='+filtro,
					function( data )
					{
						$.each(data, function( index, datos) 
							{	
								info = info + '<option value='+index+'>'+datos+'</option>';
								
							});
							
						select = $('#participacionproyectosmaestro-participante');	
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

<div class="participacion-proyectos-maestro-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'programa_proyecto')->dropDownList( $nombresProyectos, [ 'prompt' => 'Seleccione...' ]) ?>
	
	<?= $form->field($model, "participante")->widget(
						Chosen::className(), [
							'items' => [],
							'disableSearch' => 0, // Search input will be disabled while there are fewer than 5 items
							'multiple' => false,
							'clientOptions' => [
								'search_contains' => true,
								'single_backstroke_delete' => false,
							],
                            'placeholder' => 'Seleccione un participante',
							'noResultsText' => "Enter para buscar",
					])?>
	
    <?= $form->field($model, 'tipo')->dropDownList( $perfiles ) ?>

    <?= $form->field($model, 'objeto')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'duracion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'anio_inicio')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'anio_fin')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tematica')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'areas')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'otros')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'materiales_recursos')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'logros')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'observaciones')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_institucion')->dropDownList( $instituciones ) ?>

    <?= $form->field($model, 'estado')->dropDownList( $estados ) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
