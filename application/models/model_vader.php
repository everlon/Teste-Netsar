<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
*
* @author       Everlon Passos <dev@everlon.com.br>
* @link         http://www.everlon.com.br Página pessoal do Autor
* @version      1.0 (em desenvolvimento)
* @copyright    2012-2013 Grupo MG Contábil
*
*/

class Model_vader extends CI_Model
{
    # Obtêm o número registros da tabela no BD
    function count_rows( $tabela ) { return $this->db->count_all_results( $tabela ); }

    # Obtem todos os itens da tabela
    function get_all($de=0, $tabela, $campos=NULL, $onde=NULL, $onde_for=NULL, $referenciado=NULL, $quantidade=NULL, $ordem=NULL)
    {
        if (empty($tabela)) { return FALSE; } # Tabela é obrigatório informar

        # Quais campos devem ser retornados
        if (!empty($campos)) { $this->db->select( $campos ); }

        # Comando SQL Where
        if( isset($onde) && isset($onde_for) ) { $this->db->where($onde, $onde_for); }

        # Definindo o $referenciado colocamos um WHERE na Query
        # Usado em ENTRADA DE VALORES MENSAIS para separar Energia, Gastos Fixos e Gastos Variaveis
        if( isset($referenciado) ) { $this->db->where('local_ref', $referenciado); }

        # Limite
        if (!empty($quantidade)) { $this->db->limit($quantidade, $de); }

        # Ordenar 
        if (!empty($ordem)) { $this->db->order_by($ordem); }
        
        # Executa a consulta
        return $this->db->get( $tabela );

    } # get_all

    # Obtem todos os itens da tabela agrupados
    function get_all_group($de=0, $tabela, $campos=NULL, $onde=NULL, $onde_for=NULL, $agrupados=NULL, $quantidade=NULL, $ordem=NULL)
    {
        if (empty($tabela)) { return FALSE; } # Tabela é obrigatório informar

        # Quais campos devem ser retornados
        if (!empty($campos)) { $this->db->select( $campos ); }

        # Comando SQL Where
        if( isset($onde) && isset($onde_for) ) { $this->db->where($onde, $onde_for); }

        # Definindo o $referenciado colocamos um WHERE na Query
        if( isset($agrupados) ){ $this->db->group_by($agrupados);  }
        
        # Limite
        if (!empty($quantidade)) { $this->db->limit($quantidade, $de); }

        # Ordenar 
        if (!empty($ordem)) { $this->db->order_by($ordem); }
        
        # Executa a consulta
        return $this->db->get( $tabela );

    } # get_all

    # Obtêm todos os campos de um registro em particular
    function get_by_id($tabela, $id)
    {
        $this->db->where('md5(id)', md5($id));
        $resultado = $this->db->get($tabela);
        
        if( $resultado->num_rows == 0 ) { return FALSE; }
        else { return $resultado; }

    } # get_by_id

    # Adicionar
    function add($tabela, $dados)
    {
        $this->db->insert($tabela, $dados);

        return (bool) $this->db->affected_rows();
        //return $this->db->last_query(); # Mostra ultima Query executada
    }

    # Atualizar
    function update($id, $tabela, $dados)
    {       
        $this->db->where('id', $id);
        $this->db->update($tabela, $dados);

        //return (bool) $this->db->affected_rows(); 
        return $this->db->last_query(); # Mostra ultima Query executada
    }

    # Deletar
    function del($tabela, $id)
    {
        $this->db->where('id', $id);
        $this->db->delete($tabela);
        return (bool) $this->db->affected_rows(); 
        //return $this->db->last_query(); # Mostra ultima Query executada
    }

    function save($tabela, $dados, $id)
    {
        if (empty($tabela) || empty($dados)) { return FALSE; } # Tabela é obrigatório informar

        if ( !empty($id) && $this->get_by_id($tabela, $id)->num_rows > 0 ) # Verifica se foi informado o $id
        {
            /**
            * Altera o conteúdo informado
            */
            $this->db->where('id', $id);
            $this->db->update($tabela, $dados);
            return $this->db->last_query(); # Mostra ultima Query executada
        }
        else # Se não foi informado o $id ele Adiciona
        {
            $this->db->insert($tabela, $dados);
            return (bool) $this->db->affected_rows();
        }
    }

} # Class

/* End of file Model_vader.php */