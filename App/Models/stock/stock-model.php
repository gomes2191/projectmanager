<?php

/**
 *  @Autor: F.A.G.A <gomes.tisystem@gmail.com>
 *  @Class: StockModel
 *  @Descrição: Classe responsavel por toda intereção com a base de dados e validações
 *
 *  @Pacote: OdontoControl
 *  @Versão: 0.2
 */
class StockModel extends MainModel
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

    /**
     *
     *
     * @Descrição: Construtor, carrega  o DB.
     *
     * @since 0.1
     * @access public
     */
    public function __construct($db = FALSE)
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
    public function validate_register_form()
    {
        # Cria o vetor que vai receber os dados do post
        $this->form_data = [];

        # Verifica se algo foi postado no formulário
        if ((filter_input(INPUT_SERVER, 'REQUEST_METHOD', FILTER_DEFAULT) === 'POST') && (!empty(filter_input_array(INPUT_POST, FILTER_DEFAULT)))) {

            # Faz o loop dos dados do formulário inserindo os no vetor @form_data.
            foreach (filter_input_array(INPUT_POST, FILTER_DEFAULT) as $key => $value) {

                # Configura os dados do post para a propriedade $form_data
                $this->form_data[$key] = $value;
            } # End foreach

            #   Não será permitido campos vazios
            if (empty($this->form_data['stock_cod']) or empty($this->form_data['stock_desc'])) {

                #   Feedback para o usuário
                $this->form_msg = [0 => 'alert-warning', 1 => 'glyphicon glyphicon-info-sign', 2 => 'Opa! ', 3 => 'Campos marcados com <strong>*</strong> são obrigatórios .'];

                # Termina
                return;
            }
        } else {

            # Finaliza se nada foi enviado
            return FALSE;
        } #--> End

        # Rotina que verifica se o registro já existe
        $db_check_ag = $this->db->query(' SELECT count(*) FROM `stock` WHERE `stock_id` = ? ', [
            chkArray($this->form_data, 'stock_id')
        ]);

        # Verefica qual tipo de ação a ser tomada se existe ID faz Update se não existir efetua o insert
        if (($db_check_ag->fetchColumn()) >= 1) {
            $this->updateRegister(chkArray($this->form_data, 'stock_id'));
            return;
        } else {
            $this->insertRegister();
            return;
        }
    } #--> End validate_register_form()

    /**
     *   @Acesso: public
     *   @Autor: Gomes - F.A.G.A <gomes.tisystem@gmail.com>
     *   @Função: insertRegister()
     *   @Versão: 0.2
     *   @Descrição: Insere o registro no BD.
     *   @Obs: Este método só funcionara se for chamado no método validate_register_form() ambos trabalham em conjunto.
     **/
    public function insertRegister()
    {
        //var_dump($this->form_data['stock_tipo_unit']);die;
        //var_dump('==Insert=='.  $this->converteData('d/m/Y', 'Y-m-d', chkArray($this->form_data, 'stock_data_aq')).'== novo==');die;
        # Se o ID do agendamento estiver vazio, insere os dados
        $query_ins = $this->db->insert('stock', [
            'stock_cod'         =>  $this->avaliar(chkArray($this->form_data, 'stock_cod')),
            'stock_desc'        =>  $this->avaliar(chkArray($this->form_data, 'stock_desc')),
            'stock_tipo_unit'   =>  $this->avaliar(chkArray($this->form_data, 'stock_tipo_unit')),
            'stock_fornecedor'  =>  $this->avaliar(chkArray($this->form_data, 'stock_fornecedor')),
            'stock_inicial'     =>  (int) $this->onlyFilterNumber(chkArray($this->form_data, 'stock_inicial')),
            'stock_minimo'      =>  (int) $this->onlyFilterNumber(chkArray($this->form_data, 'stock_minimo')),
            'stock_atual'       =>  (int) $this->onlyFilterNumber(chkArray($this->form_data, 'stock_atual')),
            'stock_valor'       =>  (int) $this->onlyFilterNumber(chkArray($this->form_data, 'stock_valor')),
            'stock_info'        =>  $this->avaliar(chkArray($this->form_data, 'stock_info'))
        ]);

        #   Verifica se a consulta está OK se sim envia o Feedback para o usuário.
        if ($query_ins) {

            # Feedback para o usuário
            $this->form_msg = [0 => 'alert-success', 1 => 'glyphicon glyphicon-info-sign', 2 => 'Sucesso! ', 3 => 'Registro efetuado com sucesso!'];

            # Redireciona de volta para a página após dez segundos
            echo '<meta http-equiv="Refresh" content="4; url=' . HOME_URI . '/stock/cad">';

            # Destroy variável não mais utilizada
            unset($query_ins);

            # Finaliza execução.
            return;
        } else {

            # Feedback para o usuário
            $this->form_msg = [0 => 'alert-danger', 1 => 'fa fa-exclamation-triangle fa-2', 2 => 'Erro! ', 3 => 'Erro interno do sistema se o problema persistir contate o administrador. Erro: 800'];

            # Destroy variáveis não mais utilizadas.
            unset($query_ins);

            # Finaliza execução.
            return;
        }
    }

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

        //var_dump($this->form_data['stock_valor']);die;

        #   Se o ID não estiver vazio, atualiza os dados
        if ($registro_id) {
            # Efetua o update do registro
            $query_up = $this->db->update('stock', 'stock_id', $registro_id, [
                'stock_cod'         =>  $this->avaliar(chkArray($this->form_data, 'stock_cod')),
                'stock_desc'        =>  $this->avaliar(chkArray($this->form_data, 'stock_desc')),
                'stock_tipo_unit'   =>  $this->avaliar(chkArray($this->form_data, 'stock_tipo_unit')),
                'stock_fornecedor'  =>  $this->avaliar(chkArray($this->form_data, 'stock_fornecedor')),
                'stock_inicial'     =>  (int) $this->onlyFilterNumber(chkArray($this->form_data, 'stock_inicial')),
                'stock_minimo'      =>  (int) $this->onlyFilterNumber(chkArray($this->form_data, 'stock_minimo')),
                'stock_atual'       =>  (int) $this->onlyFilterNumber(chkArray($this->form_data, 'stock_atual')),
                'stock_valor'       =>  (int) $this->onlyFilterNumber(chkArray($this->form_data, 'stock_valor')),
                'stock_info'        =>  $this->avaliar(chkArray($this->form_data, 'stock_info'))
            ]);

            # Verifica se a consulta foi realizada com sucesso
            if ($query_up) {

                # Feedback para o usuário
                $this->form_msg = [0 => 'alert-success', 1 => 'glyphicon glyphicon-info-sign', 2 => 'Informção! ', 3 => 'Os dados foram atualizados com sucesso!'];

                # Redireciona de volta para a página após dez segundos
                #echo '<meta http-equiv="Refresh" content="4; url=' . HOME_URI . '/stock/cad">';

                # Destroy variáveis nao mais utilizadas
                unset($registro_id, $query_up);

                # Finaliza execução.
                return;
            } else {

                # Feedback para o usuário
                $this->form_msg = [0 => 'alert-danger', 1 => 'fa fa-exclamation-triangle fa-2', 2 => 'Erro! ', 3 => 'Erro interno do sistema se o problema persistir contate o administrador. Erro: 800'];

                # Destroy variáveis nao mais utilizadas
                unset($registro_id, $query_up);

                # Finaliza
                return;
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

        $id_decode = intval($this->encodeDecode(0, $id_encode));

        # Verifica na base de dados o registro
        $query_get = $this->db->query('SELECT * FROM `stock` WHERE `stock_id` = ?', [$id_decode]);



        # Obtém os dados da consulta
        $fetch_userdata = $query_get->fetch(PDO::FETCH_ASSOC);

        # Faz um loop dos dados, guardando os no vetor $form_data
        foreach ($fetch_userdata as $key => $value) {
            $this->form_data[$key] = $value;
        }

        # Tratamento da data para o modelo visao do fomulario
        #$this->form_data['stock_data_aq'] = $this->converteData('Y-m-d', 'd/m/Y', $this->form_data['stock_data_aq']);

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
        $decode_id = intval($this->encodeDecode(0, $encode_id));

        # Executa a consulta na base de dados
        $search = $this->db->query("SELECT count(*) FROM `stock` WHERE `stock_id` = $decode_id ");
        if ($search->fetchColumn() < 1) {

            #   Feedback para o usuário
            $this->form_msg = [0 => 'alert-danger', 1 => 'fa fa-info-circle', 2 => 'Erro! ', 3 => 'Erro interno do sistema. Contate o administrador. Cod: 800'];

            # Redireciona de volta para a página após 4 segundos
            echo '<meta http-equiv="Refresh" content="4; url=' . HOME_URI . '/stock">';

            # Destroy variáveis não mais utilizadas
            unset($encode_id, $search, $decode_id);

            # Finaliza
            return;
        } else {
            # Deleta o registro
            $query_del = $this->db->delete('stock', 'stock_id', $decode_id);

            #   Feedback para o usuário
            $this->form_msg = [0 => 'alert-success', 1 => 'fa fa-info-circle', 2 => 'Sucesso! ', 3 => 'Registro removido com sucesso!'];

            #   Destroy variáveis não mais utilizadas
            unset($parametro, $query_del, $search, $id);

            # Redireciona de volta para a página após o tempo informado segundos
            echo '<meta http-equiv="Refresh" content="4; url=' . HOME_URI . '/stock">';

            #   Finaliza
            return;
        }
    }   #--> End delRegister()



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

    /**
     *   @Acesso: public
     *   @Autor: Gomes - F.A.G.A <gomes.tisystem@gmail.com>
     *   @Versão: 0.1
     *   @Função: get_table_data()
     *   @Descrição: Recebe os valores passado na função, $campo, $tabela e $id, efetua a consulta e retorna o resultado.
     * */
    public function get_table_data($campo, $table, $id)
    {

        #   Simplesmente seleciona os dados na base de dados
        $query = $this->db->query("SELECT  $campo FROM $table ORDER BY $id");

        // Verifica se a consulta está OK
        if (!$query) {

            # Finaliza
            return;
        }

        # Retorna os valores da consulta
        return $query->fetchAll(PDO::FETCH_BOTH);
    }   # End get_table_data()

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
        $query_get = $this->db->query(" SELECT * FROM  `stock` WHERE `stock_id`= $decode_id ");

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

}
