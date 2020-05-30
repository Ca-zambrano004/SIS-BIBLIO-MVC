<?php
date_default_timezone_set('America/Bogota');
require('fpdf/fpdf.php');

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
    $this->Cell(100,30,'REPORTE DE USUARIOS CLIENTES',0,0,'C');
    // Salto de línea
    $this->Ln(20);

    $this->Cell(10,10,utf8_decode ('#'),1,0,'C',0);
    $this->Cell(40,10,utf8_decode ('IDENTIFICACIÓN'),1,0,'C',0);
	$this->Cell(33,10,utf8_decode ('NOMBRE'),1,0,'C',0);
	$this->Cell(33,10,utf8_decode ('APELLIDOS'),1,0,'C',0);
	$this->Cell(27,10,utf8_decode ('TELEFONO'),1,0,'C',0);
    $this->Cell(30,10,utf8_decode ('OCUPACIÓN'),1,0,'C',0);
	$this->Cell(65,10,utf8_decode ('DIRECCIÓN'),1,1,'C',0);
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

	require 'conexionbd.php';

	$datos="SELECT * FROM cliente ORDER BY id ASC";
	$resultado= $mysqli->query($datos);

$pdf = new PDF('l','mm','letter');
#Establecemos los márgenes izquierda, arriba y derecha:
$pdf->SetMargins(25, 25 , 25);
#Establecemos el margen inferior:
$pdf->SetAutoPageBreak(true,25); 
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);
	while ($rows=$resultado->fetch_assoc()) {
		$pdf->Cell(10,10,utf8_decode ($rows['id']),1,0,'C',0);
		$pdf->Cell(40,10,utf8_decode ($rows['ClienteCC']),1,0,'C',0);
		$pdf->Cell(33,10,utf8_decode ($rows['ClienteNombre']),1,0,'C',0);
		$pdf->Cell(33,10,utf8_decode ($rows['ClienteApellido']),1,0,'C',0);
		$pdf->Cell(27,10,utf8_decode ($rows['ClienteTelefono']),1,0,'C',0);
        $pdf->Cell(30,10,utf8_decode ($rows['ClienteOcupacion']),1,0,'C',0);
		$pdf->Cell(65,10,utf8_decode ($rows['ClienteDireccion']),1,1,'C',0);
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
