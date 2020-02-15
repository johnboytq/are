<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\GestionCurricularCiclos */

$this->title = 'Actualizar';
$this->params['breadcrumbs'][] = ['label' => 'Gestión Curricular Ciclos', 'url' => ['index']];
$this->params['breadcrumbs'][] = "Actualizar";
?>
<div class="gestion-curricular-ciclos-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
		'estados' =>$estados,
    ]) ?>

</div>
