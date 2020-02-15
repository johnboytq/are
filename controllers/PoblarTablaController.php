<?php

namespace app\controllers;

if(@$_SESSION['sesion']=="si")
{ 
	// echo $_SESSION['nombre'];
} 
//si no tiene sesion se redirecciona al login
else
{
	header('Location: index.php?r=site%2Flogin');
	die;
}
use Yii;
use app\models\PoblarTabla;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

use yii\base\ErrorException;
use yii\db\Exception;

use yii\helpers\Json;

class PoblarTablaController extends Controller
{
	public function actionColumnasPorTabla( $tabla ){
		
		$data = [
			'error' => 0,
			'msg' 	=> '',
			'data'	=> [],
		];
		
		// var_dump( $file );
		$sql = "SELECT ordinal_position, column_name 
				  FROM information_schema.columns 
				 WHERE table_name = '".$tabla."'
			  ORDER BY 1;";
				 
		$connection = Yii::$app->getDb();
		
		$command = $connection->createCommand($sql);
		
		$result = $command->queryAll();

		foreach( $result as $key => $value )
		{
			// var_dump( $value );
			// var_dump( $value['column_name'] );
			$data['data'][] = $value['column_name'];
		}
		
		echo Json::encode( $data );
	}

    public function actionCreate( )
    {
		$delimiter = ";";
		
		$model = new PoblarTabla();
		
		$msg = [];
		
		if( $model->load(Yii::$app->request->post()) )
		{
			// var_dump( Yii::$app->getDb() ); exit();
		
			$connection = Yii::$app->getDb();
			
			$file = UploadedFile::getInstance( $model, "archivo" );
					
			if( $file )
			{
				try
				{
					
					// var_dump( $file );
					$sql = "COPY ".$model->tabla." FROM '".$file->tempName."' WITH csv DELIMITER '".$delimiter."' ENCODING 'latin1';;";
					
					$command = $connection->createCommand($sql);
					
					$result = $command->execute();
					
					// var_dump( $result );
					
					$msg = $result;
					$msg = [ 0 => 0, 1 => "Datos guardados correctamente" ];
				}
				catch ( Exception $e )
				{
					$msg = $e;
					$msg = [ 0 => 1 , 1 => $e->errorInfo[2] ];
				}
			}
		}
		
		return $this->redirect(['index',
			'msg' 	=> $msg,
		]);
		
    }
	
	public function actionIndex( array $msg = [] )
    {
		$connection = Yii::$app->getDb();
		
		$sql = "SELECT tablename FROM pg_tables WHERE schemaname = 'public' ORDER BY 1;";
		
		$command = $connection->createCommand($sql);
					
		$result = $command->queryAll();

		$tablas = [];
		foreach( $result as $key => $value )
		{
			$tablas[$value['tablename']] = $value['tablename'];
		}
		
		$model = new PoblarTabla();
		
        return $this->render('index',[
			'model' => $model,
			'tablas'=> $tablas,
			'msg'	=> $msg,
		]);
    }
}