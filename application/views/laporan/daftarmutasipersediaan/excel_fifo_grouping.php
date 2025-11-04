<?php  

header("Content-type: application/vnd-ms-excel");
 
// Mendefinisikan nama file ekspor "hasil-export.xls"
header("Content-Disposition: attachment; filename=laporan-daftar-mutasi-persediaan.xls");

$table = '
				<table border="0" width="100%" cellpadding="10">
					<thead>
						<tr style="font-size: 16px; font-weight: bold; text-align: center">
							<td>'.$namaruangan.'</td>
						</tr>
						<tr style="font-size: 16px; font-weight: bold; text-align: center">
							<td>DINAS PENDIDIKAN KAB. DELI SERDANG</td>
						</tr>
						<tr style="font-size: 16px; font-weight: bold; text-align: center">
							<td>DAFTAR MUTASI PERSEDIAAN</td>
						</tr>
						<tr style="font-size: 16px; font-weight: bold; text-align: center">
							<td>PER '.strtoupper(tglindonesialengkap($tglakhir)).'</td>
						</tr>
						<tr style="font-size: 16px; font-weight: bold; text-align: center">
							<td>'.strtoupper($subjudul).'</td>
						</tr>
					</thead>
				</table>';

		$table  .= '<table border="1" width="100%">';
		$table 	.= ' 
					<thead>
						<tr style="background-color:#ccc; font-size: 9px; font-weight: bold;">
							<th width="5%" style="text-align:center;" rowspan="2">NO</th>
							<th width="15%" style="text-align:center;" rowspan="2">JENIS BARANG</th>				
							<th width="20%" style="text-align:center;" colspan="4">SALDO AWAL PER '.strtoupper(tglindonesialengkap($tglawal)).'</th>				
							<th width="20%" style="text-align:center;" colspan="4">PENAMBAHAN (PEMBELIAN) TAHUN '.$this->session->userdata('tahunanggaran').'</th>				
							<th width="20%" style="text-align:center;" colspan="4">PENGURANGAN (PEMAKAIAN) TAHUN '.$this->session->userdata('tahunanggaran').'</th>				
							<th width="20%" style="text-align:center;" colspan="4">SALDO AKHIR PER '.strtoupper(tglindonesialengkap($tglakhir)).'</th>				
						</tr>
						<tr style="background-color:#ccc; font-size: 9px; font-weight: bold;">
							<th style="text-align:center;">UNIT</th>				
							<th style="text-align:center;">SATUAN</th>				
							<th style="text-align:center;">HARGA SATUAN (Rp)</th>				
							<th style="text-align:center;">NILAI (Rp)</th>				

							<th style="text-align:center;">UNIT</th>				
							<th style="text-align:center;">SATUAN</th>				
							<th style="text-align:center;">HARGA SATUAN (Rp)</th>				
							<th style="text-align:center;">NILAI (Rp)</th>				

							<th style="text-align:center;">UNIT</th>				
							<th style="text-align:center;">SATUAN</th>				
							<th style="text-align:center;">HARGA SATUAN (Rp)</th>				
							<th style="text-align:center;">NILAI (Rp)</th>				

							<th style="text-align:center;">UNIT</th>				
							<th style="text-align:center;">SATUAN</th>				
							<th style="text-align:center;">HARGA SATUAN (Rp)</th>				
							<th style="text-align:center;">NILAI (Rp)</th>				
						</tr>
					</thead>
					<tbody>';

		$no=1;
		$total = 0;
		$kdupt_old = '';
		$namaupt_old = '';
		$kdkelompok_old = '';
		$namakelompok_old = '';
		$subtotalsaldoawal = 0;
		$subtotalpenambahan = 0;
		$subtotalpemakaian = 0;
		$subtotalsaldoakhir = 0;
		$subtotalsaldoawal_upt = 0;
		$subtotalpenambahan_upt = 0;
		$subtotalpemakaian_upt = 0;
		$subtotalsaldoakhir_upt = 0;


		$totalsaldoawal = 0;
		$totalpenambahan = 0;
		$totalpemakaian = 0;
		$totalsaldoakhir = 0;

		$no=1;
		if ($rslaporan->num_rows()>0) {
			foreach ($rslaporan->result() as $row) {
				

				if ($kdruangan!='-') {
					
					//  ===================================== Sekolah ======================================================

					$qtysaldoawal = $this->db->query("select saldoawal_perruangan_new('$tglawal', '$kdruangan', '$tahunanggaran', '$row->keybarang', $row->hargabelisatuan) as qtysaldoawal")->row()->qtysaldoawal;

					$qtypenerimaan = $this->db->query("select penerimaan_perruangan_new('$tglawal', '$tglakhir', '$kdruangan', '$tahunanggaran', '$row->keybarang', $row->hargabelisatuan) as qtypenerimaan")->row()->qtypenerimaan;

					$qtypengeluaran = $this->db->query("select pengeluaran_perruangan_new('$tglawal', '$tglakhir', '$kdruangan', '$tahunanggaran', '$row->keybarang', $row->hargabelisatuan) as qtypengeluaran")->row()->qtypengeluaran;

				}else{
					if ($kdupt!='') {
						
						
						//  ===================================== UPT ======================================================

						$qtysaldoawal = $this->db->query("select saldoawal_perupt_new('$tglawal', '$kdupt', '$tahunanggaran', '$row->keybarang', $row->hargabelisatuan) as qtysaldoawal")->row()->qtysaldoawal;

						$qtypenerimaan = $this->db->query("select penerimaan_perupt_new('$tglawal', '$tglakhir', '$kdupt', '$tahunanggaran', '$row->keybarang', $row->hargabelisatuan) as qtypenerimaan")->row()->qtypenerimaan;

						$qtypengeluaran = $this->db->query("select pengeluaran_perupt_new('$tglawal', '$tglakhir', '$kdupt', '$tahunanggaran', '$row->keybarang', $row->hargabelisatuan) as qtypengeluaran")->row()->qtypengeluaran;

					}else{
						
						//  ===================================== Dinas / Admin ======================================================
						
						// $qtysaldoawal = $this->db->query("select saldoawal_dinas_new('$tglawal', '$tahunanggaran', '$row->keybarang', $row->hargabelisatuan) as qtysaldoawal")->row()->qtysaldoawal;

						// $qtypenerimaan = $this->db->query("select penerimaan_dinas_new('$tglawal', '$tglakhir', '$tahunanggaran', '$row->keybarang', $row->hargabelisatuan) as qtypenerimaan")->row()->qtypenerimaan;

						// $qtypengeluaran = $this->db->query("select pengeluaran_dinas_new('$tglawal', '$tglakhir', '$tahunanggaran', '$row->keybarang', $row->hargabelisatuan) as qtypengeluaran")->row()->qtypengeluaran;

						
						// =========== 04/11/2025 cetak perupt
						$qtysaldoawal = $this->db->query("select saldoawal_perupt_new('$tglawal', '$row->kdupt', '$tahunanggaran', '$row->keybarang', $row->hargabelisatuan) as qtysaldoawal")->row()->qtysaldoawal;

						$qtypenerimaan = $this->db->query("select penerimaan_perupt_new('$tglawal', '$tglakhir', '$row->kdupt', '$tahunanggaran', '$row->keybarang', $row->hargabelisatuan) as qtypenerimaan")->row()->qtypenerimaan;

						$qtypengeluaran = $this->db->query("select pengeluaran_perupt_new('$tglawal', '$tglakhir', '$row->kdupt', '$tahunanggaran', '$row->keybarang', $row->hargabelisatuan) as qtypengeluaran")->row()->qtypengeluaran;

					}
				}

				
				
				//Nama UPT
				if ($this->session->userdata('akseslevel') == '3' || $this->session->userdata('akseslevel') == '9') {


					if ($kdupt_old != $row->kdupt) {

						if ($no!=1) {
							
							$table .= '
											<tr style="font-size: 9px; font-weight: bold">
												<td width="20%" style="text-align:right; font-size: 10;" colspan="2">SUB TOTAL '.strtoupper($namaupt_old) .'</td>		
												<td width="20%" style="text-align:right;" colspan="4">'.untitik($subtotalsaldoawal_upt).'</td>
												<td width="20%" style="text-align:right;" colspan="4">'.untitik($subtotalpenambahan_upt).'</td>
												<td width="20%" style="text-align:right;" colspan="4">'.untitik($subtotalpemakaian_upt).'</td>
												<td width="20%" style="text-align:right;" colspan="4">'.untitik($subtotalsaldoakhir_upt).'</td>
											</tr>
									';

							$subtotalsaldoawal_upt = 0;
							$subtotalpenambahan_upt = 0;
							$subtotalpemakaian_upt = 0;
							$subtotalsaldoakhir_upt = 0;

						}

						$table .= '
							<tr style="font-size: 9px;">
								<td width="100%" style="text-align:left; font-weight: bold; font-size: 12;" colspan="17">'.$row->namaupt.'</td>		
							</tr>
					';
					}					
				}

				

				$stokbarang = $qtysaldoawal + $qtypenerimaan - $qtypengeluaran;


				$namakelompok = $this->db->query("select * from kelompokbarang where kdkelompok='$row->kdkelompok'")->row()->namakelompok;

				if ($kdkelompok_old!=$row->kdkelompok && $no!=1) {
					
					$table .= '
							<tr style="font-size: 9px; font-weight: bold">
								<td width="20%" style="text-align:right; font-size: 10;" colspan="2">SUB TOTAL '.strtoupper($namakelompok_old) .'</td>		
								<td width="20%" style="text-align:right;" colspan="4">'.untitik($subtotalsaldoawal).'</td>
								<td width="20%" style="text-align:right;" colspan="4">'.untitik($subtotalpenambahan).'</td>
								<td width="20%" style="text-align:right;" colspan="4">'.untitik($subtotalpemakaian).'</td>
								<td width="20%" style="text-align:right;" colspan="4">'.untitik($subtotalsaldoakhir).'</td>
							</tr>
					';

					$table .= '
							<tr style="font-size: 9px; font-weight: bold">
								<td width="100%" style="text-align:right;" colspan="18">&nbsp;</td>
							</tr>
					';

					$subtotalsaldoawal = 0;
					$subtotalpenambahan = 0;
					$subtotalpemakaian = 0;
					$subtotalsaldoakhir = 0;

				}


				if ($kdkelompok_old!=$row->kdkelompok) {
					

					$table .= '
							<tr style="font-size: 9px;">

								<td width="5%" style="text-align:center;"></td>
								<td width="95%" style="text-align:left; font-weight: bold; font-size: 10;" colspan="17">'.$namakelompok.'</td>		
							</tr>
					';

				}



				$table .= '
							<tr style="font-size: 9px;">

								<td width="5%" style="text-align:center;">'.$no++.'</td>
								<td width="15%" style="text-align:left;">'.$row->namabarang.'</td>		

								<td width="5%" style="text-align:center;">'.untitik($qtysaldoawal).'</td>				
								<td width="5%" style="text-align:center;">'.$row->satuan.'</td>				
								<td width="5%" style="text-align:right;">'.untitik($row->hargabelisatuan).'</td>				
								<td width="5%" style="text-align:right;">'.untitik($qtysaldoawal * $row->hargabelisatuan ).'</td>

								<td width="5%" style="text-align:center;">'.untitik($qtypenerimaan).'</td>				
								<td width="5%" style="text-align:center;">'.$row->satuan.'</td>				
								<td width="5%" style="text-align:right;">'.untitik($row->hargabelisatuan).'</td>				
								<td width="5%" style="text-align:right;">'.untitik($qtypenerimaan*$row->hargabelisatuan).'</td>

								<td width="5%" style="text-align:center;">'.untitik($qtypengeluaran).'</td>				
								<td width="5%" style="text-align:center;">'.$row->satuan.'</td>				
								<td width="5%" style="text-align:right;">'.untitik($row->hargabelisatuan).'</td>				
								<td width="5%" style="text-align:right;">'.untitik($qtypengeluaran * $row->hargabelisatuan ).'</td>

								<td width="5%" style="text-align:center;">'.untitik($stokbarang).'</td>				
								<td width="5%" style="text-align:center;">'.$row->satuan.'</td>				
								<td width="5%" style="text-align:right;">'.untitik($row->hargabelisatuan).'</td>				
								<td width="5%" style="text-align:right;">'.untitik($stokbarang * $row->hargabelisatuan).'</td>


							</tr>
				';

				
				$kdupt_old = $row->kdupt;
				$namaupt_old = $row->namaupt;
				$kdkelompok_old = $row->kdkelompok;
				$namakelompok_old = $namakelompok;


				$subtotalsaldoawal += $qtysaldoawal*$row->hargabelisatuan;
				$subtotalpenambahan += $qtypenerimaan*$row->hargabelisatuan;
				$subtotalpemakaian += $qtypengeluaran * $row->hargabelisatuan;
				$subtotalsaldoakhir += $stokbarang * $row->hargabelisatuan;


				$subtotalsaldoawal_upt += $qtysaldoawal * $row->hargabelisatuan;
				$subtotalpenambahan_upt += $qtypenerimaan * $row->hargabelisatuan;
				$subtotalpemakaian_upt += $qtypengeluaran * $row->hargabelisatuan;
				$subtotalsaldoakhir_upt += $stokbarang * $row->hargabelisatuan;


				$totalsaldoawal += $qtysaldoawal*$row->hargabelisatuan;
				$totalpenambahan += $qtypenerimaan*$row->hargabelisatuan;
				$totalpemakaian += $qtypengeluaran * $row->hargabelisatuan;
				$totalsaldoakhir += $stokbarang * $row->hargabelisatuan;

				
			}

			$table .= '
					<tr style="font-size: 9px; font-weight: bold">
						<td width="20%" style="text-align:right; font-size: 10;" colspan="2">SUB TOTAL '.strtoupper($namakelompok_old).'</td>		
						<td width="20%" style="text-align:right;" colspan="4">'.untitik($subtotalsaldoawal).'</td>
						<td width="20%" style="text-align:right;" colspan="4">'.untitik($subtotalpenambahan).'</td>
						<td width="20%" style="text-align:right;" colspan="4">'.untitik($subtotalpemakaian).'</td>
						<td width="20%" style="text-align:right;" colspan="4">'.untitik($subtotalsaldoakhir).'</td>
					</tr>
			';

			$table .= '
							<tr style="font-size: 9px; font-weight: bold">
								<td width="100%" style="text-align:right;" colspan="18">&nbsp;</td>
							</tr>
					';

			//Dinas atau Admin
			if ($this->session->userdata('akseslevel') == '3' || $this->session->userdata('akseslevel') == '9') {

				$table .= '
								<tr style="font-size: 12px; font-weight: bold">
									<td width="20%" style="text-align:right; font-size: 10;" colspan="2">SUB TOTAL '.strtoupper($namaupt_old) .'</td>		
									<td width="20%" style="text-align:right;" colspan="4">'.untitik($subtotalsaldoawal_upt).'</td>
									<td width="20%" style="text-align:right;" colspan="4">'.untitik($subtotalpenambahan_upt).'</td>
									<td width="20%" style="text-align:right;" colspan="4">'.untitik($subtotalpemakaian_upt).'</td>
									<td width="20%" style="text-align:right;" colspan="4">'.untitik($subtotalsaldoakhir_upt).'</td>
								</tr>
						';
	
				$table .= '
								<tr style="font-size: 9px; font-weight: bold">
									<td width="100%" style="text-align:right;" colspan="18">&nbsp;</td>
								</tr>
						';
			}

			$table .= '
					<tr style="font-size: 12px; font-weight: bold">
						<td width="20%" style="text-align:right;" colspan="2">TOTAL KESELURUHAN</td>		
						<td width="20%" style="text-align:right;" colspan="4">'.untitik($totalsaldoawal).'</td>
						<td width="20%" style="text-align:right;" colspan="4">'.untitik($totalpenambahan).'</td>
						<td width="20%" style="text-align:right;" colspan="4">'.untitik($totalpemakaian).'</td>
						<td width="20%" style="text-align:right;" colspan="4">'.untitik($totalsaldoakhir).'</td>
					</tr>
			';


		}else{

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


echo $table;

?>