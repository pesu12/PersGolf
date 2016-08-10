<?php

namespace Anax\Calender;

/**
* A controller for Calender.
*
*/
class CalenderController implements \Anax\DI\IInjectionAware
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
  }

  /**
  * Add new activity for calender.
  *
  * @param string $id of calender activity to add.
  *
  * @return void
  */
  public function addAction($id = null)
  {
    $this->di->session();
    $this->calenders->theme->addStylesheet('css/anax-grid/style.php');
    $isPosted = $this->request->getPost('doAddCalender');

    if (!$isPosted) {
        $this->response->redirect($this->request->getPost('redirect'));
    }

    $now = new \DateTime();
    $activity = [
        'Date'     => $now->format('Y-m-d H:i:s'),
        'activity' => $this->request->getPost('activity'),
    ];

    $this->calenders->setDI($this->di);
    $all = $this->calenders->create($activity);
    $this->response->redirect($this->di->get('url')->create('Calender'));
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

    $this->views->add('calenders/addcalender', [
      'calenders' => $all,
      'title' => "Ny aktivitet",
    ]);

    //Sidebar
    $this->links = new \Anax\Link\Link();
    $this->links->setDI($this->di);

    $all = $this->links->findAll();
    $this->theme->setTitle("Länkar");
    $this->views->add('links/list-all', [
      'links' => $all,
      'title' => "Länkar",
    ],'sidebar');
  }
}
