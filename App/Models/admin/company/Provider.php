<?php

/**
 *  @Autor: F.A.G.A <gomes.tisystem@gmail.com>
 *  @Class: FeesModel
 *  @Descrição: Classe responsavel por toda intereção com a base de dados e validações
 *
 *  @Pacote: OdontoControl
 *  @Versão: 0.2
 */
class Provider extends MainModel
{

    /**
     * $form_data
     *
     * @Descrição: Armazena os dados recebido do post.
     *
     * @Acesso: public
     */
    public $form_data;

    /**
     * $form_msg
     *
     * @Descrição: As mensagens de feedback para o usuário.
     *
     * @Acesso: public
     */
    public $form_msg;

    /**
     * $db
     *
     * @Descrição: O objeto da nossa conexão PDO
     *
     * @Acesso: public
     */
    public $db;

    public $global;

    // Responsável por armazenar os dados do formulário.
    private $formData = [];

    /**
     *
     *
     * @Descrição: Construtor, carrega  o DB.
     *
     * @since 0.1
     * @access public
     */
    public function __construct($db = null)
    {
        $this->db = $db;
    }

    /**
     *   @Acesso: public
     *   @Autor: Gomes - F.A.G.A <gomes.tisystem@gmail.com>
     *   @Função: validate_register_form()
     *   @Versão: 0.2
     *   @Descrição: Método que trata o fromulário, verifica o tipo de dados passado e executa as validações necessarias.
     *   @Obs: Este método pode inserir ou atualizar dados dependendo do tipo de requisição solicitada pelo usuário.
     **/
    public function formValidation()
    {
        try {
            # Verifica se não é vazio o $_POST
            if ((filter_input(INPUT_SERVER, 'REQUEST_METHOD', FILTER_DEFAULT) === 'POST') && (!empty(filter_input_array(INPUT_POST, FILTER_DEFAULT)))) {

                // Faz o loop dos dados do formulário inserindo os no vetor $form_data.
                foreach (filter_input_array(INPUT_POST, FILTER_DEFAULT) as $key => $value) {
                    # Configura os dados do post para a propriedade $form_data
                    $this->formData[$key] = $value;
                } // End foreach

                // Verifica se existe o ID e decodifica se o mesmo existir.
                if (!empty($this->formData['id'])) {
                    $this->formData['id'] = GFunc::encodeDecode(0, $this->formData['id']);
                }
            } else {
                // Finaliza a execução e retorna o erro.
                throw new Exception("Requisição post não declarada ou campos vázios.");
            } #--> End

        } catch (Exception $e) {

            echo 'Erro: ' . $e->getMessage();
        }

        // Verifica se o registro já existe.
        $checkReg = $this->db->query(' SELECT count(*) FROM `Providers` WHERE `id` = ? ', [
            GFunc::chkArray($this->formData, 'id')
        ]);

        // Verefica qual tipo de ação a ser tomada se existe ID faz Update se não existir efetua o insert
        if (($checkReg->fetchColumn()) >= 1) {
            $this->updateRegister($this->formData['id']);
        } else {
            //var_dump($this->form_data);die;
            $this->insertRegister();
        }
    } //--> End formValidation()

    /**
     * Faz a inserção do registro no BD.
     * Obs.: se houver erro na inserção o valor "1" será retornado.
     *
     * @param int $lastId - valor do tipo inteiro.
     *
     * @return bool Retorna um valor boleano (true ou false).
     */
    public function insertRegister()
    {
        //var_dump($this->convertDataHora('d/m/Y', 'Y-m-d',$this->avaliar(chkArray($this->form_data, 'provider_date_provider'))));die;
        # Se o ID do agendamento estiver vazio, insere os dados
        $lastId = (int) $this->db->insert('Providers', [
            'name'              =>  GFunc::chkArray($this->formData,     'name'),
            'cpf_cnpj'          =>  GFunc::chkArray($this->formData,     'cpf_cnpj'),
            'razao_social'      =>  GFunc::chkArray($this->formData,     'razao_social'),
            'occupation_area'   =>  GFunc::chkArray($this->formData,     'occupation_area'),
            'insc_uf'           =>  GFunc::chkArray($this->formData,     'insc_uf'),
            'web_url'           =>  GFunc::chkArray($this->formData,     'web_url'),
            'status'            =>  GFunc::chkArray($this->formData,     'status'),
            'email'             =>  GFunc::chkArray($this->formData,     'email'),
            'obs'               =>  GFunc::chkArray($this->formData,     'obs'),
            'created_at'        =>  date('Y-m-d H:i:s', time())
        ]);

        //$lastId[0] =  (int) $this->db->lastInsertId();

        $this->db->insert('Address', [
            'id_provider'   =>  $lastId,
            'address'       =>  GFunc::chkArray($this->formData, 'address'),
            'district'      =>  GFunc::chkArray($this->formData, 'district'),
            'city'          =>  GFunc::chkArray($this->formData, 'city'),
            'uf'            =>  GFunc::chkArray($this->formData, 'uf'),
            'cep'           =>  GFunc::chkArray($this->formData, 'cep'),
            'nation'        =>  GFunc::chkArray($this->formData, 'nation'),
        ]);

        $this->db->insert('Representatives', [
            'id_provider'   =>  $lastId,
            'name'          =>  GFunc::chkArray($this->formData,     'rp_name'),
            'nickname'      =>  GFunc::chkArray($this->formData,     'rp_nickname'),
            'email'         =>  GFunc::chkArray($this->formData,     'rp_email'),
        ]);

        // Captura o id do último registro inserido.
        //$lastId[1] =  (int) $this->db->lastInsertId();

        $this->db->insert('BankAccounts', [
            'id_representative' =>  $lastId,
            'bank'              =>  GFunc::chkArray($this->formData,     'bank'),
            'agency'            =>  GFunc::chkArray($this->formData,     'agency'),
            'account'           =>  GFunc::chkArray($this->formData,     'account'),
            'holder'            =>  GFunc::chkArray($this->formData,     'holder'),
            'owner'             =>  'R',
        ]);

        $this->db->insert('Contacts', [
            'id_provider'       =>  $lastId,
            'phone'             =>  GFunc::chkArray($this->formData, 'cel'),
            'type'              =>  'C',
            'owner'             =>  'P'
        ]);

        $this->db->insert('Contacts', [
            'id_provider'    =>  $lastId,
            'phone'     => GFunc::chkArray($this->formData, 'phone'),
            'type'      => 'T',
            'owner'     => 'P'
        ]);

        $this->db->insert('Contacts', [
            'id_provider'    =>  $lastId,
            'phone'          =>  GFunc::chkArray($this->formData, 'rp_cel'),
            'type'           =>  'C',
            'owner'          =>  'R'
        ]);

        $this->db->insert('Contacts', [
            'id_provider'   =>   $lastId,
            'phone'         =>   GFunc::chkArray($this->formData, 'rp_phone'),
            'type'          =>  'T',
            'owner'         =>  'R'
        ]);

        // Deleta a variável.
        //unset($lastId);
        # Verifica se a consulta está OK se sim envia o Feedback para o usuário.
        if ($lastId > 0) {
            // Deleta a variável.
            unset($lastId);

            # Feedback sucesso!
            die(false);
        } else {

            // Deleta a variável.
            unset($lastId);

            # Feedback erro!
            die(true);
        }
    } // end Insert

    /**
     *   @Acesso: public
     *   @Autor: Gomes - F.A.G.A <gomes.tisystem@gmail.com>
     *   @Função: updateRegister()
     *   @Versão: 0.2
     *   @Descrição: Atualiza um registro especifico no BD.
     *   @Obs: Este método só funcionara se for chamado no método validate_register_form() ambos trabalham em conjunto.
     **/
    public function updateRegister($registro_id = NULL)
    {
        # Verifica se existe ID
        if ($registro_id) {
            # Efetua o update do registro
            $query_up = $this->db->update('providers', 'id', $registro_id, [
                'provider_name'         =>  chkArray($this->form_data, 'provider_name'),
                'provider_cpf_cnpj'     =>  chkArray($this->form_data, 'provider_cpf_cnpj'),
                'provider_rs'           =>  chkArray($this->form_data, 'provider_rs'),
                'provider_at'           =>  chkArray($this->form_data, 'provider_at'),
                'provider_end'          =>  chkArray($this->form_data, 'provider_end'),
                'provider_district'     =>  chkArray($this->form_data, 'provider_district'),
                'provider_city'         =>  chkArray($this->form_data, 'provider_city'),
                'provider_uf'           =>  chkArray($this->form_data, 'provider_uf'),
                'provider_cep'          =>  chkArray($this->form_data, 'provider_cep'),
                'provider_nation'       =>  chkArray($this->form_data, 'provider_nation'),
                'provider_cel'          =>  chkArray($this->form_data, 'provider_cel'),
                'provider_tel_1'        =>  chkArray($this->form_data, 'provider_tel_1'),
                'provider_tel_2'        =>  chkArray($this->form_data, 'provider_tel_2'),
                'provider_insc_uf'      =>  chkArray($this->form_data, 'provider_insc_uf'),
                'provider_web_url'      =>  chkArray($this->form_data, 'provider_web_url'),
                'provider_sit'          =>  chkArray($this->form_data, 'provider_sit'),
                'provider_email'        =>  chkArray($this->form_data, 'provider_email'),
                'provider_rep_name'     =>  chkArray($this->form_data, 'provider_rep_name'),
                'provider_rep_apelido'  =>  chkArray($this->form_data, 'provider_rep_apelido'),
                'provider_rep_cel'      =>  chkArray($this->form_data, 'provider_rep_cel'),
                'provider_rep_tel_1'    =>  chkArray($this->form_data, 'provider_rep_tel_1'),
                'provider_rep_tel_2'    =>  chkArray($this->form_data, 'provider_rep_tel_2'),
                'provider_rep_email'    =>  chkArray($this->form_data, 'provider_rep_email'),
                'provider_banco_1'      =>  chkArray($this->form_data, 'provider_banco_1'),
                'provider_agencia_1'    =>  chkArray($this->form_data, 'provider_agencia_1'),
                'provider_conta_1'      =>  chkArray($this->form_data, 'provider_conta_1'),
                'provider_titular_1'    =>  chkArray($this->form_data, 'provider_titular_1'),
                'provider_banco_2'      =>  chkArray($this->form_data, 'provider_banco_2'),
                'provider_agencia_2'    =>  chkArray($this->form_data, 'provider_agencia_2'),
                'provider_conta_2'      =>  chkArray($this->form_data, 'provider_conta_2'),
                'provider_titular_2'    =>  chkArray($this->form_data, 'provider_titular_2'),
                'provider_obs'          =>  chkArray($this->form_data, 'provider_obs'),
                'provider_modified'     =>  date('Y-m-d H:i:s', time())
            ]);

            # Verifica se a consulta foi realizada com sucesso
            if ($query_up) {
                # Destroy variáveis nao mais utilizadas.
                unset($registro_id, $query_up);

                # Retorna o valor e finaliza execução.
                echo 'ok';
                exit();
            } else {
                # Destroy variavel nao mais utilizadas.
                unset($registro_id, $query_up);

                # Retorna o valor e finaliza execução.
                echo 'err';
                exit();
            }
        }
    } #--> End updateRegister()

    /**
     *   @Acesso: public
     *   @Autor: Gomes - F.A.G.A <gomes.tisystem@gmail.com>
     *   @Função: get_register_form()
     *   @Versão: 0.2
     *   @Descrição: Obtém os dados do registro existente e retorna o valor para o usuario codificando e decodificando o mesmo na url.
     **/
    public function get_register_form($id_encode)
    {

        $id_decode = intval($this->gFun->encodeDecode(0, $id_encode));

        # Verifica na base de dados o registro
        $query_get = $this->db->query('SELECT * FROM `covenant` WHERE `covenant_id` = ?', [$id_decode]);



        # Obtém os dados da consulta
        $fetch_userdata = $query_get->fetch(PDO::FETCH_ASSOC);

        # Faz um loop dos dados, guardando os no vetor $form_data
        foreach ($fetch_userdata as $key => $value) {
            $this->form_data[$key] = $value;
        }

        # Tratamento da data para o modelo visao do fomulario
        #$this->form_data['covenant_data_aq'] = $this->converteData('Y-m-d', 'd/m/Y', $this->form_data['covenant_data_aq']);

        # Destroy variaveis não mais utilizadas
        unset($query_get, $fetch_userdata);

        return;
    } # End get_register_form()


    /**
     *   @Acesso: public
     *   @Autor: Gomes - F.A.G.A <gomes.tisystem@gmail.com>
     *   @Função: delRegister()
     *   @Versão: 0.2
     *   @Descrição: Recebe o id passado no método e executa a exclusão caso exista o id se não retorna um erro.
     * */
    public function delRegister($encode_id)
    {

        # Recebe o ID do registro converte de string para inteiro.
        $decode_id = intval(GFunc::encodeDecode(0, $encode_id));

        # Executa a consulta na base de dados
        $search = $this->db->query("SELECT count(*) FROM `Providers` WHERE `id` = $decode_id ");
        if ($search->fetchColumn() < 1) {

            # Destroy variáveis não mais utilizadas
            unset($encode_id, $search, $decode_id);

            exit(1);
        } else {
            # Deleta o registro
            $this->db->delete('Providers', 'id', $decode_id);

            #   Destroy variáveis não mais utilizadas
            unset($parametro, $search, $id);

            die(0);
        }
    }   #--> End delRegister()





    public function listar($table = 'Providers', $column = '*', $condition = null)
    {
        return $this->db->select($table, $column, $condition);
    }

    /**
     *   @Acesso: public
     *   @Autor: Gomes - F.A.G.A <gomes.tisystem@gmail.com>
     *   @Versão: 0.1
     *   @Função: get_ultimo_id()
     *   @Descrição: Pega o ultimo ID do registro.
     **/
    public function get_ultimo_id()
    {
        // Simplesmente seleciona os dados na base de dados
        $query = $this->db->query(' SELECT MAX(agenda_id) AS `agenda_id` FROM `agendas` ');

        $row = $query->fetch();
        $id = trim($row[0]);

        return $id;
    } // End get_ultimo_id()



    public function getSelect_return($sql)
    {
        # Simplesmente seleciona os dados na base de dados
        $queryGet = $this->db->query($sql);

        # Declara o vetor
        $result_array = [];


        # Retorna os valores da consulta
        while ($results = $queryGet->fetchAll(PDO::FETCH_ASSOC)) {
            $result_array = $results;
        }

        foreach ($result_array as $result) {

            # The output
            echo '<tr>';
            echo '<td class="small">' . $result['id'] . '</td>';
            echo '<td class="small">' . $result['provider_venc'] . '</td>';
            echo '<td class="small">' . $result['provider_date_provider'] . '</td>';
            echo '<td class="small">' . $result['provider_cat'] . '</td>';
            echo '<td class="small">' . $result['provider_desc'] . '</td>';
            echo '<td class="small">' . $result['provider_val'] . '</td>';
            echo '</tr>';
        }
    }

    /**
     *   @Acesso: public
     *   @Autor: Gomes - F.A.G.A <gomes.tisystem@gmail.com>
     *   @Versão: 0.1
     *   @Função: getJSON()
     *   @Descrição: Recebe a tabela e o id, e retorna um JSON dos dados.
     **/
    public function getJSON($table, $id)
    {

        # Simplesmente seleciona os dados na base de dados
        $query = $this->db->query("SELECT * FROM $table ORDER BY $id");

        # Verifica se a consulta está OK
        if (!$query) {

            # Finaliza execução
            return;
        }

        # Retorna os valores da consulta
        $queryResult = $query->fetchAll(PDO::FETCH_ASSOC);

        // Prepara a conversao para o formato desejado
        foreach ($queryResult as $provider) {
            $mysql_data[] = [
                "id"        => $provider['id'],
                "provider_venc"      => $provider['provider_venc'],
                "provider_date_provider"  => $provider['provider_date_provider'],
                "provider_cat"       => '$ ' . $provider['provider_cat'],
                "provider_desc"      => $provider['provider_desc'],
                "provider_val"       => $provider['provider_val']
            ];
        }

        # Cria o arquivo JSON
        $fp = fopen('arquivo.json', 'w');
        fwrite($fp, json_encode($mysql_data));
        fclose($fp);

        # Finaliza execução
        return;
    } # End getJSON()

    /**
     *   @Acesso: public
     *   @Autor: Gomes - F.A.G.A <gomes.tisystem@gmail.com>
     *   @Versão: 0.1
     *   @Função: get_registro()
     *   @Descrição: Pega o ID passado na função e retorna os valores do id solicitado.
     **/
    public function get_registro($encode_id = NULL)
    {
        #   Recebe o ID codficado e decodifica depois converte e inteiro
        $decode_id = intval($this->encodeDecode(0, $encode_id));

        # Simplesmente seleciona os dados na base de dados
        $query_get = $this->db->query(" SELECT * FROM  `provider` WHERE `id`= $decode_id ");

        # Verifica se a consulta está OK
        if (!$query_get) {

            # Finaliza
            return;
        }

        # Destroy variaveis não mais utilizadas
        unset($decode_id, $encode_id);


        # Retorna os valores da consulta
        return $query_get->fetch(PDO::FETCH_ASSOC);
    } # End get_registro()

    /**
     * Paginação
     *
     * Cria uma paginação simples.
     *
     * @param int $total_artigos Número total de artigos da sua consulta
     * @param int $artigos_por_pagina Número de artigos a serem exibidos nas páginas
     * @param int $offset Número de páginas a serem exibidas para o usuário
     *
     * @return string A paginação montada
     */
    function paginacao($total_artigos = 0, $artigos_por_pagina = 10, $offset = 5)
    {
        // Obtém o número total de página
        $numero_de_paginas = floor($total_artigos / $artigos_por_pagina);

        // Obtém a página atual
        $pagina_atual = 1;

        // Atualiza a página atual se tiver o parâmetro pagina=n
        if (!empty($_GET['pagina'])) {
            $pagina_atual = (int) $_GET['pagina'];
        }

        // Vamos preencher essa variável com a paginação
        $paginas = null;

        // Primeira página
        $paginas .= " <a href='?pagina=0'>Home</a> ";

        // Faz o loop da paginação
        // $pagina_atual - 1 da a possibilidade do usuário voltar
        for ($i = ($pagina_atual - 1); $i < ($pagina_atual - 1) + $offset; $i++) {

            // Eliminamos a primeira página (que seria a home do site)
            if ($i < $numero_de_paginas && $i > 0) {
                // A página atual
                $página = $i;

                // O estilo da página atual
                $estilo = null;

                // Verifica qual dos números é a página atual
                // E cria um estilo extremamente simples para diferenciar
                if ($i == @$_parameters[1]) {
                    $estilo = ' style="color:red;" ';
                }

                // Inclui os links na variável $paginas
                $paginas .= " <a $estilo href='?pagina=$página'>$página</a> ";
            }
        } // for

        $paginas .= " <a href='?pagina=$numero_de_paginas'>Última</a> ";

        // Retorna o que foi criado
        return $paginas;
    }


    /*
     * Returns rows from the database based on the conditions
     * @param string name of the table
     * @param array select, where, search, order_by, limit and return_type conditions
     */
    public function getRows($table, $conditions = [])
    {
        $sql = 'SELECT ';
        $sql .= array_key_exists('select', $conditions) ? $conditions['select'] : '*';
        $sql .= ' FROM ' . $table;

        if (array_key_exists('where', $conditions)) {
            $sql .= ' WHERE ';
            $i = 0;
            foreach ($conditions['where'] as $key => $value) {
                $pre = ($i > 0) ? ' AND ' : '';
                $sql .= $pre . $key . " = '" . $value . "'";
                $i++;
            }
        }

        if (array_key_exists('where_limit', $conditions)) {
            $sql .= ' WHERE ' . $conditions['where_limit']['key_where'] . ' = ' . $conditions['where_limit']['value_where'];
            //$sql .=  $conditions['where_limit']['value_limit'];
            //var_dump($sql);die;

        }

        if (array_key_exists('search', $conditions)) {
            $sql .= (strpos($sql, 'WHERE') !== false) ? '' : ' WHERE ';
            $i = 0;
            foreach ($conditions['search'] as $key => $value) {
                $pre = ($i > 0) ? ' OR ' : '';
                $sql .= $pre . $key . " LIKE '%" . $value . "%'";
                $i++;
            }
        }



        if (array_key_exists("order_by", $conditions)) {
            $sql .= ' ORDER BY ' . $conditions['order_by'];
        }
        var_dump($sql);

        if (array_key_exists("start", $conditions) && array_key_exists("limit", $conditions)) {

            $sql .= ' LIMIT ' . $conditions['start'] . ',' . $conditions['limit'];
        } elseif (!array_key_exists("start", $conditions) && array_key_exists("limit", $conditions)) {
            $sql .= ' LIMIT ' . $conditions['limit'];
        }

        $result = $this->db->query($sql);

        if (array_key_exists("return_type", $conditions) && $conditions['return_type'] != 'all') {
            switch ($conditions['return_type']) {
                case 'count':
                    $data = count($result);
                    break;
                case 'single':
                    $data = $result->fetch(PDO::FETCH_ASSOC);
                    break;
                default:
                    $data = '';
            }
        } else {
            if (count($result) > 0) {
                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    $data[] = $row;
                    //var_dump($data);
                }
            }
        }
        return !empty($data) ? $data : false;
    }
} #Fees_Model
