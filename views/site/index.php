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

//con que institucion y que sede se debe trabajar
if (@$_GET['instituciones'])
{
	$_SESSION['instituciones'][0]=$_GET['instituciones'];
}

if (@$_GET['sede'])
{
	$_SESSION['sede'][0]=$_GET['sede'];
}


 $this->registerJsFile(Yii::$app->request->baseUrl.'/js/sweetalert2.js',['depends' => [\yii\web\JqueryAsset::className()]]);
 $this->registerJsFile(Yii::$app->request->baseUrl.'/js/index.js',['depends' => [\yii\web\JqueryAsset::className()]]);
 	
	//solo los id de institucion a los que la persona con ese perfil pertenece
 foreach($_SESSION['instituciones'] as $i)
		{
			$idInstituciones[]=$i;
		}
		
		$idInstituciones= implode(",",$idInstituciones);

	
	
$connection = Yii::$app->getDb();
//saber el id de la sede para redicionar al index correctamente
$command = $connection->createCommand("
SELECT id, descripcion
FROM instituciones 
WHERE estado = 1
AND id in($idInstituciones)
");
$result = $command->queryAll();

$datos="";
foreach($result as $r)
{
	$id=$r['id'];
	$descripcion = $r['descripcion'];
	$datos.= "'$id':'$descripcion',";
}

	
	$this->registerJs( <<< EOT_JS_CODE
	
	//que institucion selecciono
const {value: institucion} = swal({
  title: 'Seleccione una Institución',
  input: 'select',
  inputOptions: { $datos
    
  },
  inputPlaceholder: 'Seleccione...',
  inputValidator: (value) => {
    return new Promise((resolve) => {
      if (value !== '') 
	  {  
  
  
		  //-----se usa para saber que sede selecciono-------
		  //crear variable de session que tenga la institucion que seleciono
		 var Institucion = $.get( "index.php?instituciones="+value, function() 
			{
				
			})
			  
			return fetch('index.php?r=sedes/sedes&idInstitucion='+value)
			  .then(response => {
				if (!response.ok) {
				  throw new Error(response.statusText)
				}
				(prueba) =   response.json()
				
				
				
				const {valor: sede} = swal({
			title: 'Seleccione una sede',
			input: 'select',
			inputOptions: (prueba),
				inputPlaceholder: 'Seleccione...',
				
				inputValidator: (valor) => 
				{
					return new Promise((resolve) => 
					{
						if (valor !== '') 
						  {
							  //variable de sesion con la sede que selecciono
							 var Sedesasda = $.get( "index.php?sede="+valor, function() 
								{
									
								})
								
								
								
									
									
									
							resolve()
						  }
						  else 
						  {
							resolve('Debe seleccionar una sede')
						  }
					})
				}
			})
				
				
      })

      }
	  else 
	  {
        resolve('Debe seleccionar una institucion')
      }
    })
  }
})




EOT_JS_CODE
);
?>

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

/* @var $this yii\web\View */

$this->title = 'Sistema de Información GERMAN';
?>

<div class="site-index">

    <div class="jumbotron">
        <h2>Bienvenido al sistema de información GERMAN</h2>
        <!--<img src="../views/site/logo_mcee.png" style="width: 100%; margin: 15px auto;">-->
	</div>
</div>
