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

$this->registerJsFile(Yii::$app->request->baseUrl.'/js/perfilPersonaInstitucion.js',['depends' => [\yii\web\JqueryAsset::className()]]);

/* @var $this yii\web\View */
/* @var $model app\models\PerfilesPersonasInstitucion */

$this->title = 'Agregar Perfiles Personas Institucion';
$this->params['breadcrumbs'][] = ['label' => 'Perfiles Personas Institucions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="perfiles-personas-institucion-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
		'perfilesTable' => $perfilesTable,
		'perfiles' => $perfiles,
		'instituciones' => $instituciones,
		'estados' => $estados,
		'perfilesSelected' => $perfilesSelected,
        'PerfilesXPersonas' => $PerfilesXPersonas,
        'modificar' => $modificar,
    ]) ?>

</div>
