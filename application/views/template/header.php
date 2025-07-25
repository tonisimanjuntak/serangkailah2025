<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>SERANGKAILAH - SISTEM INFORMASI BARANG HABIS PAKAI SEKOLAH</title>
  <link rel="icon" type="image/png" href="<?php echo base_url('images/tutwurihandayani.png') ?>"/>

  <!-- Font Awesome Icons 5.1 -->
  <link rel="stylesheet" href="<?php echo(base_url()) ?>assets/adminlte/plugins/fontawesome-free/css/all.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?php echo(base_url()) ?>assets/adminlte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo(base_url()) ?>assets/adminlte/dist/css/adminlte.min.css">

  <!-- datatables -->
  <link href="<?php echo(base_url('assets/')) ?>datatables/css/jquery.dataTables.min.css" rel="stylesheet">

  <!-- jquery-confirm -->
  <link rel="stylesheet" href="<?php echo(base_url('assets/')) ?>jquery-confirm/css/jquery-confirm.min.css">

  <!-- jquery-ui -->
  <link rel="stylesheet" href="<?php echo(base_url('assets/')) ?>jquery-ui/themes/base/jquery-ui.css">
  
  
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

  <!-- select2 -->
  <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />

  <style>

  .ui-autocomplete {
    max-height: 400px;
    overflow-y: auto;
    /* prevent horizontal scrollbar */
    overflow-x: hidden;
  }
  /* IE 6 doesn't support max-height
   * we use height instead, but this forces the menu to always be this tall
   */
  * html .ui-autocomplete {
    height: 100px;
  }

  .has-error .help-block {
    color: red;
  }


  .required label {
    font-weight: bold;
  }

  .required label:after {
      color: #e32;
      content: ' * wajib';
      font-style: italic;
      font-size: 12px;
      display:inline;
  }

  #cardcontent .card-title {
    font-size: 25px;
    color: #A4A4A4;
  }


  #table th {
    font-size: 14px;
  }

  #table td {
    font-size: 14px;
  }
  
  table.dataTable thead th {
    vertical-align: middle;
  }
  
  .main-sidebar { background-color: #3D99B4 !important }
  
  .nav-link {color: #111111 !important}
  
  .batas-menu {
    margin-top: 2px;
    margin-bottom: 2px;
    border-width: 2px;
  }  

  .kelapkelip{
    animation:kelapkelipText 1.5s infinite;
  }
  @keyframes kelapkelipText{
      0%{     color: #FE0303;    }
      50%{    color: #FF6E6E; }
      60%{    color: #FFB7B7; }
      70%{    color: #FFCFCF; }
      80%{    color: #FFF1F1; }
      90%{    color:transparent;  }
      100%{   color: transparent;    }
  }


.select2,
.select2-search__field,
.select2-results__option
{
    font-size:1.1em!important;
}
.select2-selection__rendered {
    /*line-height: 2em !important;*/
}
.select2-container .select2-selection--single {
    /*height: 2em !important;*/
      height: 40px;
}
.select2-selection__arrow {
    height: 2em !important;
}


.swal-overlay {
  background-color: rgba(43, 165, 137, 0.45);
}
  </style>


</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed sidebar-collapse accent-navy">
<div class="wrapper">