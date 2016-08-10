<?php

namespace Anax\Link;

/**
* A controller for Link.
*
*/
class LinkController implements \Anax\DI\IInjectionAware
{
  use \Anax\DI\TInjectable;

  /**
  * Initialize the controller.
  *
  * @return void
  */
  public function initialize()
  {
    $this->links = new \Anax\Link\Link();
    $this->links->setDI($this->di);
  }

  /**
  * Add new link.
  *
  * @param string $id of link to add.
  *
  * @return void
  */
  public function addAction($id = null)
  {
    $this->di->session();
    $this->links->theme->addStylesheet('css/anax-grid/style.php');
    $isPosted = $this->request->getPost('doAddLink');

    if (!$isPosted) {
        $this->response->redirect($this->request->getPost('redirect'));
    }

    $activity = [
        'Link' => $this->request->getPost('link'),
        'Description' => $this->request->getPost('description'),
    ];

    $this->links->setDI($this->di);
    $all = $this->links->create($activity);
    $this->response->redirect($this->di->get('url')->create('Link'));
  }


  /**
  * Index action.
  *
  * @return void
  */
  public function indexAction()
  {
    $this->links->setDI($this->di);
    $all = $this->links->findAll();
    $this->theme->setTitle("Länkar");
    $this->views->add('links/list-all', [
      'links' => $all,
      'title' => "Länkar",
    ]);

    $this->views->add('links/addlink', [
      'links' => $all,
      'title' => "Ny länk",
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
