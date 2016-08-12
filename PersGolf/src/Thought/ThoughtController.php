<?php

namespace Anax\Thought;

/**
* A controller for Thought.
*
*/
class ThoughtController implements \Anax\DI\IInjectionAware
{
  use \Anax\DI\TInjectable;

  /**
  * Initialize the controller.
  *
  * @return void
  */
  public function initialize()
  {
    $this->thoughts = new \Anax\Thought\Thought();
    $this->thoughts->setDI($this->di);
  }

  /**
  * Add new thought.
  *
  * @param string $id of thought to add.
  *
  * @return void
  */
  public function addAction($id = null)
  {
    $this->di->session();
    $this->thoughts->theme->addStylesheet('css/anax-grid/style.php');
    $isPosted = $this->request->getPost('doAddThought');

    if (!$isPosted) {
        $this->response->redirect($this->request->getPost('redirect'));
    }

    $now = new \DateTime();
    $activity = [
        'Date'     => $now->format('Y-m-d H:i:s'),
        'Category' => $this->request->getPost('category'),
        'Activity' => $this->request->getPost('activity'),
    ];

    $this->thoughts->setDI($this->di);
    $all = $this->thoughts->create($activity);
    $this->response->redirect($this->di->get('url')->create('Thought'));
  }


  /**
  * Index action.
  *
  * @return void
  */
  public function indexAction()
  {
    $this->thoughts->setDI($this->di);
    $all = $this->thoughts->findAll();
    $this->theme->setTitle("Spontana tankar");
    $this->views->add('thoughts/list-all', [
      'thoughts' => $all,
      'title' => "Spontana tankar",
    ]);

    $this->views->add('thoughts/addthought', [
      'thoughts' => $all,
      'title' => "Ny spontan tanke",
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
