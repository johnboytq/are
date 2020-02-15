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
/* @var $model app\models\AsignaturasNivelesSedes */

$this->title = 'Agregar Asignaturas Niveles Sedes';
$this->params['breadcrumbs'][] = ['label' => 'Asignaturas Niveles Sedes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<script>

var idModelo= 0 ;

</script>
<div class="asignaturas-niveles-sedes-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
		'idSedes'=>0,
		'idNiveles'=>0,
		'idAsignaturas'=>0,
    ]) ?>

</div>
