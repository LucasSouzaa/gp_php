<?php
define("QUEBRA_LINHA" ,"\n");
define("FIM_LINHA" ,";");
define("TABULACAO" ,"    ");

$dicionario  = array(
		"estruturas"=>array(
				array( "codigo"=>"if(COND)",
                                    "subcodigo"=>array("else",
				"else if(COND)")
                                    ),
				array(
                                    "codigo"=>"foreach(VAR as VAR_NIVEL)",
                                    "funcoes"=>array("break")
                                    ),
				array(
                                    "codigo"=>"while(COND)",
                                    "funcoes"=>array("break")
                                    )
				),
		"funcoes"=>array(
				"rand()",
				"md5(VAR)"
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


/*
for($i = 0; $i <$nIndividuos; $i++){
    $profundidade = 0;
    $output = "<?php".QUEBRA_LINHA;
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
            //$output .= str_repeat(TABULACAO, $profundidade_nova);
            $output .= $dicionario[$p1][$p2] ."{".QUEBRA_LINHA ;			
        }else if($profundidade_nova<$profundidade){
                
            $p1 = rand(1, (count($dicionario)-1));
            $p2 = rand(1, (count($dicionario[$p1])-1));

            $output .= str_repeat(TABULACAO, $profundidade);
            $output .= $dicionario[$p1][$p2] . FIM_LINHA.QUEBRA_LINHA ;

            $output .= str_repeat(TABULACAO, $profundidade_nova)."}".QUEBRA_LINHA ;
                
        }else{
                $p1 = rand(1, (count($dicionario)-1));
                $p2 = rand(1, (count($dicionario[$p1])-1));
                $output .= str_repeat(TABULACAO, $profundidade_nova);
                $output .= $dicionario[$p1][$p2] . FIM_LINHA.QUEBRA_LINHA ;
        }


            $profundidade = $profundidade_nova;
    }
    if($profundidade >0){
        while($profundidade>=0){
            $output .= str_repeat(TABULACAO, $profundidade)."}".QUEBRA_LINHA ;
            $profundidade--;
        }
    }
    file_put_contents("populacao/$i.php", $output);
}

*/

function retornaEstruturaAleatoria($dicionario, $interacoes = 40){
    $output = "";
    $profundidade = 0;
    
    //$output .= "[PRE_NIVEL_$profundidade]".QUEBRA_LINHA;
    
    for($i = 0; $i <$interacoes; $i++){
        $output .= str_repeat(TABULACAO, $profundidade)."[INTERACAO_$i]".QUEBRA_LINHA;
        $profundidade_nova = $profundidade;
        if($i>0){
            $profundidade_nova = rand(-1,1)+$profundidade;
            $profundidade_nova = ($profundidade_nova)<0?0:$profundidade_nova;
        }
        
        if($profundidade_nova>$profundidade){
            
            //$output .= "[PRE_INTERACAO_$i]".QUEBRA_LINHA;
            $output .= str_repeat(TABULACAO, $profundidade);
            $output .= $dicionario["estruturas"]
                            [rand(0, (count($dicionario["estruturas"])-1))]["codigo"] 
                    ." { //".$profundidade.QUEBRA_LINHA ;
            
            
        }else if($profundidade_nova<$profundidade){
            $output .= str_repeat(TABULACAO, $profundidade_nova)."}".QUEBRA_LINHA ;    
        }
        $profundidade = $profundidade_nova;
       //$output .= "/*POS_INTERACAO_$i*/".QUEBRA_LINHA;
    }
    
    if($profundidade >0){
        while($profundidade>0){
            $output .= str_repeat(TABULACAO, $profundidade)."[INTERACAO_$i]".QUEBRA_LINHA;
            $i++;
            $profundidade--;
            $output .= str_repeat(TABULACAO, $profundidade)."}".QUEBRA_LINHA ;
            //$output .= "[POS_NIVEL_$profundidade]".QUEBRA_LINHA;
        }
    }
    
    return $output;
    
}

file_put_contents("populacao/0.php", retornaEstruturaAleatoria($dicionario)); 
