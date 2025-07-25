<html>
	<head>
		<title>LAPORAN MUTASI BARANG</title>
	</head>
	<body onload="window.print()">
		
		<?php


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
		$kdkelompok_old = '';
		$namakelompok_old = '';
		$subtotalsaldoawal = 0;
		$subtotalpenambahan = 0;
		$subtotalpemakaian = 0;
		$subtotalsaldoakhir = 0;


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

						$qtysaldoawal = $this->db->query("select saldoawal_dinas_new('$tglawal', '$tahunanggaran', '$row->keybarang', $row->hargabelisatuan) as qtysaldoawal")->row()->qtysaldoawal;

						$qtypenerimaan = $this->db->query("select penerimaan_dinas_new('$tglawal', '$tglakhir', '$tahunanggaran', '$row->keybarang', $row->hargabelisatuan) as qtypenerimaan")->row()->qtypenerimaan;

						$qtypengeluaran = $this->db->query("select pengeluaran_dinas_new('$tglawal', '$tglakhir', '$tahunanggaran', '$row->keybarang', $row->hargabelisatuan) as qtypengeluaran")->row()->qtypengeluaran;

					}
				}

				


				

				$stokbarang = $qtysaldoawal + $qtypenerimaan - $qtypengeluaran;


				$namakelompok = $this->db->query("select * from kelompokbarang where kdkelompok='$row->kdkelompok'")->row()->namakelompok;

				if ($kdkelompok_old!=$row->kdkelompok && $no!=1) {
					
					$table .= '
							<tr style="font-size: 9px; font-weight: bold">
								<td width="20%" style="text-align:right; font-size: 10;" colspan="2">Sub Total '.$namakelompok_old.'</td>		
								<td width="20%" style="text-align:right;" colspan="4">'.number_format($subtotalsaldoawal).'</td>
								<td width="20%" style="text-align:right;" colspan="4">'.number_format($subtotalpenambahan).'</td>
								<td width="20%" style="text-align:right;" colspan="4">'.number_format($subtotalpemakaian).'</td>
								<td width="20%" style="text-align:right;" colspan="4">'.number_format($subtotalsaldoakhir).'</td>
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

								<td width="5%" style="text-align:center;">'.number_format($qtysaldoawal).'</td>				
								<td width="5%" style="text-align:center;">'.$row->satuan.'</td>				
								<td width="5%" style="text-align:right;">'.number_format($row->hargabelisatuan).'</td>				
								<td width="5%" style="text-align:right;">'.number_format($qtysaldoawal * $row->hargabelisatuan ).'</td>

								<td width="5%" style="text-align:center;">'.number_format($qtypenerimaan).'</td>				
								<td width="5%" style="text-align:center;">'.$row->satuan.'</td>				
								<td width="5%" style="text-align:right;">'.number_format($row->hargabelisatuan).'</td>				
								<td width="5%" style="text-align:right;">'.number_format($qtypenerimaan*$row->hargabelisatuan).'</td>

								<td width="5%" style="text-align:center;">'.number_format($qtypengeluaran).'</td>				
								<td width="5%" style="text-align:center;">'.$row->satuan.'</td>				
								<td width="5%" style="text-align:right;">'.number_format($row->hargabelisatuan).'</td>				
								<td width="5%" style="text-align:right;">'.number_format($qtypengeluaran * $row->hargabelisatuan ).'</td>

								<td width="5%" style="text-align:center;">'.number_format($stokbarang).'</td>				
								<td width="5%" style="text-align:center;">'.$row->satuan.'</td>				
								<td width="5%" style="text-align:right;">'.number_format($row->hargabelisatuan).'</td>				
								<td width="5%" style="text-align:right;">'.number_format($stokbarang * $row->hargabelisatuan).'</td>


							</tr>
				';

				

				$kdkelompok_old = $row->kdkelompok;
				$namakelompok_old = $namakelompok;


				$subtotalsaldoawal += $qtysaldoawal*$row->hargabelisatuan;
				$subtotalpenambahan += $qtypenerimaan*$row->hargabelisatuan;
				$subtotalpemakaian += $qtypengeluaran * $row->hargabelisatuan;
				$subtotalsaldoakhir += $stokbarang * $row->hargabelisatuan;


				$totalsaldoawal += $qtysaldoawal*$row->hargabelisatuan;
				$totalpenambahan += $qtypenerimaan*$row->hargabelisatuan;
				$totalpemakaian += $qtypengeluaran * $row->hargabelisatuan;
				$totalsaldoakhir += $stokbarang * $row->hargabelisatuan;

				
			}

			$table .= '
					<tr style="font-size: 9px; font-weight: bold">
						<td width="20%" style="text-align:right; font-size: 10;" colspan="2">Sub Total '.$namakelompok_old.'</td>		
						<td width="20%" style="text-align:right;" colspan="4">'.number_format($subtotalsaldoawal).'</td>
						<td width="20%" style="text-align:right;" colspan="4">'.number_format($subtotalpenambahan).'</td>
						<td width="20%" style="text-align:right;" colspan="4">'.number_format($subtotalpemakaian).'</td>
						<td width="20%" style="text-align:right;" colspan="4">'.number_format($subtotalsaldoakhir).'</td>
					</tr>
			';

			$table .= '
							<tr style="font-size: 9px; font-weight: bold">
								<td width="100%" style="text-align:right;" colspan="18">&nbsp;</td>
							</tr>
					';

			$table .= '
					<tr style="font-size: 9px; font-weight: bold">
						<td width="20%" style="text-align:right; font-size: 10;" colspan="2">Total Keseluruhan</td>		
						<td width="20%" style="text-align:right;" colspan="4">'.number_format($totalsaldoawal).'</td>
						<td width="20%" style="text-align:right;" colspan="4">'.number_format($totalpenambahan).'</td>
						<td width="20%" style="text-align:right;" colspan="4">'.number_format($totalpemakaian).'</td>
						<td width="20%" style="text-align:right;" colspan="4">'.number_format($totalsaldoakhir).'</td>
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
	</body>
</html>
