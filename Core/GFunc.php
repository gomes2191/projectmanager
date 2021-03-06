<?php
    /**
     * GFunc - possui inúmeras funções amplamente utilizadas no sistema.
     *
     * @copyright 2021 FAGA - Tecnologia
     * @package  GClinic
     * @author   Francisco <gomes.tisystem@gmail.com>
     * @license  gclinic.com Proprietário
     * @link     www.gclinic.com.br
     * @since    0.2
     */
    class GFunc
    {
        /**
         * Verifica se a chave existe no array e se ela tem algum valor.
         * Obs.: Essa função está no escopo global, pois, vamos precisar muito da mesma.
         *
         * @param array $array O array
         * @param int   $key   chave do array
         *
         * @return null|array Retorna array ou null.
         */
        static function chkArray($array, $key)
        {
            // Verifica se a chave existe no array
            if (isset($array[$key]) && !empty($array[$key])) {
                // Retorna o valor da chave
                return $array[$key];
            }

            // Retorna nulo por padrão
            return null;
        }

        /**
         * Verifica se a url possui o valor passado se sim, aplica
         * a classe de menu ativo se não, não faz nada.
         *
         * @param array  $url_vetor - valor do tipo array
         * @param string $value - valor do tipo string
         *
         * @return string|true|false Retorna um valor dinâmico.
         */
        static function isSite()
        {
            if (filter_input(INPUT_SERVER, 'REDIRECT_URL')) {
                $url_vetor = (array_filter(explode('/', filter_input(INPUT_SERVER, 'REDIRECT_URL')), function ($value) {
                    return '' !== $value;
                }));
            } else {
                $url_vetor = (array_filter(explode('/', filter_input(INPUT_SERVER, 'REQUEST_URI')), function ($value) {
                    return '' !== $value;
                }));
            }
            (count($url_vetor) > 1) ? array_shift($url_vetor) : false;
            $sites = func_get_args();
            foreach ($sites as $site) {
                if (in_array($site, $url_vetor)) {
                    return true;
                }
            }

            return false;
        }

        /**
         *  Recebe uma determinada data e um verificador, verifica se a data atende
         *  o verificador passado e retorna true se sim e false se não.
         *  Exemplos:
         *   var_dump(validaDataHora('2014-02-28 12:12:12')); # true
         *   var_dump(validaDataHora('2014-02-30 12:12:12')); # false
         *   var_dump(validaDataHora('2015-06-26', 'Y-m-d')); # true
         *   var_dump(validaDataHora('2015/06/26', 'Y-m-d')); # false
         *   var_dump(validaDataHora('28/02/2014', 'd/m/Y')); # true
         *   var_dump(validaDataHora('30/02/2014', 'd/m/Y')); # false
         *   var_dump(validaDataHora('14:50', 'H:i')); # true
         *   var_dump(validaDataHora('14:77', 'H:i')); # false
         *   var_dump(validaDataHora(14, 'H')); # true
         *   var_dump(validaDataHora('14', 'H')); # true
         *
         * @param mixed $date
         * @param mixed $format
         * @param mixed $v_date
         *
         * @return true|false retorna true ou false
         * */
        public static function validaDataHora($date, $format = 'Y-m-d H:i:s')
        {
            if (!empty($date) && $v_date = date_create_from_format($format, $date)) {
                $v_date = date_format($v_date, $format);

                return $v_date && $v_date == $date;
            }

            return null;
        }

        /**
         *  Converte uma determinada data para o formato desejado.
         *  Exemplos:
         *  var_dump(convertDataHora('d m Y', 'Y-m-d', '06 02 2025')); 2025-02-06
         *  var_dump(convertDataHora('d-m-Y', 'm/d/Y H:i', '06-02-2014')); 02/06/2014 12:39
         *  var_dump(convertDataHora('Y-m-d', 'l F Y  H:i', '2014-02-06')); Thursday February 2014  12:38
         *
         * @param mixed $format    tipo mixed
         * @param mixed $to_format tipo mixed
         * @param mixed $date      tipo mixed
         * @param mixed $timezone  tipo mixed
         *
         * @return null|string retorna o resultado
         */
        public static function convertDataHora($format, $to_format, $date = null, $timezone = null)
        {
            // Verifica se a data informada e verdadeira se sim executa a função se não retorna NULL
            if (self::validaDataHora($date, $format)) {
                $timezone = $timezone ? $timezone : new DateTimeZone(date_default_timezone_get());
                $f_date = date_create_from_format($format, $date, $timezone);

                return date_format($f_date, $to_format);
            }
            return null;
        }

        /**
         * Codifica e Decodifica  a string passada dependendo do parâmetro.
         *
         * @param bool   $encode Valor true ou false.
         * @param string $decode Valor do tipo string.
         *
         * @return int|string Retorna a codificação ou a decodificação da encriptação.
         */
        public static function encodeDecode($encode = false, $decode = false)
        {
            if ($encode == true) {
                $rand = rand(100, 900);

                return base64_encode($encode . $rand);
            } else {
                $decode = base64_decode($decode);

                return substr($decode, 0, -3);
            }
        }


        /**
         * Remove tudo o que não for número.
         *
         * @param string $valor recebe número formato string.
         *
         * @return int Retorna um valor inteiro.
         */
        public static function onlyFilterNumber($valor)
        {
            return (int) (preg_replace('/[^0-9]/', '', $valor));
        }
    }