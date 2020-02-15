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

use yii\validators\FileValidator;

$this->registerJsFile("https://unpkg.com/sweetalert/dist/sweetalert.min.js");
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/poblarTablas.js',['depends' => [\yii\web\JqueryAsset::className()]]);


if( !empty( $msg ) ){
	
	// var_dump( $msg['errorInfo'][1] );
	
	$warning = $msg[0] == 0 ? 'success' : 'warning';
	$message = str_replace( "\n", "<br>", $msg[1] );
	
	$this->registerJs( <<< EOT_JS_CODE

  swal({
		text: "$message",
		icon: "$warning",
		button: "Cerrar",
	});

EOT_JS_CODE
);
}

$this->title = 'Poblar tabla';

$fileValidator = new FileValidator();
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
	
	.campos{
		display: inline-block;
		padding: 10px;
		border: 1px solid black;
		margin: 5px;
		background-color: white;
	}
</style>

<h1><?= Html::encode($this->title) ?></h1>

<div class="documentos-form">

    <?php $form = ActiveForm::begin([
		// 'id' => 'contact-form',
		// 'enableAjaxValidation' => true,
		'method' 				=> 'post',
		'enableClientValidation'=> true,		
		'options' 				=> [ 'enctype' => 'multipart/form-data' ],
		'action' 				=> [ 'create' ],
	]); ?>
    
	
	<div id=dvTable class=table>
		
		<div class=row>
	
			<div class=cell>
				<?= $form->field( $model, 'tabla')->dropDownList( $tablas, [ 'prompt' 	=> 'Seleccione...', 
																			 'class'	=> 'form-control', 
																			 'onChange'	=> 'seleccionarTabla(this);', 
				] ) ?>
			</div>
		
		</div>
		
		<div class=row>

			<div class=cell>
				<?= $form->field( $model, 'archivo')->fileInput( [ 'accept' => ".csv, .txt" ] )->label( "Archivo csv(".Yii::$app->formatter->asShortSize( $fileValidator->sizeLimit ).")" ) ?>
			</div>
				
		</div>
	
		<div class=row>
			<div class=cell>
				<br><b>Campos de la tabla</b>
				<div style='overflow:auto;width:80%;background:#ddd;padding:20px;' id='dvCampos'>
				
				</div>
			</div>
		</div>
			
		<div class=row>
			<div class=cell style='overflow:auto;'>
				<br><b>Ejemplo archivo csv:</b>
				<div style='overflow:auto;width:80%;background:#ddd;'>
					<p style='background:#ddd;padding:10px;' id='pCsvExample'>
						"campo1";"campo2";"campo3",...<br>
						"campo1";"campo2";"campo3",...
					</p>
				</div>
			</div>
		</div>
		
	</div>
    
	
	<div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
