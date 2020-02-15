<?php

namespace app\controllers;

use Yii;
use app\models\ResultadosPruebasSaberIe;
use app\models\ResultadosPruebasSaberIeBuscar;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\models\ResultadosPruebasSaberCali;
use app\models\Instituciones;
use app\models\AsignaturaEspecifica;
use app\models\AsignaturasEvaluadas;
use app\models\Estados;
use app\models\Zonificaciones;
use yii\helpers\ArrayHelper;

use yii\data\ActiveDataProvider;
use yii\db\Query;

/**
 * ResultadosPruebasSaberIeController implements the CRUD actions for ResultadosPruebasSaberIe model.
 */
class ResultadosController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
	
	public function actionGetResultadosPruebasSaber(){
		
		$idInstitucion 			= $_SESSION[ 'instituciones' ][0];
		
		$asignaturasEvaluadas 	= [];
		$asignaturasEspecifica 	= [];
		$data 					= [];
		
		$queryIE = (new Query())
						->select( 'aevi.id as ida, aevi.descripcion as da, aesi.id as idb, aesi.descripcion as db, rpsi.valor, rpsi.anio' )
						->from( "resultados_pruebas_saber_ie rpsi, 
								asignatura_especifica aesi,
								asignaturas_evaluadas aevi" )
						->where( "rpsi.id_asignatura_especifica=aesi.id" )
						->andWhere( "aesi.id_asignatura_evaluada=aevi.id" )
						->andWhere( "rpsi.estado=1")
						->andWhere( "aesi.estado=1")
						->andWhere( "aevi.estado=1")
						->andWhere( "rpsi.id_institucion=".$idInstitucion )
						->orderBy( [ 'rpsi.anio' => SORT_DESC ] )
						->all()
						;
						
		foreach( $queryIE as $key => $value )
		{
			$data[ $value['anio'] ][ $value['db'] ]['ie'] 	= $value[ 'valor' ];
			$data[ $value['anio'] ][ $value['db'] ]['cali'] = '';
			
			if( !isset( $asignaturasEvaluadas[ $value['da'] ] ) )
			{
				$asignaturasEvaluadas[ $value['da'] ]	= 0;
			}
			
			if( !isset( $asignaturasEspecifica[ $value['da'] ] ) || !ArrayHelper::isIn( $value['da'], $asignaturasEspecifica[ $value['da'] ] ) )
			{				
				if( !isset( $asignaturasEspecifica[ $value['da'] ] ) ){
					$asignaturasEspecifica[ $value['da'] ] = [];
				}
				
				if( !ArrayHelper::isIn( $value['db'], $asignaturasEspecifica[ $value['da'] ] ) ){
					$asignaturasEspecifica[ $value['da'] ][] 	= $value['db'];
					$asignaturasEvaluadas[ $value['da'] ]	+= 2;
				}
			}
		}
		
		$queryCali = (new Query())
						->select( 'aevc.id as ida, aevc.descripcion as da, aesc.id as idb, aesc.descripcion as db, rpsc.valor, rpsc.anio' )
						->from( "resultados_pruebas_saber_cali rpsc,
								asignatura_especifica aesc,
								asignaturas_evaluadas aevc" )
						->where( "rpsc.id_asignatura_especifica=aesc.id" )
						->andWhere( "aesc.id_asignatura_evaluada=aevc.id" )
						->andWhere( "rpsc.estado=1")
						->andWhere( "aesc.estado=1")
						->andWhere( "aevc.estado=1")
						->andWhere( "rpsc.id_institucion=".$idInstitucion )
						->orderBy( [ 'rpsc.anio' => SORT_DESC ] )
						->all()
						;
		
		foreach( $queryCali as $key => $value )
		{
			$data[ $value['anio'] ][ $value['db'] ]['cali']= $value[ 'valor' ];
			
			if( !isset($data[ $value['anio'] ][ $value['db'] ]['ie']) )
			{
				$data[ $value['anio'] ][ $value['db'] ]['ie']	 = '';
			}
			
			if( !isset( $asignaturasEvaluadas[ $value['da'] ] ) )
			{
				$asignaturasEvaluadas[ $value['da'] ]	= 0;
			}
			
			if( !isset( $asignaturasEspecifica[ $value['da'] ] ) || !ArrayHelper::isIn( $value['da'], $asignaturasEspecifica[ $value['da'] ] ) )
			{
				if( !isset( $asignaturasEspecifica[ $value['da'] ] ) ){
					$asignaturasEspecifica[ $value['da'] ] = [];
				}
				
				if( !ArrayHelper::isIn( $value['db'], $asignaturasEspecifica[ $value['da'] ] ) ){
					$asignaturasEspecifica[ $value['da'] ][] 	= $value['db'];
					$asignaturasEvaluadas[ $value['da'] ] += 2;
				}
			}
		}
					
		return [
			'asignaturasEspecifica' => $asignaturasEspecifica,
			'asignaturasEvaluadas' 	=> $asignaturasEvaluadas,
			'data' 					=> $data,
		];
	}
	
	public function actionIndiceSinteticoDeCalidad(){
		
		$anios 	= [];
		$indices= [];
		$data 	= [];
		
		$query = (new Query())
						->select( 'isc.id, isc.anio, isc.id_indice_especifico, isc.valor, ie.descripcion' )
						->from( "indice_sintetico_calidad isc, indice_especifico ie" )
						->where( "isc.id_indice_especifico=ie.id" )
						->andWhere( "ie.estado=1")
						->andWhere( "isc.estado=1")
						->orderBy( [ 'isc.anio' => SORT_DESC ] )
						->all()
						;
		
		foreach( $query as $key => $value )
		{
			if( !isset( $anios[ $value['anio'] ] ) )
			{
				$anios[ $value['anio'] ] = 0;
			}
			
			if( !isset( $indices[ $value['anio'] ] ) )
			{
				$indices[ $value['anio'] ] = [];
			}
			
			if( !ArrayHelper::isIn( $value['descripcion'], $indices[ $value['anio'] ] ) ){
				$indices[ $value['anio'] ][] = $value['descripcion'];
				$anios[ $value['anio'] ]++;
			}
			
			$data[ $value['anio'] ][ $value['descripcion'] ] = $value['valor'];
		}
		
		return [
			'anios'		=> $anios,
			'indices'	=> $indices,
			'data'		=> $data,
		];
	}
	
	public function actionPMI(){
		
		$idInstitucion 			= $_SESSION[ 'instituciones' ][0];
		
		$areas			= [];
		$subProcesos	= [];
		$procesos		= [];
		$data 			= [];
		
		$query = (new Query())
						->select( 'pmi.anio, pe.descripcion as pedes, ag.descripcion as agdes, spe.descripcion spedes, pmi.valor, pmi.codigo_dane, pmi.zona, c.descripcion comuna' )
						->from( "pmi, proceso_especifico pe, sub_proceso_evaluacion spe, area_gestion ag, comunas_corregimientos as c" )
						->where( "pmi.id_institucion=".$idInstitucion )
						->andWhere( "pmi.comuna=c.id")
						// ->andWhere( "pmi.zona=z.id")
						->andWhere( "pmi.id_proceso_especifico=pe.id")
						->andWhere( "pe.id_sub_proceso=spe.id")
						->andWhere( "spe.id_area_gestion=ag.id")
						->andWhere( "pmi.estado=1")
						->andWhere( "spe.estado=1")
						->andWhere( "ag.estado=1")
						->orderBy( [ 'anio' => SORT_DESC ] )
						->all()
						;
		
		foreach( $query as $key => $value )
		{
			if( !isset( $areas[ $value['agdes'] ] ) )
			{
				$areas[ $value['agdes'] ] = 0;
			}
			
			if( !isset( $subProcesos[ $value['agdes'] ][ $value['spedes'] ] ) )
			{
				$subProcesos[ $value['agdes'] ][ $value['spedes'] ] = 0;
			}
			
			if( !isset( $procesos[ $value['agdes'] ][ $value['spedes'] ] ) )
			{
				$procesos[ $value['agdes'] ][ $value['spedes'] ] = [];
			}
			
			if( !ArrayHelper::isIn( $value['pedes'], $procesos[ $value['agdes'] ][ $value['spedes'] ] ) ){
				$procesos[ $value['agdes'] ][ $value['spedes'] ][] = $value['pedes'];
				$subProcesos[ $value['agdes'] ][ $value['spedes'] ]++;
				$areas[ $value['agdes'] ]++;
			}
			
			$data[ $value['anio'] ]['codigo_dane'] 	= $value['codigo_dane'];
			$data[ $value['anio'] ]['comuna'] 		= $value['comuna'];
			$data[ $value['anio'] ]['zona'] 		= Zonificaciones::findOne( $value['zona'] )->descripcion;
			$data[ $value['anio'] ]['valores'][ $value['agdes'] ][ $value['spedes'] ][ $value['pedes'] ] = $value['valor'];
		}
		
		return [
			'areas'			=> $areas,
			'subProcesos'	=> $subProcesos,
			'procesos'		=> $procesos,
			'data'			=> $data,
		];
	}
	
	public function actionPruebasExternas(){
		
		$idInstitucion 			= $_SESSION[ 'instituciones' ][0];
		
		$query = (new Query())
						->select( 'id, descripcion, valor' )
						->from( "resultados_pruebas_externas rpe" )
						->where( "rpe.estado=1" )
						->andWhere( "rpe.id_institucion=".$idInstitucion )
						->all();
		
		return [
			'data'			=> $query,
		];
	}
	
	public function actionPruebasDocentres(){
		
		$idInstitucion 			= $_SESSION[ 'instituciones' ][0];
		
		$query = (new Query())
						->select( 'id, descripcion, valor' )
						->from( "resultados_evaluacion_docente red" )
						->where( "red.estado=1" )
						->andWhere( "red.id_institucion=".$idInstitucion )
						->all();
		
		return [
			'data'			=> $query,
		];
	}
	
	public function actionPruebasSEM(){
		
		$idInstitucion 			= $_SESSION[ 'instituciones' ][0];
		
		$query = (new Query())
						->select( 'id, descripcion, valor' )
						->from( "resultados_sem rs" )
						->where( "rs.estado=1" )
						->andWhere( "rs.id_institucion=".$idInstitucion )
						->all();
		
		return [
			'data'			=> $query,
		];
	}

    /**
     * Lists all ResultadosPruebasSaberIe models.
     * @return mixed
     */
    public function actionIndex()
    {
		
		$data 				= $this->actionGetResultadosPruebasSaber();
		$dataIndices		= $this->actionIndiceSinteticoDeCalidad();
		$dataPMI 			= $this->actionPMI();
		$dataPruebasExternas= $this->actionPruebasExternas();
		$dataPruebasDocentes= $this->actionPruebasDocentres();
		$dataPruebasSEM		= $this->actionPruebasSEM();

        return $this->render('index', [
			'title'					=> 'Resultados',
			'data'					=> $data,
			'dataIndices'			=> $dataIndices,
			'dataPMI'				=> $dataPMI,
			'dataPruebasExternas'	=> $dataPruebasExternas,
			'dataPruebasDocentes'	=> $dataPruebasDocentes,
			'dataPruebasSEM'		=> $dataPruebasSEM,
        ]);
    }
}
