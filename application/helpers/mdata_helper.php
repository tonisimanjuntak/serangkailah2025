<?php 
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

 	// function __construct()
 	// {
 	// 	__construct();
 	// }

	function kekata($x) {
	    $x = abs($x);
	    $angka = array("", "satu", "dua", "tiga", "empat", "lima",
	    "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
	    $temp = "";
	    if ($x <12) {
	        $temp = " ". $angka[$x];
	    } else if ($x <20) {
	        $temp = kekata($x - 10). " belas";
	    } else if ($x <100) {
	        $temp = kekata($x/10)." puluh". kekata($x % 10);
	    } else if ($x <200) {
	        $temp = " seratus" . kekata($x - 100);
	    } else if ($x <1000) {
	        $temp = kekata($x/100) . " ratus" . kekata($x % 100);
	    } else if ($x <2000) {
	        $temp = " seribu" . kekata($x - 1000);
	    } else if ($x <1000000) {
	        $temp = kekata($x/1000) . " ribu" . kekata($x % 1000);
	    } else if ($x <1000000000) {
	        $temp = kekata($x/1000000) . " juta" . kekata($x % 1000000);
	    } else if ($x <1000000000000) {
	        $temp = kekata($x/1000000000) . " milyar" . kekata(fmod($x,1000000000));
	    } else if ($x <1000000000000000) {
	        $temp = kekata($x/1000000000000) . " trilyun" . kekata(fmod($x,1000000000000));
	    }     
	        return $temp;
	}


	function terbilang($x, $style) {
	    if($x<0) {
	        $hasil = "minus ". trim(kekata($x));
	    } else {
	        $hasil = trim(kekata($x));
	    }     
	    switch ($style) {
	        case 1:
	            $hasil = strtoupper($hasil);
	            break;
	        case 2:
	            $hasil = strtolower($hasil);
	            break;
	        case 3:
	            $hasil = ucwords($hasil);
	            break;
	        default:
	            $hasil = ucfirst($hasil);
	            break;
	    }     
	    return $hasil;
	}

	function bulan($id_bulan){
		switch ($id_bulan) {
			case '1':
				$strbulan='Januari';
				break;		
			case '2':
				$strbulan='Februari';
				break;
			case '3':
				$strbulan='Maret';
				break;
			case '4':
				$strbulan='April';
				break;
			case '5':
				$strbulan='Mei';
				break;
			case '6':
				$strbulan='Juni';
				break;
			case '7':
				$strbulan='Juli';
				break;
			case '8':
				$strbulan='Agustus';
				break;
			case '9':
				$strbulan='September';
				break;
			case '10':
				$strbulan='Oktober';
				break;
			case '11':
				$strbulan='November';
				break;
			case '12':
				$strbulan='Desember';
				break;
			default:
				$strbulan='';
				break;
		}
		return $strbulan;
	}


	function hari($date){
		$hari = date ("D", strtotime($date));
	 
		switch($hari){
			case 'Sun':
				$hari_ini = "Minggu";
			break;
	 
			case 'Mon':			
				$hari_ini = "Senin";
			break;
	 
			case 'Tue':
				$hari_ini = "Selasa";
			break;
	 
			case 'Wed':
				$hari_ini = "Rabu";
			break;
	 
			case 'Thu':
				$hari_ini = "Kamis";
			break;
	 
			case 'Fri':
				$hari_ini = "Jumat";
			break;
	 
			case 'Sat':
				$hari_ini = "Sabtu";
			break;
			
			default:
				$hari_ini = "Tidak di ketahui";		
			break;
		}
	 
		return $hari_ini;
	 
	}

	function tglindonesialengkap($tanggal)
	{
		$ntgl = date('d', strtotime($tanggal));
		$nbln = date('m', strtotime($tanggal));
		$nthn = date('Y', strtotime($tanggal));

		switch ($nbln) {
			case '01':
				$cBln = 'Januari';
				break;
			case '02':
				$cBln = 'Februari';
				break;
			case '03':
				$cBln = 'Maret';
				break;
			case '04':
				$cBln = 'April';
				break;
			case '05':
				$cBln = 'Mei';
				break;
			case '06':
				$cBln = 'Juni';
				break;
			case '07':
				$cBln = 'Juli';
				break;
			case '08':
				$cBln = 'Agustus';
				break;
			case '09':
				$cBln = 'September';
				break;
			case '10':
				$cBln = 'Oktober';
				break;
			case '11':
				$cBln = 'November';
				break;
			default:
				$cBln = 'Desember';
				break;
		}

		return $ntgl.' '.$cBln.' '.$nthn;

	}


	function tglindonesia($tanggal)
	{
		if (!empty($tanggal)) {
			
			$ntgl = date('d', strtotime($tanggal));
			$nbln = date('m', strtotime($tanggal));
			$nthn = date('Y', strtotime($tanggal));

			switch ($nbln) {
				case '01':
					$cBln = 'Jan';
					break;
				case '02':
					$cBln = 'Feb';
					break;
				case '03':
					$cBln = 'Mar';
					break;
				case '04':
					$cBln = 'Apr';
					break;
				case '05':
					$cBln = 'Mei';
					break;
				case '06':
					$cBln = 'Jun';
					break;
				case '07':
					$cBln = 'Jul';
					break;
				case '08':
					$cBln = 'Ags';
					break;
				case '09':
					$cBln = 'Sep';
					break;
				case '10':
					$cBln = 'Okt';
					break;
				case '11':
					$cBln = 'Nov';
					break;
				default:
					$cBln = 'Des';
					break;
			}

			return $ntgl.' '.$cBln.' '.$nthn;
		}else{
			return '';
		}

	}

	function tgldmy($tanggal)
	{
		if (!empty($tanggal)) {
			return date('d-m-Y', strtotime($tanggal));			
		}else{
			return '';
		}
	}

	function tglymd($tanggal)
	{
		if (!empty($tanggal)) {
			return date('Y-m-d', strtotime($tanggal));			
		}else{
			return '';
		}
	}

	function numberformat_indonesia($tenama)
	{
		$cReturn = number_format($tenama, 0, ',', '.'); 
		return $cReturn;
	}

	function untitik($tenama)
	{
		$cReturn = str_replace('.', '', $tenama); 
		$cReturn = str_replace(',', '', $cReturn); 
		return $cReturn;
	}

	function berapawaktuyanglalu($tanggal)
	{

	    $tanggal         = new DateTime(date("Y-m-d H:i:s", strtotime($tanggal)));
	    $tanggalsekarang = new DateTime();
	    $interval        = $tanggal->diff($tanggalsekarang);
	    $waktulalu       = '';

	    if ($interval->format('%y') >= 1) {
	        $waktulalu = $interval->format('%y Tahun');
	    }

	    if ($interval->format('%m') >= 1) {
	        $waktulalu = $interval->format('%m bulan');
	    }

	    if ($interval->format('%d') >= 1) {
	        $waktulalu = $interval->format('%d Hari');
	    } else {
	        if ($interval->format('%h') >= 1) {
	            $waktulalu .= $interval->format('%h Jam ');
	        } else {
	            $waktulalu .= $interval->format('%i Menit');
	        }
	    }

	    if ($interval->format('%i') <= 0) {
	        return $waktulalu = 'Baru saja';
	    } else {
	        return $waktulalu . ' yang lalu';
	    }

	}


	function sisawaktu($tanggal)
	{

	    $tanggal         = new DateTime(date("Y-m-d H:i:s", strtotime($tanggal)));
	    $tanggalsekarang = new DateTime();
	    $interval        = $tanggal->diff($tanggalsekarang);
	    $waktulalu       = '';

	    if ($interval->format('%y') >= 1) {
	        $waktulalu .= $interval->format('%y Tahun').' ';
	    }

	    if ($interval->format('%m') >= 1) {
	        $waktulalu .= $interval->format('%m bulan').' ';
	    }

	    if ($interval->format('%d') >= 1) {
	        $waktulalu .= $interval->format('%d Hari').' ';
	    } else {
	        if ($interval->format('%h') >= 1) {
	            $waktulalu .= $interval->format('%h Jam ');
	        } else {
	            $waktulalu .= $interval->format('%i Menit');
	        }
	    }

	    return $waktulalu;
	    

	}

	function since($timestamp)
	{
		// Waktu sekarang
		$currentTime = time();

		// Selisih waktu (dalam detik)
		$timeDifference = $currentTime - strtotime($timestamp);

		// Jika waktu yang diberikan lebih besar dari waktu sekarang
		if ($timeDifference < 0) {
			return "Waktu yang diberikan tidak valid.";
		}

		// Hitung selisih waktu dalam menit, jam, hari, minggu, bulan, dan tahun
		$minutes = floor($timeDifference / 60); // 1 menit = 60 detik
		$hours = floor($timeDifference / 3600); // 1 jam = 3600 detik
		$days = floor($timeDifference / 86400); // 1 hari = 86400 detik
		$weeks = floor($timeDifference / 604800); // 1 minggu = 604800 detik
		$months = floor($timeDifference / 2592000); // 1 bulan = 2592000 detik (30 hari)
		$years = floor($timeDifference / 31536000); // 1 tahun = 31536000 detik (365 hari)

		// Tentukan format yang sesuai berdasarkan selisih waktu
		if ($timeDifference < 60) {
			return "Baru saja";
		} elseif ($minutes < 60) {
			return $minutes . " menit yang lalu";
		} elseif ($hours < 24) {
			return $hours . " jam yang lalu";
		} elseif ($days < 7) {
			return $days . " hari yang lalu";
		} elseif ($weeks < 4) {
			return $weeks . " minggu yang lalu";
		} elseif ($months < 12) {
			return $months . " bulan yang lalu";
		} else {
			return $years . " tahun yang lalu";
		}
	}