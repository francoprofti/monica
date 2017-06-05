<html>
<head>
<link type="text/css" rel="stylesheet"  href="estilo/estilo.css">
    <meta charset="utf-8">

</head>
<?php
include 'conecta.php';
session_start();

   
    
if(isset($_FILES['arquivo'])){
    
    if (is_uploaded_file($_FILES['arquivo']['tmp_name'])) {
    //echo "<h1>" . "File ". $_FILES['arquivo']['tmp_name'] ." uploaded successfully." . "</h1>";
    //echo "<h2>Displaying contents:</h2>";
    $arquivo = $_FILES['arquivo']['tmp_name'];
    //readfile($arquivo);
    }
    
    $delimitador = ';';
    $numtotaloperacao = 0;
    $numtotalreferencia = 0;
    $numtotalassociacao = 0;

    // Abrir arquivo para leitura
    $f = fopen($arquivo, 'r');
     
    $a=0;
    if ($f) {

        // Enquanto nao terminar o arquivo
        while (!feof($f)) {

            // Ler uma linha do arquivo
            $linha = fgetcsv($f, 0, $delimitador,'"');
        
            if ($linha) { 
                for($i = 0; $i < 4; $i++){
                     
                    
                    if($i==0){
                        $referencia = $linha[$i]; 
                           
                    }
                    if($i==1){
                        $operacao = $linha[$i]; 
                    }
                    if($i==2){
                        $desoperacao = $linha[$i]; 
                    }
                    if($i==3){
                        if($linha[$i]!=""){
                            $parte = $linha[$i];     
                        }else{
                            $parte = 0;
                        }
                        
                    }
                    
                    
                    
                }
                
                $sqlverificaref = "SELECT idreferencia,codigoref FROM referencia WHERE referencia.codigoref=".$referencia;
                $resultverificaref = mysqli_query($conecta,$sqlverificaref);
                
                $sqlverificaop = "SELECT idoperacao,codigo FROM operacao WHERE operacao.codigo=".$operacao;
                $resultverificaop = mysqli_query($conecta,$sqlverificaop);
               
                
              
                
                
                if($resultverificaref){
                    $row_cnt = mysqli_num_rows($resultverificaref);
                    if($row_cnt == 0){
                        $sqlnovaref = "INSERT INTO referencia (idreferencia, codigoref,status) VALUES (NULL, '$referencia',0)";
                        $resultnovaref = mysqli_query($conecta,$sqlnovaref);
                        $referencia = mysqli_insert_id($conecta);
                        $numtotalreferencia++;
    
                        
                    }else{
                         while($pegaref = mysqli_fetch_array($resultverificaref)) {
                             $referencia = $pegaref['idreferencia'];
                         }
                         
                    }
                    
                }
                
                if($resultverificaop){
                    $row_cntop = mysqli_num_rows($resultverificaop);
                    if($row_cntop ==0){
                        $sqlnovaop = "INSERT INTO operacao (idoperacao, nomeoperacao,status,codigo,parte) VALUES (NULL, '$desoperacao','0','$operacao','$parte')";
                        $resultnovaref = mysqli_query($conecta,$sqlnovaop);
                        $operacao = mysqli_insert_id($conecta);
                        $numtotaloperacao++;

    
                        
                    }else{
                         while($pegaop = mysqli_fetch_array($resultverificaop)) {
                             $operacao = $pegaop['idoperacao'];
                         }
                        
                    }
                }
                
                $sqlverificaassocia = "SELECT * FROM operacaoreferencia WHERE idoperacao=$operacao AND idreferencia=$referencia";
                
                $resultverificaassocia = mysqli_query($conecta,$sqlverificaassocia);
               
                if($resultverificaassocia){
                    $row_cntassocia = mysqli_num_rows($resultverificaassocia);
                   
                    if($row_cntassocia == 0){
                        if($operacao !=0){
                            $sqlassocia = "INSERT INTO `operacaoreferencia` (`idoperacaoreferencia`, `idoperacao`, `idreferencia`, `parte`) VALUES (NULL, '".$operacao."', '".$referencia."', '".$parte."');";
                            $resultnovaref = mysqli_query($conecta,$sqlassocia);
                            $numtotalassociacao++;
                        }
                        
                    }
                    
                }
                
               
            }

            
        }
        fclose($f);
    }
    
    
    
    
}
    
    
    




?>
<body>
<div class="content">
    <div class="topo">
        <div class="topo">
           
            <div class="userlogado">
                <a href="referencia.php"><div class="btnsup"><p>Voltar</p></div></a>
            </div>
            
            <div class="botaosup">
                <a href="index.php?sair=true">
                    <div class="sair">
                        <p>SAIR</p>
                    </div>
                </a>
            </div>
             
        </div>
        <div class="caminho">
                <p><h3><a href="geral.php">Início</a> > <a href="referencia.php">Referências</a> > Atualizar Referência via Planilha  </h3></p>   
        </div>
        
        <div class="corpo">
            <div class="interna">



        <fieldset>
            <legend>Selecione a planilha</legend>
            <form name="formrefplan" action="refplanilha.php" enctype="multipart/form-data" method="post">
                <input name="arquivo" type="file">
                
                <input type="submit" name="buscar" value="Buscar">




            </form>  
        </fieldset>
            <br><br> 
  
                <?php
                    if(isset($_POST['buscar'])){
                        echo "Foram atualizadas<br>".$numtotalreferencia." referências<br>".$numtotaloperacao." operações<br>". $numtotalassociacao." associações entre Operações e Referências";
                        
                    }
                ?>
            
           
        </div>
    </div>


</div>


</body>
</html>