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

<style>
    .loader {
        position: fixed;
        left: 0px;
        top: 0px;
        width: 50%;
        height: 50%;
        z-index: 9999;
        background: url("<?php echo base_url('images/loading2.gif') ?>") 100% 100% no-repeat;
    }
</style>

<style>
/* ====================
   SIDEBAR STYLING
   ==================== */
.main-sidebar {
    background-color: #27293D !important; /* Dark blue-gray */
}

.main-sidebar .nav-link {
    color: #FFFFFF !important; /* White text */
}

.main-sidebar .nav-link:hover,
.main-sidebar .nav-link:focus {
    color: #FFFFFF !important;
    background-color: #4A5568 !important; /* Dark gray hover */
}

.main-sidebar .nav-link.active {
    color: #FFFFFF !important;
    background-color: #3B82F6 !important; /* Light blue for active */
}

.main-sidebar .nav-icon {
    color: #FFFFFF !important;
}

.main-sidebar .nav-icon:hover {
    color: #3B82F6 !important; /* Light blue for icon hover */
}

.nav-treeview > .nav-item > .nav-link {
    color: #FFFFFF !important;
}

.nav-treeview > .nav-item > .nav-link:hover {
    color: #FFFFFF !important;
    background-color: #4A5568 !important;
}

.nav-treeview > .nav-item > .nav-link.active {
    color: #FFFFFF !important;
    background-color: #3B82F6 !important;
}

/* ====================
   HEADER STYLING
   ==================== */
.main-header {
    background-color: #1E3A8A !important; /* Dark blue */
}

.main-header .navbar-brand,
.main-header .nav-link {
    color: #FFFFFF !important; /* White text */
}

.main-header .nav-link:hover {
    color: #3B82F6 !important; /* Light blue hover */
}


/* ====================
   FOOTER STYLING
   ==================== */
.main-footer {
    background-color: #1F2937 !important; /* Dark footer */
    color: #D1D5DB !important; /* Light gray text */
}

.main-footer a {
    color: #3B82F6 !important; /* Light blue links */
}

.main-footer a:hover {
    color: #FFFFFF !important; /* White on hover */
}

/* ====================
   BUTTONS AND FORMS
   ==================== */
.btn-primary {
    background-color: #3B82F6 !important; /* Light blue button */
    border-color: #3B82F6 !important;
}

.btn-primary:hover {
    background-color: #2563EB !important; /* Slightly darker blue */
    border-color: #2563EB !important;
}

.btn-secondary {
    background-color: #4A5568 !important; /* Dark gray button */
    border-color: #4A5568 !important;
}

.btn-secondary:hover {
    background-color: #374151 !important; /* Slightly darker gray */
    border-color: #374151 !important;
}

.form-control {
    border-color: #CBD5E0 !important; /* Light gray border */
    background-color: #FFFFFF !important; /* White background */
}

.form-control:focus {
    border-color: #3B82F6 !important; /* Light blue focus */
    box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.25) !important; /* Light blue glow */
}

/* ====================
   TABLES
   ==================== */
.table thead th {
    background-color: #1E3A8A !important; /* Dark blue header */
    color: #FFFFFF !important; /* White text */
}

.table tbody tr:nth-child(even) {
    background-color: #F3F4F6 !important; /* Light gray rows */
}

.table tbody tr:hover {
    background-color: #E5E7EB !important; /* Slightly darker gray on hover */
}

/* ====================
   ALERTS
   ==================== */
.alert-success {
    background-color: #DCFCE7 !important; /* Light green */
    color: #15803D !important; /* Dark green text */
    border-color: #BBF7D0 !important; /* Border */
}

.alert-danger {
    background-color: #FEE2E2 !important; /* Light red */
    color: #B91C1C !important; /* Dark red text */
    border-color: #FDA4AF !important; /* Border */
}

.alert-warning {
    background-color: #FEF3C7 !important; /* Light yellow */
    color: #D97706 !important; /* Dark yellow text */
    border-color: #FCD34D !important; /* Border */
}

.alert-info {
    background-color: #E0F2FE !important; /* Light blue */
    color: #0891B2 !important; /* Dark blue text */
    border-color: #93C5FD !important; /* Border */
}  


/* ====================
   BRAND LOGO
   ==================== */
.brand-link {
    background-color: #1E3A8A !important; /* Biru tua */
    text-decoration: none !important;
    /* padding: 10px 15px !important; */
}

.brand-image {
    width: 40px !important;
    height: 40px !important;
    border-radius: 50% !important;
}

.brand-text {
    color: #FFFFFF !important; /* Putih */
    font-size: 18px;
    font-weight: 600;
}

/* ====================
   USER PANEL
   ==================== */

.user-panel .info a {
    color: #FFFFFF !important; /* Putih */
    font-size: 16px;
    font-weight: 500;
    text-decoration: none !important;
}

.user-panel .info a:hover {
    color: #3B82F6 !important; /* Biru muda saat hover */
}

</style>

</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed sidebar-collapse accent-navy">
<div class="wrapper">