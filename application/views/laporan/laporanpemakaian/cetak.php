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



if ($tglawal==$tglakhir) {
	$periode = tglindonesialengkap($tglawal); 
}else{
	$periode = tglindonesialengkap($tglawal).' s/d '.tglindonesialengkap($tglakhir) ; 
}

$title = '
	<span style="text-align:center; font-size: 20px; font-weight: bold;">DINAS PENDIDIKAN KAB. DELI SERDANG</span><br>
	<span style="text-align:center; font-size: 20px; font-weight: bold;">'.$namaruangan.'</span><br>
	<span style="text-align:center; font-size: 20px; font-weight: bold;">LAPORAN PEMAKAIAN BARANG</span><br>
	<span style="text-align:center">Periode '.$periode.'</span><br><br>
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

$table  .= '<table border="1" width="100%" cellpadding="5">';
$table .= ' 
			<thead>
				<tr style="background-color:#ccc; font-size: 14px; font-weight: bold;">
					<th width="5%" style="text-align:center;">NO</th>
					<th width="15%" style="text-align:center;">TANGGAL</th>				
					<th width="65%" style="text-align:center;">URAIAN</th>				
					<th width="15%" style="text-align:center;">QTY</th>					
				</tr>
			</thead>
			<tbody>';

$no=1;
$total = 0;

if ($rslaporan->num_rows()>0) {
	
	$nokeluar_old='';

	foreach ($rslaporan->result() as $row) {
		
		if ($nokeluar_old != $row->nokeluar) {
			
			$table .= '
							<tr style="font-size: 12px;">
								<td width="5%" style="text-align:center;">'.$no++.'</td>
								<td width="15%" style="text-align:center;">'.tglindonesia($row->tglkeluar).'</td>				
								<td width="65%" style="text-align:left;">'.$row->uraian.'</td>				
								<td width="15%" style="text-align:center;"></td>			
							</tr>

							';

			$table .= '
							<tr style="font-size: 12px;">
								<td width="5%" style="text-align:center;"></td>
								<td width="15%" style="text-align:center;"></td>				
								<td width="65%" style="text-align:left;">'.$row->namabarang.'</td>				
								<td width="15%" style="text-align:center;">'.$row->qtykeluar.'</td>							
							</tr>

							';
			
		}else{
			$table .= '
							<tr style="font-size: 12px;">
								<td width="5%" style="text-align:center;"></td>
								<td width="15%" style="text-align:center;"></td>				
								<td width="65%" style="text-align:left;">'.$row->namabarang.'</td>				
								<td width="15%" style="text-align:center;">'.$row->qtykeluar.'</td>					
							</tr>

							';
		}
		$nokeluar_old = $row->nokeluar;
	}
}else{
	$table .= '
				<tr style="font-size: 12px; font-weight: bold;">
					<td width="100%" style="text-align:center;" colspan="4">Data tidak ditemukan...</td>		
				</tr>
				';
}




$table .= ' </tbody>
			</table>';




		$rsttdks = $this->db->query("select * from penandatangan where kdruangan='".$this->session->userdata('kdruangan')."' and kdttd='KS'");
		$rsttdpb = $this->db->query("select * from penandatangan where kdruangan='".$this->session->userdata('kdruangan')."' and kdttd='PB'");

		if ($rsttdks->num_rows()>0) {
			$jabatan_ks 			= $rsttdks->row()->jabatan;
			$nip_ks 				= $rsttdks->row()->nip;
			$namapenandatangan_ks 	= $rsttdks->row()->namapenandatangan;
			$golongan_ks 			= $rsttdks->row()->golongan;
		}else{
			$jabatan_ks 			= '';
			$nip_ks 				= '';
			$namapenandatangan_ks 	= '';
			$golongan_ks 			= '';
		}


		if ($rsttdpb->num_rows()>0) {
			$jabatan_pb 			= $rsttdpb->row()->jabatan;
			$nip_pb 				= $rsttdpb->row()->nip;
			$namapenandatangan_pb 	= $rsttdpb->row()->namapenandatangan;
			$golongan_pb 			= $rsttdpb->row()->golongan;
		}else{
			$jabatan_pb 			= '';
			$nip_pb 				= '';
			$namapenandatangan_pb 	= '';
			$golongan_pb 			= '';
		}


		$table  .= '<br><br><table border="0" width="100%"><tbody>';
		$table .= ' 
					<tr style="font-size: 12px;">
						<td width="5%" style="text-align:center;"></td>		
						<td width="30%" style="text-align:center;"></td>
						<td width="30%" style="text-align:center;"></td>
						<td width="30%" style="text-align:center;">Diketahui Oleh</td>
						<td width="5%" style="text-align:center;"></td>
					</tr>
			';

		$table .= ' 
					<tr style="font-size: 12px;">
						<td width="5%" style="text-align:center;"></td>		
						<td width="30%" style="text-align:center;">'.$jabatan_pb.'</td>
						<td width="30%" style="text-align:center;"></td>
						<td width="30%" style="text-align:center;">'.$jabatan_ks.'</td>
						<td width="5%" style="text-align:center;"></td>
					</tr>
			';


		$table .= ' 
					<tr style="font-size: 12px;">
						<td width="5%" style="text-align:center;">&nbsp;</td>		
						<td width="30%" style="text-align:center;"></td>
						<td width="30%" style="text-align:center;"></td>
						<td width="30%" style="text-align:center;"></td>
						<td width="5%" style="text-align:center;"></td>
					</tr>
			';
		$table .= ' 
					<tr style="font-size: 12px;">
						<td width="5%" style="text-align:center;">&nbsp;</td>		
						<td width="30%" style="text-align:center;"></td>
						<td width="30%" style="text-align:center;"></td>
						<td width="30%" style="text-align:center;"></td>
						<td width="5%" style="text-align:center;"></td>
					</tr>
			';
		$table .= ' 
					<tr style="font-size: 12px;">
						<td width="5%" style="text-align:center;">&nbsp;</td>		
						<td width="30%" style="text-align:center;"></td>
						<td width="30%" style="text-align:center;"></td>
						<td width="30%" style="text-align:center;"></td>
						<td width="5%" style="text-align:center;"></td>
					</tr>
			';
		$table .= ' 
					<tr style="font-size: 12px;">
						<td width="5%" style="text-align:center;">&nbsp;</td>		
						<td width="30%" style="text-align:center;"></td>
						<td width="30%" style="text-align:center;"></td>
						<td width="30%" style="text-align:center;"></td>
						<td width="5%" style="text-align:center;"></td>
					</tr>
			';

		$table .= ' 
					<tr style="font-size: 12px; font-weight: bold;">
						<td width="5%" style="text-align:center;"></td>		
						<td width="30%" style="text-align:center;">'.$namapenandatangan_pb.'</td>
						<td width="30%" style="text-align:center;"></td>
						<td width="30%" style="text-align:center;">'.$namapenandatangan_ks.'</td>
						<td width="5%" style="text-align:center;"></td>
					</tr>
			';
		$table .= ' 
					<tr style="font-size: 12px;">
						<td width="5%" style="text-align:center;"></td>		
						<td width="30%" style="text-align:center;">'.$golongan_pb.'</td>
						<td width="30%" style="text-align:center;"></td>
						<td width="30%" style="text-align:center;">'.$golongan_ks.'</td>
						<td width="5%" style="text-align:center;"></td>
					</tr>
			';

		$table .= ' 
					<tr style="font-size: 12px; font-weight: bold;">
						<td width="5%" style="text-align:center;"></td>		
						<td width="30%" style="text-align:center;">NIP. '.$nip_pb.'</td>
						<td width="30%" style="text-align:center;"></td>
						<td width="30%" style="text-align:center;">NIP. '.$nip_ks.'</td>
						<td width="5%" style="text-align:center;"></td>
					</tr>
			';

		$table .= '</tbody></table>';

$pdf->SetTopMargin(35);
$pdf->SetFont('times', '');
$pdf->writeHTML($table, true, false, false, false, '');


$tglcetak = date('d-m-Y');



$pdf->Output();
?>
