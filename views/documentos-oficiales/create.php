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
/* @var $model app\models\Documentos */

$this->title = 'Agregar documentos institucionales';
$this->params['breadcrumbs'][] = ['label' => 'Documentos', 'url' => ['index', 'idInstitucion' => $idInstitucion ]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="documentos-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' 		=> $model,
        'tiposDocumento'=> $tiposDocumento,
        'instituciones'	=> $instituciones,
		'estados' 		=> $estados,
		'idInstitucion'	=> $idInstitucion,
    ]) ?>

</div>
