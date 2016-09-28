<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sat_model extends CI_Model
{
	
	public function __construct() 
	{        
    	parent::__construct();
		
		$this->load->model('uteis_model');
		$this->load->model('satitens_model');
		$this->load->model('satpgto_model');
		
	}
	
	private function geraLoteId()
	{
		return $this->uteis_model->getGUID();	
	}
	
	public function incluirNFSAT($nfSAT = array(), $id_un_negocio = 0)
	{
		
		$retorno = true;
		
		if(!$this->nfExiste($nfSAT["identificadorNF"], $id_un_negocio))
		{
		
			$this->db->trans_begin();
			
			
			$nfSAT["proc_id"] = $this->geraLoteId();
				
				
			$itensNF = $nfSAT["itens"];
			unset($nfSAT["itens"]);
			
			$pagamentoNF = $nfSAT["pagamento"];
			unset($nfSAT["pagamento"]);
			
			$this->db->insert('tb_sat', $nfSAT);
	        
	        //echo 'TB_SAT '.$this->db->last_query();
			
			//Itens
			if ($this->db->trans_status())
			{
				$retorno = $this->satitens_model->incluirItensNFSAT($itensNF, $nfSAT["proc_id"], $id_un_negocio);
			
				//Forma de Pagamento
				if ($retorno)
				{
					$retorno = $this->satpgto_model->incluirPgtoNFSAT($pagamentoNF, $nfSAT["proc_id"]);				
				}
				else
				{
					$retorno = false;
				}
				
			}
			else
			{
				$retorno = false;
			}
			
			
			//$this->db->trans_rollback();
			
			if($retorno)
				$this->db->trans_commit();
			else
				$this->db->trans_rollback(); 
		}
		return $retorno;
		
	
		
	}


	public function incluirCancNFSAT($nfCancSAT = array(), $id_un_negocio = 0)
	{
		$retorno = false;
		
		$idNF = $this->getIDnf($nfCancSAT['chCanc'], $id_un_negocio);
		
		if($idNF)
		{
			$this->db->where('proc_id', $idNF);
			
			unset($nfCancSAT['chCanc']);
			
			$retorno = $this->db->update('tb_sat', $nfCancSAT);
			
		}

		return $retorno;
		
	}	
	
	
	public function getIDnf($idNF, $id_un_negocio = 0)
	{
		$where ['id_un_negocio'] = $id_un_negocio;
		$where ['IdentificadorNF'] = $idNF;
		
		$aux = $this->getNFSATDB($where);
		
		$retorno = FALSE;
		if(count($aux) == 1)
		{
			$retorno = $aux[0]['proc_id'];
		}
		
		return $retorno;
		
	}
	
	public function nfExiste($idNF, $id_un_negocio = 0)
	{
		$retorno = false;
		
		$aux = $this->getIDnf($idNF, $id_un_negocio);
		if($aux <> "")
		{
			$retorno = true;
		}

		return $retorno;
		
	}
	
	
	private function getNFSATDB($where)
	{
		$this->db->select("*");
		$this->db->from('tb_sat');
		
		if(!isset($where))
			$this->db->where('1','2');
		
		if(isset($where['id_un_negocio']))
			$this->db->where('tb_sat.id_un_negocio',$where['id_un_negocio']);
		
		
		if(isset($where['IdentificadorNF']))
			$this->db->where('tb_sat.IdentificadorNF',$where['IdentificadorNF']);
		
		$query = $this->db->get();
		
		$rs = $query->result_array();
		
		//var_dump($rs);
		
		return $rs;
		
	}
	
}