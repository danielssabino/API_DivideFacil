<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Satpgto_model extends CI_Model
{
	
	public function __construct() 
	{        
    	parent::__construct();		
	}
	
	public function incluirPgtoNFSAT($PgtosNFSAT = array(), $procID = "")
	{
		$retorno = true;
		
		foreach ($PgtosNFSAT as $key => $pgtoNF) 
		{		
			$pgtoNF["proc_id"] = $procID;			
			$this->db->insert('tb_sat_pagamento', $pgtoNF);	
			//echo 'TB_SAT_PAGAMENTO '.$this->db->last_query();								
		}
		
		if(isset($error))
		{
			var_dump($error);
			$retorno = false;
		}
			
		return $retorno;
		
	
		
	}
	
	
}