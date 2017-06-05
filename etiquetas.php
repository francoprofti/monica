<html>
    <?php
    include 'conecta.php';
    
     if($_GET['tipo'] != ""){
        
        $nome = $_GET['busca'];
        $tipo = $_GET['tipo'];
        $status = $_GET['status'];
        $tipoetiqueta = $_GET['tipo'];
        
        if($tipo == "fac"){
            
            $tipo = "AND faccionista.nomefac like";    
            
        }elseif($tipo == "r"){
            $tipo = "AND ordemservico.referencia like";
            
        }elseif($tipo == "m"){
            $tipo = "AND ordemservico.modelo like";
            
        }elseif($tipo == "fun"){
            $tipo = "AND funcionario.nome like";
            
        }
        
        
        if($_GET['datini'] != ""  AND $_GET['datfim'] != ""){
            $datini =  date('Y-m-d', strtotime($_GET['datini']));
            $datfim =  date('Y-m-d', strtotime($_GET['datfim']));
            $data =  "AND ordemservico.datacriacao BETWEEN '$datini' AND '$datfim'";    
        }else{
            $data="";
            $datini = "";
            $datfim = "";
        }
        
        $sql = "SELECT *  FROM operacao  
                INNER JOIN  ordemoperacao ON (operacao.idoperacao = ordemoperacao.idoperacao)
                INNER JOIN ordemservico ON (ordemoperacao.idordemservico = ordemservico.idordemservico)
                INNER JOIN faccionista ON (ordemservico.idfaccionista = faccionista.idfaccionista)
                INNER JOIN referencia  ON (ordemservico.idreferencia = referencia.idreferencia)
                WHERE  ordemservico.status  = '$status' $tipo '%$nome%' $data
                ORDER BY ordemservico.datacriacao DESC"; 
        $result = mysqli_query($conecta,$sql);
       
      
        
    }
    
    ?>
    <head>
        <link type="text/css" rel="stylesheet"  href="estilo/estiloetiqueta.css">
        <meta charset="utf-8">
    </head>
    <body>
        <div id="content">
            
            <?php
                    $idordem = "";
                  while($consulta = mysqli_fetch_array($result)) {
                  if($idordem != $consulta['idordemservico']){
                      
                  
                    
            ?>
            
            
           
            <div class="etia">
                
                <div class="fac">
                    <div class="titulfac">
                        Faccionista: <br><b><?php echo $consulta['nomefac']; ?></b>
                    </div>
                    <div class="titulfac" style="text-align: right;">
                        Data Saída:<br>
                        <b><?php echo date('d/m/Y');?></b>
                    </div>
                    
                    
                    
                </div>
                <div class="peca">
                    <div>
                        <span>Ref</span>
                        <span>Qnt</span>
                        <span>Modelo</span>
                    </div><br>
                    <div>
                        <span><b><?php echo $consulta['codigoref']; ?></b></span>
                        <span><b><?php echo $consulta['qnt']; ?></b></span>
                        <span><b><?php echo $consulta['modelo']; ?></b></span>
                    </div>
                    
                </div>
                <div class="operacao">
                    <div>
                         Observação:  <b><?php echo $consulta['obs']; ?></b>
                       
                    </div>
                    <div>
                         
                    </div>
                    
                </div>
                <div id="obs">
                        Operação:<br>
                        <b><?php 
                                $sqloperacao = "SELECT * FROM ordemoperacao INNER JOIN operacao ON (ordemoperacao.idoperacao = operacao.idoperacao) WHERE ordemoperacao.idordemservico=".$consulta['idordemservico'];
                                $resultop = mysqli_query($conecta,$sqloperacao);  
                                while($consultaop = mysqli_fetch_array($resultop)) {
                                        echo $consultaop['codigo']." - ".$consultaop['nomeoperacao']." / ";
                                  }
                          ?>
                        </b>
                </div>
            </div>
            
            
            <div class="etia">
                <div class="fac">
                    <div class="titulfac">
                        Faccionista: <br><b><?php echo $consulta['nomefac']; ?></b>
                    </div>
                    <div class="titulfac">
                        Data Saída:<br>
                        <b><?php echo date('d/m/Y');?></b>
                    </div>
                    
                    
                    
                </div>
                <div class="peca">
                    <div>
                        <span>Ref</span>
                        <span>Qnt</span>
                        <span>Modelo</span>
                    </div><br>
                    <div>
                        <span><b><?php echo $consulta['codigoref']; ?></b></span>
                        <span><b><?php echo $consulta['qnt']; ?></b></span>
                        <span><b><?php echo $consulta['modelo']; ?></b></span>
                    </div>
                    
                </div>
                <div class="operacao">
                    <div>
                        Observação:  <b><?php echo $consulta['obs']; ?></b> 
                       
                    </div>
                    <div>
                        
                    </div>
                    
                </div>
                <div id="obs">
                   Operação: <br>
                     <b><?php 
                            $sqloperacao = "SELECT * FROM ordemoperacao INNER JOIN operacao ON (ordemoperacao.idoperacao = operacao.idoperacao) WHERE ordemoperacao.idordemservico=".$consulta['idordemservico'];
                            $resultop = mysqli_query($conecta,$sqloperacao);  
                            while($consultaop = mysqli_fetch_array($resultop)) {
                                    echo $consultaop['codigo']." - ".$consultaop['nomeoperacao']." / ";
                              }
                      ?>
                    </b>
                    
                </div>
            </div>
            
            <?php
                      
                $idordem = $consulta['idordemservico'];      
                  }
                }
            ?>
        </div>
        
    </body>
</html>