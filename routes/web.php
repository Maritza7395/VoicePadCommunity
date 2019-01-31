<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');


Route::get('/register/verify/{code}', 'Auth\RegisterController@verify');
Route::get('policy/cookies','PolicyController@cookies');
Route::get('policy/termsconditions','PolicyController@conditions');
Route::get('categorias/Data','CategoriesController@indexData');
Route::get('generos/Data','GenreController@indexData');
Route::get('follows/followers/{id}','FollowsController@indexFollowers');
Route::get('follows/followed/{id}','FollowsController@indexFollowed');
Route::get('usuarios/Data/{id}','UsersController@showData');
Route::get('usuarios/{usuarios}','UsersController@show')->name('usuarios.show');
Route::get('Data/usuarios','UsersController@indexData')->name('usuarios.indexData');
Route::get('home','HomeController@indexData');
Route::get('/', 'HomeController@index')->name('home');
Route::get('motivos-texto/Data','MotivationTextsController@indexData');
Route::get('motivos-usuario/Data','MotivationUsersController@indexData');

Route::post('search','SearchFiltersController@filter');
Route::get('search/Data','SearchFiltersController@indexData');
Route::get('search','SearchFiltersController@index')->name('search.index');
Route::get('search/{data}','SearchFiltersController@show');

Route::get('summernote/{summernote}','SummernoteController@show')->name('summernote.show');//Ver informacion general del texto Vista
Route::get('summernote/Data/Comment/{summernote}', 'SummernoteController@showDataComment'); //comentarios y mas del libro
Route::get('summernote/Data/{summernote}', 'SummernoteController@showData'); //comentarios y mas del libro
Route::get('summernotes/Data/{id}','SummernoteController@indexData'); //libros del usuario

Route::get('favoritos/{id}','SummernoteFavoritesController@index');//libros favoritos del usuario


///////////-------------------------------------------------------------------------/////////////////////////

Auth::routes();

//Confirmacion de Email
// Route::get('/register/verify/{code}', 'Auth\RegisterController@verify');
Route::group(['middleware' => ['auth']], function () {	
	Route::get('/cambiarPassword','UsersController@showChangePasswordForm');
	Route::post('/cambiarPassword','UsersController@changePassword')->name('changePassword');
	Route::get('/editarPerfil','UsersController@edit');
	Route::post('/editarPerfil','UsersController@update')->name('editUser');

	Route::resource('notificaciones', 'NotificationsController');
	Route::get('notificaciones/unread/data', 'NotificationsController@unreadNotificationsData');
	Route::get('notificaciones/read/data', 'NotificationsController@readNotificationsData');
	Route::patch('notificaciones/{id}/leer','NotificationsController@readNotification');

	
	Route::post('send_mail_verify','Auth\RegisterController@send_mail_verify')->name('register.send_mail_verify');
	Route::get('/usuarioAutenticado','UsersController@userAuth');
	Route::get('complaintUsers/isComplaint/{id}','ComplaintUsersController@isComplaintAuth');//verifica si es denunciado
	Route::group(['middleware' => ['checkRoleAuthor']], function () {
		Route::post('complaintUsers','ComplaintUsersController@store');//denuncia
		Route::resource('/comentarios','CommentsController');//Comentarios
		Route::resource('/comentarios_respuesta','CommentResponseController');//Comentarios Respuesta

		Route::post('follows','FollowsController@store');
		Route::post('follows/cancel','FollowsController@destroy');
		Route::get('follows/isFollow/{id}','FollowsController@isFollow');

		Route::post('resetValues','CommandsController@resetValues');
		Route::post('comandos/user','CommandsController@store_user');
		Route::get('comandos/Data','CommandsController@indexData');

		Route::post('complaintSummernotes','ComplaintSummernotesController@store');
		Route::get('complaintSummernotes/verify/{id}','ComplaintSummernotesController@isComplaintAuth');

		Route::get('/summernote/{summernote}/leer/','SummernoteController@showContent')->name('summernote.showContent'); //lee Libro
		Route::get('summernote/{summernote}/Data/leer', 'SummernoteController@showContentData');
		Route::get('summernote_create','SummernoteController@create')->name('summernote.create'); //Vista para crear un libro
		Route::post('summernote','SummernoteController@store')->name('summernote.store'); //Guarda un nuevo libro
		Route::get('summernote/{summernote}/edit','SummernoteController@edit')->name('summernote.edit');//Vista de edicion de texto
		Route::put('summernote/{summernote}','SummernoteController@update')->name('summernote.update');//Actualizacion del Libro
		Route::get('summernoteCategorias/{id}','SummernoteController@categoriesSummernote'); //carga las categorias del libro
		Route::delete('summernote/{id}','SummernoteController@destroy');//elimina el libro
		Route::post('/publicarSummernote','SummernoteController@summernotePrivate');//pone el libro es publico o privado
		Route::post('statusSummernote','SummernoteController@summernoteStatus');//cambia estado del libro
		Route::get('/MisObras','SummernoteController@indexForUser')->name('summernote.indexForUser'); //libros por usuario

		Route::post('/calificacion','SummernoteScoreController@store');
		Route::get('/calificacion/{id}','SummernoteScoreController@show');

		

		Route::post('paper','PaperController@store');
		Route::delete('paper/{id}','PaperController@destroy');
		Route::put('paper/{id}','PaperController@update');
		Route::get('summernote/{id}/edit/content','PaperController@edit');
		Route::get('paper/{id}','PaperController@show');//No se esta ultilizando aun

		Route::post('favoritos','SummernoteFavoritesController@store');
		Route::post('favoritos/cancel','SummernoteFavoritesController@destroy');
		Route::get('favoritos/{id}/show','SummernoteFavoritesController@show'); //verifica si es favorito o no

		Route::get('exportPdf/{idSummernote}' , 'ExportsController@pdf')->name('exports.pdf');	
	});
	Route::group(['middleware' => ['checkRoleAdmin']], function () {	
		Route::post('alerts','AlertController@store');	
		Route::delete('usuarios/{id}','UsersController@destroy');
		
		Route::post('complaintSummernotes/Denied','ComplaintSummernotesController@denied');
		Route::post('complaintSummernotes/Plagiarism','ComplaintSummernotesController@acceptPlagiarism');
		Route::post('complaintSummernotes/Genre','ComplaintSummernotesController@acceptGenre');
		Route::post('complaintSummernotes/Adult','ComplaintSummernotesController@acceptAdult');
	}); 
	Route::group(['middleware' => ['auth','checkRoleSuperUser']], function () {
		Route::get('complaintUsers','ComplaintUsersController@index')->name('complaintUsers.index');//lista de denuncias
		Route::post('complaintUsers/Data','ComplaintUsersController@indexData'); //lista de denuncias
		Route::get('complaintUsers/Data/{id}','ComplaintUsersController@showData'); // denuncias que tiene un usuario
		Route::get('complaintUsers/{id}','ComplaintUsersController@show');// denuncias que tiene un usuario

		Route::post('follows/reports','FollowsController@index');//filtrados

		Route::post('usuarios/reports','UsersController@reports');
		Route::post('usuarios/reportsSummernotes','UsersController@reportsSummernotes');
		Route::get('/añadirfotoDefault','UsersController@addProfileDefaultShow');
		Route::post('/añadirfotoDefault','UsersController@submitProfile')->name('addProfileDefault');

		Route::get('usuarios','UsersController@index')->name('usuarios.index');
		Route::get('alerts/user/{user_id}','AlertController@index_user');	

		Route::get('administradores','AdministratorController@index')->name('administradores.index');
		Route::get('administradores/Data','AdministratorController@indexData');
		Route::delete('administradores/{id}','AdministratorController@destroy');
		Route::put('administradores/{id}','AdministratorController@update');	
		Route::post('sendEmail','AdministratorController@sendEmail');
		Route::post('administradores','AdministratorController@store');

		////////////MANTENEDORES
		Route::resource('categorias','CategoriesController');
		Route::post('categorias/report','CategoriesController@report');

		Route::resource('generos','GenreController');
		Route::post('generos/report','GenreController@report');
		Route::resource('/comandos','CommandsController');

		Route::resource('motivos-texto','MotivationTextsController');
		Route::resource('motivos-usuario','MotivationUsersController');

		/////////DENUNCIAS
		Route::get('complaintSummernotes','ComplaintSummernotesController@index')->name('complaintSummernotes.index');
		Route::get('complaintSummernotes/{id}','ComplaintSummernotesController@show');
		Route::post('complaintSummernotes/Data','ComplaintSummernotesController@indexData');
		Route::get('complaintSummernotes/Data/{id}','ComplaintSummernotesController@showData');
		//rEPORTES
		Route::get('summernote','SummernoteController@index')->name('summernote.index'); //todos los libros y generacion de reportes
		Route::post('views/report','SummernoteController@viewsSummernote');//cuenta las visitas de cada libro parametrisable 
		Route::post('/calificacion/report','SummernoteScoreController@index');
		Route::post('paper/report','PaperController@index');
		Route::post('favoritos/report','SummernoteFavoritesController@report');
		//EXCEL
		Route::post('excel/complaint/users/reports','ExportsController@excelComplaintUsers');
		Route::post('excel/complaint/summernotes/reports','ExportsController@excelComplaintSummernotes');
		Route::post('excel/genres/reports','ExportsController@excelGenres');
		Route::post('excel/categories/reports','ExportsController@excelCategories');
		Route::post('excel/user/reports','ExportsController@excelUser');
		Route::post('excel/summernote/reports','ExportsController@excelSummernote');
		Route::get('excel/reports/{nameExcel}','ExportsController@excelDownload');	
	});
});


