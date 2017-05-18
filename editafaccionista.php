<html>
<head>
    <link type="text/css" rel="stylesheet"  href="estilo/estilo.css">
    <script type="text/javascript" src="js/mascara.js"></script>
          
</head>
    
    <?php
    include 'conecta.php';
    $sucesso ="";
    
    
    if( isset($_POST['nome']) ){
       
        $nome = $_POST['nome'];
        $id = $_POST['id'];
   
        $sql = "UPDATE `faccionista` SET `nomefac` = '$nome' WHERE `faccionista`.`idfaccionista` =".$id; 
       
        $result = mysqli_query($conecta,$sql); 
        
        $listapost = substr($_POST['listaop'],0,-1);
        $listapost = explode(',',$listapost);
          
        foreach($listapost as $lista) {
            $valpost = "valor".$lista;
            
             if( isset($_POST[$valpost])){
                $valor = $_POST[$valpost];
                if($valor == ""){
                   $valor = 0;
                }
                
                 $valor = str_replace(',', '.', $valor);
                
                 
                $sqlverifica = "SELECT * FROM operacaofaccionista WHERE idfaccionista = '$id' AND `idoperacao` = '$lista';";
             
                $resultverifica = mysqli_query($conecta,$sqlverifica); 
                
                if(mysqli_num_rows($resultverifica) > 0){
                    $sqlassocia = "UPDATE `operacaofaccionista` SET valor = '$valor' WHERE idfaccionista = '$id' AND `idoperacao` = '$lista';"; 
                    
                    $result = mysqli_query($conecta,$sqlassocia);         
                }else{
                    $sqlassocia = "INSERT INTO `operacaofaccionista` (`idfaccionista`, `idoperacao`, `valor`) VALUES ('$id', '$lista', '$valor');"; 
                    $result = mysqli_query($conecta,$sqlassocia); 
                }
            }
        }

        if($result){
            $sucesso = "salvou";
        }else{
            $sucesso = "Erro ao Salvar";
        }
        
        mysqli_close($conecta); 
          
    }
    
   
    
    if(isset($_GET['id']) ){
        
         if(isset($_GET['del'])){
            
            $id = $_GET['id'];
            
            if(!$id ==""){
                
                echo "<SCRIPT LANGUAGE='JavaScript' TYPE='text/javascript'>
                                
                    decisao = confirm('Deseja REALMENTE desativar este faccionista???');

                    if (decisao){
                         location.href = 'editafaccionista.php?confdel=".$id."';
                    } else {
                         location.href = 'faccionista.php';
                    }

                    </SCRIPT>";
              
            }else{
                
                echo "<SCRIPT LANGUAGE='JavaScript' TYPE='text/javascript'>
                                
                        decisao = alert('Não é possível desativar este funcionario???');
                        location.href = 'funcionario.php';
                  
                    </SCRIPT>";
             }
            
           
            
            
        }else{
        

            $id= $_GET['id'];     
            $nomefac ="";
            //faz consulta das operações
            $sql2 = "SELECT * FROM operacao WHERE status = 0 ORDER BY nomeoperacao ASC";  
            $resultop = mysqli_query($conecta,$sql2);     

            $sql3= "SELECT faccionista.idfaccionista as idfacicionista,
                    faccionista.nomefac as nomefac,
                    faccionista.status as statusfac,
                    operacao.nomeoperacao  as operacao,
                    operacaofaccionista.idfaccionista as operafacidfac,
                    operacaofaccionista.idoperacao as operafacidop,
                    operacaofaccionista.valor as valor,
                    operacao.idoperacao AS idoperacao
                    FROM operacao LEFT JOIN operacaofaccionista ON ( operacao.idoperacao = operacaofaccionista.idoperacao)
                    LEFT JOIN faccionista ON (operacaofaccionista.idfaccionista = faccionista.idfaccionista)
                    WHERE operacao.status = 0  AND faccionista.idfaccionista = $id OR faccionista.idfaccionista IS NULL ORDER BY nomeoperacao ASC;";
            $resultinner = mysqli_query($conecta,$sql3);     


            $sqlnome = "SELECT nomefac FROM faccionista WHERE idfaccionista=".$id;
            $resultnome =  mysqli_query($conecta,$sqlnome);     
             while($consnome = mysqli_fetch_array($resultnome)) { 
                $nomefac = $consnome['nomefac'];

            }
         }
    
    }
    
    
    if( isset($_GET['confdel'])){
        
        $id = $_GET['confdel'];
        $sql = "UPDATE `faccionista` SET `status` = '1'  WHERE `faccionista`.`idfaccionista` =".$id;
        
        $result = mysqli_query($conecta,$sql); 
        
        echo"<SCRIPT LANGUAGE='JavaScript' TYPE='text/javascript'>
                                
            alert('Faccionista DESATIVADO COM SUCESSO!');
            location.href = 'Faccionista.php';
   
            </SCRIPT>";
                
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
                <p><h3><a href="geral.php">Início</a> > <a href="faccionista.php">Faccionista</a> > Edita Faccionista</h3></p>   
        </div>
        <div class="corpo">
            <div class="interna">
                <?php 
                    if($sucesso == "salvou"){
                       echo"<SCRIPT LANGUAGE='JavaScript' TYPE='text/javascript'>
                                
                                decisao = confirm('Faccionista alterado com sucesso!!');
                                
                                if (decisao){
                                        location.href = 'faccionista.php';
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
                <form name="cadoperacao" action="editafaccionista.php" method="post">
                    <label>
                        Faccionista:
                    </label>
                    <input type="hidden" name="id" size="80" value="<?php echo $id;?>">
                    <input type="text" name="nome" size="80" placeholder="Digite o nome do Faccionista" value="<?php echo $nomefac;?>"><br>
                    
                  
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
                        $listaop = 0;
                        while($consult = mysqli_fetch_array($resultinner)) { 
                    ?>
    

                    <tr>
                        
                        <td>
                            <?php echo $consult['operacao'] ?></td>
                        <td> 
                            
                            <?php
                            $listaop =$consult['idoperacao'].",". $listaop;
                            $valor = $consult['valor'];
                            $valor = str_replace('.', ',', $valor);
                            echo "<input type='hidden' name='listaop' value='".$listaop."'>";
                            echo "<input style='text-align:right;'type='text' name='valor".$consult['idoperacao']."' size='8' placeholder='' onkeypress='mascara(this,moeda)' value='".$valor."'>";
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
    
    
    </div>
    
    
</body>
</html>