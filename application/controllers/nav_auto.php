<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
*
* @author       Everlon Passos <dev@everlon.com.br>
* @link         http://www.everlon.com.br
* @version      0.1 (em desenvolvimento)
* @copyright    2013
*
*/

class Nav_auto extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->model('Model_vader');
        $this->load->view('top');
    }
    
    function index()
    {
        require_once(APPPATH.'libraries/autoload.php');

        # Abrir página
        $browser      = WebDriver\Browser::create('firefox', 'http://localhost:4444/wd/hub');
        $browser->open('http://NOMEDODOMINIO.com.br/login.php');

        # Definir o Campo de Usuário
        $input = $browser->element(WebDriver\By::css('#login')); 
        $input->type('USUARIO');

        # Definir o Campo de Senha
        $input = $browser->element(WebDriver\By::css('#password'));
        $input->type('SENHA');

        # Clicar no botão de login
        $browser->element(WebDriver\By::xpath("//img[@onclick='fullwin(); Formulario.submit()']"))->click();

        # Acessar a página diretamente
        $formulario = $browser->open('http://labs.netsarnetwork.com.br/NetSarOperadorConfigurarWebMail.php');

        # Pegar dados do campo account
        $campo_account          = $formulario->element(WebDriver\By::name('account'));
        $campo_domain           = $formulario->element(WebDriver\By::name('domain'));
        $campo_imap_server      = $formulario->element(WebDriver\By::name('imap_server'));
        $campo_imap_port        = $formulario->element(WebDriver\By::name('imap_port'));
        $campo_imap_security    = $formulario->element(WebDriver\By::name('imap_security'));
        $campo_smtp_server      = $formulario->element(WebDriver\By::name('smtp_server'));
        $campo_smtp_port        = $formulario->element(WebDriver\By::name('smtp_port'));
        $campo_smtp_security    = $formulario->element(WebDriver\By::name('smtp_security'));
        $campo_smtp_auth        = $formulario->element(WebDriver\By::name('smtp_auth'));
        $campo_password         = $formulario->element(WebDriver\By::name('password'));

        # Exibir dados
        $data['user']            = $campo_account->getAttribute("value");
        $data['domain']          = $campo_domain->getAttribute("value");
        $data['imap']            = $campo_imap_server->getAttribute("value");
        $data['imap_port']       = $campo_imap_port->getAttribute("value");
        $data['imap_protocol']   = $campo_imap_security->getAttribute("value");
        $data['smtp']            = $campo_smtp_server->getAttribute("value");
        $data['smtp_port']       = $campo_smtp_port->getAttribute("value");
        $data['smtp_protocol']   = $campo_smtp_security->getAttribute("value");
        $data['smtp_auth']       = $campo_smtp_auth->getAttribute("value");
        $data['password']        = $campo_password->getAttribute("value");

        //$browser->close();

        # Verificando se pelo menos o campo Account contem dados.
        if( empty($data['user']) )
        {
            $data['url']     = '.';
            $data['message'] = '<div class="alert alert-error">Erro ao importar dados.</div>';
            $this->load->view('mensagem_selenium', $data);
            $this->load->view('footer');
        }
        else
        {
            # Estou colocando aqui somente os dizeres de conclusão, onde este teria que testar cada operação.
            $data['url']        = 'emails';
            $data['message']    = '<div class="alert alert-success">Sucesso ao importar!</div><br />
                                   <p class="text-info">
                                    <br>1 - URL acessada <span class="badge badge-success">OK</span>
                                    <br>2 - Informando Usuário e Senha <span class="badge badge-success">OK</span>
                                    <br>3 - Aberto menu "Ferramentas" <span class="badge badge-success">OK</span>
                                    <br>4 - Aberto link "Configurar Conta de E-Mail" <span class="badge badge-success">OK</span>
                                    <br>5 - Feito leitura de todos os campos e salvo no histórico <span class="badge badge-success">OK</span>
                                    <br>6 - Inserindo os dados em todos campos e salvo as configurações <span class="badge badge-success">OK</span>
                                   </p>';


                # Salvando os dados na DB
                foreach ($data as $key => $value)
                {
                    switch ($key)
                    {
                        case 'message':
                        case 'url':
                            break;
                        
                        default:
                            $dados_save[$key] = $value;
                            break;
                    }
                }
                $this->Model_vader->save( 'webmail_config', $dados_save, NULL );


            $this->load->view('mensagem_selenium', $data);
            $this->load->view('footer');

        } # else

    } # index()

} # Class
