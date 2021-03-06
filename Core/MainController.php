<?php

/**
 * MainController - Todos os controllers deverão estender essa classe
 *
 * @package OdontoControl
 * @since 0.1
 */
class MainController
{
    /**
     * $db
     *
     * Nossa conexão com a base de dados. Manterá o objeto PDO
     *
     * @access public
     */
    public $db;

    /**
     * $title
     *
     * Título das páginas
     *
     * @access public
     */
    public $title;

    /**
     * $login_required
     *
     * Se a página precisa de login
     *
     * @access public
     */
    public $login_required = false;

    /**
     * $permission_required
     *
     * Permissão necessária
     *
     * @access public
     */
    public $permission_required = 'any';

    /**
     * $_parameters
     *
     * @access public
     */
    public $_parameters = [];

    /**
     * Construtor da classe
     *
     * Configura as propriedades e métodos da classe.
     *
     * @since 0.1
     * @access public
     */
    public function __construct($_parameters = [])
    {

        // Instancia do DB
        $this->db = new SystemDB();

        // Parâmetros
        $this->_parameters = $_parameters;

    }

    /**
     * Load model
     *
     * Carrega os modelos presentes na pasta /models/.
     *
     * @since 0.1
     * @access public
     */
    function loadModel($model_name = false)
    {
        // Um arquivo deverá ser enviado
        if (!$model_name) return;

        // Garante que o nome do modelo tenha letras minúsculas
        //$model_name =  strtolower( $model_name );

        // Inclui o arquivo
        $model_path = Config::ABS_PATH . '/App/Models/' . $model_name . '.php';


        // Verifica se o arquivo existe
        if (file_exists($model_path)) {
            # Inclui o arquivo
            require_once $model_path;

            # Remove os caminhos do arquivo (se tiver algum)
            $model_name = explode('/', $model_name);

            # Pega só o nome final do caminho
            $model_name = end($model_name);

            # Remove caracteres inválidos do nome do arquivo
            $model_name = preg_replace('/[^a-zA-Z0-9]/is', '', $model_name);

            # Verifica se a classe existe
            if (class_exists($model_name)) {
                # Retorna um objeto da classe
                return new $model_name($this->db, $this);
            }

            // The end :)
            return;
        }
    } // Fim :) load_model
} // Fim :) class MainController