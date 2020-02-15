<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace yii\base;

use Yii;
use app\models\PerfilesPersonasInstitucion;

/**
 * Object is the base class that implements the *property* feature.
 *
 * It has been replaced by [[BaseObject]] in version 2.0.13 because `object` has become a reserved word which can not be
 * used as class name in PHP 7.2.
 *
 * Please refer to [[BaseObject]] for detailed documentation and to the
 * [UPGRADE notes](https://github.com/yiisoft/yii2/blob/2.0.13/framework/UPGRADE.md#upgrade-from-yii-2012)
 * on how to migrate your application to use [[BaseObject]] class to make your application compatible with PHP 7.2.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 * @deprecated since 2.0.13, the class name `Object` is invalid since PHP 7.2, use [[BaseObject]] instead.
 * @see https://wiki.php.net/rfc/object-typehint
 * @see https://github.com/yiisoft/yii2/issues/7936#issuecomment-315384669
 */

 
 
//se extrae los datos que vienen de login (usuario y contraseña) para para validarlos
extract($_POST['LoginForm']);
$perfil = $_POST['Perfiles']['descripcion'];
//se encripta primero para comparalo con lo que esta en la base de datos
$psw = hash("sha256",$password);

//variable de conexion
$connection = Yii::$app->getDb();

//consulta los datos del usuario con el nombre de usuario y la contraseña, tambien debe estar activo
$command = $connection->createCommand("
SELECT p.*, pp.id as perfilesxpersonas
	FROM public.personas as p, perfiles_x_personas as pp, perfiles as pe
	WHERE usuario = '$username' 
	AND psw = '$psw'
	AND p.id = pp.id_personas 
	AND pp.id_perfiles = pe.id
	AND pe.id = $perfil
	AND p.estado =1
");
$result = $command->queryAll();

//si no trae datos se redireciona nuevamente al login 
if (count($result)==0)
{
	header('Location: index.php?r=site%2Flogin&mensaje=1');
}
//se crean los datos de sesion 
else
{
	session_destroy(); 
	session_start();
	//se crean los datos de sesion con los datos del usuario
	foreach($result[0] as $r => $valor)
	{
		$_SESSION[$r]=$valor;

	}
	
	$_SESSION['sesion']="si";
	$_SESSION['perfil']=$perfil;
	
	//ids de las instituciones a la que pertenece la personas
	$command = $connection->createCommand("
	SELECT ppi.id_institucion
	FROM perfiles_x_personas_institucion as ppi, perfiles_x_personas as pp
	where pp.id_personas = ".$_SESSION['id']."
	AND ppi.id_perfiles_x_persona = pp.id");
	$idsInstituciones = $command->queryAll();
	
	foreach($idsInstituciones as $i)
	{
		$idInstitucion[] = $i['id_institucion'];
	}
		
	//Id de las instituciones a la pertenece la persona
	$_SESSION['instituciones']=$idInstitucion;
	header('Location: index.php');	
}

die;

// class Object extends BaseObject
// {
// }
