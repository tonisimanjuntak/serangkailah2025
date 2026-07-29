/*
select * from barang where tahunanggaran = '2026';
*/

INSERT INTO barang
SELECT CONCAT(RTRIM(kdbarang), '2026') AS keybarang, kdbarang, namabarang,
	keyakun5, merk, `type`, satuan, '2026' AS tahunanggaran, kdkelompok, NOW() AS tglinsert, NOW() AS lastupdate, '9999999999' AS idpengguna
	FROM barang WHERE tahunanggaran = '2025'
