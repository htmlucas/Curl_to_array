<?php



    $atuald = 1; // a cada 10 páginas, ele soma mais 1 a variavel, e o site só mostra 10 paginas
 
    $pagina = 2; // numero da página para bucar as informações

    $i = 0; // variavel contador para buscar o código do produto

    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => 'http://www.tbca.net.br/base-dados/composicao_alimentos.php?pagina='.$pagina.'&atuald='.$atuald,
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

        //echo $response;

        $DOM = new DOMDocument();
        libxml_use_internal_errors(true); //tirar os erros
        $DOM->loadHTML($response);
        libxml_clear_errors(); //tirar os erros
        $DOM->saveHTML();

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
                    
                    $cod_alimento = $df[$i][0]; // PEGAR O CODIGO DO ALIMENTO DE CADA LINHA

                     /* BUSCAR A COMPOSIÇÃO*/ 

                    $curl_2 = curl_init();

                    // BUSCAR OS DETALHES DE CADA ALIMENTO DIRETAMENTO DO CODIGO
                    curl_setopt_array($curl_2, [
                    CURLOPT_RETURNTRANSFER => 1,
                    CURLOPT_URL => 'http://www.tbca.net.br/base-dados/int_composicao_alimentos.php?cod_produto='.$cod_alimento
                    ]);

                    // Envio e armazenamento da resposta
                    $response2 = curl_exec($curl_2);
                    
                    // Fecha e limpa recursos
                    curl_close($curl_2);
                    
                    
                        $DOM2 = new DOMDocument();
                        libxml_use_internal_errors(true); // ELIMINAR ERROS
                        $DOM2->loadHTML($response2);
                        libxml_clear_errors(); // ELIMINAR ERROS
                        $DOM2->saveHTML();
                    
                        $df2 = array();
                        
                        $tablebodys = $DOM2->getElementsByTagName('tbody');
                        foreach($tablebodys as $tbodys)
                        {
                            $rowws = $tbodys->getElementsByTagName('tr');
                            foreach($rowws as $roww)
                            {		
                                $linhas = array();
                                $celulas = $roww->getElementsByTagName('td'); 
                                foreach ($celulas as $celula) 
                                {
                                        array_push($linhas, $celula->textContent);
                                    
                                }
                                array_push($df2, $linhas);	
                            }
                                
                        } 
                        $i = $i + 1;  
                        /* FIM BUSCAR A COMPOSIÇÃO*/ 
                        
                    //print_r($df); // MOSTRAR OS VALORES POR PÁGINA
                    //print_r($df2);  //MOSTRAR OS VALORES DESCRITIVOS DO ALIMENTO POR PAGINA
            }

        }
       

    
    

?>
