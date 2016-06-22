<?php
namespace Anax\HTMLForm;
/**
* Anax base class for wrapping sessions.
*
*/
class CFormPsWebUpdateUser extends \Anax\HTMLForm\CForm
{
  use \Anax\DI\TInjectionaware,
  \Anax\MVC\TRedirectHelpers;

  public function __construct($user=null)
  {
    /**
    * Constructor
    *
    */
    $_POST['Id']=$user->Id;
    parent::__construct([], [
      'name' => [
        'type'        => 'text',
        'class'       => 'form-control',
        'label'       => 'Namn:',
        'autofocus'   => true,
        'required'    => true,
        'validation'  => ['not_empty'],
        'value'		  => isset($user) ? $user->Username : '',
      ],

      'golfclub' => [
        'type'        => 'text',
        'class'       => 'form-control',
        'label'       => 'Golfklubb:',
        'autofocus'   => true,
        'required'    => true,
        'validation'  => ['not_empty'],
        'value'		  => isset($user) ? $user->Golfclub : '',
      ],

      'handicap' => [
        'type'        => 'text',
        'class'       => 'form-control',
        'label'       => 'Handikapp:',
        'autofocus'   => true,
        'required'    => true,
        'validation'  => ['not_empty'],
        'value'		  => isset($user) ? $user->Handicap : '',
      ],

      'uppdatera' => [
        'type'      => 'submit',
        'class'     => 'btn',
        'value'     => 'Uppdatera',
        'callback'  => [$this, 'callbackSubmit'],
      ],
    ]);
  }

  /**
  * Customise the check() method.
  *
  * @param callable $callIfSuccess handler to call if function returns true.
  * @param callable $callIfFail    handler to call if function returns true.
  */
  public function check($callIfSuccess = null, $callIfFail = null)
  {
    return parent::check([$this, 'callbackSuccess'], [$this, 'callbackFail']);
  }

  /**
  * Callback for submit-button.
  *
  * @param $form.
  */
  public function callbackSubmit()
  {
    $this->users = new \Anax\User\User();
    $this->users->setDI($this->di);
    $this->users->saveToDB([
      'Id' => $_POST['Id'],
      'Username' => $_POST['name'],
      'Golfclub' => $_POST['golfclub'],
      'Handicap' => $_POST['handicap'],
    ]);
    $this->redirectTo($this->di->get('url')->create('User'));
    return true;
  }

  /**
  * Callback What to do if the form was submitted?
  *
  * @param $form.
  */
  public function callbackSuccess()
  {
    $this->users = new \Anax\User\User();
    $this->users->setDI($this->di);
    $this->redirectTo($this->di->get('url')->create('User'));
  }

  /**
  * Callback What to do when form could not be processed?
  *
  * @param $form.
  */
  public function callbackFail()
  {
    $this->users = new \Anax\User\User();
    $this->users->setDI($this->di);
    $this->redirectTo($this->di->get('url')->create('User'));
  }
}
