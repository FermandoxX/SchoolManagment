<?php
require_once __DIR__.'/../vendor/autoload.php';

use Core\ServiceContainer;
use Core\Router;
use Core\Response;
use Core\Request;
use Core\View; 
use Core\Session;

use App\Controller\Login;
use App\Controller\Main;
use App\Controller\Users;
use App\Controller\Admin;
use App\Controller\Teacher;
use App\Controller\Classes;
use App\Controller\Grade;
use App\Controller\Subject;
use App\Controller\Student;
use App\Controller\Attendance;
use App\Controller\Teacher\TeacherStudent;
use App\Controller\Teacher\TeacherAttendance;
use App\Controller\Student\StudentTeacher;
use App\Controller\Student\StudentSubject;
use App\Controller\Student\StudentGrade;
use App\Controller\Student\StudentAttendance;


use App\Middleware\AuthMiddleware;
use App\Middleware\AdminMiddleware;
use App\Middleware\AdminTeacherMiddleware;
use App\Middleware\StudentMiddleware;
use App\Middleware\TeacherMiddleware;

GLOBAL $app;

$app = new ServiceContainer();
$app->singleton(Response::class, Response::class);
$app->singleton(Request::class, Request::class);
$app->singleton(View::class, View::class);
$app->singleton(Session::class,Session::class);

$response = $app->get(Response::class);
$request = $app->get(Request::class);
$router = $app->get(Router::class);

$router->get('/',[Login::class,'index']);
$router->post('/',[Login::class,'login']);

$router->get('/main',[Main::class,'index'],[AuthMiddleware::class]);

$router->get('/user',[Users::class,'index'],[AuthMiddleware::class]);
$router->get('/user/update/profile',[Users::class,'editProfile'],[AuthMiddleware::class]);
$router->get('/user/update/password',[Users::class,'editPassword'],[AuthMiddleware::class]);
$router->post('/user/update/profile',[Users::class,'updateProfile'],[AuthMiddleware::class]);
$router->post('/user/update/password',[Users::class,'updatePassword'],[AuthMiddleware::class]);

$router->get('/admin',[Admin::class,'index'],[AuthMiddleware::class,AdminMiddleware::class]);
$router->get('/admin/create',[Admin::class,'add'],[AuthMiddleware::class,AdminMiddleware::class]);
$router->post('/admin/create',[Admin::class,'create'],[AuthMiddleware::class,AdminMiddleware::class]);
$router->get('/admin/delete',[Admin::class,'delete'],[AuthMiddleware::class,AdminMiddleware::class]);
$router->get('/admin/profile',[Admin::class,'edit'],[AuthMiddleware::class,AdminMiddleware::class]);
$router->post('/admin/profile/update',[Admin::class,'updateProfile'],[AuthMiddleware::class,AdminMiddleware::class]);
$router->get('/admin/password',[Admin::class,'editPassword'],[AuthMiddleware::class,AdminMiddleware::class]);
$router->post('/admin/password/update',[Admin::class,'updatePassword'],[AuthMiddleware::class,AdminMiddleware::class]);

$router->get('/teacher',[Teacher::class,'index'],[AuthMiddleware::class]);
$router->get('/teacher/create',[Teacher::class,'add'],[AuthMiddleware::class,AdminMiddleware::class]);
$router->post('/teacher/create',[Teacher::class,'create'],[AuthMiddleware::class,AdminMiddleware::class]);
$router->get('/teacher/profile',[Teacher::class,'editProfile'],[AuthMiddleware::class,AdminMiddleware::class]);
$router->post('/teacher/profile/update',[Teacher::class,'updateProfile'],[AuthMiddleware::class,AdminMiddleware::class]);
$router->get('/teacher/password',[Teacher::class,'editPassword'],[AuthMiddleware::class,AdminMiddleware::class]);
$router->post('/teacher/password/update',[Teacher::class,'updatePassword'],[AuthMiddleware::class,AdminMiddleware::class]);
$router->get('/teacher/delete',[Teacher::class,'delete'],[AuthMiddleware::class,AdminMiddleware::class]);

$router->get('/student',[Student::class,'index'],[AuthMiddleware::class,AdminMiddleware::class]);
$router->get('/student/create',[Student::class,'add'],[AuthMiddleware::class,AdminMiddleware::class]);
$router->post('/student/create',[Student::class,'create'],[AuthMiddleware::class,AdminMiddleware::class]);
$router->get('/student/profile',[Student::class,'edit'],[AuthMiddleware::class,AdminMiddleware::class]);
$router->post('/student/profile/update',[Student::class,'updateProfile'],[AuthMiddleware::class,AdminMiddleware::class]);
$router->get('/student/password',[Student::class,'editPassword'],[AuthMiddleware::class,AdminMiddleware::class]);
$router->post('/student/password/update',[Student::class,'updatePassword'],[AuthMiddleware::class,AdminMiddleware::class]);
$router->get('/student/delete',[Student::class,'delete'],[AuthMiddleware::class,AdminMiddleware::class]);

$router->get('/class',[Classes::class,'index'],[AuthMiddleware::class]);
$router->post('/class',[Classes::class,'index'],[AuthMiddleware::class,AdminMiddleware::class]);
$router->get('/class/create',[Classes::class,'add'],[AuthMiddleware::class,AdminMiddleware::class]);
$router->post('/class/create',[Classes::class,'create'],[AuthMiddleware::class,AdminMiddleware::class]);
$router->get('/class/update',[Classes::class,'edit'],[AuthMiddleware::class,AdminMiddleware::class]);
$router->post('/class/update',[Classes::class,'update'],[AuthMiddleware::class,AdminMiddleware::class]);
$router->get('/class/delete',[Classes::class,'delete'],[AuthMiddleware::class,AdminMiddleware::class]);

$router->get('/subject',[Subject::class,'index'],[AuthMiddleware::class]);
$router->get('/subject/create',[Subject::class,'add'],[AuthMiddleware::class,AdminMiddleware::class]);
$router->post('/subject/create',[Subject::class,'create'],[AuthMiddleware::class,AdminMiddleware::class]);
$router->get('/subject/update',[Subject::class,'edit'],[AuthMiddleware::class,AdminMiddleware::class]);
$router->post('/subject/update',[Subject::class,'update'],[AuthMiddleware::class,AdminMiddleware::class]);
$router->get('/subject/delete',[Subject::class,'delete'],[AuthMiddleware::class,AdminMiddleware::class]);

$router->get('/grade',[Grade::class,'index'],[AuthMiddleware::class]);
$router->get('/grade/supject',[Grade::class,'subject'],[AuthMiddleware::class]);
$router->get('/grade/supject/add',[Grade::class,'add'],[AuthMiddleware::class]);
$router->post('/grade/insert',[Grade::class,'insert'],[AuthMiddleware::class,AdminTeacherMiddleware::class]);

$router->get('/attendance',[Attendance::class,'index'],[AuthMiddleware::class]);
$router->get('/attendance/subject',[Attendance::class,'attendanceSubject'],[AuthMiddleware::class]);
$router->get('/attendance/add',[Attendance::class,'addAttendance'],[AuthMiddleware::class,AdminTeacherMiddleware::class]);
$router->post('/attendance/insert',[Attendance::class,'insertAttendance'],[AuthMiddleware::class,AdminTeacherMiddleware::class]);
$router->post('/attendance/show',[Attendance::class,'showAttendance'],[AuthMiddleware::class,]);
$router->get('/attendance/remove',[Attendance::class,'removeAttendance'],[AuthMiddleware::class,AdminTeacherMiddleware::class]);
$router->get('/attendance/delete',[Attendance::class,'deleteAttendance'],[AuthMiddleware::class,AdminTeacherMiddleware::class]);

//Teacher 
$router->get('/teacher/student',[TeacherStudent::class,'index'],[TeacherMiddleware::class]);

$router->get('/teacher/attendance',[TeacherAttendance::class,'index'],[TeacherMiddleware::class,AuthMiddleware::class]);
$router->get('/teacher/attendance/subject',[TeacherAttendance::class,'attendanceSubject'],[TeacherMiddleware::class,AuthMiddleware::class]);
$router->get('/teacher/attendance/add',[TeacherAttendance::class,'addAttendance'],[TeacherMiddleware::class,AuthMiddleware::class]);
$router->get('/teacher/attendance/remove',[TeacherAttendance::class,'removeAttendance'],[TeacherMiddleware::class,AuthMiddleware::class]);
$router->get('/teacher/attendance/delete',[TeacherAttendance::class,'deleteAttendance'],[TeacherMiddleware::class,AuthMiddleware::class]);

//Student
$router->get('/student/teacher',[StudentTeacher::class,'index'],[AuthMiddleware::class,StudentMiddleware::class]);

$router->get('/student/subject',[StudentSubject::class,'index'],[AuthMiddleware::class,StudentMiddleware::class]);

$router->get('/student/grade/supject',[StudentGrade::class,'subject'],[AuthMiddleware::class,StudentMiddleware::class]);
$router->get('/student/grade/supject/add',[StudentGrade::class,'add'],[AuthMiddleware::class,StudentMiddleware::class]);

$router->get('/student/attendance',[StudentAttendance::class,'index'],[StudentMiddleware::class,AuthMiddleware::class]);
$router->get('/student/attendance/subject',[StudentAttendance::class,'attendanceSubject'],[StudentMiddleware::class,AuthMiddleware::class]);
$router->post('/student/attendance/show',[StudentAttendance::class,'showAttendance'],[StudentMiddleware::class,AuthMiddleware::class,]);

$router->run();
$response->send();

?>