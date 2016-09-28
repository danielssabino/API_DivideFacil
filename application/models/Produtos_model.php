<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Produtos_model extends CI_Model
{
	
	//var $id_un_negocio;
	
	public function __construct() 
	{        
    	parent::__construct();
		//$this->id_un_negocio = $this->session->userdata('id_un_negocio');

	}
	
	
	public function retornaProdutosIdxBySistOrig($id_un_negocio = 0)
	{
		$where['id_un_negocio'] = $id_un_negocio;
		$rsAux = $this->getProductsDB($where);
		
		$resultado = array();
		
		foreach ($rsAux as $row) 
		{
			$resultado[$row["codigo_produto_sist_origem"]]['produto_lnk_id'] = $row["produto_lnk_id"];
			$resultado[$row["codigo_produto_sist_origem"]]['codigo_produto_sist_orig'] = $row["codigo_produto_sist_origem"];
			
		}
		
		return $resultado;
			
	}
	
	//Função que faz consulta no banco 
	private function getProductsDB($where)
	{
		
		//$this->db->select("tb_produtos_lnk.estocavel");
		//$this->db->select("tb_produtos.produto");
		$this->db->select("*");
		//$this->db->select("unCompra.unidade as unidadeCompra");
		//$this->db->select("unVenda.unidade as unidadeVenda");
		
		$this->db->from('tb_produtos');
		$this->db->join('tb_produtos_lnk', 'tb_produtos.produto_id = tb_produtos_lnk.produto_id');
		$this->db->join('tb_subcategoria', 'tb_produtos.subcategoria_id = tb_subcategoria.subcategoria_id');
		$this->db->join('tb_categorias', 'tb_subcategoria.categoria_id = tb_categorias.categoria_id');
		
		//$this->db->join('tb_unidades_medida unCompra', 'tb_produtos.id_unid_compra = unCompra.unidade_id 
		//											and tb_categorias.id_un_legal = unCompra.id_un_legal', 'left');
		//$this->db->join('tb_unidades_medida unVenda', 'tb_produtos.id_unid_venda = unVenda.unidade_id 
		//										   and tb_categorias.id_un_legal = unCompra.id_un_legal', 'left');
		//$this->db->join('tb_unidades_medida unEstoque', 'tb_produtos.id_unid_estoque = unEstoque.unidade_id 
		//											 and tb_categorias.id_un_legal = unCompra.id_un_legal', 'left');
		
		if(isset($where['id_un_negocio']))
			$this->db->where('tb_produtos_lnk.id_un_negocio',$where['id_un_negocio']);
		
		if(isset($where['estocavel']))
			$this->db->where('tb_produtos_lnk.estocavel',$where['estocavel']);
		
		
		if(!isset($where))
			$this->db->where('1','2');
		
				
		$this->db->order_by("tb_categorias.ordem_exibicao", "ASC");
		$this->db->order_by("tb_categorias.categoria", "ASC");
		$this->db->order_by("tb_subcategoria.ordem_exibicao", "ASC");
		$this->db->order_by("tb_subcategoria.subcategoria", "ASC");
		$this->db->order_by("tb_produtos_lnk.ordem_exibicao", "ASC");
		$this->db->order_by("tb_produtos.produto", "ASC");
		
		
		
		$query = $this->db->get();
		
		$rs = $query->result_array();
		
		//var_dump($rs);
		
		return $rs;
		
	}
	


}
	