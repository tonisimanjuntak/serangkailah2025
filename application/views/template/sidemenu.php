<?php
$level = $this->session->userdata('akseslevel');
$kdruangan = $this->session->userdata('kdruangan');

?>
  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-info elevation-4">
    <!-- Brand Logo -->
    <a href="<?php echo site_url() ?>" class="brand-link navbar-dark text-light text-sm">
      <img src="<?php echo (base_url()) ?>images/tutwurihandayani.png" alt="DISDIK" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">DINAS PENDIDIKAN</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar text-sm">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <?php
if (empty($this->session->userdata('foto'))) {
    echo '
                <img src="' . base_url("images/users.png") . '" class="img-circle elevation-2" alt="User Image">
              ';
} else {
    echo '
                <img src="' . base_url("uploads/pengguna/") . $this->session->userdata('foto') . '" class="img-circle elevation-2" alt="User Image">
              ';
}
?>
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo ($this->session->userdata('namapengguna')) ?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

          <li class="nav-item">
            <a href="<?php echo (site_url()) ?>" class="nav-link <?php echo ($menu == 'home') ? 'active' : '' ?>">
              <i class="nav-icon fas fa-home"></i>
              <p>
                Home
              </p>
            </a>
          </li>


          <?php
$menudropdown = array('pengguna', 'skpd', 'upt', 'ruangan', 'penandatangan');
if (in_array($menu, $menudropdown)) {
    $dropdownselected = true;
} else {
    $dropdownselected = false;
}
?>

          <li class="nav-item has-treeview <?php echo ($dropdownselected) ? 'menu-open' : '' ?>">
            <a href="#" class="nav-link <?php echo ($dropdownselected) ? 'active' : '' ?>">
              <i class="nav-icon fas fa-landmark"></i>
              <p>
                Data Unit Kerja
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">


              <?php if ($level == '2' || $level == '3' || $level == '9') {?>
              <li class="nav-item">
                <a href="<?php echo (site_url('upt')) ?>" class="nav-link <?php echo ($menu == 'upt') ? 'active' : '' ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>UPT</p>
                </a>
              </li>
              <?php }?>


              <?php if ($level == '9' || $level == '3' || $level == '1') {?>
                <li class="nav-item">
                  <a href="<?php echo (site_url('ruangan')) ?>" class="nav-link <?php echo ($menu == 'ruangan') ? 'active' : '' ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Sekolah</p>
                  </a>
                </li>
              <?php }?>


              <?php if ($level == '9') {?>
              <li class="nav-item">
                <a href="<?php echo (site_url('pengguna')) ?>" class="nav-link <?php echo ($menu == 'pengguna') ? 'active' : '' ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pengguna Aplikasi</p>
                </a>
              </li>
              <?php }?>


              <?php if ($level == '1') {?>
                <li class="nav-item">
                  <a href="<?php echo (site_url('penandatangan')) ?>" class="nav-link <?php echo ($menu == 'penandatangan') ? 'active' : '' ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Penandatangan</p>
                  </a>
                </li>
              <?php }?>

            </ul>
          </li>

          <?php
$menudropdown = array('akun5', 'barang', 'program', 'kegiatan', 'skpd', 'kelompokbarang');
if (in_array($menu, $menudropdown)) {
    $dropdownselected = true;
} else {
    $dropdownselected = false;
}
?>

          <?php if ($level == '9') {?>
          <li class="nav-item has-treeview <?php echo ($dropdownselected) ? 'menu-open' : '' ?>">
            <a href="#" class="nav-link <?php echo ($dropdownselected) ? 'active' : '' ?>">
              <i class="nav-icon fas fa-database"></i>
              <p>
                Data Master
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">

                <li class="nav-item">
                  <a href="<?php echo (site_url('kelompokbarang')) ?>" class="nav-link <?php echo ($menu == 'kelompokbarang') ? 'active' : '' ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Kelompok Barang</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="<?php echo (site_url('barang')) ?>" class="nav-link <?php echo ($menu == 'barang') ? 'active' : '' ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Barang</p>
                  </a>
                </li>


            </ul>
          </li>
          <?php }?>


          <?php
$menudropdown = array('pembelianbarang', 'pemakaianbarang', 'saldoawal');
if (in_array($menu, $menudropdown)) {
    $dropdownselected = true;
} else {
    $dropdownselected = false;
}
?>

          <?php if (!empty($kdruangan)) {?>
            <li class="nav-item has-treeview <?php echo ($dropdownselected) ? 'menu-open' : '' ?>">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-copy"></i>
                <p>
                  Transaksi
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="<?php echo (site_url('saldoawal')) ?>" class="nav-link <?php echo ($menu == 'saldoawal') ? 'active' : '' ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Saldo Awal Tahun</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="<?php echo (site_url('pembelianbarang')) ?>" class="nav-link <?php echo ($menu == 'pembelianbarang') ? 'active' : '' ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Pembelian Barang</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="<?php echo (site_url('pemakaianbarang')) ?>" class="nav-link <?php echo ($menu == 'pemakaianbarang') ? 'active' : '' ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Pemakaian Barang</p>
                  </a>
                </li>

              </ul>
            </li>
          <?php }?>


          <?php
$menudropdown = array('laporanstokfifo', 'laporanpembelian', 'laporanpemakaian', 'daftarmutasipersediaan', 'kartustok');
if (in_array($menu, $menudropdown)) {
    $dropdownselected = true;
} else {
    $dropdownselected = false;
}
?>

          <li class="nav-item has-treeview <?php echo ($dropdownselected) ? 'menu-open' : '' ?>">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                Laporan
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo (site_url('laporan/laporanstokfifo')) ?>" class="nav-link <?php echo ($menu == 'laporanstokfifo') ? 'active' : '' ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Laporan Stok FIFO</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="<?php echo (site_url('laporan/laporanpembelian')) ?>" class="nav-link <?php echo ($menu == 'laporanpembelian') ? 'active' : '' ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Laporan Pembelian Barang</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="<?php echo (site_url('laporan/laporanpemakaian')) ?>" class="nav-link <?php echo ($menu == 'laporanpemakaian') ? 'active' : '' ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Laporan Pemakaian Barang</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="<?php echo (site_url('laporan/daftarmutasipersediaan')) ?>" class="nav-link <?php echo ($menu == 'daftarmutasipersediaan') ? 'active' : '' ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Daftar Mutasi Persediaan</p>
                </a>
              </li>


              <li class="nav-item">
                <a href="<?php echo (site_url('kartustok')) ?>" class="nav-link <?php echo ($menu == 'kartustok') ? 'active' : '' ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Kartu Persediaan</p>
                </a>
              </li>


            </ul>
          </li>




<?php
$menudropdown = array('bataspenginputan', 'pengaturanttd', 'migrasibarang', 'defaultsekolah');
if (in_array($menu, $menudropdown)) {
    $dropdownselected = true;
} else {
    $dropdownselected = false;
}
?>

          <li class="nav-item has-treeview <?php echo ($dropdownselected) ? 'menu-open' : '' ?>">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-cogs"></i>
              <p>
                Pengaturan
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">

              <?php if ($level == '9' || $level == '3') {?>

              <li class="nav-item">
                <a href="<?php echo (site_url('pengaturan/defaultsekolah')) ?>" class="nav-link <?php echo ($menu == 'defaultsekolah') ? 'active' : '' ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Default Sekolah</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="<?php echo (site_url('pengaturan/bataspenginputan')) ?>" class="nav-link <?php echo ($menu == 'bataspenginputan') ? 'active' : '' ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Batas Waktu Penginputan</p>
                </a>
              </li>


              <?php }?>

              <?php if ($level == '9') {?>
              <li class="nav-item">
                <a href="<?php echo (site_url('pengaturan/migrasibarang')) ?>" class="nav-link <?php echo ($menu == 'migrasibarang') ? 'active' : '' ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Migrasi Kode Barang</p>
                </a>
              </li>
              <?php }?>


              <?php if ($level == '1' || $level == '2') {?>

              <li class="nav-item">
                <a href="<?php echo (site_url('pengaturan/ttd')) ?>" class="nav-link <?php echo ($menu == 'pengaturanttd') ? 'active' : '' ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Penandatangan</p>
                </a>
              </li>

              <?php }?>





            </ul>
          </li>




          <li class="nav-item">
            <a href="<?php echo (site_url('Login/keluar')) ?>" class="nav-link text-warning">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>
                Logout
              </p>
            </a>
          </li>










        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>