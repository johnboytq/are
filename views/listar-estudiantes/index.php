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
use yii\grid\GridView;
use app\models\Sedes;
use fedemotta\datatables\DataTables;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Listar Estudiantes';
$this->params['breadcrumbs'][] = $this->title;

$sedes   = Sedes::findOne($idSedes);
$nombreSede = $sedes ? $sedes->descripcion : '';
?>

<script>

var idSede = <?php echo $idSedes; ?>;
var idInstitucion=<?php echo $idInstitucion; ?>;
</script>
<script src="js/jquery-3.3.1.min.js"> </script>
<script src="js/listarEstudiantes.js"> </script>

<div class="listar-estudiantes-index">

    <h1><?= Html::encode($nombreSede) ?></h1>
	
	<?php $form = ActiveForm::begin(); ?>
		<?php echo $form->field($model, 'id_paralelos')->dropDownList($paralelos,['prompt'=>'Seleccione...','options' => [$idParalelo => ['selected' => 'selected']]]) ?>
		<?php echo $form->field($model, 'estado')->dropDownList($jornadas,['prompt'=>'Seleccione...','options' => [$idJornada => ['selected' => 'selected']]])->label("Jornada") ?>
	<?php ActiveForm::end(); ?> 

    
 <?php echo  DataTables::widget([
						'dataProvider' => $dataProvider,
						'clientOptions' => [
							'language'=>[
									'url' => '//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json',
								],
							"lengthMenu"=> [[20,-1], [20,Yii::t('app',"All")]],
							"info"=>false,
							"responsive"=>true,
							"dom"=> 'lfTrtip',
							"tableTools"=>[
								"aButtons"=> [  
									[
									"sExtends"=> "csv",
									"oSelectorOpts"=> ["page"=> 'current']
									],
									[
									"sExtends"=> "xls",
									"oSelectorOpts"=> ["page"=> 'current']
									],
									[
									"sExtends"=> "pdf",
									"oSelectorOpts"=> ["page"=> 'current']
									],
								],
							],
						],
						'columns' => 
						[
							['class' => 'yii\grid\SerialColumn'], 
							[
								'attribute' => 'identificacion',
								'label'		=> 'Documento',
							],
							[
								'attribute' => 'nombres',
								'label'		=> 'Nombre',
							],
							[
								'attribute' => 'domicilio',
								'label'		=> 'Dirección',
							],
							[
								'attribute' => 'grupo',
								'label'		=> 'Grupo',
							],
							[
								'attribute' => 'descripcion',
								'label'		=> 'Jornada',
							],

						],
					]); ?>
</div>
