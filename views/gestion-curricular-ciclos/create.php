<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\GestionCurricularCiclos */

$this->title = 'Agregar Gestión Curricular Ciclos';
$this->params['breadcrumbs'][] = ['label' => 'Gestión Curricular Ciclos', 'url' => ['index']];
$this->params['breadcrumbs'][] = "Agregar";
?>
<div class="gestion-curricular-ciclos-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
		'estados' =>$estados,
    ]) ?>

</div>
