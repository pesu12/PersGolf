<?php
/**
 * This is a Anax pagecontroller.
 *
 */

// Get environment & autoloader.
require __DIR__.'/config_with_app.php';

$app->theme->configure(ANAX_APP_PATH . 'config/theme_me.php');

$app->navbar->configure(ANAX_APP_PATH . 'config/navbar_me.php');

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


$app->router->add('', function() use ($app) {

  $app->theme->addStylesheet('css/anax-grid/style.php');
  $content = $app->fileContent->get('me.md');
  $content = $app->textFilter->doFilter($content, 'shortcode, markdown');

  $byline = $app->fileContent->get('byline.md');
  $byline = $app->textFilter->doFilter($byline, 'shortcode, markdown');

  $app->views->add('me/page', [
      'content' => $content,
      'byline' => $byline,
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
