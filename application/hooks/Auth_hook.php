<?php
if (!defined( 'BASEPATH')) exit('No direct script access allowed'); 

class Auth_hook
{
    private $ci;
    public function __construct()
    {
        $this->ci =& get_instance();
        //!$this->ci->load->library('session') ? $this->ci->load->library('session') : false;
        //!$this->ci->load->helper('url') ? $this->ci->load->helper('url') : false;
    }    
 
    public function valida_login()
    {
    	
		//echo $this->ci->uri->uri_string.'<hr>';
    	//var_dump( $this->ci->uri);
		
        //if(  $this->ci->uri->segment(1) != "Auth" || $this->ci->uri->segment(1) != "auth")
        
        if(strripos($this->ci->uri->uri_string, "Auth") === FALSE)
        {
            //echo var_dump($this->ci->session->userdata);
				
			//echo 'nao eh Auth<br>';
            if($this->ci->session->userdata('user_id')  == FALSE )
            {
                redirect('Auth');
            	//echo 'user_id nao setado';
			}
        }
    }
}
/*
/end hooks/Auth_hook.php
*/