<?php  

	ob_start("ob_gzhandler");

	if(isset($_REQUEST['tp']) && $_REQUEST['tp'] == 'enviar' && file_exists('sockets/'.base64_encode($_REQUEST['s']).'.php')){

		include 'sockets/'.base64_encode($_REQUEST['s']).'.php';
		if(count($arrays) == 25){
			file_put_contents('sockets/'.base64_encode($_REQUEST['s']).'.php','');
		}

		$array = $_REQUEST['da'];
		$datea = '';
		if(count($array) > 1){
			$i = 0;
			while ($i < count($array)) {
				if($i == 0){
					$datea .= '"'.$array[$i].'"';
				}elseif($i == 0 && count($array[$i]) > 1){
					$datArr = '';
					foreach ($array[$i] as $key => $value) {
						$datArr .= $value.',';
					}
					$datArr = substr($datArr, 0, -1);
					$datea .= 'array("'.$datArr.'")';
				}elseif($i != 0 && count($array[$i]) > 1){
					$datArr = '';
					foreach ($array[$i] as $key => $value) {
						$datArr .= $value.',';
					}
					$datArr = substr($datArr, 0, -1);
					$datea .= ',array("'.$datArr.'")';
				}else{
					$datea .= ',"'.$array[$i].'"';
				}
				$i++;
			}
		$data = '
		<?php $arrays[] = array('.$datea.');?>';
		}else{
		$data = '';
		foreach ($array as $key => $value) {
			if(count($value) > 1){
				$monta = '';
				foreach ($value as $key => $value) {
					$monta .= $value.',';
				}
				$monta = substr($monta, 0, -1);
				$data = '
		<?php $arrays[] = array("'.$monta.'"); ?>';
			}else{
				$data = '
		<?php $arrays[] = array("'.$value.'"); ?>';
			}
		}
		}
		file_put_contents('sockets/'.base64_encode($_REQUEST['s']).'.php',file_get_contents('sockets/'.base64_encode($_REQUEST['s']).'.php').$data);
		echo 'sucesso';
	} else if(isset($_REQUEST['tp']) && $_REQUEST['tp'] == 'enviar'){
		$array = $_REQUEST['da'];
		$datea = '';
		if(count($array) > 1){
			$i = 0;
			while ($i < count($array)) {
				if($i == 0){
					$datea .= '"'.$array[$i].'"';
				}elseif($i == 0 && count($array[$i]) > 1){
					$datArr = '';
					foreach ($array[$i] as $key => $value) {
						$datArr .= $value.',';
					}
					$datArr = substr($datArr, 0, -1);
					$datea .= 'array("'.$datArr.'")';
				}elseif($i != 0 && count($array[$i]) > 1){
					$datArr = '';
					foreach ($array[$i] as $key => $value) {
						$datArr .= $value.',';
					}
					$datArr = substr($datArr, 0, -1);
					$datea .= ',array("'.$datArr.'")';
				}else{
					$datea .= ',"'.$array[$i].'"';
				}
				$i++;
			}
		$data = '
		<?php $arrays[] = array('.$datea.');?>';
		}else{
			$data = '';
		foreach ($array as $key => $value) {
		$data = '
		<?php $arrays[] = array('.$value.'"); ?>';
		}
		}
		file_put_contents('sockets/'.base64_encode($_REQUEST['s']).'.php', $data);
		echo 'sucesso';
	}

	if(isset($_REQUEST['tp']) && $_REQUEST['tp'] == 'receber'){
		if(!file_exists('sockets/'.base64_encode($_REQUEST['nome']).'.php')){
			$array = array('naoexiste');
			echo json_encode($array);
		}else{
			include 'sockets/'.base64_encode($_REQUEST['nome']).'.php';
			$array = array($_REQUEST['nome'] => array());
			$arr = $arrays;
			foreach ($arr as $key => $value) {
				array_push($array[$_REQUEST['nome']], $value);
			}
			echo json_encode($array);
		}
	}

	ob_flush();
	
?>