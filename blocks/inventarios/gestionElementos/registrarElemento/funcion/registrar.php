<?php

namespace inventarios\gestionElementos\registrarElemento\funcion;

use inventarios\gestionElementos\registrarElemento\funcion\redireccion;

include_once ('redireccionar.php');

$ruta_1 = $this->miConfigurador->getVariableConfiguracion ( 'raizDocumento' ) . '/plugin/php_excel/Classes/PHPExcel.class.php';
$ruta_2 = $this->miConfigurador->getVariableConfiguracion ( 'raizDocumento' ) . '/plugin/php_excel/Classes/PHPExcel/Reader/Excel2007.class.php';

include_once ($ruta_1);
include_once ($ruta_2);

if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}
class RegistradorOrden {
	var $miConfigurador;
	var $lenguaje;
	var $miFormulario;
	var $miFuncion;
	var $miSql;
	var $conexion;
	function __construct($lenguaje, $sql, $funcion) {
		$this->miConfigurador = \Configurador::singleton ();
		$this->miConfigurador->fabricaConexiones->setRecursoDB ( 'principal' );
		$this->lenguaje = $lenguaje;
		$this->miSql = $sql;
		$this->miFuncion = $funcion;
	}
	function procesarFormulario() {
		$conexion = "inventarios";
		$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
		
		$cadenaSql = $this->miSql->getCadenaSql ( 'consultar_entrada_acta', $_REQUEST ['entrada'] );
		$acta = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "busqueda" );
		
		$acta = $acta [0] [0];
		
		$cadenaSql = $this->miSql->getCadenaSql ( 'consultar_elementos_acta', $acta );
		$elementos_acta = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "busqueda" );
		
		$numero_elementos_acta = count ( $elementos_acta );
		
		$cadenaSql = $this->miSql->getCadenaSql ( 'consultar_elementos_entrada', $_REQUEST ['entrada'] );
		$elementos_entrada = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "busqueda" );
		
		$numero_elementos_entrada = count ( $elementos_entrada );
		
		// if($numero_elementos_acta==$numero_elementos_entrada){
		
		// redireccion::redireccionar ( 'noCargarElemento' );
		
		// }
		
		$fechaActual = date ( 'Y-m-d' );
		
		$esteBloque = $this->miConfigurador->getVariableConfiguracion ( "esteBloque" );
		
		$rutaBloque = $this->miConfigurador->getVariableConfiguracion ( "raizDocumento" ) . "/blocks/inventarios/gestionElementos/";
		$rutaBloque .= $esteBloque ['nombre'];
		$host = $this->miConfigurador->getVariableConfiguracion ( "host" ) . $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/blocks/inventarios/gestionEntradas/" . $esteBloque ['nombre'];
		
		$_REQUEST ['total_iva_con'] = round ( $_REQUEST ['total_iva_con'] );
		
		switch ($_REQUEST ['tipo_registro']) {
			
			case '1' :
				
				if ($_REQUEST ['tipo_bien'] == 1) {
					
					$cadenaSql = $this->miSql->getCadenaSql ( 'consultar_placa', '1' );
					$placa = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "busqueda" );
					
					$arreglo = array (
							$fechaActual,
							$_REQUEST ['nivel'],
							$_REQUEST ['tipo_bien'],
							$_REQUEST ['descripcion'],
							$_REQUEST ['cantidad'],
							$_REQUEST ['unidad'],
							$_REQUEST ['valor'],
							$_REQUEST ['iva'],
							$_REQUEST ['ajuste'] = 0,
							$_REQUEST ['bodega'],
							$_REQUEST ['subtotal_sin_iva'],
							$_REQUEST ['total_iva'],
							$_REQUEST ['total_iva_con'],
							$_REQUEST ['marca'],
							$_REQUEST ['serie'],
							$_REQUEST ['entrada'] 
					);
					
					$cadenaSql = $this->miSql->getCadenaSql ( 'ingresar_elemento_tipo_1', $arreglo );
					
					$elemento = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "busqueda" );
				} else if ($_REQUEST ['tipo_bien'] == 2) {
					
					$arreglo = array (
							$fechaActual,
							$_REQUEST ['nivel'],
							$_REQUEST ['tipo_bien'],
							$_REQUEST ['descripcion'],
							$_REQUEST ['cantidad'] = 1,
							$_REQUEST ['unidad'],
							$_REQUEST ['valor'],
							$_REQUEST ['iva'],
							$_REQUEST ['ajuste'] = 0,
							$_REQUEST ['bodega'],
							$_REQUEST ['subtotal_sin_iva'],
							$_REQUEST ['total_iva'],
							$_REQUEST ['total_iva_con'],
							$_REQUEST ['marca'],
							$_REQUEST ['serie'],
							$_REQUEST ['entrada'] 
					);
					
					$cadenaSql = $this->miSql->getCadenaSql ( 'ingresar_elemento_tipo_1', $arreglo );
					
					$elemento = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "busqueda" );
				} else if ($_REQUEST ['tipo_bien'] == 3) {
					
					if ($_REQUEST ['tipo_poliza'] == 1) {
						$arreglo = array (
								$fechaActual,
								$_REQUEST ['nivel'],
								$_REQUEST ['tipo_bien'],
								$_REQUEST ['descripcion'],
								$_REQUEST ['cantidad'] = 1,
								$_REQUEST ['unidad'],
								$_REQUEST ['valor'],
								$_REQUEST ['iva'],
								$_REQUEST ['ajuste'] = 0,
								$_REQUEST ['bodega'],
								$_REQUEST ['subtotal_sin_iva'],
								$_REQUEST ['total_iva'],
								$_REQUEST ['total_iva_con'],
								$_REQUEST ['tipo_poliza'],
								'0001-01-01',
								'0001-01-01',
								$_REQUEST ['marca'],
								$_REQUEST ['serie'],
								$_REQUEST ['entrada'] 
						);
					} else if ($_REQUEST ['tipo_poliza'] == 2) {
						$arreglo = array (
								$fechaActual,
								$_REQUEST ['nivel'],
								$_REQUEST ['tipo_bien'],
								$_REQUEST ['descripcion'],
								$_REQUEST ['cantidad'] = 1,
								$_REQUEST ['unidad'],
								$_REQUEST ['valor'],
								$_REQUEST ['iva'],
								$_REQUEST ['ajuste'] = 0,
								$_REQUEST ['bodega'],
								$_REQUEST ['subtotal_sin_iva'],
								$_REQUEST ['total_iva'],
								$_REQUEST ['total_iva_con'],
								$_REQUEST ['tipo_poliza'],
								$_REQUEST ['fecha_inicio'],
								$_REQUEST ['fecha_final'],
								$_REQUEST ['marca'],
								$_REQUEST ['serie'],
								$_REQUEST ['entrada'] 
						);
					}
					
					$cadenaSql = $this->miSql->getCadenaSql ( 'ingresar_elemento_tipo_2', $arreglo );
					
					$elemento = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "busqueda" );
				}
				
				$placa = date ( 'Ymd' ) . "00000";
				
				$cadenaSql = $this->miSql->getCadenaSql ( 'buscar_repetida_placa', $placa );
				
				$num_placa = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "busqueda" );
				
				if ($num_placa [0] [0] == 0) {
					
					for($i = 0; $i < $_REQUEST ['cantidad']; $i ++) {
						$arregloElementosInv = array (
								$fechaActual,
								$placa + $i,
								$_REQUEST ['serie'],
								$elemento [0] [0] 
						);
						
						$cadenaSql = $this->miSql->getCadenaSql ( 'ingresar_elemento_individual', $arregloElementosInv );
						
						$elemento_id [$i] = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "busqueda" );
					}
				} else if ($num_placa [0] [0] != 0) {
					
					$cadenaSql = $this->miSql->getCadenaSql ( 'buscar_placa_maxima', $placa );
					
					$num_placa = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "busqueda" );
					
					$placa = $num_placa [0] [0];
					
					for($i = 1; $i <= $_REQUEST ['cantidad']; $i ++) {
						$arregloElementosInv = array (
								$fechaActual,
								$placa + $i,
								$_REQUEST ['serie'],
								$elemento [0] [0] 
						);
						
						$cadenaSql = $this->miSql->getCadenaSql ( 'ingresar_elemento_individual', $arregloElementosInv );
						
						$elemento_id [$i] = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "busqueda" );
					}
				}
				
				$datos = array (
						$elemento [0] [0],
						$fechaActual,
						$_REQUEST ['entrada'] 
				);
	
				if ($elemento) {
					
					redireccion::redireccionar ( 'inserto', $datos, $_REQUEST ['datosGenerales'] );
				} else {
					
					redireccion::redireccionar ( 'noInserto', $datos );
				}
				
				break;
			case '2' :
				$ingreso = 0;
				
				$ruta_eliminar_xlsx = $rutaBloque . "/archivo/*.xlsx";
				
				$ruta_eliminar_xls = $rutaBloque . "/archivo/*.xls";
				
				foreach ( glob ( $ruta_eliminar_xlsx ) as $filename ) {
					unlink ( $filename );
				}
				foreach ( glob ( $ruta_eliminar_xls ) as $filename ) {
					unlink ( $filename );
				}
				
				$i = 0;
				foreach ( $_FILES as $key => $values ) {
					
					$archivo [$i] = $_FILES [$key];
					$i ++;
				}
				
				$archivo = $archivo [0];
				
				$trozos = explode ( ".", $archivo ['name'] );
				$extension = end ( $trozos );
				
				if ($extension == 'xlsx' || $extension == 'xls') {
					
					if ($archivo) {
						// obtenemos los datos del archivo
						$tamano = $archivo ['size'];
						$tipo = $archivo ['type'];
						$archivo1 = $archivo ['name'];
						$prefijo = "archivo";
						
						if ($archivo1 != "") {
							// guardamos el archivo a la carpeta files
							$ruta_absoluta = $rutaBloque . "/archivo/" . $prefijo . "_" . $archivo1;
							
							if (copy ( $archivo ['tmp_name'], $ruta_absoluta )) {
								$status = "Archivo subido: <b>" . $archivo1 . "</b>";
								$destino1 = $host . "/archivo/" . $prefijo . "_" . $archivo1;
							} else {
								$status = "Error al subir el archivo";
								echo $status;
							}
						} else {
							$status = "Error al subir archivo";
							echo $status;
						}
					}
					
					$arreglo = array (
							$destino1,
							$archivo1 
					);
					
					if (file_exists ( $ruta_absoluta )) {
						
						// Cargando la hoja de cálculo
						
						$objReader = new \PHPExcel_Reader_Excel2007 ();
						
						$objPHPExcel = $objReader->load ( $ruta_absoluta );
						
						$objFecha = new \PHPExcel_Shared_Date ();
						
						// Asignar hoja de excel activa
						
						$objPHPExcel->setActiveSheetIndex ( 0 );
						
						$objWorksheet = $objPHPExcel->setActiveSheetIndex ( 0 );
						
						$highestRow = $objWorksheet->getHighestRow ();
						
						for($i = 2; $i <= $highestRow; $i ++) {
							
							$datos [$i] ['Nivel'] = $objPHPExcel->getActiveSheet ()->getCell ( 'A' . $i )->getCalculatedValue ();
							
							$datos [$i] ['Tipo_Bien'] = $objPHPExcel->getActiveSheet ()->getCell ( 'B' . $i )->getCalculatedValue ();
							
							$datos [$i] ['Descripcion'] = $objPHPExcel->getActiveSheet ()->getCell ( 'C' . $i )->getCalculatedValue ();
							
							$datos [$i] ['Cantidad'] = $objPHPExcel->getActiveSheet ()->getCell ( 'D' . $i )->getCalculatedValue ();
							
							$datos [$i] ['Unidad_Medida'] = $objPHPExcel->getActiveSheet ()->getCell ( 'E' . $i )->getCalculatedValue ();
							
							$datos [$i] ['Valor_Precio'] = $objPHPExcel->getActiveSheet ()->getCell ( 'F' . $i )->getCalculatedValue ();
							
							$datos [$i] ['Iva'] = $objPHPExcel->getActiveSheet ()->getCell ( 'G' . $i )->getCalculatedValue ();
							
							$datos [$i] ['Ajuste'] = $objPHPExcel->getActiveSheet ()->getCell ( 'H' . $i )->getCalculatedValue ();
							
							$datos [$i] ['Bodega'] = $objPHPExcel->getActiveSheet ()->getCell ( 'I' . $i )->getCalculatedValue ();
							
							$datos [$i] ['Tipo_poliza'] = $objPHPExcel->getActiveSheet ()->getCell ( 'J' . $i )->getCalculatedValue ();
							
							$datos [$i] ['Fecha_Inicio_Poliza'] = $objPHPExcel->getActiveSheet ()->getCell ( 'K' . $i )->getCalculatedValue ();
							
							$datos [$i] ['Fecha_Final_Poliza'] = $objPHPExcel->getActiveSheet ()->getCell ( 'L' . $i )->getCalculatedValue ();
							
							$datos [$i] ['Marca'] = $objPHPExcel->getActiveSheet ()->getCell ( 'M' . $i )->getCalculatedValue ();
							
							$datos [$i] ['Serie'] = $objPHPExcel->getActiveSheet ()->getCell ( 'N' . $i )->getCalculatedValue ();
							
							$datos [$i] ['Entrada'] = $objPHPExcel->getActiveSheet ()->getCell ( 'O' . $i )->getCalculatedValue ();
						}
						
						for($i = 2; $i <= $highestRow; $i ++) {
							
							$arreglo = array (
									$fechaActual,
									$datos [$i] ['Nivel'],
									$datos [$i] ['Tipo_Bien'],
									trim ( $datos [$i] ['Descripcion'], "'" ),
									$datos [$i] ['Cantidad'],
									trim ( $datos [$i] ['Unidad_Medida'], "'" ),
									$datos [$i] ['Valor_Precio'],
									$datos [$i] ['Ajuste'],
									$datos [$i] ['Bodega'],
									$datos [$i] ['Cantidad'] * $datos [$i] ['Valor_Precio'],
									$datos [$i] ['Cantidad'] * $datos [$i] ['Valor_Precio'] * $datos [$i] ['Iva'],
									round ( $datos [$i] ['Cantidad'] * $datos [$i] ['Valor_Precio'] * $datos [$i] ['Iva'] ) + ($datos [$i] ['Cantidad'] * $datos [$i] ['Valor_Precio']),
									$datos [$i] ['Tipo_poliza'],
									trim ( $datos [$i] ['Fecha_Inicio_Poliza'], "'" ),
									trim ( $datos [$i] ['Fecha_Final_Poliza'], "'" ),
									trim ( $datos [$i] ['Marca'], "'" ),
									trim ( $datos [$i] ['Serie'], "'" ),
									$datos [$i] ['Entrada'] 
							);
							
							$cadenaSql = $this->miSql->getCadenaSql ( 'ingresar_elemento_masivo', $arreglo );
							
							$elemento = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "busqueda" );
							
							$_REQUEST ['cantidad'] = $datos [$i] ['Cantidad'];
							
							$_REQUEST ['serie'] = trim ( $datos [$i] ['Serie'], "'" );
							$ingreso = 1;
							
							$placa = date ( 'Ymd' ) . "00000";
							
							$cadenaSql = $this->miSql->getCadenaSql ( 'buscar_repetida_placa', $placa );
							
							$num_placa = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "busqueda" );
							
							if ($num_placa [0] [0] == 0) {
								
								for($i = 0; $i < $_REQUEST ['cantidad']; $i ++) {
									$arregloElementosInv = array (
											$fechaActual,
											$placa + $i,
											$_REQUEST ['serie'],
											$elemento [0] [0] 
									);
									
									$cadenaSql = $this->miSql->getCadenaSql ( 'ingresar_elemento_individual', $arregloElementosInv );
									
									$elemento_id [$i] = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "busqueda" );
								}
							} else if ($num_placa [0] [0] != 0) {
								
								$cadenaSql = $this->miSql->getCadenaSql ( 'buscar_placa_maxima', $placa );
								
								$num_placa = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "busqueda" );
								
								$placa = $num_placa [0] [0];
								
								for($i = 1; $i <= $_REQUEST ['cantidad']; $i ++) {
									$arregloElementosInv = array (
											$fechaActual,
											$placa + $i,
											$_REQUEST ['serie'],
											$elemento [0] [0] 
									);
									
									$cadenaSql = $this->miSql->getCadenaSql ( 'ingresar_elemento_individual', $arregloElementosInv );
									
									$elemento_id [$i] = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "busqueda" );
								}
							}
						}
						
						if ($elemento) {
							
							redireccion::redireccionar ( 'inserto_M', $fechaActual );
						} else {
							
							redireccion::redireccionar ( 'noInserto', $datos );
						}
					}
				} else {
					
					redireccion::redireccionar ( 'noExtension' );
				}
				
				break;
		}
	}
	function resetForm() {
		foreach ( $_REQUEST as $clave => $valor ) {
			
			if ($clave != 'pagina' && $clave != 'development' && $clave != 'jquery' && $clave != 'tiempo') {
				unset ( $_REQUEST [$clave] );
			}
		}
	}
}

$miRegistrador = new RegistradorOrden ( $this->lenguaje, $this->sql, $this->funcion );

$resultado = $miRegistrador->procesarFormulario ();

?>