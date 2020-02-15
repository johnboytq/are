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

$this->title = 'Agregar';
$this->params['breadcrumbs'][] = ['label' => 'Personas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="personas-create">

    <h1><?= Html::encode($this->title) ?></h1>
	<?php $clave= true; ?>
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
		'perfilesSelected'=>'',
		'arrayGrupoSanguineo'=>$arrayGrupoSanguineo,
		'arrayRH'=>$arrayRH,
		
    ]) ?>

</div>
