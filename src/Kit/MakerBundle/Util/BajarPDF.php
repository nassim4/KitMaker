<?php
namespace Kit\MakerBundle\Util;
/**
 * GenerarPDF.
 */
class BajarPDF 
{
		public function bajar()
		{
			
			$command = 'pdftk /var/www/html/KitMaker/src/Kit/MakerBundle/Util/pdf/Bienvenido.pdf dump_data_fields';
			$output = array();
			exec( $command , $output );

			$fieldNames = array();

			if (null == $output) {
				                echo "ne se ha bajado nada";
				                return false;				                
			}
			else{
				$datos = array();
				$mensage="Datos de acceso.";
				foreach ($output as $key => $v) {
				    $pos = strpos($v, "FieldName:");
				    if($pos !== false) {
				        $auxArray = split(':', $v);
				        $fieldName = trim($auxArray[1]);
				        $fieldNames[$key] = $fieldName;               
				    }               
				}
			}				    
			return $fieldNames;
		}
}