<?php
define("QUEBRA_LINHA" ,"\n");
define("FIM_LINHA" ,";");
define("TABULACAO" ,"    ");
define("INTERACOES" ,200);

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
                                "array(0,0,0,0,0,0,0,0)",
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
//                                "~",
                                "<<",
                                ">>"
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


/*
for($i = 0; $i <$nIndividuos; $i++){
    file_put_contents("populacao/$i.php", $output);
}

*/

function retornaEstruturaAleatoria($dicionario){
    echo "iniciou a estrutura <br>";
    $output = "";
    $profundidade = 0;
    $variaveis = array();
    $arrays = array();
    
    
    
    for($i = 0; $i < INTERACOES; $i++){
        $output .= str_repeat(TABULACAO, $profundidade)."//[INTERACAO_$i]".QUEBRA_LINHA;
        $output .= str_repeat(TABULACAO, $profundidade)
                    .   retornaInteracaoAleatoria($dicionario, $variaveis, $i)
                    .   QUEBRA_LINHA;
        $profundidade_nova = $profundidade;
        if($i>0){
            $profundidade_nova = rand(-1,1)+$profundidade;
            $profundidade_nova = ($profundidade_nova)<0?0:$profundidade_nova;
        }
        
        if($profundidade_nova>$profundidade){
            
            $output .= str_repeat(TABULACAO, $profundidade);
            $estrutura_aux = $dicionario["estruturas"]
                            [rand(0, (count($dicionario["estruturas"])-1))]["codigo"];
            $output .= str_replace('COND', 
                        $variaveis[rand(0, (count($variaveis)-1) )] . ' ' .
                        $dicionario["operadores_comparacao"]
                            [rand(0, (count($dicionario["operadores_comparacao"])-1))] . ' ' .
                        $variaveis[rand(0, (count($variaveis)-1) )]
                                    , $estrutura_aux);
                    
            $output .=" { //".$profundidade.QUEBRA_LINHA ;
            
            
        }else if($profundidade_nova<$profundidade){
            $output .= str_repeat(TABULACAO, $profundidade_nova)."}".QUEBRA_LINHA ;    
        }
        $profundidade = $profundidade_nova;
    }
    
    if($profundidade >0){
        while($profundidade>0){
            $output .= str_repeat(TABULACAO, $profundidade)."//[INTERACAO_$i]".QUEBRA_LINHA;
            $output .= str_repeat(TABULACAO, $profundidade)
                    .   retornaInteracaoAleatoria($dicionario, $variaveis, $i)
                    .   QUEBRA_LINHA;
            $i++;
            $profundidade--;
            $output .= str_repeat(TABULACAO, $profundidade)."}".QUEBRA_LINHA ;
        }
    }
    echo "finalizou a estrutura<br>";
    return $output;
}



function retornaInteracaoAleatoria($dicionario, &$variaveis, $interacao){
    $out_interacao = "";
        

    // INTERACAO COM VARIAVEIS
    // 0 - variavel nova, 1 - variavel antiga, (2 - variavel de contexto)
    $i_var = rand(0,1);
    if($i_var===1 && count($variaveis)>0){
        $out_interacao .= $variaveis[rand(0, (count($variaveis)-1) )]
                .' '.$dicionario["operadores_atribuicao"]
                        [rand(0, (count($dicionario["operadores_atribuicao"])-1))].' ';
    }else{
        $i_var = 0;
        $variaveis[] = '$VAR_'.$interacao;
        $out_interacao .= '$VAR_'.$interacao.' = ';
    }


    // ATRIBUICAO DAS VARIAVEIS
    /* 
     * 0 - variavel aleatoria direta
     * 1 - duas ou mais variaveis
     * 2 - funcoes
     * 3 - valores randomicos
     */
    $pos_variaveis = ($i_var===0)?count($variaveis)-2:count($variaveis)-1;
    if($pos_variaveis>=0){
        $a_var = rand(0,3);
    }else{
        $a_var = rand(2,3);
    }
    switch ($a_var){
        case(0):
            $out_interacao .= $variaveis[rand(0, $pos_variaveis )];
            break;
        case(1):
            $qtd_vars = rand(1,10);
            while($qtd_vars-->0){
                $out_interacao .= $variaveis[rand(0, $pos_variaveis )].' '.
                    $dicionario["operadores_matematicos"]
                        [rand(0, (count($dicionario["operadores_matematicos"])-1))];
            }
            $out_interacao .= $variaveis[rand(0, $pos_variaveis )];
            break;
        case(2):
            $out_interacao .= str_replace('VAR', $variaveis[rand(0, $pos_variaveis )], $dicionario["funcoes"]
                                        [rand(0, (count($dicionario["funcoes"])-1))]);
            break;
        case(3):
            $out_interacao .= rand();
    }

    $out_interacao .= ';';
    
    return $out_interacao;
}


$teste = retornaEstruturaAleatoria($dicionario);


    
file_put_contents("populacao/0.php", "<?php".QUEBRA_LINHA. $teste); 
