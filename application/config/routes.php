<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'beranda';
$route['dashboard'] = 'beranda';
$route['manager-dashboard'] = 'beranda/dsbmng';
$route['operator-dashboard'] = 'beranda/dsbopt';
$route['404_override'] = 'Notfounde';
$route['translate_uri_dashes'] = FALSE;
$route['upload-image'] = 'Upload_image';
$route['store-image'] = 'Upload_image/produk_upload';
$route['daftar'] = 'beranda/daftar';
$route['registrasi-sukses'] = 'beranda/sukses';
$route['error-register'] = 'beranda/errros';
$route['stok-gudang'] = 'stok/gudang';
$route['data-non-ori'] = 'datanon/pertama';
$route['data-non-ori/bp'] = 'datanon/kedua';
$route['data-non-ori/bc'] = 'datanon/ketiga';
$route['data-non-ori/aval'] = 'datanon/keempat';
// new route akses halaman
$route['report-produksi'] = 'adm/rproduksi';
$route['report-stok'] = 'adm/rstok';
$route['report-stok-lama'] = 'adm/rstoklama';
$route['report-penjualan'] = 'adm/rpenjualan';
$route['manage-user'] = 'adm/mnguser';
$route['log-aktivitas'] = 'adm/logactv';
$route['input-konstruksi'] = 'inputt/konstruksi';
$route['settings-konstruksi'] = 'inputt/setkonstruksi';
$route['input-produksi'] = 'inputt/produksi';
$route['pengiriman'] = 'inputt/produksikirim';
$route['input-penjualan'] = 'inputt/penjualan';
$route['input-penjualan-list'] = 'inputt/tes';
$route['produksi-mesin'] = 'inputt/promesin';
$route['data-konsumen'] = 'inputt/konsumen';
$route['input-produksi-inspect'] = 'inputt/inputif';
$route['input-produksi-folding'] = 'inputt/inputfol';
$route['input-produksi-insgrey'] = 'inputt/inputgrey';
$route['proses-produksi'] = 'inputt/proses_produksi';
$route['generate-kode'] = 'beranda/generatekode';
$route['generate-kode/(:num)'] = 'beranda/generatekode/$1';
$route['packing-list'] = 'beranda/pkglist';
$route['create-packing-list'] = 'inputt/create_pkg';
$route['track-packing-list'] = 'beranda/pkg_pengiriman';
$route['insert-data-list'] = 'inputt/insert_pkg';
$route['surat-jalan'] = 'kirim/srt_jalan';
$route['pagedireksi'] = 'laporan/direksi';
$route['report-dashboard'] = 'laporan/dasboarddireksi';
$route['data-roll'] = 'data/rollkain';
$route['find-code'] = 'data/find';
$route['tracking-produksi'] = 'reverse/showproduksi';
$route['cek-produksi'] = 'reload/cekupload';
$route['report-wa'] = 'laporan/dashboardwa';
$route['report-wa2'] = 'laporan/dashboardwa2';
$route['nota-penjualan'] = 'nota';
$route['insgrey'] = 'users/insgrey';
$route['produksi-insgrey/(:any)'] = 'produksistx/insgrey/$1';
$route['produksi-folgrey/(:any)'] = 'produksistx/folgrey/$1';
$route['produksi-folfinish/(:any)'] = 'produksistx/folfinish/$1';
$route['produksi-insfinish/(:any)'] = 'produksistx/insfinish/$1'; 
$route['rekap-piutang'] = 'beranda/rekappiutang';
$route['saldo-piutang'] = 'beranda/saldopiutang';
$route['report-penjualan'] = 'beranda/rekappenjualan';
$route['all-dashboard'] = 'alldashboard';
$route['dash-manager'] = 'alldashboard/halamanutama';
$route['penjualan-grey'] = 'alldashboard/penjualangrey';
$route['log/produksi/if/(:any)/(:any)'] = 'block/logopt'; 
$route['log/produksi/fol/(:any)/(:any)'] = 'block/logopt';
$route['input-nonori'] = 'databs/newbs';
/*
| -------------------------------------------------------------------------
| Sample REST API Routes
| -------------------------------------------------------------------------
*/

$route['api/example/users/(:num)'] = 'api/example/users/id/$1'; // Example 4
$route['api/get_data/(:num)/(:num)'] = 'ApiController/get_data/$1/$2';
$route['api/example/users/(:num)(\.)([a-zA-Z0-9_-]+)(.*)'] = 'api/example/users/id/$1/format/$3$4'; // Example 8
