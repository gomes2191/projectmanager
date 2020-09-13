<?php

/**
 * LoginController - Controller de exemplo
 *
 * @package OdontoControl
 * @since 0.1
 */
class LoginController extends MainController
{

	/**
	 * Carrega a página "/views/login/index.php"
	 */
	public function index()
	{
		// Título da página
		$this->title = 'Login';

		// Parametros da função
		$_parameters = (func_num_args() >= 1) ? func_get_arg(0) : array();

		// Login não tem Model

		/** Carrega os arquivos do view **/

		// /views/_includes/header.php
		require Config::HOME_URI . '/views/_includes/header.php';

		// /views/_includes/menu.php
		require Config::HOME_URI . '/views/_includes/menu.php';

		// /views/home/login-view.php
		require Config::HOME_URI . '/views/login/login-view.php';

		// /views/_includes/footer.php
		require Config::HOME_URI . '/views/_includes/footer.php';
	} // index

} // class LoginController