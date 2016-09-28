<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ProcessaArquivo extends CI_Controller 
{


	var $id_un_negocio;

/* PDF */

	// Some settings
	var $multibyte = 4; // Use setUnicode(TRUE|FALSE)
	var $convertquotes = ENT_QUOTES; // ENT_COMPAT (double-quotes), ENT_QUOTES (Both), ENT_NOQUOTES (None)
	var $showprogress = FALSE; // TRUE if you have problems with time-out

	// Variables
	var $filename = '';
	var $decodedtext = '';
	
/**************************/

	// REVER
	var $data = '';
	var $lotes = array();


	function __construct()
    {
        parent::__construct();
		
		//Verificar no provedor
		set_time_limit(60*5);
		
		$this->id_un_negocio = $this->session->userdata('id_un_negocio');
		
		$this->load->library('PDF2Text');
        $this->load->model('lotes_model');
    }
	
	public function index()
    {
       $this->formUpload();
    }
	
	
	public function formUpload()
	{
		$dados['mensagem'] = $this->session->flashdata('msgProcArquivoOK');
		$this->load->view('ProcessaArquivoForm_view',$dados);;
	}
	
	public function sendFile()
	{
		$config['upload_path']          = './uploads/';
        $config['allowed_types']        = 'pdf';
		$filename = 'upload_'.date("Y-m-d_h-i-s");
		$config['file_name']        = $filename;
		
		$this->load->library('upload', $config);
		
		
		if ($this->upload->do_upload('arquivo'))
        {
        	$this->processaPDF($filename);
        }
		else 
		{
            $data = array('error' => $this->upload->display_errors());
            $this->load->view('ProcessaArquivoForm_view', $data);
		}
		
	}
	
	
	private function processaPDF_Original($filename)
	{
		$arrayPDFText = $this->getPDFArrayText($filename);
		
		//Processa PDF
		
		$quebra = $arrayPDFText;
		
		$linhasArray = sizeof($quebra) - 2;
		
  		$a = 0;
  		
		//print_r($quebra);
		
		$this->setData(substr( $quebra[16], 5));
		$hora = $quebra[19];
		
		$ctrID = 22;
		
		$controle = true;
		
		//$produtos = $this->produtos_model->retornaProdutosIdxBySistOrig();
		
		$linha = 0;
		while ($controle)
		{
			
			$ctrID = $this->verificaQuebra($quebra, $ctrID);
			
			if ($ctrID > $linhasArray)
			{
				$controle = false;
				break;
			}
	
			//echo 'ctrID:'.$ctrID.'-'.$quebra[$ctrID].'<br>';
			
			$dados[$linha]['codigo_produto_sist_origem'] = $quebra[$ctrID++];
			
			//echo '<h1>'.$produtos[$quebra[$ctrID++]]["produto_lnk_id"].'</h1>';
			
			if ($ctrID > $linhasArray)
			{
				$controle = false;
				break;
			}
			
			
			//echo 'ctrID:'.$ctrID.'-'.$quebra[$ctrID].'<br>';
			//$dados[$linha]['descricao'] = $quebra[$ctrID++];
			$ctrID++;
			
			if ($ctrID > $linhasArray)
			{
				$controle = false;
				break;
			}
			
			//echo 'ctrID:'.$ctrID.'-'.$quebra[$ctrID].'<br>';
			//$dados[$linha]['grupo'] = $quebra[$ctrID++];
			$ctrID++;
			
			if ($ctrID > $linhasArray)
			{
				$controle = false;
				break;
			}
			
			//echo 'ctrID:'.$ctrID.'-'.$quebra[$ctrID].'<br>';
			//$dados[$linha]['subgrpo'] = $quebra[$ctrID++];
			$ctrID++;
			
			if ($ctrID > $linhasArray)
			{
				$controle = false;
				break;
			}
			
			//echo 'ctrID:'.$ctrID.'-'.$quebra[$ctrID].'<br>';
			$dados[$linha]['quantidade'] = str_replace(',', '.', $quebra[$ctrID++]);
			
			if ($ctrID > $linhasArray)
			{
				$controle = false;
				break;
			}
			
			//echo 'ctrID:'.$ctrID.'-'.$quebra[$ctrID].'<br>';
			//$dados[$linha]['und'] = $quebra[$ctrID++];
			$ctrID++;
			
			if ($ctrID > $linhasArray)
			{
				$controle = false;
				break;
			}
			
			//echo 'ctrID:'.$ctrID.'-'.$quebra[$ctrID].'<br>';
			$dados[$linha]['data_movimentacao'] = $this->data;
			
			if ($ctrID > $linhasArray)
			{
				$controle = false;
				break;
			}
			$ctrID++; // somando uma linha da data
			
			
			//echo 'ctrID:'.$ctrID.'-'.$quebra[$ctrID].'<br>';
			$dados[$linha]['hora_movimentacao'] = $quebra[$ctrID];
			
			if ($ctrID > $linhasArray)
			{
				$controle = false;
				break;
			}
			$ctrID++; // somando uma linha da hora
			
			
			
			//echo 'ctrID:'.$ctrID.'-'.$quebra[$ctrID].'<br>';
			$dados[$linha]['valor_total'] = str_replace('R$ ', '', str_replace(',', '.',$quebra[$ctrID++]));
			
			
			//echo 'linha:'.$linha.'<hr>';
			$linha++;
			
			//echo 'substr:'.substr($quebra[$ctrID], 0,4).'<br>';
				
			if ($ctrID > $linhasArray)
			{
				$controle = false;
			}
			
			
			//TODO
			// chamada metido de lote
			// Array com movimento dentro do array lote
			//Model lote chama model movimento e gera id do lote
		
		}
		
		
		$lote = array();
		$lote[0]["id_un_negocio"] = $this->id_un_negocio;
		$lote[0]["tipo_lote_id"] = 1; //IREL
		$lote[0]["filename"] = $filename.'.pdf'; 
		$lote[0]["lote_obs"] = "Lote de Teste";
		$lote[0]["movimentacoes"] = $dados;
		
		
		$this->lotes_model->addLotes($lote);
		
			
		//echo '<hr>';
		
		//var_dump($dados);
		
		
		
	}





//************************************************

private function processaPDF($filename)
	{
		$arrayPDFText = $this->getPDFArrayText($filename);
		
		//Processa PDF
		
		$quebra = $arrayPDFText;
		
		$linhasArray = sizeof($quebra) - 2;
		
  		$a = 0;
  		
		$campos[1] = "codigo_produto_sist_origem";
		$campos[2] = "produto";
		$campos[3] = "grupo";
		$campos[4] = "subgrupo";
		$campos[5] = "quantidade";
		$campos[6] = "unidade";
		$campos[7] = "data_movimentacao";
		$campos[8] = "hora_movimentacao";
		$campos[9] = "valor_total";
		
	
		$tratNumerico = array(5=>"quantidade", 9=>"valor_total");
		$tratData = array(7=>"data_movimentacao");
		
		$dados=array();
		
		
		//print_r($quebra);
		
		$this->setData(substr( $quebra[16], 5));
		$hora = $quebra[19];
		
		$controleData = $this->data;
		
		
		$ctrID = 22;
		
		$controle = true;
		
		//$produtos = $this->produtos_model->retornaProdutosIdxBySistOrig();
		
		$teste = FALSE;
		
		$linha = 0;
		while ($controle)
		{
			$ctrID = $this->verificaQuebra($quebra, $ctrID);
			
			if($controleData <> $this->data)
			{
				//echo 'DataControle '.$controleData.'<br>';	
				//echo 'Data Controle diferente Data aquivo<br>';
				//echo 'Data '.$this->data.'<br>';	
				
				//add Lote
				$this->addLote($this->id_un_negocio, 1, $filename, $controleData, $dados, 'Lote: '.sizeof($this->lotes));
				
				$controleData = $this->data;
				$dados = array();
				
				//echo 'DataControle '.$controleData.'<br>';	
				//echo 'Data Controle diferente Data aquivo<br>';
				//echo 'Data '.$this->data.'<br>';	
				
			}
			
			
			
			if ($ctrID > $linhasArray)
			{
				$controle = false;
				break;
			}
			
			if($linhasArray - $ctrID < 9)
			{
				
				$controle = false;
				break;
			}
	
			
			for ($i=1; $i<=sizeof($campos); $i++)
			{
				
				if(array_key_exists($i, $tratNumerico))
				{
					$dados[$linha][$campos[$i]] = $this->trataNumerico($quebra[$ctrID]);
				}
				else if(array_key_exists($i, $tratData))
				{
					$dados[$linha][$campos[$i]] = $controleData;
				}
				else
				{
					$dados[$linha][$campos[$i]] = $quebra[$ctrID];
				}
				
				$ctrID++;
								
				//Ver se precisa mesmo
				if ($ctrID > $linhasArray)
				{
					$controle = false;
					break;
				}
				
			}
			
			//echo 'Linha: '.$linha .'<br>';
			//var_dump($dados[$linha]);
			//echo '<hr>';
			
			
			$linha++;
			
			
			
			
			//var_dump($dados);
			//echo '<hr>';		
			
		}

		//Inclui último lote ou quando não há quebra
		$this->addLote($this->id_un_negocio, 1, $filename, $controleData, $dados, 'Lote: '.sizeof($this->lotes));
		$controleData = $this->data;
		$dados = array();
		
		
		//var_dump($this->lotes);
		
		
		$retorno = $this->lotes_model->addLotes($this->lotes);
		
		
		
		if($retorno)
		{
			//echo 'OK';	
			$this->session->set_flashdata('msgProcArquivoOK', "Arquivo [".$filename.".pdf] Importado com sucesso.");
			redirect('ProcessaArquivo/formUpload');	
		}
		else 
		{
			echo 'Falha ao importar Lote';	
		}
		
		
		
		
		
		//echo '<hr>';
		
		//var_dump($dados);
		
		
		
	}

//************************************************
	private function trataNumerico($valor)
	{
		return str_replace('R$ ', '', str_replace(',', '.',$valor));
	}
	
	private function addLote($id_un_negocio, $tipo_lote, $file_name, $data_movimentacao, $movimentacoes, $observacao)
	{
			
		$idx = sizeof($this->lotes) + 1;	
			
		$this->lotes[$idx]["id_un_negocio"] = $this->id_un_negocio;
		$this->lotes[$idx]["tipo_lote_id"] = $tipo_lote; //IREL
		$this->lotes[$idx]["filename"] = $file_name.'.pdf'; 
		$this->lotes[$idx]["lote_obs"] = 'Lote ['. $idx. '] adicionado ref. '. $data_movimentacao;
		$this->lotes[$idx]["data_venda"] = $data_movimentacao;
		$this->lotes[$idx]["movimentacoes"] = $movimentacoes;
		
		//echo 'Lote Adicionado '.$idx.' Data: '.$data_movimentacao.' <br>';
		//var_dump($this->lotes);
		//echo '<br>';
		
		
	}

	private function getPDFArrayText($filename)
	{
		// Decodifica PDF	
		$a = new PDF2Text();
		$a->setFilename('./uploads/'.$filename.'.pdf');
		$a->setUnicode(TRUE);
		$a->decodePDF();
		
		return explode("\n", $a->output());
		
	}

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	

//REVER
	function verificaQuebra($quebra, $ctrID)
	{
		
		if(substr($quebra[$ctrID], 0,9) == 'Operador:')
		{
			//echo '<hr>Quebra de página<hr>';	
			$ctrID+=7;
		}

		if(substr($quebra[$ctrID+2], 0,9) == 'Operador:') // Quando ultima linha é total
		{
			//echo '<hr>Quebra de página+2<hr>';	
			$ctrID+=9;
		}
		
		
		if($quebra[$ctrID+2] == 'Grupo' && $quebra[$ctrID+3] == 'SubGrupo')
		{
			//echo '<hr>Cabecalho<hr>';	
			$ctrID+=9;
		}
		
		if(substr($quebra[$ctrID], 0,4) == 'Data')
		{
			//$data = substr($quebra[$ctrID], 5);
			$this->setData(substr($quebra[$ctrID], 5));
			$ctrID+=3;
			//echo 'ctrID:'.$ctrID.'<br>';
			//echo '<hr>Quebra de data<hr>';
			
		}
		
		if(substr($quebra[$ctrID], 0,4) == 'Hora')
		{
			$hora = substr($quebra[$ctrID], 5);
			$ctrID+=3;
			//echo 'ctrID:'.$ctrID.'<br>';
			//echo '<hr>Quebra de hora<hr>';
			
		}
		
		//novo
		
		$ctrID = $this->verificaQuebra2($quebra, $ctrID);
		
		return $ctrID;
	}
	
	function verificaQuebra2($quebra, $ctrID)
	{
		
		if(substr($quebra[$ctrID], 0,9) == 'Operador:')
		{
			//echo '<hr>Quebra de página<hr>';	
			$ctrID+=7;
		}
		
		
		if($quebra[$ctrID+2] == 'Grupo' && $quebra[$ctrID+3] == 'SubGrupo')
		{
			//echo '<hr>Cabecalho<hr>';	
			$ctrID+=9;
		}
		
		if(substr($quebra[$ctrID], 0,4) == 'Data')
		{
			//$data = substr($quebra[$ctrID], 5);
			$this->setData(substr($quebra[$ctrID], 5));
			$ctrID+=3;
			//echo 'ctrID:'.$ctrID.'<br>';
			//echo '<hr>Quebra de data<hr>';
			
		}
		
		if(substr($quebra[$ctrID], 0,4) == 'Hora')
		{
			$hora = substr($quebra[$ctrID], 5);
			$ctrID+=3;
			//echo 'ctrID:'.$ctrID.'<br>';
			//echo '<hr>Quebra de hora<hr>';
			
		}
		
		//$ctrID = $this->verificaQuebra($quebra, $ctrID);
		
		return $ctrID;
	}
	

	function setData($data)
	{
		//19/11/2015
		$this->data = substr($data, 7, 4).'-'.substr($data, 4,2).'-'.substr($data, 1,2);
	}


/* PDF */
	function setFilename($filename) {
		// Reset
		$this->decodedtext = '';
		$this->filename = $filename;
	}
	
		function output($echo = false) {
		if($echo) echo $this->decodedtext;
		else return $this->decodedtext;
	}

	function setUnicode($input) {
		// 4 for unicode. But 2 should work in most cases just fine
		if($input == true) $this->multibyte = 4;
		else $this->multibyte = 2;
	}

	function decodePDF() {
		// Read the data from pdf file
		$infile = @file_get_contents($this->filename, FILE_BINARY);
		if (empty($infile))
			return "";
		
		// Get all text data.
		$transformations = array();
		$texts = array();		

		// Get the list of all objects.
		preg_match_all("#obj[\n|\r](.*)endobj[\n|\r]#ismU", $infile . "endobj\r", $objects);
		$objects = @$objects[1];
		
		// Select objects with streams.
		for ($i = 0; $i < count($objects); $i++) {
			$currentObject = $objects[$i];

			// Prevent time-out
			@set_time_limit ();
			if($this->showprogress) {
//				echo ". ";
				flush(); ob_flush();
			}

			// Check if an object includes data stream.
			if (preg_match("#stream[\n|\r](.*)endstream[\n|\r]#ismU", $currentObject . "endstream\r", $stream )) {
				$stream = ltrim($stream[1]);
				// Check object parameters and look for text data.
				$options = $this->getObjectOptions($currentObject);

				if (!(empty($options["Length1"]) && empty($options["Type"]) && empty($options["Subtype"])) )
//				if ( $options["Image"] && $options["Subtype"] )
//				if (!(empty($options["Length1"]) &&  empty($options["Subtype"])) )
					continue;

				// Hack, length doesnt always seem to be correct
				unset($options["Length"]);

				// So, we have text data. Decode it.
				$data = $this->getDecodedStream($stream, $options);

				echo 'txt Data<br>';
				echo $stream;

				if (strlen($data)) {
	                if (preg_match_all("#BT[\n|\r](.*)ET[\n|\r]#ismU", $data . "ET\r", $textContainers)) {
						$textContainers = @$textContainers[1];
						$this->getDirtyTexts($texts, $textContainers);
					} else
						$this->getCharTransformations($transformations, $data);
				}
			}
		}

		// Analyze text blocks taking into account character transformations and return results.
		$this->decodedtext = $this->getTextUsingTransformations($texts, $transformations);
	}


	function decodeAsciiHex($input) {
		$output = "";

		$isOdd = true;
		$isComment = false;

		for($i = 0, $codeHigh = -1; $i < strlen($input) && $input[$i] != '>'; $i++) {
			$c = $input[$i];

			if($isComment) {
				if ($c == '\r' || $c == '\n')
					$isComment = false;
				continue;
			}

			switch($c) {
				case '\0': case '\t': case '\r': case '\f': case '\n': case ' ': break;
				case '%':
					$isComment = true;
				break;

				default:
					$code = hexdec($c);
					if($code === 0 && $c != '0')
						return "";

					if($isOdd)
						$codeHigh = $code;
					else
						$output .= chr($codeHigh * 16 + $code);

					$isOdd = !$isOdd;
				break;
			}
		}

		if($input[$i] != '>')
			return "";

		if($isOdd)
			$output .= chr($codeHigh * 16);

		return $output;
	}

	function decodeAscii85($input) {
		$output = "";

		$isComment = false;
		$ords = array();

		for($i = 0, $state = 0; $i < strlen($input) && $input[$i] != '~'; $i++) {
			$c = $input[$i];

			if($isComment) {
				if ($c == '\r' || $c == '\n')
					$isComment = false;
				continue;
			}

			if ($c == '\0' || $c == '\t' || $c == '\r' || $c == '\f' || $c == '\n' || $c == ' ')
				continue;
			if ($c == '%') {
				$isComment = true;
				continue;
			}
			if ($c == 'z' && $state === 0) {
				$output .= str_repeat(chr(0), 4);
				continue;
			}
			if ($c < '!' || $c > 'u')
				return "";

			$code = ord($input[$i]) & 0xff;
			$ords[$state++] = $code - ord('!');

			if ($state == 5) {
				$state = 0;
				for ($sum = 0, $j = 0; $j < 5; $j++)
					$sum = $sum * 85 + $ords[$j];
				for ($j = 3; $j >= 0; $j--)
					$output .= chr($sum >> ($j * 8));
			}
		}
		if ($state === 1)
			return "";
		elseif ($state > 1) {
			for ($i = 0, $sum = 0; $i < $state; $i++)
				$sum += ($ords[$i] + ($i == $state - 1)) * pow(85, 4 - $i);
			for ($i = 0; $i < $state - 1; $i++) {
				try {
					if(false == ($o = chr($sum >> ((3 - $i) * 8)))) {
						throw new Exception('Error');
					}
					$output .= $o;
				} catch (Exception $e) { /*Dont do anything*/ }
			}
		}

		return $output;
	}

	function decodeFlate($data) {
		return @gzuncompress($data);
	}

	function getObjectOptions($object) {
		$options = array();

		if (preg_match("#<<(.*)>>#ismU", $object, $options)) {
			$options = explode("/", $options[1]);
			@array_shift($options);

			$o = array();
			for ($j = 0; $j < @count($options); $j++) {
				$options[$j] = preg_replace("#\s+#", " ", trim($options[$j]));
				if (strpos($options[$j], " ") !== false) {
					$parts = explode(" ", $options[$j]);
					$o[$parts[0]] = $parts[1];
				} else
					$o[$options[$j]] = true;
			}
			$options = $o;
			unset($o);
		}

		return $options;
	}

	function getDecodedStream($stream, $options) {
		$data = "";
		if (empty($options["Filter"]))
			$data = $stream;
		else {
			$length = !empty($options["Length"]) ? $options["Length"] : strlen($stream);
			$_stream = substr($stream, 0, $length);

			foreach ($options as $key => $value) {
				if ($key == "ASCIIHexDecode")
					$_stream = $this->decodeAsciiHex($_stream);
				elseif ($key == "ASCII85Decode")
					$_stream = $this->decodeAscii85($_stream);
				elseif ($key == "FlateDecode")
					$_stream = $this->decodeFlate($_stream);
				elseif ($key == "Crypt") { // TO DO
				}
			}
			$data = $_stream;
		}
		return $data;
	}

	function getDirtyTexts(&$texts, $textContainers) {
		for ($j = 0; $j < count($textContainers); $j++) {
			if (preg_match_all("#\[(.*)\]\s*TJ[\n|\r]#ismU", $textContainers[$j], $parts))
				$texts = array_merge($texts, array(@implode('', $parts[1])));
			elseif (preg_match_all("#T[d|w|m|f]\s*(\(.*\))\s*Tj[\n|\r]#ismU", $textContainers[$j], $parts))
				$texts = array_merge($texts, array(@implode('', $parts[1])));
			elseif (preg_match_all("#T[d|w|m|f]\s*(\[.*\])\s*Tj[\n|\r]#ismU", $textContainers[$j], $parts))
				$texts = array_merge($texts, array(@implode('', $parts[1])));
		}

	}

	function getCharTransformations(&$transformations, $stream) {
		preg_match_all("#([0-9]+)\s+beginbfchar(.*)endbfchar#ismU", $stream, $chars, PREG_SET_ORDER);
		preg_match_all("#([0-9]+)\s+beginbfrange(.*)endbfrange#ismU", $stream, $ranges, PREG_SET_ORDER);

		for ($j = 0; $j < count($chars); $j++) {
			$count = $chars[$j][1];
			$current = explode("\n", trim($chars[$j][2]));
			for ($k = 0; $k < $count && $k < count($current); $k++) {
				if (preg_match("#<([0-9a-f]{2,4})>\s+<([0-9a-f]{4,512})>#is", trim($current[$k]), $map))
					$transformations[str_pad($map[1], 4, "0")] = $map[2];
			}
		}
		for ($j = 0; $j < count($ranges); $j++) {
			$count = $ranges[$j][1];
			$current = explode("\n", trim($ranges[$j][2]));
			for ($k = 0; $k < $count && $k < count($current); $k++) {
				if (preg_match("#<([0-9a-f]{4})>\s+<([0-9a-f]{4})>\s+<([0-9a-f]{4})>#is", trim($current[$k]), $map)) {
					$from = hexdec($map[1]);
					$to = hexdec($map[2]);
					$_from = hexdec($map[3]);

					for ($m = $from, $n = 0; $m <= $to; $m++, $n++)
						$transformations[sprintf("%04X", $m)] = sprintf("%04X", $_from + $n);
				} elseif (preg_match("#<([0-9a-f]{4})>\s+<([0-9a-f]{4})>\s+\[(.*)\]#ismU", trim($current[$k]), $map)) {
					$from = hexdec($map[1]);
					$to = hexdec($map[2]);
					$parts = preg_split("#\s+#", trim($map[3]));

					for ($m = $from, $n = 0; $m <= $to && $n < count($parts); $m++, $n++)
						$transformations[sprintf("%04X", $m)] = sprintf("%04X", hexdec($parts[$n]));
				}
			}
		}
	}
	function getTextUsingTransformations($texts, $transformations) {
		$document = "";
		for ($i = 0; $i < count($texts); $i++) {
			$isHex = false;
			$isPlain = false;

			$hex = "";
			$plain = "";
			for ($j = 0; $j < strlen($texts[$i]); $j++) {
				$c = $texts[$i][$j];
				switch($c) {
					case "<":
						$hex = "";
						$isHex = true;
                        $isPlain = false;
					break;
					case ">":
						$hexs = str_split($hex, $this->multibyte); // 2 or 4 (UTF8 or ISO)
						for ($k = 0; $k < count($hexs); $k++) {

							$chex = str_pad($hexs[$k], 4, "0"); // Add tailing zero
							if (isset($transformations[$chex]))
								$chex = $transformations[$chex];
							$document .= html_entity_decode("&#x".$chex.";");
						}
						$isHex = false;
					break;
					case "(":
						$plain = "";
						$isPlain = true;
                        $isHex = false;
					break;
					case ")":
						$document .= $plain;
						$isPlain = false;
					break;
					case "\\":
						$c2 = $texts[$i][$j + 1];
						if (in_array($c2, array("\\", "(", ")"))) $plain .= $c2;
						elseif ($c2 == "n") $plain .= '\n';
						elseif ($c2 == "r") $plain .= '\r';
						elseif ($c2 == "t") $plain .= '\t';
						elseif ($c2 == "b") $plain .= '\b';
						elseif ($c2 == "f") $plain .= '\f';
						elseif ($c2 >= '0' && $c2 <= '9') {
							$oct = preg_replace("#[^0-9]#", "", substr($texts[$i], $j + 1, 3));
							$j += strlen($oct) - 1;
							$plain .= html_entity_decode("&#".octdec($oct).";", $this->convertquotes);
						}
						$j++;
					break;

					default:
						if ($isHex)
							$hex .= $c;
						elseif ($isPlain)
							$plain .= $c;
					break;
				}
			}
			$document .= "\n";
		}

		return $document;
	}
		
}
	