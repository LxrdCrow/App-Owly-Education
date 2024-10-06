<?php

require_once '../controllers/CourseController.php';
require_once '../controllers/SubjectController.php';
require_once '../core/router.php'; 

$router = new Router();  


$router->get('/courses', 'CourseController@index');
$router->post('/courses', 'CourseController@store');
$router->put('/courses/{id}', 'CourseController@update');
$router->delete('/courses/{id}', 'CourseController@destroy');


$router->get('/subjects', 'SubjectController@index');
$router->post('/subjects', 'SubjectController@store');
$router->put('/subjects/{id}', 'SubjectController@update');
$router->delete('/subjects/{id}', 'SubjectController@destroy');

?>