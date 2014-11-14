<?php

$t1 = array(
		array(0,0,0,0,0,0,0,0),
		array(0,0,0,0,0,0,0,0),
		array(0,0,0,0,0,0,0,0),
		array(0,0,0,0,0,0,0,0),
		array(0,0,0,0,0,0,0,0),
		array(0,0,0,0,0,0,0,0),
		array(0,0,0,0,0,0,0,0),
		array(0,0,0,0,0,0,0,0)
		);

$t2 = array(
		array(1,0,0,0,0,0,1,0),
		array(0,0,0,0,1,0,0,0),
		array(0,0,0,0,0,0,0,0),
		array(0,0,0,1,0,0,0,0),
		array(0,0,0,0,0,0,0,0),
		array(0,0,1,0,0,1,0,0),
		array(0,0,0,0,1,0,0,0),
		array(0,0,0,0,0,0,0,0)
		);

valida($t1,8);
valida($t2,8);

function valida($tabuleiro, $tamanho){
	$br = "<br>";
	$valido = true;
	$n_rainhas = 0;
	

	
	//valida linha
	foreach($tabuleiro as $li=>$linha){
		if(array_sum($linha)>1){
			$valido = false;
			echo "Mais de uma rainha na linha: $li".$br;
		}
	}

	//valida coluna
	$array_soma_coluna = array();
	foreach($tabuleiro as $li=>$linha){
		foreach($linha as $ci=>$coluna){
			if(!array_key_exists($ci,$array_soma_coluna)){
				$array_soma_coluna[$ci] = 0;
			}
			$array_soma_coluna[$ci] += $coluna;
		}
	}
	foreach($array_soma_coluna as $ci=>$soma_coluna){
		if($soma_coluna>1){
			$valido = false;
			echo "Mais de uma rainha na coluna: $ci".$br;
		}
	}

	//valida diagonais
	$array_diagonal_1 = array();
	for($i1 = 0;$i1<count($tabuleiro);$i1++){
		for($i2=0; ($i1+$i2)<count($tabuleiro); $i2++){
			//diagonais iniciadas na linha 0
			$array_diagonal_1[$i1][($i1+$i2).$i2] = $tabuleiro[$i1+$i2][$i2];
			//diagonais iniciadas na coluna 0
			if($i1>0){
				$array_diagonal_1[$i1+7][$i2.($i1+$i2)] = $tabuleiro[$i2][$i1+$i2];
			}
		}
	}
	$array_diagonal_2 = array();
	for($i1 = 0;$i1<count($tabuleiro);$i1++){
		for($i2=7,$i3=$i1, $i4=0; $i2>=0 && $i3<count($tabuleiro); $i2--,$i3++,$i4++){
			//diagonais iniciadas na linha 
			$array_diagonal_2[$i1][$i3.$i2] = $tabuleiro[$i3][$i2];
			if($i1>0){
				$array_diagonal_2[$i1+7][$i4.($i2-$i1)] = $tabuleiro[$i4][($i2-$i1)];
			}
		}
	}
	validaDiagonal($array_diagonal_1);
	validaDiagonal($array_diagonal_2);


	echo ($valido)?"Tabuleiro valido":"Tabuleiro invalido";
	echo $br;
}


function validaDiagonal($array){
	foreach ($array as $v1) {
		if(array_sum($v1)>1){
			echo "Mais de uma rainha na diagonal, nas posicoes: ";
			$valido = false;
			foreach ($v1 as $key=>$v2) {
				if($v2==1){
					echo $key." ";
				}
			}
			echo "<br>";
		}
	}
}