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
Fecha: 06-03-2018
Desarrollador: Oscar David Lopez
Descripción: CRUD de estudiantes(Matricular estudiantes)
---------------------------------------
Modificaciones:
Fecha: 06-03-2018
Persona encargada: Oscar David Lopez
Cambios realizados: - cambios en los campos a dropDownList 
---------------------------------------
Modificaciones:
Fecha: 21-03-2018
Persona encargada: Oscar David Lopez Villa
Cambios realizados: - correccion de error cuando la sede no tiene niveles
---------------------------------------

**********/
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Estudiantes */
/* @var $form yii\widgets\ActiveForm */
use app\models\SedesNiveles;
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/matriculasEstudiantes.js',['depends' => [\yii\web\JqueryAsset::className()]]);

?>


<script type="text/javascript">
   var idSede='<?php echo $idSedes ?>';
   
   var idParalelos='<?php echo $paralelos ?>';
 
</script>

<div class="estudiantes-form">

    <?php $form = ActiveForm::begin(); ?>
	
	
	<?php 
		
		// echo "<input type='hidden' id='hidAsig' name='hidAsig' value='".$asignaturas_distribucion."'>";
		// echo "<input type='hidden' id='hidModificar' name='hidModificar' value='".$modificar."'>";
		
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
		$nivel=array();
		foreach($result as $key){
			$nivel[$key['id']]=$key['descripcion'];
		}
					
				
		if(count($nivel)==0)
		{
			echo "<script>alert('La sede no tiene niveles');</script>";
		}
		
		
		$model1->id=$niveles_sede;
				
		echo $form->field($model1, 'id')->dropDownList($nivel, ['prompt'=>'Seleccione...','id' =>'selSedesNivel','options' => [$model1['id'] => ['selected' => 'selected']]])->label('Nivel'); 
		
		// $model->id=$asignaturas_distribucion;
	
	?>

    <?php
	echo $form->field($model, 'id_paralelos')->dropDownList(['prompt'=>'Seleccione...']) ?>

	<?= $form->field($model, 'id_perfiles_x_personas')->dropDownList($estudiantes,['prompt'=>'Seleccione...'])?>
	
    <!--<?= $form->field($model, 'estado')->dropDownList($estados)?>-->

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
