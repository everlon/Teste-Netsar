<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->view('top');
    }

    public function index()
    {
        $this->load->view('view_home');
        $this->load->view('footer');
    }
}