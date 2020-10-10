<?php

/**
 * UserRegisterController - Controller de exemplo
 *
 * @package OdontoControl
 * @since 0.1
 */
class RegisterController extends MainController
{

  // Tipo de página int
  public $pageType = 1;

  /**
   * $login_required
   *
   * Se a página precisa de login
   *
   * @access public
   */
  //public $login_required = true;

  /**
   * $permission_required
   *
   * Permissão necessária
   *
   * @access public
   */
  //public $permission_required = 'user-register';

  /**
   * Carrega a página "/views/user-register/index.php"
   */
  public function index()
  {
    // Page title
    $this->title = 'Seja Bem-vindo';

    // Verifica se o usuário está logado
    /* if ( ! $this->logged_in ) {

          // Se não; garante o logout
          $this->logout();

          // Redireciona para a página de login
          $this->goto_login();

          // Garante que o script não vai passar daqui
          return;

          }

          // Verifica se o usuário tem a permissão para acessar essa página
          if (!$this->check_permissions($this->permission_required, $this->userdata['user_permissions'])) {

          // Exibe uma mensagem
          echo 'Você não tem permissões para acessar essa página.';

          // Finaliza aqui
          return;
          } */



    // Parametros da função
    $_parameters = (func_num_args() >= 1) ? func_get_arg(0) : [];

    // Carrega o modelo para este view
    $modelo = $this->loadModel('register/register-model');

    /** Carrega os arquivos do view * */
    // /views/_includes/header.php
    require Config::ABS_PATH . '/App/Views/_includes/header.php';

    // /views/_includes/menu.php
    require Config::ABS_PATH . '/App/Views/_includes/menu.php';

    // /views/user-register/index.php
    // require Config::ABS_PATH . '/App/Views/Register/register.php';

    Core\View::renderTemplate('/admin/register/register', ['modelo' => $modelo]);

    // /views/_includes/footer.php
    require Config::ABS_PATH . '/App/Views/_includes/footer.php';
  } // index


}// class home
