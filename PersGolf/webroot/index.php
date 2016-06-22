<?php
/**
 * This is a Anax pagecontroller.
 *
 */

// Get environment & autoloader.
require __DIR__.'/config_with_app.php';

$app->theme->configure(ANAX_APP_PATH . 'config/theme_me.php');

$app->navbar->configure(ANAX_APP_PATH . 'config/navbar_me.php');

$di->set('CalenderController', function () use ($di) {
  $controller = new \Anax\Calender\CalenderController();
  $controller->setDI($di);
  return $controller;
});

$di->set('CourseController', function () use ($di) {
  $controller = new \Anax\Course\CourseController();
  $controller->setDI($di);
  return $controller;
});

$di->set('FirstpageController', function () use ($di) {
  $controller = new \Anax\Firstpage\FirstpageController();
  $controller->setDI($di);
  return $controller;
});

$di->set('FormController', function () use ($di) {
  $controller = new \Anax\HTMLForm\FormController();
  $controller->setDI($di);
  return $controller;
});

$di->set('LinkController', function () use ($di) {
  $controller = new \Anax\Link\LinkController();
  $controller->setDI($di);
  return $controller;
});

$di->set('OtherController', function () use ($di) {
  $controller = new \Anax\Other\OtherController();
  $controller->setDI($di);
  return $controller;
});

$di->set('ThoughtController', function () use ($di) {
  $controller = new \Anax\Thought\ThoughtController();
  $controller->setDI($di);
  return $controller;
});

$di->set('UserController', function () use ($di) {
  $controller = new \Anax\User\UserController();
  $controller->setDI($di);
  return $controller;
});

$di->setShared('db', function() use ($di) {
  $db = new \Anax\Database\CDatabaseBasic();
  $db->setOptions(require ANAX_APP_PATH . 'config/config_mysql.php');
  $db->connect();
  return $db;
});


//For the Firstpage page
$app->router->add('', function() use ($app) {
  $app->theme->addStylesheet('css/anax-grid/style.php');
  $app->dispatcher->forward([
    'controller'    => 'Firstpage',
    'action'         => 'index',
    'params'        => [],
  ]);
});

//For the Firstpage page
$app->router->add('Firstpage', function() use ($app) {
  $app->theme->addStylesheet('css/anax-grid/style.php');
  $app->dispatcher->forward([
    'controller'    => 'Firstpage',
    'action'         => 'index',
    'params'        => [],
  ]);
});

//For the Calender page
$app->router->add('Calender', function() use ($app) {
  $app->theme->addStylesheet('css/anax-grid/style.php');
  $app->dispatcher->forward([
    'controller'    => 'Calender',
    'action'         => 'index',
    'params'        => [],
  ]);
});

//For the Link page
$app->router->add('Link', function() use ($app) {
  $app->theme->addStylesheet('css/anax-grid/style.php');
  $app->dispatcher->forward([
    'controller'    => 'Link',
    'action'         => 'index',
    'params'        => [],
  ]);
});

//For the page Other
$app->router->add('Other', function() use ($app) {
  $app->theme->addStylesheet('css/anax-grid/style.php');
  $app->dispatcher->forward([
    'controller'    => 'Other',
    'action'         => 'index',
    'params'        => [],
  ]);
});

//For the Thought page
$app->router->add('Thought', function() use ($app) {
  $app->theme->addStylesheet('css/anax-grid/style.php');
  $app->dispatcher->forward([
    'controller'    => 'Thought',
    'action'         => 'index',
    'params'        => [],
  ]);
});

//For the user page
$app->router->add('User', function() use ($app) {
  $app->theme->addStylesheet('css/anax-grid/style.php');
  $app->dispatcher->forward([
    'controller'    => 'User',
    'action'         => 'index',
    'params'        => [],
  ]);
});

$app->router->handle();
$app->theme->render();
