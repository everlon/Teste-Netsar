<?php
/**
* @author     Everlon Passos <dev@everlon.com.br>
* @link       http://www.everlon.com.br Página pessoal do Autor
* @version    1.0 (em desenvolvimento)
* @copyright  2012-2013 Grupo MG Contábil
*
*/
      function e($texto)
      {
          echo $texto; # Não você não esta vendo demais... é a função mais ridícula que já vi, tinha que postar aqui :o)
      }
      
      # Limpa formato
      function limpaString($var) { return preg_replace('/[^0-9]/', '', $var); }

      function data_to_db($date)
      {
          return preg_replace(
              "/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/i",
              "$3/$2/$1",
              $date
          );
      }

      /*
      function date2br($date)
      {
          return preg_replace(
              "/([0-9]{4})\/([0-9]{2})\/([0-9]{2})/i",
              "$3/$2/$1",
              $date
          );
      } */

      function data_br($data)
      {
            if(strpos($data, '-')){ return implode('/', array_reverse(explode('-', $data))); }
            else{ return $data; }
      }

      function formata_CNPJ($numero)
      {
          $numero = preg_replace('/[^0-9]/', '', $numero);
          $valor  = str_pad(preg_replace('[^0-9]', '', $numero), 14, '0', STR_PAD_LEFT);
          return preg_replace('/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})$/', '$1.$2.$3/$4-$5', $valor);
      }

      function detalhes_CNPJ( $cnpj )
      {
          $cnpj_limpo = limpaString( $cnpj ); # Limpar primeiro
          
          $cnpj_numr = substr($cnpj_limpo, 0 , 8);  # Numero da empresa
          $cnpj_fili = substr($cnpj_limpo, 8 , 4);  # Numero da filial
          $cnpj_vald = substr($cnpj_limpo, 12 , 2); # Validador

          return array( $cnpj_numr, $cnpj_fili, $cnpj_vald );
      }

      function formata_CEP($numero)
      {
          $numero = preg_replace('/[^0-9]/', '', $numero);
          $valor  = str_pad(preg_replace('[^0-9]', '', $numero), 7, '0', STR_PAD_LEFT);
          return preg_replace('/^(\d{2})(\d{3})(\d{3})$/', '$1.$2-$3', $valor);
      }

      function valida_Email($email)
      {
          $string = strtolower($email);
          if (preg_match( '/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $string))
          { 
                return $string;
          }
      }

      function formata_TEL($numero)
      {
          $numero = preg_replace('/[^0-9]/', '', $numero);
          $valor  = str_pad(preg_replace('[^0-9]', '', $numero), 10, '0', STR_PAD_LEFT);
          return preg_replace('/^(\d{2})(\d{4})(\d{4})$/', '($1) $2-$3', $valor);
      }

      function formatarCPF_CNPJ($campo, $formatado=TRUE)
      {
            # retira formato
            $codigoLimpo = preg_replace("[' '-./ t]", '', $campo);
            
            # pega o tamanho da string menos os digitos verificadores
            $tamanho = (strlen($codigoLimpo) -2);
            
            # verifica se o tamanho do código informado é válido
            if ($tamanho != 9 && $tamanho != 12)
            {
                return FALSE;
            }
 
            if ($formatado)
            {
                # seleciona a máscara para cpf ou cnpj
                $mascara = ($tamanho == 9) ? '###.###.###-##' : '##.###.###/####-##';
 
                $indice = -1;
                for ($i=0; $i < strlen($mascara); $i++)
                {
                    if ($mascara[$i]=='#') $mascara[$i] = $codigoLimpo[++$indice];
                }
                
                #retorna o campo formatado
                $retorno = $mascara;
            }
            else
            {
                //se não quer formatado, retorna o campo limpo
                $retorno = $codigoLimpo;
            }
            return $retorno;
 
      } # formatarCPF_CNPJ

      function moeda_br($campo=NULL, $mask=NULL)
      {
        if(isset($campo))
        { 
          $campo_n = 'R$ ' . number_format($campo, 2, ',', '.'); # retorna no formato R$ 100.000,50
          //$mask = 'decimal';
          return $campo_n;
        }
        
        else{ return FALSE; }
      }

      function cria_senha()
      {
        $pwd = sha1(uniqid(time(), true));
        $pwd = substr($pwd, 0, 8);
        return $pwd;
      }

      function objeto2Array($objeto)
      {
          $arr = array();
          for($i = 0; $i < count($objeto); $i++) { $arr[] = get_object_vars( $objeto[$i] ); }
          return $arr;
      }

      function objeto2Array_limpo($objeto)
      { # Deixa um array simples, sem multi-level
          $arr = array();
          
          for($i = 0; $i < count($objeto); $i++) 
          { 
            $arr[] = get_object_vars( $objeto[$i] ); 
          }

          foreach ($arr as $value) 
          { 
            foreach ($value as $key => $valor) { $arr_final[$key] = $valor; }
          }
          
          return $arr_final;
      }

      function zeroAleft($campo=NULL, $zeros=1)
      {
        # Define a quantidade de números preenchendo a esquerda com zeros
        if ( isset($campo) ) { return str_pad( $campo, (int)$zeros, "0", STR_PAD_LEFT ); }
        else { return FALSE; }
      }

      function Debug($value)
      {
        /*
        * Formas de uso
        * @ Debug($_POST);
        * @ Debug($_GET);
        * @ Debug($_REQUEST);
        */
          echo "<pre>";
          print_r($value);
          echo "<pre>";

          exit(); # You shall not pass!
      }

      # Acrescentando a função para servidores anteriores ao PHP 5.3
      # (PHP 5 >= 5.3.0)
      # array_replace — Replaces elements from passed arrays into the first array

      if (!function_exists('array_replace'))
      {
        function array_replace( array &$array, array &$array1 )
        {
          $args = func_get_args();
          $count = func_num_args();

          for ($i = 0; $i < $count; ++$i) {
            if (is_array($args[$i])) {
              foreach ($args[$i] as $key => $val) {
                $array[$key] = $val;
              }
            }
            else {
              trigger_error(
                __FUNCTION__ . '(): Argumento #' . ($i+1) . ' não é um array',
                E_USER_WARNING
              );
              return NULL;
            }
          }

          return $array;
        }
      }

      function voltar($i=1) { echo '<script type="text/javascript">history.go(-'.$i.')</script>'; }

      # Verifica se numero é Negativo
      function isNegative($num)
      {
          if ($num < 0){ return FALSE; }
          else { return TRUE; } 
      }

      # Função para somatória de um array tratando valores com vírgula
      function somarArray( $valores=array() )
      {
          if( !empty($valores) )
          {
              $total = array_sum( str_replace( ',', '.', $valores ) );
              return str_replace( '.', ',', $total );
          }
          else { return FALSE; }
      }

      # Colocar campos em branco no inicio do Array
      function add_field_Array($array, $qnt)
      {
        $qnt_array = count($array); # Pegar quantos itens tem no array
          
        if ($qnt_array < $qnt )
        {
          $qnt_array = $qnt - $qnt_array;
          for ($i=1; $i < $qnt_array; $i++) { array_unshift($array, NULL); }
        }
        return $array;
      }

/* End of file funcoes_helper.php */
/* Location: helpers/funcoes_helper.php */
