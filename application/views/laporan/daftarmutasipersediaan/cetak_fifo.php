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
							<td>PER 31 DESEMBER '.$this->session->userdata('tahunanggaran').'</td>
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
							<th width="20%" style="text-align:center;" colspan="4">SALDO AWAL PER 01 JANUARI '.$this->session->userdata('tahunanggaran').'</th>				
							<th width="20%" style="text-align:center;" colspan="4">PENAMBAHAN (PEMBELIAN) TAHUN '.$this->session->userdata('tahunanggaran').'</th>				
							<th width="20%" style="text-align:center;" colspan="4">PENGURANGAN (PEMAKAIAN) TAHUN '.$this->session->userdata('tahunanggaran').'</th>				
							<th width="20%" style="text-align:center;" colspan="4">SALDO AKHIR PER 31 DESEMBER '.$this->session->userdata('tahunanggaran').'</th>				
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
								<td width="95%" style="text-align:left; font-weight: bold; font-size: 10;" colspan="17">'.$row->namakelompok.'</td>		
							</tr>
					';

				}

				$hargabelisatuan_saldoawal = 0;
				$hargabelisatuan_pembelian = 0;

				if ($row->jenispenerimaan=='Saldo Awal') {
					$hargabelisatuan_saldoawal = $row->hargabelisatuan;
				}else{
					$hargabelisatuan_pembelian = $row->hargabelisatuan;
				}

				$table .= '
							<tr style="font-size: 9px;">

								<td width="5%" style="text-align:center;">'.$no++.'</td>
								<td width="15%" style="text-align:left;">'.$row->namabarang.'</td>		

								<td width="5%" style="text-align:center;">'.number_format($row->qtysaldoawal).'</td>				
								<td width="5%" style="text-align:center;">'.$row->satuan.'</td>				
								<td width="5%" style="text-align:right;">'.number_format($hargabelisatuan_saldoawal).'</td>				
								<td width="5%" style="text-align:right;">'.number_format($row->qtysaldoawal * $hargabelisatuan_saldoawal ).'</td>

								<td width="5%" style="text-align:center;">'.number_format($row->qtypenerimaan).'</td>				
								<td width="5%" style="text-align:center;">'.$row->satuan.'</td>				
								<td width="5%" style="text-align:right;">'.number_format($hargabelisatuan_pembelian).'</td>				
								<td width="5%" style="text-align:right;">'.number_format($row->qtypenerimaan*$hargabelisatuan_pembelian).'</td>

								<td width="5%" style="text-align:center;">'.number_format($row->qtypengeluaran).'</td>				
								<td width="5%" style="text-align:center;">'.$row->satuan.'</td>				
								<td width="5%" style="text-align:right;">'.number_format($row->hargabelisatuan).'</td>				
								<td width="5%" style="text-align:right;">'.number_format($row->qtypengeluaran * $row->hargabelisatuan ).'</td>

								<td width="5%" style="text-align:center;">'.number_format($row->stokbarang).'</td>				
								<td width="5%" style="text-align:center;">'.$row->satuan.'</td>				
								<td width="5%" style="text-align:right;">'.number_format($row->hargabelisatuan).'</td>				
								<td width="5%" style="text-align:right;">'.number_format($row->stokbarang * $row->hargabelisatuan).'</td>


							</tr>
				';

				

				$kdkelompok_old = $row->kdkelompok;
				$namakelompok_old = $row->namakelompok;


				$subtotalsaldoawal += $row->qtysaldoawal*$row->hargabelisatuan;
				$subtotalpenambahan += $row->qtypenerimaan*$row->hargabelisatuan;
				$subtotalpemakaian += $row->qtypengeluaran * $row->hargabelisatuan;
				$subtotalsaldoakhir += $row->stokbarang * $row->hargabelisatuan;


				$totalsaldoawal += $row->qtysaldoawal*$row->hargabelisatuan;
				$totalpenambahan += $row->qtypenerimaan*$row->hargabelisatuan;
				$totalpemakaian += $row->qtypengeluaran * $row->hargabelisatuan;
				$totalsaldoakhir += $row->stokbarang * $row->hargabelisatuan;

				
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


		echo $table;
		?>
	</body>
</html>
