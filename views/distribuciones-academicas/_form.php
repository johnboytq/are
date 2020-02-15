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
Fecha: Fecha en formato (15-03-2018)
Desarrollador: Viviana Rodas
Descripción: Formulario distribuciones academicas
---------------------------------------
Modificaciones:
Fecha: 26-04-2018
Persona encargada: Oscar David Lopez
Cambios realizados: - Horario
---------------------------------------
**********/



use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\SedesNiveles;
use app\models\Estados;
use fedemotta\datatables\DataTables;
use kartik\editable\Editable;


/* @var $this yii\web\View */
/* @var $model app\models\DistribucionesAcademicas */
/* @var $form yii\widgets\ActiveForm */
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/sweetalert2.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/distribucionesAcademicas.js',['depends' => [\yii\web\JqueryAsset::className()]]);
?>



<?php //echo $idSedes; ?>
<div class="distribuciones-academicas-form">
    
	<?php $form = ActiveForm::begin(); ?>
	
	<?= $form->field($model, 'id_perfiles_x_personas_docentes')->dropDownList($docentes, ['prompt'=>'Seleccione...'])->label('Docente') ?>
	
	<?php 
		
		echo "<input type='hidden' id='hidAsig' name='hidAsig' value='".$asignaturas_distribucion."'>";
		echo "<input type='hidden' id='hidPara' name='hidAsig' value='".$paralelos_distribucion."'>";
		echo "<input type='hidden' id='hidModificar' name='hidModificar' value='".$modificar."'>";
		echo "<input type='hidden' id='hidIdSede' name='hidIdSede' value='".$idSedes."'>";
		
		$model1 = new SedesNiveles();
					// $model1->id=$idSedes;
					
					//variable con la conexion a la base de datos
					$connection = Yii::$app->getDb();
					//saber el id de la sede para llenar los niveles de esa sede
					$command = $connection->createCommand("SELECT sn.id, n.descripcion
															FROM public.sedes_niveles as sn, niveles as n
															where sn.id_sedes = $idSedes
															and sn.id_niveles = n.id
															and n.estado = 1");
					$result = $command->queryAll();
					foreach($result as $key){
						$nivel[$key['id']]=$key['descripcion'];
					}
					
				
		
		// $model1->id=$niveles_sede;
		$model1->id=$nivelSelected;
		
		echo $form->field($model1, 'id')->dropDownList($nivel, ['prompt'=>'Seleccione...','id' =>'selSedesNivel','options' => [$model1['id'] => ['selected' => 'selected']]])->label('Nivel'); 
		
		$model->id=$asignaturas_distribucion;
	
	?>
	
	<?= $form->field($model, 'id_paralelo_sede')->dropDownList([''=>'Seleccione...'])->label('Grupo') ?>
	
	<?= $form->field($model, 'id_aulas_x_sedes')->dropDownList($aulas, ['prompt'=>'Seleccione...'])->label('Aula') ?>
    
	
	
	<?= $form->field($model, 'id_asignaturas_x_niveles_sedes')->dropDownList([''=>'Seleccione...'])->label('Asignatura') ?>

   <!-- Campos de fecha que no se envian desde el formulario se envian con datos de fecha del sistema -->
	<?php $date =  date ( 'Y-m-d H:m:s' )?>
	
	<?= $form->field($model, 'fecha_ingreso')->hiddenInput(['value'=> $date])->label(false)?>
	
    <!-- <?= $form->field($model, 'estado')->dropDownList($estados, ['prompt'=>'Seleccione...']) ?> -->

     <!--<div class="form-group">
       <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>-->

    <?php ActiveForm::end(); ?> 

	
	<?php
					DataTables::widget([
					'dataProvider' => $dataProvider,
					
					
				]); 
	?>
	
	<?= Html::tag('label', "<h2>Horario</h2>", ['id' => 'tablaModulosLabel']) ?>
	<table id="tablaModulos" class="display" cellspacing="0" width="100%" ></table>
	
</div>


<!--<button type="button" class="btn btn-primary" id='btnHorario' onClick="window.open('/are/views/distribuciones-academicas/horario.html?idSede=48', target='popup', 'toolbar=0 , location=1 , status=0 , menubar=1 , scrollbars=0 , resizable=1 ,left=150pt,top=150pt,width=400px,height=400px'); return false;">Horario</button>-->
<!--<button type="button" class="btn btn-primary" id='btnHorario' onClick="">Horario</button>-->

