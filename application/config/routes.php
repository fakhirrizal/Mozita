<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'Login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['logout'] = 'Login/logout';

$route['data-user'] = 'Data_user';
$route['pengaturan-propinsi'] = 'Data_propinsi';

$route['data-puskesmas'] = 'Puskesmas';
$route['tambah-data-puskesmas'] = 'Puskesmas/form';
$route['detail-puskesmas/(:any)'] = 'Puskesmas/form/$1';

$route['data-posyandu'] = 'Posyandu';
$route['tambah-data-posyandu'] = 'Posyandu/form';
$route['detail-data-posyandu/(:any)'] = 'Posyandu/form/$1';


$route['data-balita'] = 'Balita';
$route['tambah-data-balita'] = 'Balita/form';
$route['detail-data-balita/(:any)'] = 'Balita/form/$1';
$route['lokasi_balita/(:any)'] = 'Balita/lokasi_balita/$1';

$route['penimbangan'] = 'Penimbangan';
$route['tambah-penimbangan'] = 'Penimbangan/form';
$route['detail-penimbangan/(:any)/(:any)'] = 'Penimbangan/form/$1/$2';

$route['balita-gizi-buruk'] = 'Status_gizi/home/balita-gizi-buruk';
$route['balita-stunting'] = 'Status_gizi/home/balita-stunting';
$route['balita-bb-tb-atau-bb-pb'] = 'Status_gizi/home/bb-tb-bb-pb';
$route['balita-imt-u'] = 'Status_gizi/home/imt_u';
$route['detail-balita-gizi-buruk/(:any)/(:any)'] = 'Status_gizi/form/gizi_buruk/$1/$2';
$route['detail-balita-stunting/(:any)/(:any)'] = 'Status_gizi/form/stunting/$1/$2';
$route['detail-balita-bb-tb-atau-bb-pb/(:any)/(:any)'] = 'Status_gizi/form/bb_tb_bb_pb/$1/$2';
$route['detail-balita-imt-u/(:any)/(:any)'] = 'Status_gizi/form/imt_u/$1/$2';

$route['laporan-penimbangan'] = 'Laporan';

$route['perkembangan-balita'] = 'Perkembangan_balita';

$route['profil'] = 'Profil';
$route['ganti-kata-sandi'] = 'Profil/form_ubah_pass';



