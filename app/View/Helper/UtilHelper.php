<?php
class UtilHelper extends AppHelper {

	public function moeda($dado = null){
		return number_format($dado, 2, ",", ".");
	}

	public function data($dado= null, $soData = false){
		if(strlen($dado) == 10){
			$temp = explode("/",$dado);
			if(count($temp) == 3)
				$saida = $temp[2] . "-" . $temp[1] . "-" . $temp[0];
			$temp = explode("-",$dado);
			$saida = (count($temp) == 3) ? $temp[2] . "/" . $temp[1] . "/" . $temp[0] : false;
		} else {
			$temp = explode("/",substr($dado,0,10));
			if(count($temp) == 3)
				$saida = $temp[2] . "-" . $temp[1] . "-" . $temp[0] . " " . substr($dado, 10);
			$temp = explode("-",substr($dado,0,10));
			$saida = (count($temp) == 3) ? $temp[2] . "/" . $temp[1] . "/" . $temp[0] . " " . substr($dado, 10) : false;
		}

		if ($soData) {
			$data = substr($saida, 0, 10);
		}

		return $saida;
	}

	public function mascaras($dado = null, $tipo = null) {
		switch ($tipo) {
			case 'fone':
				$mask = "(##) ####-####";
				break;
			case 'cpf':
				$mask = "###.###.###-##";
				break;
			case 'cep':
				$mask = "#####-###";
				break;
		}

        $maskared = '';
        $k = 0;
        for($i = 0; $i <= strlen($mask)-1; $i++){
            if($mask[$i] == '#'){
                if(isset($dado[$k])){
                    $maskared .= $dado[$k++];
                }
            }else{
                if(isset($mask[$i])){
                    $maskared .= $mask[$i];
                }
            }
        }

        return $maskared;
	}
		
}