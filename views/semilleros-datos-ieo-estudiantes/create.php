<?php
/**********
Versión: 001
Fecha: 2018-08-16
Desarrollador: Edwin Molina Grisales
Descripción: Formulario CONFORMACION SEMILLEROS TIC ESTUDIANTES
---------------------------------------
**********/

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\SemillerosDatosIeoEstudiantes */

$this->title = 'CONFORMACIÓN SEMILLEROS TIC ESTUDIANTES';
$this->params['breadcrumbs'][] = ['label' => 'Conformación Semilleros TIC Estudiantes', 'url' => ['index']];
$this->params['breadcrumbs'][] = "Agregar";
?>
<div class="semilleros-datos-ieo-estudiantes-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' 		=> $model,
		'institucion' 	=> $institucion,
		'sede' 			=> $sede,
		'docentes' 		=> $docentes,
		'controller'	=> $controller,
    ]) ?>

</div>
