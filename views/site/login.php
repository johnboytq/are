<?php
$this->registerJsFile("https://unpkg.com/sweetalert/dist/sweetalert.min.js");
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\Perfiles;
use	yii\helpers\ArrayHelper;

use nex\chosen\Chosen;

$this->title = 'Ingreso al sistema GERMAN';
$this->params['breadcrumbs'][] = $this->title;

if(isset($_SESSION)) 
{ 
    session_destroy(); 
	unset($_SESSION['__flash']);
}

    
if (@$_GET['mensaje']==1)
{	
	$this->registerJs( <<< EOT_JS_CODE

  swal({
		text: "Datos incorrectos",
		icon: "warning",
		button: "Cerrar",
	});

EOT_JS_CODE
);	
}
?>
<div class="col-md-18 col-md-offset-4">
    <h1><?= Html::encode($this->title) ?></h1>


    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>

        <?= $form->field($model, 'username')->textInput(['autofocus' => true])->Label("Usuario") ?>

        <?= $form->field($model, 'password')->passwordInput()->Label("Contraseña") ?>

        <!--<?= $form->field($model, 'rememberMe')->checkbox([
            'template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
        ])->label("Recordar en esta pagina") ?>-->
		
		<?php

		$modelPerfiles = new Perfiles();
		
		$perfiles = $modelPerfiles->find()->orderBY("descripcion")->all();
		$perfiles = ArrayHelper::map($perfiles,'id','descripcion');
			
		// echo $form->field($modelPerfiles, 'descripcion')->dropDownList($perfiles)->label('Perfil'); 
		?>
		
		<?= $form->field($modelPerfiles, 'descripcion')->widget(
			Chosen::className(), [
				'items' => $perfiles,
				'disableSearch' => 5, // Search input will be disabled while there are fewer than 5 items
				'placeholder' => 'Seleccione...',
				'clientOptions' => [
					'search_contains' => true,
					'single_backstroke_delete' => false,
				],
			])->label('Perfil');
		?>

        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= Html::submitButton('Ingresar', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>

    <!--<div class="col-lg-offset-1" style="color:#999;">
        You may login with <strong>admin/admin</strong> or <strong>demo/demo</strong>.<br>
        To modify the username/password, please check out the code <code>app\models\User::$users</code>.
		</div>-->
		
</div>
<div class="col-md-18 col-md-offset-2">

</div>

