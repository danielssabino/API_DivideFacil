<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Temp_model extends CI_Model
{
	
	public function __construct() 
	{        
    	parent::__construct();
		

	}
	
	
	public function add($conteudo=array())
	{
	
		//echo "<h1> estou no addLotes</h1>";
		$retorno = true;
		$this->db->trans_begin();
		
		$retorno = $this->db->insert('tb_temp_processo', $conteudo);
			
		if($retorno)
			$this->db->trans_commit();
		else
			$this->db->trans_rollback(); 
				
		return $retorno;
		
	}  
	
	
}