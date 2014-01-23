<?php 

/**
 * 
 * Class Excel
 * @package spiderFrame
 * @author spidermay
 * @abstract simple excel class
 */
class Excel
{
	var $FileName   = "export"; #Nombre del archivo 
    var $xls        = "";       #Contenido del archivo 
    var $row        = 1;        #Fila 
    var $col        = 1;        #Columna 
  
    public function __construct($file_name = "work_book")
	{
		$this->FileName = $file_name; 
		
	}
	  
	private function Head($file_name = "")
	{ 
        //Escribe cabeceras 
        $this->FileName = ($file_name == "") ? $this->FileName : $file_name; 
        $f = $this->FileName; 
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
        header("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT"); 
        header("Cache-Control: no-cache, must-revalidate"); 
        header("Pragma: no-cache"); 
        header("Content-type: application/x-msexcel"); 
        header("Content-Disposition: attachment; filename=$f.xls" ); 
        header("Content-Description: PHP/INTERBASE Generated Data" ); 
        header("Expires: 0"); 
    } 

    private function BOF()
    { 
        //Inicialize file
        return pack("ssssss", 0x809, 0x8, 0x0, 0x10, 0x0, 0x0); 
    } 

    private function EOF()
    { 
        //Finalize file
        return pack("ss", 0x0A, 0x00); 
    } 

    public function Number($Row, $Column, $Value)
    { 
        //Escribe un número (double) en la $Row/$Column 
        $this->xls .= pack("sssss", 0x203, 14, $Row, $Column, 0x0); 
        $this->xls .= pack("d", $Value); 
    } 

    public function Text($Row, $Column, $Value)
    { 
        //Escribe texto en $Row/$Column (UTF8) 
        $Value2UTF8 = utf8_decode($Value); 
        $L = strlen($Value2UTF8); 
        $this->xls .= pack("ssssss", 0x204, 8 + $L, $Row, $Column, 0x0, $L); 
        $this->xls .= $Value2UTF8; 
    } 

    public function Write($Row, $Column, $Value)
    { 
        //Escribir texto o numeros en $Row/$Col 
        if (is_numeric($Value))
        {
        	$this->Number($Row, $Column, $Value); 
        } else { 
        	$this->Text($Row, $Column, $Value); 
        }
    } 

    public function WriteMatriz($Matriz){ 
        //Convierte una matriz en una planilla 
        //NOTA: Elimina el contenido que haya hasta ahora almacenado! 
        /* 
         * Ejemplo: 
         * $Matriz = array( 
         *      array('Nombre', 'Apellido', 'Edad'), 
         *      array('Luciana', 'Camila', 1), 
         *      array('Eduardo, 'Cuomo', 24), 
         *      array('Vanesa', 'Chavez', 21) 
         * ); 
         * 
         * Devuelve un EXCEL como: 
         * _| A     | B      | C  | 
         * 1|Nombre |Apellido|Edad| 
         * 2|Luciana|Camila  |1   | 
         * 3|Eduardo|Cuomo   |24  | 
         * 4|Vanesa |Chavez  |21  | 
         * 
        */ 
        $this->xls = ""; 
        $nRow = 0; 
        $nCol = 0; 
        foreach($Matriz as $Row){ 
            foreach($Row as $Value){ 
                $this->Write($nRow, $nCol, $Value); 
                $nCol++; 
            } 
            $nCol = 0; 
            $nRow++; 
        } 
    } 

    public function Download($file_name = ""){ 
        //Escribe el archivo y agrega las cabeceras para generar la descarga 
        $this->Head($file_name); 
        echo $this->BOF(); 
        echo $this->xls; 
        echo $this->EOF(); 
    } 

    public function Archivo($loc_file){ 
        //Crea archivo, borrando el que existe si ya existia 
        //$loc_file : Ruta del archivo. Ej: "./downloads/archivo.xls" 
        $f = fopen($loc_file, 'w'); 
        fwrite($f, $this->BOF()); 
        fwrite($f, $this->xls); 
        fwrite($f, $this->EOF()); 
        fclose($f); 
    } 
  	
}
