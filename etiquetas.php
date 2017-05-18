<html>
    <?php
    include 'conecta.php';
    
     if($_GET['tipo'] != ""){
        
        $nome = $_GET['busca'];
        $tipo = $_GET['tipo'];
        $tipoetiqueta = $_GET['tipo'];
        
        if($tipo == "fac"){
            
            $tipo = "AND faccionista.nomefac like";    
            
        }elseif($tipo == "o"){
            $tipo = "AND operacao.nomeoperacao like";
            
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
        
        $sql = "SELECT ordemservico.idordemservico AS id, funcionario.nome AS nomefuncionario,  ordemservico.datacriacao as data, faccionista.nomefac as faccionista, operacao.nomeoperacao as operacao, ordemservico.referencia, ordemservico.qnt, ordemservico.modelo, ordemservico.obs
        FROM funcionario INNER JOIN ordemservico
        ON (funcionario.idfuncionario = ordemservico.idfuncionario) INNER JOIN faccionista
        ON (ordemservico.idfaccionista = faccionista.idfaccionista) INNER JOIN operacaofaccionista
        ON (faccionista.idfaccionista = operacaofaccionista.idfaccionista) INNER JOIN operacao
        ON (operacaofaccionista.idoperacao = operacao.idoperacao)
        WHERE  ordemservico.status = 0 $tipo '%$nome%' $data
        GROUP BY ordemservico.idordemservico ORDER BY datcadastro DESC"; 
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
                  while($consulta = mysqli_fetch_array($result)) { 
            ?>
            
            
           
            <div class="etia">
                <div class="fac">
                    <div class="titulfac">
                        Faccionista: <br><b><?php echo $consulta['faccionista']; ?></b>
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
                        <span><b><?php echo $consulta['referencia']; ?></b></span>
                        <span><b><?php echo $consulta['qnt']; ?></b></span>
                        <span><b><?php echo $consulta['modelo']; ?></b></span>
                    </div>
                    
                </div>
                <div class="operacao">
                    <div>
                        Operação: 
                       
                    </div>
                    <div>
                         <b><?php echo " ".$consulta['operacao']; ?></b>
                    </div>
                    
                </div>
                <div id="obs">
                    Observação:  <b><?php echo $consulta['obs']; ?></b>
                </div>
            </div>
            
            
            <div class="etia">
                <div class="fac">
                    <div class="titulfac">
                        Faccionista: <br><b><?php echo $consulta['faccionista']; ?></b>
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
                        <span><b><?php echo $consulta['referencia']; ?></b></span>
                        <span><b><?php echo $consulta['qnt']; ?></b></span>
                        <span><b><?php echo $consulta['modelo']; ?></b></span>
                    </div>
                    
                </div>
                <div class="operacao">
                    <div>
                        Operação: 
                       
                    </div>
                    <div>
                         <b><?php echo " ".$consulta['operacao']; ?></b>
                    </div>
                    
                </div>
                <div id="obs">
                    Observação:  <b><?php echo $consulta['obs']; ?></b>
                </div>
            </div>
            
            <?php
                  }
            ?>
        </div>
        
    </body>
</html>