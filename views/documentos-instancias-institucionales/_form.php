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

/* @var $this yii\web\View */
/* @var $model app\models\Documentos */
/* @var $form yii\widgets\ActiveForm */

$this->registerJsFile(Yii::$app->request->baseUrl.'/js/documentosInstanciasInstitucionales.js',['depends' => [\yii\web\JqueryAsset::className()]]);

echo Html::hiddenInput( 'idInstitucion', $idInstitucion );
?>

<style>
	.table{
		display: table;
	}

	.row{
		display: table-row;
	}

	.cell{
		display: table-cell;
	}
</style>

<div class="documentos-form">

    <?php $form = ActiveForm::begin([
		// 'id' => 'contact-form',
		// 'enableAjaxValidation' => true,
		'method' 				=> 'post',
		'enableClientValidation'=> true,		
		'options' 				=> [ 'enctype' => 'multipart/form-data' ],
	]); ?>
    
	<div class=table>
		<div class=row>
			<div class="form-group" style='display:inline;'>
				<?= Html::buttonInput('Agregar', ['class' => 'btn btn-success', 'onclick' => 'agregarCampos()', 'id' => 'btnAgregar' ]) ?>
			</div>
			
			<div class="form-group" style='display:inline;'>
				<?= Html::buttonInput('Eliminar', ['class' => 'btn btn-success', 'onclick' => 'eliminarCampos()', 'id' => 'btnEliminar', 'style' => 'display:none' ]) ?>
			</div>
		</div>
	</div>
    
	
	<div id=dvTable class=table>
		
		<div class=row>
	
			<div class=cell>
				<?= $form->field($model, '[0]id_instituciones')->dropDownList( $instituciones ) ?>
			</div>

			<div class=cell>
				<?= $form->field($model, '[0]id_tipo_documentos')->dropDownList( $tiposDocumento, [ 'prompt' => 'Seleccione...' ] ) ?>
			</div>
				
			<div class=cell>
				<?= $form->field($model, '[0]file')->label('Archivo')->fileInput([ 'accept' => ".doc, .docx, .pdf, .xls" ]) ?>
			</div>

			<div class=cell style='display:none'>
				<?= $form->field($model, '[0]estado')->hiddenInput( [ 'value' => '1' ] )->label( '' ) ?>
			</div>
				
		</div>
	
	</div>
    
	
	<div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
