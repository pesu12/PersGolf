<?php

namespace Anax\Course;

/**
* A controller for Course.
*
*/
class CourseController implements \Anax\DI\IInjectionAware
{
  use \Anax\DI\TInjectable;

  /**
  * Initialize the controller.
  *
  * @return void
  */
  public function initialize()
  {
    $this->courses = new \Anax\Course\Course();
    $this->courses->setDI($this->di);
  }

  /**
  * Add new activity for course.
  *
  * @param string $id of course activity to add.
  *
  * @return void
  */
  public function addAction($id = null)
  {
    $this->di->session();
    $this->courses->theme->addStylesheet('css/anax-grid/style.php');
    $isPosted = $this->request->getPost('doAddCourse');

    if (!$isPosted) {
        $this->response->redirect($this->request->getPost('redirect'));
    }

    $now = new \DateTime();
    $activity = [
        'Date'     => $now->format('Y-m-d H:i:s'),
        'Course' => $this->request->getPost('course'),
        'Information' => $this->request->getPost('information'),
    ];

    $this->courses->setDI($this->di);
    $all = $this->courses->create($activity);
    $this->response->redirect($this->di->get('url')->create('Course'));
  }

  /**
  * Index action.
  *
  * @return void
  */
  public function indexAction()
  {
    $this->courses->setDI($this->di);
    $all = $this->courses->findAll();
    $this->theme->setTitle("Spelade banor");
    $this->views->add('courses/list-all', [
      'courses' => $all,
      'title' => "Spelade banor",
    ]);

    $this->views->add('courses/addcourse', [
      'courses' => $all,
      'title' => "Ny bana",
    ]);

    //Sidebar
    $this->links = new \Anax\Link\Link();
    $this->links->setDI($this->di);

    $all = $this->links->findAll();
    $this->theme->setTitle("Länkar");
    $this->views->add('links/sidebar-links', [
      'links' => $all,
      'title' => "Länkar",
    ],'sidebar');
  }
}
