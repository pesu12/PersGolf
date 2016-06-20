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
  * Display user details.
  *
  * @param integer $id of user to display delete for.
  *
  * @param string $User id
  *
  * @return void
  */

  public function displayuserAction($id = null)
  {

        $users=$this->users->findAll();
        $this->users->setDI($this->di);
        $this->users->theme->addStylesheet('css/anax-grid/style.php');
        $user = $this->users->find($id);
        $this->theme->setTitle("Användare");
        $this->views->add('users/viewuser', [
          'id' => $id,
          'user' => $user,
          'title' => "Användare",
        ]);

        $this->users->setDI($this->di);
        $this->views->add('users/viewuserupdatelink', [
          'id' => $id,
          'title' => "",
        ]);

        $this->users->setDI($this->di);
        $all = $this->users->findQuestionsForUser($id);
        $this->theme->setTitle("Ställda frågor av användare");
        $this->views->add('users/viewuserquestions', [
          'questions' => $all,
          'title' => "Ställda frågor av användaren",
        ]);
        $this->users->setDI($this->di);
        $this->views->add('users/viewaddquestionlink', [
          'id' => $id,
          'title' => "",
        ]);

        $this->di->views->add('questions/viewtitle', [
          'title' => "Besvarade frågor av användare"
        ]);

        $this->users->setDI($this->di);
        $allresponses = $this->users->findResponsesForUser($id);
        $this->theme->setTitle("Mina svar");
        foreach ($allresponses as $response) :
          $questionId = $this->users->findRequestForResponse($response->Id);
          $this->views->add('users/viewuserresponses', [
            'response' => $response,
            'questionid' => $questionId->Questionid,
            'title' => "",
          ]);
        endforeach;

        $this->di->views->add('users/viewlogoutlink', [
          'title' => ""
        ]);
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
  * Get ussr to update.
  *
  * @return void
  */
  public function updateAction()
  {
    $this->users->theme->addStylesheet('css/anax-grid/style.php');
    $users = new \Anax\MVC\CUserModel();
    $users->setDI($this->di);
    $user = $this->users->find(1);
    $form = new \Anax\HTMLForm\CFormPsWebUpdateUser($user);
    $form->setDI($this->di);
    $form->check();

    $this->di->views->add('questions/viewtitle', [
      'title' => "Uppdatera användare"
    ]);

    $this->di->views->add('default/page', [
      'title' => "",
      'content' => $form->getHTML()
    ]);

    $this->di->views->add('users/notupdatepassword', [
      'title' => ""
    ]);
  }

  /**
  * Save an editid user.
  *
  * @param $id with user id number.
  *
  * @return void
  */
  public function saveEditAction($id)
  {
    $isPosted = $this->request->getPost('doSaveEdit');

    if (!$isPosted) {
      $this->response->redirect($this->request->getPost('redirect'));
    }

    $users = new \Anax\MVC\CUserModel();
    $users->setDI($this->di);

    $editedUser = [
      'Id' => $id,
      'Username'      => $this->request->getPost('Username'),
      'Acronym'       => $this->request->getPost('Acronym'),
      'Email'      => $this->request->getPost('Email'),
      'Userpassword'      => 'test',
    ];

    $users->update($editedUser);
    $this->response->redirect($this->request->getPost('redirect'));
  }


  /**
  * List all users.
  *
  * @param string $id user id.
  *
  * @return void
  */
  public function listAction($id=null)
  {
    if($id==null) {
      $all = $this->users->findAll();
      $this->theme->setTitle("List Activated users");
      $this->views->add('users/list-all', [
        'users' => $all,
        'title' => "Users List Menu",
      ]);
    }
    else{
      $user = $this->users->find($id);
      $this->theme->setTitle("List Details for a user");
      $this->views->add('users/view', [
        'user' => $user,
        'title' => "Users List Menu",
      ]);
    }
  }

  /**
  * List user with id, questions and responses.
  *
  * @param int $id of user to display
  *
  * @return void
  */
  public function idAction($id = null)
  {
    $this->users->setDI($this->di);
    $this->users->theme->addStylesheet('css/anax-grid/style.php');
    $user = $this->users->find($id);
    $this->theme->setTitle("Användare");
    $this->views->add('users/viewuser', [
      'id' => $id,
      'user' => $user,
      'title' => "Användare",
    ]);

    $loggedIn=$this->users->checkIfLoggedIn($id);
    if ($loggedIn) {

       $this->users->setDI($this->di);
       $this->views->add('users/viewuserupdatelink', [
         'id' => $id,
         'title' => "",
       ]);
       $this->di->views->add('questions/viewaddquestionlink', [
        'id' => $id,
       ]);
    }

    $this->users->setDI($this->di);
    $all = $this->users->findQuestionsForUser($id);
    $this->theme->setTitle("Ställda Frågor");
    $this->views->add('users/viewuserquestions', [
      'questions' => $all,
      'title' => "Ställda Frågor",
    ]);

    $this->users->setDI($this->di);
    $allresponses = $this->users->findResponsesForUser($id);

    $this->di->views->add('users/viewtitle', [
      'title' => "Gjorda svar"
    ]);

    foreach ($allresponses as $response) :
      $questionId = $this->users->findRequestForResponse($response->Id);
      $this->views->add('users/viewuserresponses', [
        'response' => $response,
        'questionid' => $questionId->Questionid,
        'title' => "",
      ]);
    endforeach;
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
  }
}
