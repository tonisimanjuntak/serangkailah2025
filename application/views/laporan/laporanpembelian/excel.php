<?php  

header("Content-type: application/vnd-ms-excel");
 
// Mendefinisikan nama file ekspor "hasil-export.xls"
header("Content-Disposition: attachment; filename=laporan-pembelian-barang.xls");



if ($tglawal==$tglakhir) {
	$periode = tglindonesialengkap($tglawal); 
}else{
	$periode = tglindonesialengkap($tglawal).' s/d '.tglindonesialengkap($tglakhir) ; 
}

$table = '
	<span style="text-align:center; font-size: 20px; font-weight: bold;">DINAS PENDIDIKAN KAB. DELI SERDANG</span><br>
	<span style="text-align:center; font-size: 20px; font-weight: bold;">'.$namaruangan.'</span><br>
	<span style="text-align:center; font-size: 20px; font-weight: bold;">LAPORAN PEMBELIAN</span><br>
	<span style="text-align:center">Periode '.$periode.'</span><br><br>
';

if ($subjudul!='') {
	$table .= '
		<span>'.strtoupper($subjudul).'</span><br>
	';
}

$table  .= '<table border="1" width="100%" cellpadding="5">';
$table .= ' 
			<thead>
				<tr style="background-color:#ccc; font-size: 14px; font-weight: bold;">
					<th width="5%" style="text-align:center;">NO</th>
					<th width="15%" style="text-align:center;">TANGGAL</th>				
					<th width="40%" style="text-align:center;">URAIAN</th>				
					<th width="10%" style="text-align:center;">QTY</th>				
					<th width="15%" style="text-align:center;">HARGA BELI</th>			
					<th width="15%" style="text-align:center;">JUMLAH</th>				
				</tr>
			</thead>
			<tbody>';

$no=1;
$total = 0;

if ($rslaporan->num_rows()>0) {
	
	$noterima_old='';

	foreach ($rslaporan->result() as $row) {
		
		if ($noterima_old != $row->noterima) {
			
			$table .= '
							<tr style="font-size: 12px;">
								<td width="5%" style="text-align:center;">'.$no++.'</td>
								<td width="15%" style="text-align:center;">'.tglindonesia($row->tglterima).'</td>				
								<td width="40%" style="text-align:left;">'.$row->uraian.'</td>				
								<td width="10%" style="text-align:center;"></td>				
								<td width="15%" style="text-align:right;"></td>				
								<td width="15%" style="text-align:right;"></td>				
							</tr>

							';

			$table .= '
							<tr style="font-size: 12px;">
								<td width="5%" style="text-align:center;"></td>
								<td width="15%" style="text-align:center;"></td>				
								<td width="40%" style="text-align:left;">'.$row->namabarang.'</td>				
								<td width="10%" style="text-align:center;">'.$row->qtyterima.'</td>				
								<td width="15%" style="text-align:right;">'.$row->hargabelisatuan.'</td>		
								<td width="15%" style="text-align:right;">'.$row->qtyterima*$row->hargabelisatuan.'</td>				
							</tr>

							';
			
		}else{
			$table .= '
							<tr style="font-size: 12px;">
								<td width="5%" style="text-align:center;"></td>
								<td width="15%" style="text-align:center;"></td>				
								<td width="40%" style="text-align:left;">'.$row->namabarang.'</td>				
								<td width="10%" style="text-align:center;">'.$row->qtyterima.'</td>				
								<td width="15%" style="text-align:right;">'.$row->hargabelisatuan.'</td>		
								<td width="15%" style="text-align:right;">'.$row->qtyterima*$row->hargabelisatuan.'</td>				
							</tr>

							';
		}
		$total += ($row->qtyterima*$row->hargabelisatuan);
		$noterima_old = $row->noterima;
	}
}else{
	$table .= '
				<tr style="font-size: 12px; font-weight: bold;">
					<td width="100%" style="text-align:center;" colspan="7">Data tidak ditemukan...</td>		
				</tr>
				';
}


$table .= '
			<tr style="font-size: 12px; font-weight: bold;">
				<td width="85%" style="text-align:right;" colspan="5">TOTAL</td>				
				<td width="15%" style="text-align:right;">'.$total.'</td>				
			</tr>

			';


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


		
echo $table;

?>