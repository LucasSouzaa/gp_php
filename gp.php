<?php

$quebraLinha = "\n";
$fimLinha = ';';

$dicionario  = array(
		array(
				"estruturas",
				"if(COND)",
				"else",
				"else if(COND)",
				"foreach(VAR as VAR_NIVEL)"
				),
		array(
				"funcoes",
				"rand()",
				"md5(VAR)",
				"break"
				),
		array(
				"operadores_comparacao",
				">",
				"<",
				">=",
				"<=",
				"==",
				"!=",
				"===",
				"!=="
				),
		array(
				"operadores_logicos",
				"&&",
				"||"
				),
		array(
				"operadores_matematicos",
				"+",
				"-",
				"/",
				"*",
				".",
				"&",
				"^",
				"|",
				"=",
				"+=",
				".=",
				"-=",
				"*=",
				"/="
				)
	);
$pos_estruturas = 0;


$nIndividuos = 2;
$interacoes = 10;


for($i = 0; $i <$nIndividuos; $i++){
	$profundidade = 0;
	$output = "<?php".$quebraLinha;
	$variaveis = array();

	for($i2 = 0; $i2<$interacoes; $i2++){	

		$profundidade_nova = ($profundidade_nova = rand(-1,1)+$profundidade)<0?0:$profundidade_nova;

		if($profundidade_nova>$profundidade){
			$p1 = $pos_estruturas;
			$p2 = rand(1, (count($dicionario[$p1])-1));
			$output .= str_repeat("	", $profundidade_nova);
			$output .= $dicionario[$p1][$p2] ."{".$quebraLinha ;			
		}else if($profundidade_nova<$profundidade){
			$p1 = rand(0, (count($dicionario)-1));
			$p2 = rand(1, (count($dicionario[$p1])-1));
			$output .= str_repeat("	", $profundidade)."}".$quebraLinha ;
			$output .= str_repeat("	", $profundidade_nova);
			$output .= $dicionario[$p1][$p2] . $fimLinha.$quebraLinha ;
		}else{
			$p1 = rand(0, (count($dicionario)-1));
			$p2 = rand(1, (count($dicionario[$p1])-1));
			$output .= str_repeat("	", $profundidade_nova);
			$output .= $dicionario[$p1][$p2] . $fimLinha.$quebraLinha ;
		}
		

		$profundidade = $profundidade_nova;
	}
	file_put_contents("populacao/$i.php", $output);
}













