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

/* @var $this yii\web\View */
/* @var $model app\models\Personas */

$this->title = 'Modificar: ';
$this->params['breadcrumbs'][] = ['label' => 'Personas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Modificar';
// print_r($perfilesSelected);
// $perfilesSelected = implode(",",$perfilesSelected);
// echo $perfilesSelected;


 
?>

<script>
	selectIdcomuna = <?php echo $model->comuna; ?>;
	selectIdBarrios = <?php echo $model->id_barrios_veredas; ?>;
</script>

<div class="personas-update">

    <h1><?= Html::encode($this->title) ?></h1>

	<?php $clave= false; ?>
    <?= $this->render('_form', [
        'model' => $model,
		'identificaciones'=>$identificaciones,
		'estados'=>$estados, 	 	 	
		'generos'=>$generos, 	 	 	
		'estadosCiviles'=>$estadosCiviles,
		'municipios'=>$municipios,
		'clave'=>$clave,
		'perfiles'=>$perfiles,
		'perfilesTable'=>$perfilesTable,
		'perfilesSelected'=>$perfilesSelected,
		'arrayGrupoSanguineo'=>$arrayGrupoSanguineo,
		'arrayRH'=>$arrayRH,
		
	]) ?>
</div>
