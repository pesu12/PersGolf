<?php

namespace Anax\Firstpage;

/**
* A controller for Firstpage.
*
*/
class FirstpageController implements \Anax\DI\IInjectionAware
{
  use \Anax\DI\TInjectable;

  /**
  * Initialize the controller.
  *
  * @return void
  */
  public function initialize()
  {
    $this->calenders = new \Anax\Calender\Calender();
    $this->calenders->setDI($this->di);

    $this->thoughts = new \Anax\Thought\Thought();
    $this->thoughts->setDI($this->di);

    $this->courses = new \Anax\Course\Course();
    $this->courses->setDI($this->di);
  }

  /**
  * Index action.
  *
  * @return void
  */
  public function indexAction()
  {
    $this->calenders->setDI($this->di);
    $all = $this->calenders->findAll();
    $this->theme->setTitle("Kalenderaktiviteter");
    $this->views->add('calenders/list-all', [
      'calenders' => $all,
      'title' => "Kalenderaktiviteter",
    ]);

    $this->thoughts->setDI($this->di);
    $all = $this->thoughts->findAll();
    $this->theme->setTitle("Spontana tankar");
    $this->views->add('thoughts/list-all', [
      'thoughts' => $all,
      'title' => "Spontana tankar",
    ]);

    $this->courses->setDI($this->di);
    $all = $this->courses->findAll();
    $this->theme->setTitle("Spelade banor");
    $this->views->add('courses/list-all', [
      'courses' => $all,
      'title' => "Spelade banor",
    ]);
  }
}
