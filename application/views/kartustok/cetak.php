<?php

class MYPDF extends TCPDF {
 
	//Page header
	public function Header() {
	
		$this->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

		// set header and footer fonts
		$this->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$this->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));


		// set margins
		//$this->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$this->SetMargins(PDF_MARGIN_LEFT, 10, PDF_MARGIN_RIGHT);
		$this->SetHeaderMargin(PDF_MARGIN_HEADER);
		//$this->SetFooterMargin(PDF_MARGIN_FOOTER);
		$this->SetFooterMargin(22);
		
		// set image scale factor
		$this->setImageScale(PDF_IMAGE_SCALE_RATIO);
		
	// 	$this->writeHTML($cop, true, false, false, false, '');
	// 	// set margins
	// 	//$this->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
	// 	$this->SetMargins(PDF_MARGIN_LEFT, 30, PDF_MARGIN_RIGHT);
	// 	$this->SetHeaderMargin(PDF_MARGIN_HEADER);
		// set default header data
					
	}

	

	// Page footer
	public function Footer() {
		// Position at 15 mm from bottom
		$this->SetY(-15);
		// Set font
		$this->SetFont('helvetica', 'I', 8);
		$fot ='<div>Tgl Cetak: '.date('d-m-Y').'</div>
			
		';

		$this->writeHTML($fot, true, false, false, false, '');
	}
}

// create new PDF document
$pdf = new MYPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false); 

$pdf->AddPage('P');



$pdf->SetFont('times', '');
$pdf->writeHTML($toko, true, false, false, false, '');
$pdf->SetTopMargin(15);


$title = '
	<span style="text-align:center; font-size: 20px; font-weight: bold;">DINAS PENDIDIKAN KAB. DELI SERDANG</span><br>
	<span style="text-align:center; font-size: 14px; font-weight: bold;">'.$namaruangan.'</span><br>
	<span style="text-align:center; font-size: 14px; font-weight: bold;">KARTU PERSEDIAAN BARANG</span><br>
';
$pdf->SetFont('times', '');
$pdf->writeHTML($title, true, false, false, false, '');
$pdf->SetTopMargin(15);

if ($subjudul!='') {
	$labelsubjudul = '
		<span>'.strtoupper($subjudul).'</span><br>
	';
	$pdf->SetFont('times', '');
	$pdf->writeHTML($labelsubjudul, true, false, false, false, '');
	$pdf->SetTopMargin(15);
}


if ($tglakhir != $tglawal) {
    $periode = tglindonesialengkap($tglawal).' S/D '.tglindonesialengkap($tglakhir) ;
}else{
    $periode = tglindonesialengkap($tglawal) ;
}
$stokawal = $this->db->query("
        select saldoawal_kartustok('$tglawal', '$kdruangan', '$tahunanggaran', '$keybarang') as saldoawal_kartustok
    ")->row()->saldoawal_kartustok;

$saldoakhir_kartustok = $this->db->query("
        select saldoakhir_kartustok('$tglakhir', '$kdruangan', '$tahunanggaran', '$keybarang') as saldoakhir_kartustok
    ")->row()->saldoakhir_kartustok;

$table = '<table border="0" width="100%">
            <tbody>
                <tr style="font-size: 12px;">
                    <td width="20%" style="text-align: left;">NAMA SEKOLAH</td>
                    <td width="2%" style="text-align: center;">:</td>
                    <td width="48%" style="text-align: left;">'.$namaruangan.'</td>
                    <td width="10%" style="text-align: left;">Satuan</td>
                    <td width="2%" style="text-align: center;">:</td>
                    <td width="18%" style="text-align: left;">'.$rowBarang->satuan.'</td>                    
                </tr>
                <tr style="font-size: 12px;">
                    <td width="20%" style="text-align: left;">TAHUN ANGGARAN</td>
                    <td width="2%" style="text-align: center;">:</td>
                    <td width="48%" style="text-align: left;">'.$tahunanggaran.'</td>
                    <td width="10%" style="text-align: left;">Stok Awal</td>
                    <td width="2%" style="text-align: center;">:</td>
                    <td width="18%" style="text-align: left;">'.$stokawal.'</td>                    
                </tr>
                <tr style="font-size: 12px;">
                    <td width="20%" style="text-align: left;">KODE BARANG</td>
                    <td width="2%" style="text-align: center;">:</td>
                    <td width="48%" style="text-align: left;">'. $rowBarang->kdbarang.'</td>
                    <td width="10%" style="text-align: left;">Stok Akhir</td>
                    <td width="2%" style="text-align: center;">:</td>
                    <td width="18%" style="text-align: left;">'.$saldoakhir_kartustok.'</td>                    
                </tr>
                <tr style="font-size: 12px;">
                    <td width="20%" style="text-align: left;">NAMA BARANG</td>
                    <td width="2%" style="text-align: center;">:</td>
                    <td width="48%" style="text-align: left;">'. strtoupper($rowBarang->namabarang).'</td>
                    <td width="10%" style="text-align: left;"></td>
                    <td width="2%" style="text-align: center;"></td>
                    <td width="18%" style="text-align: left;"></td>                    
                </tr>

                <tr style="font-size: 12px;">
                    <td width="20%" style="text-align: left;">PERIODE</td>
                    <td width="2%" style="text-align: center;">:</td>
                    <td width="48%" style="text-align: left;">'.strtoupper($periode).'</td>
                    <td width="10%" style="text-align: left;"></td>
                    <td width="2%" style="text-align: center;"></td>
                    <td width="18%" style="text-align: left;"></td>                    
                </tr>
            </tbody><br>
';

		

$table  .= '<table border="1" width="100%">';
$table 	.= ' 
            <thead>
                <tr style="font-size: 12px; font-weight: bold;">
                    <th width="5%;" style="text-align: center" rowspan="2">NO</th>
                    <th width="15%;" style="text-align: center" rowspan="2">TANGGAL</th>
                    <th width="20%;" style="text-align: center" rowspan="2">ID TRANSAKSI</th>
                    <th width="60%;" style="text-align: center" colspan="4">STOK</th>
                </tr>
                <tr style="font-size: 12px; font-weight: bold;">
                    <th width="15%;" style="text-align: center">AWAL</th>
                    <th width="15%;" style="text-align: center">MASUK</th>
                    <th width="15%;" style="text-align: center">KELUAR</th>
                    <th width="15%;" style="text-align: center">AKHIR</th>
                </tr>
            </thead>
            <tbody>';


if ($rsStok->num_rows()>0) {

    
    $stokakhir = 0;
    $no = 1;

    foreach ($rsStok->result() as $row) {
        $stokakhir = $stokawal + $row->jumlahterima - $row->jumlahkeluar;

        $table .= '
                <tr style="font-size: 12px;">
                    <td width="5%;" style="text-align: center">'.$no++.'</td>
                    <td width="15%;" style="text-align: center">'.tgldmy($row->tgltransaksi).'</td>
                    <td width="20%;" style="text-align: center">'.$row->idtransaksi.'</td>
                    <td width="15%;" style="text-align: center">'.$stokawal.'</td>
                    <td width="15%;" style="text-align: center">'.$row->jumlahterima.'</td>
                    <td width="15%;" style="text-align: center">'.$row->jumlahkeluar.'</td>
                    <td width="15%;" style="text-align: center">'.$stokakhir.'</td>
                </tr>';

        $stokawal = $stokakhir;                
    }
}else{
    $table .= '
                <tr style="font-size: 12px; font-weight: bold;">
                    <td width="100%;" style="text-align: center" colspan="7">TIDAK ADA DATA</td>
                </tr>';
}

$table .= ' </tbody>
            </table>';

$pdf->SetTopMargin(35);
$pdf->SetFont('times', '');
$pdf->writeHTML($table, true, false, false, false, '');


$tglcetak = date('d-m-Y');



$pdf->Output();
?>
