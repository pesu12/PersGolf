<?php

namespace Anax\Other;

/**
* A controller for Other.
*
*/
class OtherController implements \Anax\DI\IInjectionAware
{
  use \Anax\DI\TInjectable;

  /**
  * Initialize the controller.
  *
  * @return void
  */
  public function initialize()
  {
    $this->others = new \Anax\Other\Other();
    $this->others->setDI($this->di);
  }

  /**
  * Add new other.
  *
  * @param string $id of other.
  *
  * @return void
  */
  public function addAction($id = null)
  {
    $this->di->session();
    $this->others->theme->addStylesheet('css/anax-grid/style.php');
    $isPosted = $this->request->getPost('doAddOther');

    if (!$isPosted) {
        $this->response->redirect($this->request->getPost('redirect'));
    }

    $activity = [
        'Other' => $this->request->getPost('other'),
    ];

    $this->others->setDI($this->di);
    $all = $this->others->create($activity);
    $this->response->redirect($this->di->get('url')->create('Other'));
  }


  /**
  * Index action.
  *
  * @return void
  */
  public function indexAction()
  {
    $this->others->setDI($this->di);
    $all = $this->others->findAll();
    $this->theme->setTitle("Övrigt");
    $this->views->add('others/list-all', [
      'others' => $all,
      'title' => "Övrigt",
    ]);

    $this->views->add('others/addother', [
      'others' => $all,
      'title' => "Ny övrig aktivitet",
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
