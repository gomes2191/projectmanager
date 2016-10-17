<?php

/**
 *  @Autor: F.A.G.A <gomes.tisystem@gmail.com>
 *  @Class: MainModel - Modelo base
 *  @Descrição: Essa classe servirá para manter os métodos que poderão ser utilizados em todos os modelos, ou seja, ela o ajuda a manter a reutilização de código sempre ativa.
 * 
 *  @Pacote: OdontoControl
 *  @Versão: 0.1
 * */
class MainModel {

    /**
     *  @Acesso: public
     *  @Autor: F.A.G.A <gomes.tisystem@gmail.com>
     *  @Descrição: Armazena os dados passado no formulário via post.
     * */
    public $form_data;

    /**
     *  @Acesso: public
     *  @Autor: F.A.G.A <gomes.tisystem@gmail.com>
     *  @Descrição: Responsavel por armazenar as mensagen de feedback ao usuário.
     */
    public $form_msg;

    /**
     *  @Acesso: public
     *  @Autor: F.A.G.A <gomes.tisystem@gmail.com>
     *  @Descrição: Armazena a mensagem de confirmação ao apagar algum registro
     * */
    public $form_confirma;

    /**
     *  @Acesso: public
     *  @Autor: F.A.G.A <gomes.tisystem@gmail.com>
     *  @Descrição: O objeto da nossa conexão PDO.
     * */
    public $db;

    /**
     *  @Acesso: public
     *  @Autor: F.A.G.A <gomes.tisystem@gmail.com>
     *  @Descrição: O controller que gerou esse modelo
     * */
    public $controller;

    /**
     *  @Acesso: public
     *  @Autor: F.A.G.A <gomes.tisystem@gmail.com>
     *  @Descrição: Parâmetros da URL
     * */
    public $parametros;

    /**
     *  @Acesso: public
     *  @Autor: F.A.G.A <gomes.tisystem@gmail.com>
     *  @Descrição: Dados do usuário
     * */
    public $userdata;

    /**
     * Inverte datas 
     *
     * Obtém a data e inverte seu valor.
     * De: d-m-Y H:i:s para Y-m-d H:i:s ou vice-versa.
     *
     * @since 0.1
     * @access public
     * @param string $data A data
     */
//	public function inverte_data( $data = null ) {
//	
//		// Configura uma variável para receber a nova data
//		$nova_data = null;
//		
//		// Se a data for enviada
//		if ( $data ) {
//		
//			// Explode a data por -, /, : ou espaço
//			$data = preg_split('/\-|\/|\s|:/', $data);
//			
//			// Remove os espaços do começo e do fim dos valores
//			$data = array_map( 'trim', $data );
//			
//			// Cria a data invertida
//			$nova_data .= chk_array( $data, 2 ) . '-';
//			$nova_data .= chk_array( $data, 1 ) . '-';
//			$nova_data .= chk_array( $data, 0 );
//			
//			// Configura a hora
//			if ( chk_array( $data, 3 ) ) {
//				$nova_data .= ' ' . chk_array( $data, 3 );
//			}
//			
//			// Configura os minutos
//			if ( chk_array( $data, 4 ) ) {
//				$nova_data .= ':' . chk_array( $data, 4 );
//			}
//			
//			// Configura os segundos
//			if ( chk_array( $data, 5 ) ) {
//				$nova_data .= ':' . chk_array( $data, 5 );
//			}
//		}
//		
//		// Retorna a nova data
//		return $nova_data;
//	
//	} // inverte_data

    /**
     *   @Acesso: public
     *   @Autor: Gomes - F.A.G.A <gomes.tisystem@gmail.com>
     *   @Função: validaDataHora()
     *   @Descrição: Recebe uma determinada data e um verificador, verifica se a data atende o verificador passado e retorna true se sim e false se não
     *  
     *   Exemplos:
     *   var_dump(validaData('2014-02-28 12:12:12')); # true
     *   var_dump(validaData('2014-02-30 12:12:12')); # false
     *   var_dump(validaData('2015-06-26', 'Y-m-d')); # true
     *   var_dump(validaData('2015/06/26', 'Y-m-d')); # false
     *   var_dump(validaData('28/02/2014', 'd/m/Y')); # true
     *   var_dump(validaData('30/02/2014', 'd/m/Y')); # false
     *   var_dump(validaData('14:50', 'H:i')); # true
     *   var_dump(validaData('14:77', 'H:i')); # false
     *   var_dump(validaData(14, 'H')); # true
     *   var_dump(validaData('14', 'H')); # true
     * */
    public function validaDataHora($date, $format = 'Y-m-d H:i:s') {
        if (!empty($date) && $v_date = date_create_from_format($format, $date)) {
            $v_date = date_format($v_date, $format);
            return ($v_date && $v_date == $date);
        }
        return NULL;
    }   # End ValidaDataHora()

    /**
     *  @Acesso: public
     *  @Autor: Gomes - F.A.G.A <gomes.tisystem@gmail.com>
     *  @Versão: 0.1
     *  @Função: converteData()
     *  @Descrição: Converte uma determinada data para o formato desejado.
     * 
     *  Exemplos:
     *  var_dump(converteData('d m Y', 'Y-m-d', '06 02 2025')); 2025-02-06
     *  var_dump(converteData('d-m-Y', 'm/d/Y H:i', '06-02-2014')); 02/06/2014 12:39
     *  var_dump(converteData('Y-m-d', 'l F Y  H:i', '2014-02-06')); Thursday February 2014  12:38
     * */
    public function converteData($format, $to_format, $date='00/00/0000', $timezone = NULL) {
        if (!empty($date)) {
            $timezone = $timezone ? $timezone : new DateTimeZone(date_default_timezone_get());
            $f_date = date_create_from_format($format, $date, $timezone);
            return date_format($f_date, $to_format);
        }
        return NULL;
    }   # End converteData()

    /**
     *  @Acesso: public
     *  @Autor: Gomes - F.A.G.A <gomes.tisystem@gmail.com>
     *  @Versão: 0.1
     *  @Função: avaliar()
     *  @Descrição: Avaliar os dados inseridos pelo usuário e excluir caracteres indesejados.
     * */
    public function avaliar($valor_ini) {
        $nopermitido = ["'", '\\', '<', '>', "\""];
        $valor_1 = str_replace($nopermitido, "", $valor_ini);

        $valor = filter_var($valor_1, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
        return $valor;
    }   # End Avaliar()

    /**
     *  @Acesso: public
     *  @Autor: Gomes - F.A.G.A <gomes.tisystem@gmail.com>
     *  @Versão: 0.1
     *  @Função: encode_decode()
     *  @Descrição: Codifica e decodifica  a string passada dependendo do parametro.
     * */
    public function encode_decode($encode = FALSE, $decode = FALSE) {

        if ($encode == TRUE) {

            $rand = rand(100, 900);

            $encode = base64_encode($encode . $rand);
            return $encode;
        } else {
            $decode = base64_decode($decode);
            $_decode = substr($decode, 0, -3);

            return $_decode;
        }
    }

    /**
     *  @Acesso: public
     *  @Autor: Gomes - F.A.G.A <gomes.tisystem@gmail.com>
     *  @Versão: 0.1
     *  @Função: encode_decode()
     *  @Descrição: Remove tudo o que não for número.
     * */
    public function only_filter_number($valor) {
        $valor_final = preg_replace('/[^0-9]/', '', $valor);
        return $valor_final;
    }
    
    /**
     *  @Acesso: public
     *  @Autor: Gomes - F.A.G.A <gomes.tisystem@gmail.com>
     *  @Versão: 0.1
     *  @Função: encode_decode()
     *  @Descrição: Remove tudo o que não for número.
     * */
    public function format_padrao($string, $tipo = "") {
        $string = preg_replace("[^0-9]", "", $string);
        if (!$tipo) {
            switch (strlen($string)) {
                case 11: $tipo = 'fone';
                    break;
                case 8: $tipo = 'cep';
                    break;
                case 11: $tipo = 'cpf';
                    break;
                case 14: $tipo = 'cnpj';
                    break;
            }
        }
        switch ($tipo) {
            case 'fone':
                $string = '(' . substr($string, 0, 2) . ') ' . substr($string, 2, 4) .
                        '-' . substr($string, 6);
                break;
            case 'cep':
                $string = substr($string, 0, 5) . '-' . substr($string, 5, 3);
                break;
            case 'cpf':
                $string = substr($string, 0, 3) . '.' . substr($string, 3, 3) .
                        '.' . substr($string, 6, 3) . '-' . substr($string, 9, 2);
                break;
            case 'cnpj':
                $string = substr($string, 0, 2) . '.' . substr($string, 2, 3) .
                        '.' . substr($string, 5, 3) . '/' .
                        substr($string, 8, 4) . '-' . substr($string, 12, 2);
                break;
            case 'rg':
                $string = substr($string, 0, 2) . '.' . substr($string, 2, 3) .
                        '.' . substr($string, 5, 3);
                break;
        }
        return $string;
    }

}   # End MainModel