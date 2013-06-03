<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
*
* @author       Everlon Passos <dev@everlon.com.br>
* @link         http://www.everlon.com.br
* @version      0.1 (em desenvolvimento)
* @copyright    2013
*
*/

class Emails extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->model('Model_vader');
        $this->load->library(array('pagination','table'));
        $this->load->helper(array('language', 'funcoes'));
        $this->load->language('form');
        $this->load->view('top');
    }
    
    function index()
    {
        # Acessa o Model, executa a função get_all() e recebe os contatos
        $conteudo = Model_vader::get_all(0, 'webmail_config');

        
        $tmpl = array ( 'table_open'=>'<table border="0" cellpadding="4" cellspacing="0" class="table table-hover">', 'heading_row_start'=>'<tr align="left">' );
        $this->table->set_template($tmpl);

        $this->table->set_heading('#', 'E-Mail', 'Servidor IMAP', 'Servidor SMTP', 'Porta IMAP', 'Prot. de Segurança', 'Porta SMTP', 'Prot. Segurança', 'Senha', '');
        $data['caption_title']  = 'Contas de E-Mails';
        $data['html_paginacao'] = NULL; //$this->pagination->create_links();

            foreach ($conteudo->result() as $dados)
            {
                # Criar o Alerta de Exclusão
                $alerta_exclusao = '<!-- Modal -->
                                    <div id="myModal_'.$dados->id.'" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                <h3 id="myModalLabel">Deseja realmente excluir?</h3>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                                            <a href="'.site_url('emails/del').'/'.$dados->id.'"><button class="btn btn-danger">Excluir</button></a>
                                        </div>
                                    </div>';

                $tb_cl_1 = array('data'=>$dados->id, 'style'=>'max-width:30px; min-width:10px');
                $tb_cl_2 = array('data'=>$dados->user.'@'.$dados->domain, 'style'=>'max-width:300px; min-width:100px');
                $tb_cl_3 = array('data'=>$dados->imap, 'style'=>'max-width:300px; min-width:100px');
                $tb_cl_4 = array('data'=>$dados->smtp, 'style'=>'max-width:300px; min-width:100px');
                $tb_cl_5 = array('data'=>$dados->imap_port, 'style'=>'max-width:300px; min-width:100px');
                $tb_cl_6 = array('data'=>$dados->imap_protocol, 'style'=>'max-width:300px; min-width:100px');
                $tb_cl_7 = array('data'=>$dados->smtp_port, 'style'=>'max-width:300px; min-width:100px');
                $tb_cl_8 = array('data'=>$dados->smtp_protocol, 'style'=>'max-width:300px; min-width:100px');
                $tb_cl_9 = array('data'=>$dados->password, 'style'=>'max-width:300px; min-width:100px');

                $this->table->add_row
                (
                    $tb_cl_1, $tb_cl_2, $tb_cl_3, $tb_cl_4, $tb_cl_5, $tb_cl_6, $tb_cl_7, $tb_cl_8, $tb_cl_9,
                        '<div style="float:right; width:140px; padding:0;">
                            <a class="c-view" href="'.site_url('emails/save').'/'.$dados->id.'" title="Alterar">
                            <button class="btn btn-primary" type="submit">Alterar</button></a>
                            <a href="#myModal_'.$dados->id.'" role="button" class="btn btn-danger" data-toggle="modal" title="Apagar">Excluir</a>
                        <div>', $alerta_exclusao
                );
            }

        $data['html_lista']  = $this->table->generate();
        $data['form_action'] = 'emails/save';

        $this->load->view('view_table2col', $data);
        $this->load->view('footer');

    } # index

    function save($id=NULL)
    {
        if($id)
        {
            $data = objeto2Array_limpo(Model_vader::get_by_id( 'webmail_config', $id )->result());
            $data = array('alt'=>1, 'id'=>$id)+$data;
        }
        else { $data = NULL; }

            if($data['alt'] == 1)
            {
                $data['caption_button'] = 'Alterar';
                $data['caption_title']  = 'Alterar de Conta de E-Mail';
            }
            else
            {
                $data['caption_button'] = 'Cadastrar';
                $data['caption_title']  = 'Cadastro de Conta de E-Mail';
                $data['id'] = '';
            }

            $data['form_action'] = $this->config->item('admin_folder').'emails/data_save/';
            $data['btn_back']    = $this->config->item('admin_folder').'emails/';

            $lista_campos = $this->db->list_fields( 'webmail_config' );

            foreach ($lista_campos as $key => $field)
            {
                switch ($field)
                {
                    case 'user':
                    case 'domain':

                    case 'imap':
                    case 'smtp':

                    case 'imap_port':
                    case 'smtp_port':

                    case 'imap_protocol':
                    case 'smtp_protocol':
                    
                    case 'smtp_auth':
                    case 'password':
                        $data['label_campo'][] = array('label'=>$field);
                        break;
                }
            }

            $this->load->view('view_table_itens_save', $data);
            $this->load->view('footer');
    } # save


    function data_save()
    {
        $dados_form = $this->input->post();
        unset($dados_form['submit']);

        $id = (empty($dados_form['id'])) ? NULL : $dados_form['id']; # Verifica se existe valor ID

        $query = $this->Model_vader->save( 'webmail_config', $dados_form, $id );
        $this->index();
    }

    function del($id)
    {
        Model_vader::del( 'webmail_config', $id );
        $data['emphasis_classes']   = 'text-error';
        $data['message']            = '<div class="alert alert-error">Excluido com sucesso!</div>';
        $data['url']                = 'emails';

        # Mensagem
        $this->load->view('mensagens', $data);
    }

} # Class