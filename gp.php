<?php
global $dicionario;
$quebraLinha = "\n";
$fimLinha = ';';

$dicionario  = array(
		"estruturas"=>array(
				"function FUN(VARS)",
				"if(COND)",
				"else",
				"else if(COND)",
				"foreach(VAR as VAR_NIVEL)"
				),
		"retorno"=>array(
				"return VAR"
				),
		"funcoes"=>array(
				"rand()",
				"md5(VAR)",
				"break"
				),
		"operadores_comparacao"=>array(
				">",
				"<",
				">=",
				"<=",
				"==",
				"!=",
				"===",
				"!=="
				),
		"operadores_logicos"=>array(
				"&&",
				"||"
				),
		"operadores_matematicos"=>array(
				"+",
				"-",
				"/",
				"*",
				".",
				"&",
				"^",
				"|"
				)
	);
$pos_estruturas = 0;


$nIndividuos = 2;
$interacoes = 10;

$tabulacao = "    ";

for($i = 0; $i <$nIndividuos; $i++){
    $profundidade = 0;
    $output = "<?php".$quebraLinha;
    $variaveis = array();

    for($i2 = 0; $i2<$interacoes; $i2++){
        $profundidade_nova = $profundidade;
        if($i2!=0){
            $profundidade_nova = rand(-1,1)+$profundidade;
            $profundidade_nova = ($profundidade_nova)<0?0:$profundidade_nova;
        }

        if($profundidade_nova>$profundidade){
            $p1 = $pos_estruturas;
            $p2 = rand(1, (count($dicionario[$p1])-1));
            //$output .= str_repeat($tabulacao, $profundidade_nova);
            $output .= $dicionario[$p1][$p2] ."{".$quebraLinha ;			
        }else if($profundidade_nova<$profundidade){
                
            $p1 = rand(1, (count($dicionario)-1));
            $p2 = rand(1, (count($dicionario[$p1])-1));

            $output .= str_repeat($tabulacao, $profundidade);
            $output .= $dicionario[$p1][$p2] . $fimLinha.$quebraLinha ;

            $output .= str_repeat($tabulacao, $profundidade_nova)."}".$quebraLinha ;
                
        }else{
                $p1 = rand(1, (count($dicionario)-1));
                $p2 = rand(1, (count($dicionario[$p1])-1));
                $output .= str_repeat($tabulacao, $profundidade_nova);
                $output .= $dicionario[$p1][$p2] . $fimLinha.$quebraLinha ;
        }


            $profundidade = $profundidade_nova;
    }
    if($profundidade >0){
        while($profundidade>=0){
            $output .= str_repeat($tabulacao, $profundidade)."}".$quebraLinha ;
            $profundidade--;
        }
    }
    file_put_contents("populacao/$i.php", $output);
}













