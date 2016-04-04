<?php
/**
* 
*/
class generarPDF 
{
	
	function __construct($argument)
	{
		# code...
	}

	public function generar($campos){

// FDF header section
$fdf_header = <<<FDF
%FDF-1.2
%âãÏÓ
1 0 obj
<<
/FDF
<<
/Fields [
FDF;

// FDF footer section
$fdf_footer = <<<FDF
]
>>
>>
endobj
trailer

<<
/Root 1 0 R
>>
%%EOF
FDF;

// FDF content section
foreach ($_POST as $key => $value) {
    $fdf_content.= '<</T('.$key.')/V('.$value.')>>';
}

$content = $fdf_header . $fdf_content . $fdf_footer;

// Creating a temporary file for our FDF file.
//$FDFfile = tempnam(sys_get_temp_dir(), gethostname());
$FDFfile = tempnam('pdf', gethostname());

file_put_contents($FDFfile, $content);
chmod($FDFfile, 0777);

// Merging the FDF file with the raw PDF form
$path = getcwd()."/pdf/";
$command = "pdftk ".$path."Kit_Bienvenida.pdf fill_form ".$FDFfile." output ".$path."kit_bienvenidaa.pdf";

echo $command."<br>";
$estado = false;
exec($command, $res, $estado);
echo $estado;
 
//exec("pdftk path/to/form.pdf fill_form $FDFfile output path/to/output.pdf flatten");

// Removing the FDF file as we don't need it anymore
unlink($FDFfile);
}
}