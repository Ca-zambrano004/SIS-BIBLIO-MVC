<?php
date_default_timezone_set('America/Bogota');
require('fpdf/fpdf.php');
require 'conexionbd.php';

	$datos="SELECT * FROM admin ORDER BY id ASC";
	$resultado= $mysqli->query($datos);

class PDF extends FPDF{
// Cabecera de página
function Header()
{
    // Logo
    $this->Image('../vista/assets/img/logo.png',20,20,33);
        $this->Image('../vista/assets/img/web.png',240,20,20);
    // Arial bold 15
    $this->SetFont('Times','B',12);
    // Movernos a la derecha
    $this->Cell(80);
    // Título
    $this->Cell(100,30,'REPORTE DE USUARIOS ADMINISTRADORES',0,0,'C');
    // Salto de línea
    $this->Ln(20);

    $this->Cell(10,10,utf8_decode ('#'),1,0,'C',0);
    $this->Cell(40,10,utf8_decode ('IDENTIFICACION'),1,0,'C',0);
	$this->Cell(40,10,utf8_decode ('NOMBRE'),1,0,'C',0);
	$this->Cell(40,10,utf8_decode ('APELLIDOS'),1,0,'C',0);
	$this->Cell(30,10,utf8_decode ('TELEFONO'),1,0,'C',0);
	$this->Cell(75,10,utf8_decode ('DIRECCIÓN'),1,1,'C',0);
	// Salto de línea
    $this->Ln(0);
  
}

// Pie de página
function Footer()
{

    // Posición: a 1,5 cm del final
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Times','I',8);
    // Número de página
    $this->Cell(0,10,utf8_decode('Página').$this->PageNo().'/{nb}',0,0,'C');
}
}

$pdf = new PDF('l','mm','letter');
#Establecemos los márgenes izquierda, arriba y derecha:
$pdf->SetMargins(27, 25 , 27);
#Establecemos el margen inferior:
$pdf->SetAutoPageBreak(true,25); 
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);
	while ($rows=$resultado->fetch_assoc()) {
		$pdf->Cell(10,10,utf8_decode ($rows['id']),1,0,'C',0);
		$pdf->Cell(40,10,utf8_decode ($rows['AdminCC']),1,0,'C',0);
		$pdf->Cell(40,10,utf8_decode ($rows['AdminNombre']),1,0,'C',0);
		$pdf->Cell(40,10,utf8_decode ($rows['AdminApellido']),1,0,'C',0);
		$pdf->Cell(30,10,utf8_decode ($rows['AdminTelefono']),1,0,'C',0);
		$pdf->Cell(75,10,utf8_decode ($rows['AdminDireccion']),1,1,'C',0);
	}
	
$pdf->Cell(177);
$pdf->Cell(35,10,utf8_decode ('Fecha de Impresión: '),0,0,'L',0);
$pdf->Cell(40,10,date('d/m/Y'),0,0,'L',0);
$pdf->Ln(5);
$pdf->Cell(177);
$pdf->Cell(35,10,utf8_decode ('Hora de Impresión: '),0,0,'L',0);
$pdf->Cell(10,10,date("G:i:s"),0);

$pdf->Output();
?>
