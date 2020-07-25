<?php

/**
 *  @Autor: F.A.G.A <gomes.tisystem@gmail.com>
 *  @Class: FeesModel
 *  @Descrição: Classe responsavel por toda intereção com a base de dados e validações
 *
 *  @Pacote: OdontoControl
 *  @Versão: 0.2
 */
class PatrimonyModel extends MainModel 
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
    public function __construct( $db = FALSE ) {
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
    public function validate_register_form () {
        # Cria o vetor que vai receber os dados do post
        $this->form_data = [];
        
        # Verifica se não é vazio o $_POST
        if ( (filter_input(INPUT_SERVER, 'REQUEST_METHOD', FILTER_DEFAULT) === 'POST') && (!empty(filter_input_array(INPUT_POST, FILTER_DEFAULT) ) ) ) {
            
            # Faz o loop dos dados do formulário inserindo os no vetor $form_data.
            foreach ( filter_input_array(INPUT_POST, FILTER_DEFAULT) as $key => $value ) {
                # Configura os dados do post para a propriedade $form_data
                $this->form_data[$key] = $value;
            } # End foreach
            
            # Verifica se existe o ID e decodifica se o mesmo existir.
            ( !empty($this->form_data['patrimony_id']) ) 
            ? $this->form_data['patrimony_id'] = $this->encode_decode(0, $this->form_data['patrimony_id']) : '';
        }else {
            # Finaliza a execução.
            return 'err';
        } #--> End
        
        # Verifica se o registro já existe.
        $db_check_ag = $this->db->query (' SELECT count(*) FROM `patrimony` WHERE `patrimony_id` = ? ',[
            chk_array($this->form_data, 'patrimony_id')
        ]);
        
        # Verefica qual tipo de ação a ser tomada se existe ID faz Update se não existir efetua o insert
        if ( ($db_check_ag->fetchColumn()) >= 1 ) {           
            $this->updateRegister( $this->form_data['patrimony_id'] );
        }else{
            //var_dump($this->form_data);die;
            $this->insertRegister();
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
    public function insertRegister(){
        //var_dump($this->convertDataHora('d/m/Y', 'Y-m-d',$this->avaliar(chk_array($this->form_data, 'patrimony_date_patrimony'))));die;
        # Se o ID do agendamento estiver vazio, insere os dados
        $query_ins = $this->db->insert('patrimony',[
            'patrimony_cod'         =>  chk_array($this->form_data, 'patrimony_cod'),
            'patrimony_desc'        =>  chk_array($this->form_data, 'patrimony_desc'),
            'patrimony_data_aq'     =>  $this->convertDataHora('d/m/Y', 'Y-m-d', chk_array($this->form_data, 'patrimony_data_aq')),
            'patrimony_cor'         =>  chk_array($this->form_data, 'patrimony_cor'),
            'patrimony_for'         =>  chk_array($this->form_data, 'patrimony_for'),
            'patrimony_dimen'       =>  chk_array($this->form_data, 'patrimony_dimen'),
            'patrimony_setor'       =>  chk_array($this->form_data, 'patrimony_setor'),
            'patrimony_valor'       =>  number_format(moeda($this->form_data['patrimony_valor']), 2, '.', ''),
            'patrimony_garan'       =>  chk_array($this->form_data, 'patrimony_garan'),
            'patrimony_quant'       =>  chk_array($this->form_data, 'patrimony_quant'),
            'patrimony_sit'         =>  chk_array($this->form_data, 'patrimony_sit'),
            'patrimony_nf'          =>  chk_array($this->form_data, 'patrimony_nf'),
            'patrimony_obs'         =>  chk_array($this->form_data, 'patrimony_obs'),
            'patrimony_created'     =>  date('Y-m-d H:i:s', time())
        ]);

        # Verifica se a consulta está OK se sim envia o Feedback para o usuário.
        if ( $query_ins ) {
            //$this->form_msg = ['result'=>'success', 'message'=>'query success'];
            //return $this->form_msg;
            echo 'ok';
        }else{
            # Feedback
            //$this->form_msg = ['result'=>'error', 'message'=>'query error'];
            
            # Retorna o valor e finaliza execução
            //return $this->form_msg;
            echo 'err';
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
    public function updateRegister( $registro_id = NULL ){
        # Verifica se existe ID
        if ( $registro_id ) {

           //$valor =  moeda($this->form_data['patrimony_valor']);
           //print_r($valor);die;
          //$valor = number_format(moeda($this->form_data['patrimony_valor']), 2, '.', '');
          //$valor = number_format(str_replace(",",".",str_replace(".","",$this->form_data['patrimony_valor'])), 2, '.', '');
          //print_r($valor);die;
            
            # Efetua o update do registro
            $query_up = $this->db->update('patrimony', 'patrimony_id', $registro_id,[
                'patrimony_cod'        =>  chk_array($this->form_data, 'patrimony_cod'),
                'patrimony_desc'       =>  chk_array($this->form_data, 'patrimony_desc'),
                'patrimony_data_aq'    =>  $this->convertDataHora('d/m/Y', 'Y-m-d', chk_array($this->form_data, 'patrimony_data_aq')),
                'patrimony_cor'        =>  chk_array($this->form_data, 'patrimony_cor'),
                'patrimony_for'        =>  chk_array($this->form_data, 'patrimony_for'),
                'patrimony_dimen'      =>  chk_array($this->form_data, 'patrimony_dimen'),
                'patrimony_setor'      =>  chk_array($this->form_data, 'patrimony_setor'),
                'patrimony_valor'      =>  number_format(moeda($this->form_data['patrimony_valor']), 2, '.', ''),
                'patrimony_garan'      =>  chk_array($this->form_data, 'patrimony_garan'),
                'patrimony_quant'      =>  chk_array($this->form_data, 'patrimony_quant'),
                'patrimony_nf'         =>  chk_array($this->form_data, 'patrimony_nf'),
                'patrimony_sit'        =>  chk_array($this->form_data, 'patrimony_sit'),
                'patrimony_obs'        =>  chk_array($this->form_data, 'patrimony_info'),
                'patrimony_modified'   =>  date('Y-m-d H:i:s', time())
            ]);

            # Verifica se a consulta foi realizada com sucesso
            if ( $query_up ) {
                # Destroy variáveis nao mais utilizadas.
                unset( $registro_id, $query_up  );
                
                # Retorna o valor e finaliza execução.
                echo 'ok';exit();
            }else{
                # Destroy variavel nao mais utilizadas.
                unset( $registro_id, $query_up  );
                
                # Retorna o valor e finaliza execução.   
                echo 'err';exit();
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
    public function get_register_form ( $id_encode ) {
        
        $id_decode = intval($this->encode_decode(0, $id_encode));
        
        # Verifica na base de dados o registro
        $query_get = $this->db->query('SELECT * FROM `covenant` WHERE `covenant_id` = ?', [ $id_decode ]  );

        

        # Obtém os dados da consulta
        $fetch_userdata = $query_get->fetch(PDO::FETCH_ASSOC);
        
        # Faz um loop dos dados, guardando os no vetor $form_data
        foreach ( $fetch_userdata as $key => $value ) {
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
    public function delRegister( $encode_id ) {

        # Recebe o ID do registro converte de string para inteiro.
        $decode_id = intval($this->encode_decode(0, $encode_id));
        
        # Executa a consulta na base de dados
        $search = $this->db->query("SELECT count(*) FROM `patrimony` WHERE `patrimony_id` = $decode_id ");
        if ($search->fetchColumn() < 1) {

            # Destroy variáveis não mais utilizadas
            unset($encode_id, $search, $decode_id);
            
            echo 'err';exit();
            
        } else {
            # Deleta o registro
            $query_del = $this->db->delete('patrimony', 'patrimony_id', $decode_id);

            #   Destroy variáveis não mais utilizadas
            unset($parametro, $query_del, $search, $id);

            echo 'ok';exit();
        }
    }   #--> End delRegister()
   
    /**
    *   @Acesso: public
    *   @Autor: Gomes - F.A.G.A <gomes.tisystem@gmail.com>
    *   @Versão: 0.1
    *   @Função: get_ultimo_id() 
    *   @Descrição: Pega o ultimo ID do registro.
    **/
    public function get_ultimo_id() {
        // Simplesmente seleciona os dados na base de dados
        $query = $this->db->query(' SELECT MAX(agenda_id) AS `agenda_id` FROM `agendas` ');
         
        $row = $query->fetch();
        $id = trim($row[0]);
        
        return $id;
        
     } // End get_ultimo_id()
     
     
    
    public function getSelect_return($sql){
        # Simplesmente seleciona os dados na base de dados
        $queryGet = $this->db->query($sql);
        
        # Declara o vetor
        $result_array = [];
        
       
        # Retorna os valores da consulta
        while($results = $queryGet->fetchAll(PDO::FETCH_ASSOC)) {
            $result_array = $results;
        }
       
        foreach ($result_array as $result) {
            
            # The output
            echo '<tr>';			
            echo '<td class="small">'.$result['patrimony_id'].'</td>';
            echo '<td class="small">'.$result['patrimony_venc'].'</td>';
            echo '<td class="small">'.$result['patrimony_date_patrimony'].'</td>';
            echo '<td class="small">'.$result['patrimony_cat'].'</td>';
            echo '<td class="small">'.$result['patrimony_desc'].'</td>';
            echo '<td class="small">'.$result['patrimony_val'].'</td>';
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
  public function getJSON($table, $id) {

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
        foreach ($queryResult as $patrimony) {
            $mysql_data[] = [
                "patrimony_id"        => $patrimony['patrimony_id'],
                "patrimony_venc"      => $patrimony['patrimony_venc'],
                "patrimony_date_patrimony"  => $patrimony['patrimony_date_patrimony'],
                "patrimony_cat"       => '$ ' . $patrimony['patrimony_cat'],
                "patrimony_desc"      => $patrimony['patrimony_desc'],
                "patrimony_val"       => $patrimony['patrimony_val']
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
    public function get_registro( $encode_id = NULL ) {
        #   Recebe o ID codficado e decodifica depois converte e inteiro
        $decode_id = intval($this->encode_decode(0, $encode_id));
        
        # Simplesmente seleciona os dados na base de dados
        $query_get = $this->db->query( " SELECT * FROM  `patrimony` WHERE `patrimony_id`= $decode_id " );

        # Verifica se a consulta está OK
        if ( !$query_get ) {
            
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
    function paginacao(
        $total_artigos = 0, $artigos_por_pagina = 10, $offset = 5
    ) {
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
        for ($i = ( $pagina_atual - 1 ); $i < ( $pagina_atual - 1 ) + $offset; $i++) {

            // Eliminamos a primeira página (que seria a home do site)
            if ($i < $numero_de_paginas && $i > 0) {
                // A página atual
                $página = $i;

                // O estilo da página atual
                $estilo = null;

                // Verifica qual dos números é a página atual
                // E cria um estilo extremamente simples para diferenciar
                if ($i == @$parametros[1]) {
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
    public function getRows($table, $conditions = []){
        $sql = 'SELECT ';
        $sql .= array_key_exists('select',$conditions) ? $conditions['select']: '*';
        $sql .= ' FROM '.$table;             
        
        if(array_key_exists('where',$conditions)){
            $sql .= ' WHERE ';
            $i = 0;
            foreach($conditions['where'] as $key => $value){
                $pre = ($i > 0) ? ' AND ' : '';
                $sql .= $pre.$key." = '".$value."'";
                $i++;
            }
        }
        
        if(array_key_exists('where_limit',$conditions)){
            $sql .= ' WHERE '.$conditions['where_limit']['key_where']. ' = '.$conditions['where_limit']['value_where'];
            //$sql .=  $conditions['where_limit']['value_limit'];
            //var_dump($sql);die;
            
        }
        
        if(array_key_exists('search',$conditions)){
            $sql .= (strpos($sql, 'WHERE') !== false) ? '' : ' WHERE ';
            $i = 0;
            foreach($conditions['search'] as $key => $value){
                $pre = ($i > 0)?' OR ':'';
                $sql .= $pre.$key." LIKE '%".$value."%'";
                $i++;
            }
        }
        
        
        
        if(array_key_exists("order_by",$conditions)){
            $sql .= ' ORDER BY '.$conditions['order_by']; 
        }
    
        //var_dump($sql);
        
        if(array_key_exists("start",$conditions) && array_key_exists("limit",$conditions)){
            
            $sql .= ' LIMIT '.$conditions['start'].','.$conditions['limit']; 
            
        }elseif(!array_key_exists("start",$conditions) && array_key_exists("limit",$conditions)){
            $sql .= ' LIMIT '.$conditions['limit']; 
            
        }
        
        $result = $this->db->query($sql);
        
        if(array_key_exists("return_type",$conditions) && $conditions['return_type'] != 'all'){
            switch($conditions['return_type']){
                case 'count':
                    $data = count($result);
                    break;
                case 'single':
                    $data = $result->fetch(PDO::FETCH_ASSOC);
                    break;
                default:
                    $data = '';
            }
        }else{
            if(count($result) > 0){
                while($row = $result->fetch(PDO::FETCH_ASSOC)){
                    $data[] = $row;
                    //var_dump($data);
                }
            }
        }
        return !empty($data) ? $data : false;
    }

} # Patrimony-Model