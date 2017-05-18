<html>
<head>
    <link type="text/css" rel="stylesheet"  href="estilo/estilo.css">
    <script type="text/javascript" src="js/mascara.js"></script>
     
          
</head>
    
    <?php
    include 'conecta.php';
    $sucesso ="";
    
    
    if( isset($_POST['nome']) )
    {
       
       
    
        $nome = $_POST['nome'];
   
        $sql = "INSERT INTO `faccionista` (`idfaccionista`, `nomefac`, `status`) VALUES (NULL, '$nome', '0');"; 
        $result = mysqli_query($conecta,$sql); 
        $ultimoid = mysqli_insert_id($conecta);
        
        $listapost = substr($_POST['listaop'],0,-1);
        $listapost = explode(',',$listapost);
        
        
        foreach($listapost as $lista) {
            $valpost = "valor".$lista;
             
            
           
            
             if( isset($_POST[$valpost])){
                $valor = $_POST[$valpost];
                $valor = str_replace(',', '.', $valor);
                if($valor == ""){
                    $valor = 0;
                }  
                $sqlassocia = "INSERT INTO `operacaofaccionista` (`idfaccionista`, `idoperacao`, `valor`) VALUES ($ultimoid, '$lista', '$valor');"; 
                $result = mysqli_query($conecta,$sqlassocia);     
            }
            
        }
        
      
        
        
        
        if($result){
            $sucesso = "salvou";
        }else{
            $sucesso = "Erro ao Salvar";
        }
        
        mysqli_close($conecta); 
          
    }
    
   
    
    if( !isset($_POST['nome']) ){
    //faz consulta das operações
    $sql2 = "SELECT * FROM operacao WHERE status = 0 ORDER BY nomeoperacao ASC";  
    $resultop = mysqli_query($conecta,$sql2);     
        
    $sql3= "SELECT faccionista.idfaccionista as idfacicionista,
            faccionista.nomefac as nomefac,
            faccionista.status as statusfac,
            operacaofaccionista.idfaccionista as operafacidfac,
            operacaofaccionista.idoperacao as operafacidop,
            operacaofaccionista.valor as valor
            FROM faccionista INNER JOIN operacaofaccionista ON ( faccionista.idfaccionista = operacaofaccionista.idfaccionista) INNER JOIN operacao ON (operacaofaccionista.idoperacao = operacao.idoperacao) WHERE operacao.status = 0;";
    $resultinner = mysqli_query($conecta,$sql3);     
    
    }
  
    
    ?>
<body>
    <div class="content">
        <div class="topo">
           
            <div class="userlogado">
                <div class="btnsup"><p><a href="faccionista.php">Voltar</a></p></div>
                
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
                <p><h3><a href="geral.php">Início</a> > <a href="faccionista.php">Faccionista</a> > Novo Faccionista</h3></p>   
        </div>
        <div class="corpo">
            <div class="interna">
                <?php 
                    if($sucesso == "salvou"){
                       echo"<SCRIPT LANGUAGE='JavaScript' TYPE='text/javascript'>
                                
                                decisao = confirm('Salvo com sucesso, deseja salvar mais?');
                                
                                if (decisao){
                                        location.href = 'novofaccionista.php';
                                } else {
                                        location.href = 'faccionista.php';
                                }
                                
                                </SCRIPT>";
                    }elseif($sucesso=="Erro ao Salvar"){
                        echo"<script>alert('Ocorreu algum erro ao Salvar!Consulte o suporte!');</script>";
                    }
                ?>
                <fieldset>
                    <legend> Cadastro de Faccionistas</legend>
                <form name="cadoperacao" action="novofaccionista.php" method="post" style="">
                    
                    
                    <label>
                        Faccionista:
                    </label>
                    <input type="text" name="nome" size="80" placeholder="Digite o nome do Faccionista"><br>
                    
                  
                    
             <div style=" width: auto;
                height: 400px;
                overflow-y: scroll;
                overflow-x: hidden;">        
                    
                    
                <table>
                   <tr>
                        <th>Operação</th>
                        <th style="width:200px;">Valor</th>
                        
                   </tr>
                    <tr>
                        
                    
                    <?php
                        $listaop = "";
                        while($consultaop = mysqli_fetch_array($resultop)) { 
                    ?>
    
                  
                        
                        <tr>
                        
                        <td>
                            <?php echo $consultaop['nomeoperacao'] ?></td>
                        <td> 
                            
                            <?php
                            $listaop =$consultaop['idoperacao'].",". $listaop;
                            echo "<input type='hidden' name='listaop' value='".$listaop."'>";
                            echo "<input style='text-align:right;'type='text' name='valor".$consultaop['idoperacao']."'size='8' placeholder='' onkeypress='mascara(this,moeda)' value='0,00'>";
                            ?>
                        </td>

                    </tr>
                  
                    
                    <?php 
                        } 
                    ?>
                </table>
                      </div>
                      <input type="submit" value="Salvar" name="salvar">
                    
                    
                    
                    
                </form>
                </fieldset>
            </div>
        </div>
   
    
</body>
</html>