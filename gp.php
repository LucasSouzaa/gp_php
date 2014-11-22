<?php
define("QUEBRA_LINHA" ,"\n");
define("FIM_LINHA" ,";");
define("TABULACAO" ,"    ");
define("INTERACOES" ,40);

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
				"|",
                                "."
				),
                "operadores_atribuicao"=>array(
				"=",
				"+=",
                                ".=",
                                "*=",
                                "/="
                                )
	);
$pos_estruturas = 0;


$nIndividuos = 2;
$interacoes = 10;


/*
for($i = 0; $i <$nIndividuos; $i++){
    file_put_contents("populacao/$i.php", $output);
}

*/

function retornaEstruturaAleatoria($dicionario){
    $output = "";
    $profundidade = 0;
    
    //$output .= "[PRE_NIVEL_$profundidade]".QUEBRA_LINHA;
    
    for($i = 0; $i < INTERACOES; $i++){
        $output .= str_repeat(TABULACAO, $profundidade)."//[INTERACAO_$i]".QUEBRA_LINHA;
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
            $output .= str_repeat(TABULACAO, $profundidade)."//[INTERACAO_$i]".QUEBRA_LINHA;
            $i++;
            $profundidade--;
            $output .= str_repeat(TABULACAO, $profundidade)."}".QUEBRA_LINHA ;
            //$output .= "[POS_NIVEL_$profundidade]".QUEBRA_LINHA;
        }
    }
    
    return $output;
}

function substituiInteracoesAleatorias($dicionario, $input){
    $variaveis = array();
    $output = $input;
    for($i = 0; $i < INTERACOES; $i++){
        $out_interacao = "";
        

        // INTERACAO COM VARIAVEIS
        // 0 - variavel nova, 1 - variavel antiga, (2 - variavel de contexto)
        $i_var = rand(0,1);
        if($i_var===1 && count($variaveis)>0){
            $out_interacao .= '$'.$variaveis[rand(0, (count($variaveis)-1) )]
                    .' '.$dicionario["operadores_atribuicao"]
                            [rand(0, (count($dicionario["operadores_atribuicao"])-1))].' ';
        }else{
            $variaveis[] = "VAR_$i";
            $out_interacao .= '$VAR_'.$i.' = ';
        }
        
        
        $output = str_replace("//[INTERACAO_$i]", $out_interacao, $output);
    }
    return $output;
}


$teste = retornaEstruturaAleatoria($dicionario);



file_put_contents("populacao/0.php", "<?php".QUEBRA_LINHA. substituiInteracoesAleatorias($dicionario, $teste)); 
