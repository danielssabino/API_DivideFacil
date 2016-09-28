<style>
*{
	border: 0;
	margin: 0;
	padding: 0;
}
a{
	color: rgb(132, 156, 168);
	text-decoration: none;
	-webkit-transition-duration:450ms;
}
a:hover{
	color: rgb(67, 73, 77);	
}
p{
	margin-bottom: 1em;
}
ul{
	margin: 0.5em 0;
}
header,footer{
	display: block;
}
html{
	height: 100%;
	width: 100%;
}
body{
	height: 90%;
	background: #FFF;
	font-size: 12px;
	color: rgb(100,100,100);
	font-family: "Lucida Grande", "Helvetica Neue", "Helvetica", sans-serif;
	text-shadow: rgb(255,255,255) 0px 1px 0px;
}
#wrapper{
	width: 720px;
	margin: 40px auto;
}
header{
	margin: 1.2em 0;
}
footer{
	margin-top: 2.5em;
	font-size: 10px;
	color: rgb(132,132,132);
}

h1,
h1 a{
	font-size: 12px;
}
h1{
	font-weight: normal;
	color:rgb(180,182,185);
}
h1 a{
	font-weight: 600;
	color:rgb(150,152,155);
}
ul{
	list-style: none;

}
li{
	font-size: 11px;
	line-height: 14px;
	display: block;
	height: 22px;
	padding-top: 6px;
	padding-left: 16px;
	border-bottom: 1px solid rgb(235,238,240);
	box-shadow:rga(255,255,255) 0 1px 0;
	-webkit-transition-duration:200ms;
	background: rgb(248, 249, 252);
}
li.file:hover,
li.folder:hover{
	background: rgb(160, 170, 177);
	border-bottom: 1px solid rgb(255,255,255);
}
li:last-child{
	border-bottom: 0;
	box-shadow:none;
}
li span{
	display: block;
	float: left;
	text-shadow:none;
}
li span.name{
	width: 400px;
	overflow: hidden;
}
li span.size em{
	font-size: 10px;
	color: rgb(150,150,160);
	font-style: normal;
	text-shadow:none;
	margin-left: 2px;
}
li.folder span.size,
li.file span.size{
	margin-left: -22px;
}
li span.time{
	float: right;
	width: 120px;
	color: rgb(122, 144, 158);
	text-align: center;
}
li.file span.time{
	margin-right: 10px;
}
li a{
	color: rgb(132, 156, 168);
	text-shadow:none;
}
li a:hover{
	color: rgb(54, 176, 221);
}
li:hover a{
	color: rgb(255,255,255);
}
li:hover span.size em,
li:hover span.size{
	color: rgb(245,245,245);
}
li:hover span.time{
	color: rgb(230, 235, 240);
}
li.header span.size,
li.header span.time,
li.header{
	color: rgb(90,90,90);
	font-size: 9px;
	text-transform: uppercase;
}
li.footer{
	xtext-align: center;
	color: rgb(150,155,160);
	font-size: 10px;
	margin-top: 3px;
}
li span,
li span em,
li span a{
	-webkit-transition-duration:100ms;
}

/* Filetype Icons */
li.file,
li.folder,
li.file:hover,
li.folder:hover{
	background-repeat:no-repeat;
	background-position: 16px 5px;
	text-indent: 22px;	
}
li.folder{
	background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAQ1JREFUeNqkU7sNwjAQ9QWTICSE6KhSUbFBWIIdKGmpGAKJCWACCmr6MAEVFVRIDHHYZ599siNRxJKV58T3PucYEFH1GYXqOfThdLXP1szGugEA+sDOzPpu8MpjJffsNmtyQMW8gYcgagxGO5FYAT1/yxEaqZjiLlKHXZ3mNRUyEAWkCSo8mQO9ChEsFzXKfKmDLkeP50sFAj0onDIUniQ5HC8fGigIHYHWnWpBMc0h+kSV1VCHzjC77Ad2EHEUbZnKUqtENrebYo5gN1Xl0OmBlwv6sQCyoxY9GI+qLPe/O8ImbITPbDqZZ9lFZnm8EH+2L0fYni+3o8F1GtG5gNiC2Ni3qdvT+77X+SfAAEvqkZolhaOxAAAAAElFTkSuQmCC);
}
li.file:hover,
li.folder:hover{
	background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAFpJREFUeNpi/P//PwMlgImBQjC4DZgGxGwETQAFIg4MAseAWAKPGoIGgMBzILakxAAQ+AnEadjUkRKIzOSEAcwLNuR64SQQS5MbiHOAmA2fZhBmHM0LDAABBgCGVDSYjuNH3wAAAABJRU5ErkJggg==);
}

li.type-image{
	background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAATlJREFUeNqkkq9OA0EQxmcv9SjeBIOpgoSkAk9SU1RrEAieAoPBIRCEBNUnQKNI06cgadImFQdULL/Z27mbPVB0cnP77Tfzzc7+CTFG2ccq2dMG+rt9mEftJIQgNpr9xRu+npyHgSVChN9iaed9scK2A1ckWpIX9YQpZDmVT+CrgTWJycH3Os/ckPEEbe2LV2WrcUuhLUD9FXyVMbx8p4OSFJfoD9F1uskHtoKdgHfgF/hT8COcxjZJ4wu4t7DGd/gM9kPTEL4TX8BdlodbdBB8gTuYpTWJ+Ij4FPiJXzRFe+/A3fWacQwc53YRyAH+ZAt4cdFB3obu7xl/Y/rV8LqqHBI/Zjzr3oMr4LahtzACj3Rqe22Kt7eUcoszcHbjV/DtNrh8pUUBveO+uFut3HjXkXuS/7UfAQYA17qzFYKU5M8AAAAASUVORK5CYII=);
}
li.type-audio{
	background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAATlJREFUeNqkUztOxEAMtaPUcAyKFRKHiERJyQHoqUB0LIug5AqcAVr6lejY6+wOk+G9jCfjBKhiyfHE9nv+TKIpJVkijSyUlo+X1/d7mE1xsitVlfo+PEdf7lrXN1cXj63lELz5a5xKphMi+IkZCSgP0C30FskB9oCkPS2UNpiSpivdtLUlITOOKSA2gPF+DPcJdAU9hf8MWde/duDmTTj7yp/JlpDbZm7dyUjg5u2RuHckmFw+gNplcrnLBS3iR2AFaJ9nF5IEi13i3M0Kpcl34EYgAcASuAuLFfDaYGkoZJjGX5cRGFjfZjf6DcyX5UT1S3Qd8RB4G7BH8O9cd08EwxfhiwViS9TSUW98uGd5dptPtuDI6swrvE0tPEpXggWcARlsi46T72C23PPStvsd/hVd+jv/CDAAQ1ayAGK49EIAAAAASUVORK5CYII=);
}
li.type-text{
	background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAANVJREFUeNpi/P//PwMlgAXG6J238RjQMEtGRka4JMhwZD4SOFWc5G+OYgAQgDTbI2tGNgTNsIMYLoACd5hCdJcQ9AIUVBFwOoYcugGMEOdiCKK44j8ShwXVdDCJ1XaYGLocCzaFQIPOgNSBDERTbwKzBKcBUNeZALViDQOIgTjDAO78aYjoQ3FFFsKrWAxA8l8Wws9ILgP7C9VbLDiiKBg1EUEtYGBYy8CImi6wugCoYC1qYvqPZgHudIAS79ii7j8DXi+A5FGTMrJByPkCbhml2RkgwAA9i3GQGmDgoAAAAABJRU5ErkJggg==);
}
li.type-document{
	background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAN9JREFUeNqkU9sNwjAM9EX9YgfESuzABEiMwQRIDMEQ/WAh/pBxHm7skBSkRkovTezL+dyCmWnLmHRxvT8YIIp8ivKUiYSQzXiZ4uV0hCMACoBmwbPgS15l0juT0E4O94IHwZvmhUYRa0lrpdmjliBJKKshyRJiCWKwTOgNMQg2cjCMAixEmpdJ/yQoN3Ilygp+iQitOTWBu6YNCYp0WDOLL6sqgk8g18JcQi2p1xWnQMX23NeutMZOtgv5E2YakaixQxOVxZbjFX4bahREabGN6ZpnK8B64fa3/s4fAQYA6oRv8KuGWCkAAAAASUVORK5CYII=);
}
li.type-script{
	background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAASJJREFUeNqkkz1uAkEMhceIjiZ3yQ24QLgATWo6ipSIgiJI4QgcAZEbcBzo6CKxu0w+z8wiY+2GSIxk+T3/jcfySIwxPHOkLfC1/U5AuYg8TJy/v6WggTWSLJKzJRcPBkerb2doktX/2nakdbSUUtuQ727oHE2+wM4lhr/G5J/QUAeRMXSduais4Wpr8iWxuwCBNWpEwAy9VA6uC1bbCKntMwauo4qEBQEb9Ek5uEKf4Bv0Qm09Q0zDwilXbbMk2kPrAV+seoaYZnAh8QO6Rw7wc2n3hYg5cIK+dA6xLJBWP4JX6E+Cq9IyOK6wH3ufUG5qnTuCd2ZY0xb7TXWLFOpSzu3CPxZJk3QHLHc70vlH7obI+fHBZcUT7yoiz37nXwEGAMvvnKrrNA13AAAAAElFTkSuQmCC);
}
li.type-generic{
	background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAMlJREFUeNqkU90RwiAMTu7YyEHcwRWcwxXcwem8k3IRaALhE+pDeQF64ftLyiJCZ1aww+P5akgGysztjuf77coDgC4+YtuBa4n8KNCCSykwtoaa7yurAQpTByv3vo+WFgCZJVlRfUyzxzIoDCMjb0NBPmucqkbWFlRuNL9lxyy8komCKiEu2+fCnFqoMok+2NWm5p+CwuEtmG8cjaUC/Rh9Jr6ds8eTNtKGueEsHA5SXglbZax+97ZgEum9B9dZMXkcaz77O38FGAA+6npWbXDqiwAAAABJRU5ErkJggg==);
}
li.type-app{
	background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAYJJREFUeNqkkz1LA0EQhm+OEwx30UbBKiA22ohgYW0rRBEsInYBG0UsBH+FQkCwtLNT0B8gFqKgpZWFIEQCtqKVzfnMfiTjWWbgvZmdj3d3ZvekLMtkGMn0c3x2vQpRR0Smde1JRa2QJonIoIj4G7mHB+21izT4TnBsERAFBYj7OKFESs/oEHJP+ydAGuCHwKLfwZ+C9Tb6Edezc4ZjYGrupCWI8h0OmYhPXqJqCv0QWwjERSxIbbUGzVDHMZ/wroCJ6FRiO/Y0HjkER1AO+HbJncP3CTajXyFVAjPhmoKCGXwb2B1wxala6DF0DeJaYu4n+9tCkqNuzfoyzoPi+7DZMupLqjPwvZc6nH3sHnqd5CbFTSVFvwS7sG2ng2I3gwK0sc7xjYbkgrCeatbfiieIbWf9yXqOOngHr/jqhvyDrCP0Auj+e8qRkWRmIDfYebjv+B5Uetoa69y8KU9AgB2SeXBn77vSniEryZWubWEn/EyN6sOyZEa0eM/Fhv2dfwUYAOqyo2jA4ZjtAAAAAElFTkSuQmCC);
}
li.type-archive{
	background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAStJREFUeNpi/P//PwMlgAVE9MzduIWRkcEbZBgjkIEOYOIgu2DSQLGDJckBDmADQJpBFEwxMgBphBmKZvZ/uAugIBqmkBhvwdSyIDnxPZI0im3IXkP3JgvMNKD4C5g4iEZXCHEUZhghe+EsNqeiGoQakGgG/G+EhiNSqGOLlf9AcbAX69Fd8AXdRmxRii7GhMR+D8aQwARjoFlA/P8bEEcA+b+AGER/BvLfYwuDNwywxMDAgBTvjAVADcZAhirQQD6gG98DXTEFxQVQZ78FUm+BXDAGisHYtdBY8gYZCGQ3QuVQoxEIPqJ7GWrwJahrDkP5h4FcPVhag3nhBRBrAfEF9MACatJAT9JAYACUeYScErOAkhOATDnkhAN1MraYeASUzwWzKc3OAAEGAI7dlKvJHLpmAAAAAElFTkSuQmCC);
}
li.type-video{
	background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAORJREFUeNqkU8ERwjAMszlm6Jsh2IMdWIE5WIEdWKPHEN2hr76MndpUDk0+zfUuTqPIsuKwiNCRcY7g+XoXJiNkZqrjejzuN04EPhTPRnTxRSLSeSoAkP0jsF+GKTHRwG3VgqqSAiXWHVYAjZh5O1DmfQUMe/pd4yD6oNOnq2BNYR7I3DG+5UHJJK5kcU9CdqqUQMEJ7E/owNS3WHyC3vlT4PGw1r8RgKGy20igwABjIzt1+kCAna91J/qNtG/BAeyAea+NA4NlJAXAvkR3RlHA1fdA1hSTncwNuD0WJOGjz/krwABwfIjPbdfMqQAAAABJRU5ErkJggg==);
}
</style>
<?php

error_reporting(1);

/***[ SETTINGS ]***/ 

// Set sorting properties.
$sort = array(
	array('key'=>'lname',	'sort'=>'asc'), // ... this sets the initial sort "column" and order ...
	array('key'=>'size',	'sort'=>'asc') // ... for items with the same initial sort value, sort this way.
);
// Files you want to hide form the listing
$ignore_list = array('');

/***[ DIRECTORY LOGIC ]***/
// Get this folder and files name.

$this_script = basename(__FILE__);
$this_folder = str_replace('/'.$this_script, '', $_SERVER['SCRIPT_NAME']);

$this_domain = $_SERVER['SERVER_NAME'];
$dir_name = explode("/", $this_folder);
//$dir_name = explode("/",dirname($_SERVER['REQUEST_URI']))
//$dir_path = explode("/", $this_folder);


	
// Declare vars used beyond this point.

$file_list = array();
$folder_list = array();
$total_size = 0;

$filetype = array(
	'doc' => array('doc','docs','pdf','pages','key','numbers','xls','ppt'),
	'text'		=> array('txt', 'rtf', 'text', 'nfo', 'md', 'markdown'),
	'audio'		=> array('aac', 'mp3', 'wav', 'wma', 'm4p'),
	'image'	=> array('ai', 'bmp', 'eps', 'gif', 'ico', 'jpg', 'jpeg', 'png', 'psd', 'psp', 'raw', 'tga', 'tif', 'tiff','icns'),
	'video'		=> array('mv4', 'bup', 'mkv', 'ifo', 'flv', 'vob', '3g2', 'bik', 'xvid', 'divx', 'wmv', 'avi', '3gp', 'mp4', 'mov', '3gpp', '3gp2', 'swf', 'mpg', 'mpeg'),
	'archive'	=> array('7z', 'dmg', 'rar', 'sit', 'zip', 'bzip', 'gz', 'tar','pkg','safariextz','bz2'),
	'app'		=> array('ipa', 'exe', 'app'),
	'script'	=> array('js', 'html', 'htm', 'xhtml', 'jsp', 'asp', 'aspx', 'php', 'xml', 'css', 'plist')
);

// Open the current directory...
if ($handle = opendir('.'))
{
	// ...start scanning through it.
    while (false !== ($file = readdir($handle)))
	{
		// Make sure we don't list this folder, file or their links.
        if ($file != "." && $file != ".." && $file != $this_script && !in_array($file, $ignore_list))
		{
			// Get file info.
			$stat				=	stat($file); // ... slow, but faster than using filemtime() & filesize() instead.
			$info				=	pathinfo($file);
			// Organize file info.
			$item['name']		=	$info['filename'];
			$item['lname']		=	strtolower($info['filename']);
			$item['ext']		=	$info['extension'];
			$item['lext']		=	strtolower($info['extension']);
			if($info['extension'] == '') $item['ext'] = '.';
			
			if(in_array($item[lext], $filetype['doc'])){
				$item['class'] = 'type-document';
			}elseif(in_array($item[lext], $filetype['text'])){
				$item['class'] = 'type-text';
			}elseif(in_array($item[lext], $filetype['audio'])){
				$item['class'] = 'type-audio';
			}elseif(in_array($item[lext], $filetype['image'])){
				$item['class'] = 'type-image';
			}elseif(in_array($item[lext], $filetype['video'])){
				$item['class'] = 'type-video';
			}elseif(in_array($item[lext], $filetype['archive'])){
				$item['class'] = 'type-archive';
			}elseif(in_array($item[lext], $filetype['app'])){
				$item['class'] = 'type-app';
			}elseif(in_array($item[lext], $filetype['script'])){
				$item['class'] = 'type-script';
			}else{
				$item['class'] = 'type-generic';			
			}
			$item['bytes']		=	$stat['size'];
			$item['size']		=	bytes_to_string($stat['size'], 2);
			$item['mtime']		=	$stat['mtime'];
			// Add files to the file list...
			if($info['extension'] != ''){
				array_push($file_list, $item);
			}
			// ...and folders to the folder list.
			else{
				array_push($folder_list, $item);
			}
			// Clear stat() cache to free up memory (not really needed).
			clearstatcache();
			// Add this items file size to this folders total size
			$total_size += $item['bytes'];
        }
    }
	// Close the directory when finished.
    closedir($handle);
}
// Sort folder list.
if($folder_list)
	$folder_list = php_multisort($folder_list, $sort);
// Sort file list.
if($file_list)
	$file_list = php_multisort($file_list, $sort);
// Calculate the total folder size (fix: total size cannont display while there is no folder inside the directory)
if($file_list && $folder_list || $file_list)
	$total_size = bytes_to_string($total_size, 2);

$total_folders = count($folder_list);
$total_files = count($file_list);

if ($total_folders > 0){
	if ($total_folders > 1){
		$funit = 'pastas';
	}else{
		$funit = 'pasta';
	}
	$contained = $total_folders.' '.$funit;
}
if ($total_files > 0){
	if($total_files > 1){
		$iunit = 'itens';
	}else{
		$iunit = 'item';
	}
	if (isset($contained)){
		$contained .= ' &amp; '.$total_files.' '.$iunit;
	}else{
		$contained = $total_files.' '.$iunit;	
	}
}

/***[ FUNCTIONS ]***/

/**
 *	http://us.php.net/manual/en/function.array-multisort.php#83117
 */
 
function php_multisort($data,$keys)
{
	foreach ($data as $key => $row)
	{
		foreach ($keys as $k)
		{
			$cols[$k['key']][$key] = $row[$k['key']];
		}
	}
	$idkeys = array_keys($data);
	$i=0;
	foreach ($keys as $k)
	{
		if($i>0){$sort.=',';}
		$sort.='$cols['.$k['key'].']';
		if($k['sort']){$sort.=',SORT_'.strtoupper($k['sort']);}
		if($k['type']){$sort.=',SORT_'.strtoupper($k['type']);}
		$i++;
	}
	$sort .= ',$idkeys';
	$sort = 'array_multisort('.$sort.');';
	eval($sort);
	foreach($idkeys as $idkey)
	{
		$result[$idkey]=$data[$idkey];
	}
	return $result;
} 

/**
 *	@ http://us3.php.net/manual/en/function.filesize.php#84652
 */
function bytes_to_string($size, $precision = 0) {
	$sizes = array('YB', 'ZB', 'EB', 'PB', 'TB', 'GB', 'MB', 'KB', 'Bytes');
	$total = count($sizes);
	while($total-- && $size > 1024) $size /= 1024;
	$return['num'] = round($size, $precision);
	$return['str'] = $sizes[$total];
	return $return;
}

/**
 *	@ http://us.php.net/manual/en/function.time.php#71342
 */
function time_ago($timestamp, $recursive = 0)
{
	$current_time = time();
	$difference = $current_time - $timestamp;
	$periods = array("segundo", "minuto", "hora", "dia", "semana", "mês", "ano", "década");
	$lengths = array(1, 60, 3600, 86400, 604800, 2630880, 31570560, 315705600);
	for ($val = sizeof($lengths) - 1; ($val >= 0) && (($number = $difference / $lengths[$val]) <= 1); $val--);
	if ($val < 0) $val = 0;
	$new_time = $current_time - ($difference % $lengths[$val]);
	$number = floor($number);
	if($number != 1)
	{
		$periods[$val] .= "s";
	}
	$text = sprintf("%d %s ", $number, $periods[$val]);   
	
	if (($recursive == 1) && ($val >= 1) && (($current_time - $new_time) > 0))
	{
		$text .= time_ago($new_time);
	}
	return $text;
}


/***[ HTML TEMPLATE ]***/
?>
<!DOCTYPE html>
	<html>
		<head>
			<meta charset="UTF-8"> 
			<title>Index of <?=$this_domain?><?=$this_folder?></title>
			<link rel="icon" href="https://www.weblink.com.br/favicon.ico">
		</head>

		<body>
			<div id="wrapper">
				<header>
					<h2>
						<img src="https://www.weblink.com.br/images/mail-logo.png">
						<br>
						Sua conta <a href="http://<?=$this_domain?>"><?=$this_domain?></a><? foreach($dir_name as $dir => $name) : ?>
							<? if(($name != ' ') && ($name != '') && ($name != '.') && ($name != '/')): ?>
								<? $parent = ''; ?>
									<?for ($i = 1; $i <= $dir; $i++): ?>
										<? $parent .= $dir_name[$i] . '/'; ?>
									<?endfor;?>
								/ <a href="/<?=$parent?>"><?=$name?></a>
							<?endif; ?>
						<? endforeach; ?>
					  está ativada!</h2>
					  <br><p>Por Favor utilize FTP ou Gerenciador de arquivos online para fazer o upload do seu site. Esta é apenas uma página de teste que mostra os arquivos de sua pasta public_html.</p>
				</header>				
				<ul id="list">
					<li class="header"><span class="name">nome</span><span class="size">tamanho</span><span class="time">data de modificação</span></li>
			<!-- folders -->
			<? if($folder_list): ?>
				<? foreach($folder_list as $item) : ?>
					<li class="folder"><span class="name"><a href="<?=$item['name']?>/"><?=$item['name']?></a></span><span class="size">-</span></li>
				<? endforeach; ?>
			<? endif; ?>
			<!-- /folders -->
		<!-- files -->
		<? if($file_list): ?>
			<? foreach($file_list as $item) : ?>
					<li class="file <?=$item['class']?>">
						<span class="name"><a href="<?=$item['name']?>.<?=$item['ext']?>"><?=$item['name']?>.<?=$item['ext']?></a></span>
						<span class="size"><?=$item['size']['num']?><em><?=$item['size']['str']?></em></span>
						<span class="time"><?=time_ago($item['mtime'])?> atrás</span>
					</li>
			<? endforeach; ?>
		<? endif; ?>
		<!-- /files -->
		<? if($file_list): ?>
			<li class="footer"><?=$contained?>, <?=$total_size['num']?> <?=$total_size['str']?> de tamanho</li>
		<? endif; ?>
				</ul>
				<p>
					<p><strong>Precisa de ajuda? Sinta-se a vontade para nos contatar:</strong></p>
					- Abra um ticket em: <a href="http://cpanel.weblink.com.br" target="_blank">http://cpanel.weblink.com.br</a><br>
					- Ligue para nós: <strong>(48) 3364-4635</strong><br>
					- Fale conosco em nosso chat: <a href="https://www.weblink.com.br" target="_blank">https://www.weblink.com.br</a><br>
					- Nos mande um email: <strong>suporte@weblink.com.br</strong><br>
					- Leia a página de perguntas frequentes: <a href="https://www.weblink.com.br/FAQ" target="_blank">https://www.weblink.com.br/FAQ</a><br>
					- Confira nossa página no Facebook: <a href="https://www.facebook.com/WebLink.Hospedagem" target="_blank">https://www.facebook.com/WebLink.Hospedagem</a><br>
					- Acompanhe nosso canal no <a href="https://www.youtube.com/channel/UC_JHAWm1mFcOnKaMtFQ3tTg" target="_blank">YouTube</a>
				</p>
			</div>
		</body>
	</html>