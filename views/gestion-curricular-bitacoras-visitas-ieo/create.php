<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\GestionCurricularBitacorasVisitasIeo */

$this->title = '';
$this->params['breadcrumbs'][] = ['label' => 'Bitácora De Visitas A Las Instituciones Educativas Oficiales', 'url' => ['index']];
$this->params['breadcrumbs'][] = "Agregar";
?>
<div class="gestion-curricular-bitacoras-visitas-ieo-create">

    <h1><?= Html::encode('Bitácora De Visitas A Las Instituciones Educativas Oficiales') ?></h1>

    <?= $this->render('_form', [
        'model' 	=> $model,
        'model2' 	=> $model2,
		'model3' 	=> $model3,
		'model4' 	=> $model4,
		'model5' 	=> $model5,
		'model6' 	=> $model6,
		'model7' 	=> $model7,
		'model8' 	=> $model8,
		'model9' 	=> $model9,
		'model10' 	=> $model10,
		'titulos'	=> $titulos,
		'datosCiclos'=> $datosCiclos,
		'datosSemanas'=> $datosSemanas,
		'parametro'	=> $parametro,
		'jornadas'	=> $jornadas,
		'estados'	=> $estados,
		'docentes'	=> $docentes,
		'momento1Sem1'	=> $momento1Sem1,
    ]) ?>

</div>
