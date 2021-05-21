<?php


$num_paginas = 54;

for ($i=0; $i <= $num_paginas ; $i++) { 

    $atuald = 1;

    $cont_pagina = 1;


    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => 'http://www.tbca.net.br/base-dados/composicao_alimentos.php?pagina='.$cont_pagina.'&atuald='.$atuald,
        CURLOPT_POST => 1,
        CURLOPT_POSTFIELDS => [
        'guarda' => '',
        'produto' => '',
        'cmb_grupo' => '',
        'cmb_tipo_alimento' => ''
        ]
        ]);
        // Envio e armazenamento da resposta
        $response = curl_exec($curl);
        
        // Fecha e limpa recursos
        curl_close($curl);
        
        curl_error($curl);

        //echo $response;

        $DOM = new DOMDocument();
        $DOM->loadHTML($response);

        $DOM->saveHTML();
        
        $contador = 0;

        $df = array();
        
        $tbodys = $DOM->getElementsByTagName('tbody');
        foreach($tbodys as $tbody)
        {
            $rows = $tbody->getElementsByTagName('tr');
            foreach($rows as $row)
            {	
                $linha = array();
                $cells = $row->getElementsByTagName('td'); 
                foreach ($cells as $cell) 
                {
                    $ahref = $cell->getElementsByTagName('a');
                    foreach($ahref as $a)
                    {
                        array_push($linha, $a->textContent);
                    
                    }
                    
                }
                array_push($df, $linha); // COLOCAR OS VALORES DA LINHA EM OUTRO ARRAY PRA FICAR CERTO
                
                $cod_alimento = $df[$contador][0]; // PEGAR O CODIGO DO ALIMENTO DE CADA LINHA

                /* BUSCAR A COMPOSIÇÃO*/ 

                $curl_2 = curl_init();

                // Configura
                curl_setopt_array($curl_2, [
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => 'http://www.tbca.net.br/base-dados/int_composicao_alimentos.php?cod_produto='.$cod_alimento
                ]);
                
                // Envio e armazenamento da resposta
                $response2 = curl_exec($curl_2);
                
                // Fecha e limpa recursos
                curl_close($curl_2);
                
                //echo $response2;
                
                    $DOM2 = new DOMDocument();
                    $DOM2->loadHTML($response2);
                
                    $DOM2->saveHTML();
                
                    $df2 = array();
                    
                    $tablebodys = $DOM2->getElementsByTagName('tbody');
                    foreach($tablebodys as $tbodys){
                        $rowws = $tbodys->getElementsByTagName('tr');
                        foreach($rowws as $roww)
                        {		
                            $linhas = array();
                            $celulas = $roww->getElementsByTagName('td'); 
                            foreach ($celulas as $celula) {
                                    array_push($linhas, $celula->textContent);
                                
                            }
                            array_push($df2, $linhas);	
                        }
                            
                    }   
                    /* FIM BUSCAR A COMPOSIÇÃO*/ 

10                    print_r($df);
                    //print_r($df2);
                
                    
                $contador ++;	
            }
                
        }
    $num_paginas++;
    if($i /10 = 0){
        $atuald++;
    }
    if($atuald = 6 and $num_paginas = 54){
        break;
    }
}
    //print_r($df);
    








/*  INFORMAÇÕES ESTATISTICAS */

$curl = curl_init();

// Configura
curl_setopt_array($curl, [
CURLOPT_RETURNTRANSFER => 1,
CURLOPT_URL => 'http://www.tbca.net.br/base-dados/int_composicao_estatistica.php?cod_produto=C0001C'
]);

// Envio e armazenamento da resposta
$response = curl_exec($curl);

// Fecha e limpa recursos
curl_close($curl);
    
curl_error($curl);

//echo $response;

    $DOM = new DOMDocument();
    $DOM->loadHTML($response);

     $DOM->saveHTML();

    $df = array();
    
    $tbodys = $DOM->getElementsByTagName('tbody');
    foreach($tbodys as $tbody){
        $rows = $tbody->getElementsByTagName('tr');
        foreach($rows as $row)
        {		
            $linha = array();
            $cells = $row->getElementsByTagName('td'); 
            foreach ($cells as $cell) {
                    array_push($linha, $cell->textContent);
                
            }
            array_push($df, $linha);	
        }
               
    }
    //print_r($df);




?>
