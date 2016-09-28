<?php 
require APPPATH.'/libraries/REST_Controller.php';

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class SATNFs extends REST_Controller 
{


	function __construct()
    {
        parent::__construct();
		$this->load->model('sat_model');
		
	}

	public function ProcessaArqSAT_POST()
	{
			
		$id_un_negocio = $this->post('id_un_negocio');
		$SATJson = $this->post('nfSAT');
		$dataHr_envio = $this->post('dthr');
		$file_name = $this->post('filename');
		
		
		$json = json_decode($SATJson);
		
		
		$retorno = "";
		
		//var_dump($json);
		
		if(property_exists($json, "CFeCanc"))
		{
			
			$nfCancSAT = array();
			$nfCancSAT["infCFe_cancelamento"] = $json->CFeCanc->infCFe->{'@Id'};
			$nfCancSAT["chCanc"] = $json->CFeCanc->infCFe->{'@chCanc'};
			
			$nfCancSAT["dEmi_canc"] = date('Ymd', strtotime($json->CFeCanc->infCFe->ide->dEmi));
			$nfCancSAT["hEmi_canc"] = date('His', strtotime($json->CFeCanc->infCFe->ide->hEmi)); 
			
			$nfCancSAT["data_envio_cancNF"] = $dataHr_envio; 
			$nfCancSAT["arquivo_origem_canc"] = $file_name; 
			$nfCancSAT["jsonCancelamento"] = $SATJson;
			
			
			if($this->sat_model->incluirCancNFSAT($nfCancSAT, $id_un_negocio))
			{
			    $retorno = 'OK';
			}
            else 
            {
                $retorno = 'FALHA';
            }
			
		}
		else 
		{	
			
			$nfSAT = array();
			$nfSATItens = array();
			$nfSATMeioPgto = array();
				
			//`proc_id`, --> Incluir no Model
			$nfSAT["identificadorNF"] = $json->CFe->infCFe->{'@Id'};
			
			//IDE
			$nfSAT["nCFe"] = $json->CFe->infCFe->ide->nCFe; 
			
			//$nfSAT["dEmi"] = $json->CFe->infCFe->ide->dEmi; 
			$nfSAT["dEmi"] = date('Ymd', strtotime($json->CFe->infCFe->ide->dEmi));
			
			$nfSAT["hEmi"] = date('His', strtotime($json->CFe->infCFe->ide->hEmi)); 
			
			//$nfSAT["CNPJ"] = $json->CFe->infCFe->ide->CNPJ;
			if(isset($json->CFe->infCFe->dest->CPF))
				$nfSAT["CNPJ"] = $json->CFe->infCFe->dest->CPF;
	
			//Total
			$nfSAT["vCFe"]  = $json->CFe->infCFe->total->vCFe;
			
			//Pagamento
			$i = 1;
			
			//Uma única forma de pagamento
			if(isset($json->CFe->infCFe->pgto->MP->cMP))
			{
				
				$nfSATMeioPgto[$i]["cMP"]  = $json->CFe->infCFe->pgto->MP->cMP;
				$nfSATMeioPgto[$i]["vMP"] = $json->CFe->infCFe->pgto->MP->vMP;
				
			}
			//Multiplos meios de pagamento
			else 
			{
				
				foreach ($json->CFe->infCFe->pgto->MP as $meioPgto)
				{
					$nfSATMeioPgto[$i]["cMP"]  = $meioPgto->cMP;
					$nfSATMeioPgto[$i]["vMP"] = $meioPgto->vMP;
					$i++;
				}	
			}	
			$nfSAT["pagamento"] = $nfSATMeioPgto;
			
			$nfSAT["vTroco"] = $json->CFe->infCFe->pgto->vTroco;
			
			
			$nfSAT["id_un_negocio"] = $id_un_negocio; 
			$nfSAT["data_criacaoNF"] = $dataHr_envio; 
			
			
			$nfSAT["arquivo_origem"] = $file_name; 
			
			$nfSAT["conteudoNFJson"] = $SATJson;
			
			//NF com item um item
			if(isset($json->CFe->infCFe->det->prod->cProd))
			{
				$nfSATItens[$json->CFe->infCFe->det->{'@nItem'}]["nItem"] = $json->CFe->infCFe->det->{'@nItem'};
				$nfSATItens[$json->CFe->infCFe->det->{'@nItem'}]["cProd"] = $json->CFe->infCFe->det->prod->cProd;
				$nfSATItens[$json->CFe->infCFe->det->{'@nItem'}]["qCom"] = $json->CFe->infCFe->det->prod->qCom;
				$nfSATItens[$json->CFe->infCFe->det->{'@nItem'}]["vUnCom"] = $json->CFe->infCFe->det->prod->vUnCom; 
				$nfSATItens[$json->CFe->infCFe->det->{'@nItem'}]["vProd"] = $json->CFe->infCFe->det->prod->vProd;
				
				if(property_exists($json->CFe->infCFe->det->prod, "vDesc"))
					$nfSATItens[$json->CFe->infCFe->det->{'@nItem'}]["vDesc"] = $json->CFe->infCFe->det->prod->vDesc;
				
				$nfSATItens[$json->CFe->infCFe->det->{'@nItem'}]["vItem"] = $json->CFe->infCFe->det->prod->vItem;
				$nfSATItens[$json->CFe->infCFe->det->{'@nItem'}]["geral"] = $json->CFe->infCFe->det->prod->cProd." - ".$json->CFe->infCFe->det->prod->xProd;
	
			}
			// NF com mais de um Item
			else 
			{
				foreach ($json->CFe->infCFe->det as $key => $nfItem) 
				{
					//var_dump($nfItem);	
					$nfSATItens[$nfItem->{'@nItem'}]["nItem"] = $nfItem->{'@nItem'};
					$nfSATItens[$nfItem->{'@nItem'}]["cProd"] = $nfItem->prod->cProd;
					$nfSATItens[$nfItem->{'@nItem'}]["qCom"] = $nfItem->prod->qCom;
					$nfSATItens[$nfItem->{'@nItem'}]["vUnCom"] = $nfItem->prod->vUnCom; 
					$nfSATItens[$nfItem->{'@nItem'}]["vProd"] = $nfItem->prod->vProd;
					
					if(property_exists($nfItem->prod, "vDesc"))
						$nfSATItens[$nfItem->{'@nItem'}]["vDesc"] = $nfItem->prod->vDesc;
					
					$nfSATItens[$nfItem->{'@nItem'}]["vItem"] = $nfItem->prod->vItem;
					$nfSATItens[$nfItem->{'@nItem'}]["geral"] = $nfItem->prod->cProd." - ".$nfItem->prod->xProd;
							
				}	
			}
					
			
			
			$nfSAT["itens"] = $nfSATItens;
			if($this->sat_model->incluirNFSAT($nfSAT, $id_un_negocio))
    			$retorno = 'OK';
            else 
            {
                $retorno = 'FALHA';
            }

		}


		$this->set_response($retorno, REST_Controller::HTTP_OK);

	}
	
	

	
	
}
	