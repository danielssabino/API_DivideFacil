<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Satitens_model extends CI_Model
{
	
	public function __construct() 
	{        
    	parent::__construct();
		
		$this->load->model('produtos_model');
		
	}
	
	public function incluirItensNFSAT($itensNFSAT = array(), $procID = "", $id_un_negocio = 0)
	{
		
		$DEPARA_produtosLinkID = $this->produtos_model->retornaProdutosIdxBySistOrig($id_un_negocio);
		
		$retorno = true;
		
		if(count($itensNFSAT) < 1)
		{
			$error[] = "Itens NF não capturados";
		}
		
		foreach ($itensNFSAT as $key => $itemNF) 
		{
				
			if(array_key_exists($itemNF["cProd"], $DEPARA_produtosLinkID))
			{
				$itemNF["proc_id"] = $procID;	
				
				$itemNF["produto_lnk_id"] = $DEPARA_produtosLinkID[$itemNF["cProd"]]["produto_lnk_id"];
				unset($itemNF["cProd"]);
				
				$this->db->insert('tb_sat_itens', $itemNF);	
				
				//echo 'TB_SAT_ITENS '.$this->db->last_query();						
			}
			else
			{
				//TODO	
				$error[] = "Produto ".$itemNF["cProd"]." / ".$itemNF["geral"]." nao cadastrado";
			}
				
		}
		
		if(isset($error))
		{
			var_dump($error);
			$retorno = false;
		}
			
		return $retorno;
		
	}
	
	
}