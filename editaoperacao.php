<html>
<head>
    <link type="text/css" rel="stylesheet"  href="estilo/estilo.css">
          
</head>
    
    <?php
    include 'conecta.php';
    $sucesso ="";
   
    if( isset($_POST['nome']) ){
       
        $nome = $_POST['nome'];
        $id = $_POST['id'];
    
        $sql = "UPDATE `operacao` SET `nomeoperacao` = '$nome'  WHERE `operacao`.`idoperacao` = '$id'"; 
        $result = mysqli_query($conecta,$sql); 
    
        if($result){
            $sucesso = "salvou";
        }else{
            $sucesso = "Erro ao Salvar";
        }
        mysqli_close($conecta); 
    }
    
    if( isset($_GET['id']) ){
         if(isset($_GET['del'])){

                $id = $_GET['id'];

                if(!$id ==""){

                    echo "<SCRIPT LANGUAGE='JavaScript' TYPE='text/javascript'>

                        decisao = confirm('Deseja REALMENTE desativar esta Operação???');

                        if (decisao){
                             location.href = 'editaoperacao.php?confdel=".$id."';
                        } else {
                             location.href = 'operacao.php';
                        }

                        </SCRIPT>";

                }else{

                       echo "<SCRIPT LANGUAGE='JavaScript' TYPE='text/javascript'>

                                decisao = alert('Não é possível desativar esta Operação???');
                                location.href = 'operacao.php';

                            </SCRIPT>";
                }
            }
        
            $id = $_GET['id'];
            $sql = "SELECT * FROM `operacao` WHERE idoperacao =".$id;
            $result = mysqli_query($conecta,$sql); 
             
            
            if(mysqli_num_rows($result) > 0){
            $localiza = "Localizado";
            
            }else{
                $localiza = "Usuário não localizado";
                 echo"<SCRIPT LANGUAGE='JavaScript' TYPE='text/javascript'>

                alert('Operação não localizado!');
                     location.href = 'operacao.php';
                </SCRIPT>";
            }


            while($consulta = mysqli_fetch_array($result)) { 
                $nome = $consulta['nomeoperacao'];
               
            }  
        
        
    }
        
    
     if( isset($_GET['confdel'])){
        
        $id = $_GET['confdel'];
        $sql = "UPDATE `operacao` SET `status` = '1'  WHERE `operacao`.`idoperacao` =".$id;
        
        $result = mysqli_query($conecta,$sql); 
        
        echo"<SCRIPT LANGUAGE='JavaScript' TYPE='text/javascript'>
                                
            alert('Operação DESATIVADO COM SUCESSO!');
            location.href = 'operacao.php';
   
            </SCRIPT>";
                
    }
    
      
    
    
   
    
    ?>
<body>
    <div class="content">
       <div class="topo">
            <div class="topo">
           
            <div class="userlogado">
                <div class="btnsup"><p><a href="operacao.php">Voltar</a></p></div>
               
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
            <p><h3><a href="geral.php">Início</a> > <a href="operacao.php">Operações</a> > Editar Operação</h3></p>   
        </div>
        <div class="corpo">
            <div class="interna">
                <?php 
                    if($sucesso == "salvou"){
                        echo"<SCRIPT LANGUAGE='JavaScript' TYPE='text/javascript'>
                                
                                alert('Operação Alterado com sucesso!!');
                                location.href = 'operacao.php';
                                                                
                            </SCRIPT>";
                    }elseif($sucesso=="Erro ao Salvar"){
                        echo"<script>alert('Ocorreu algum erro ao Salvar!Consulte o suporte!');</script>";
                    }
                ?>
                <fieldset>
                    <legend> Cadastrar nova operação</legend>
                <form name="cadoperacao" action="editaoperacao.php" method="post">
                    <label>
                        Operação:
                        <input type="hidden" name="id" size="80" placeholder="Digite o nome da operação e salve" value="<?php echo $id;?>">    
                    </label>
                    <input type="text" name="nome" size="80" placeholder="Digite o nome da operação e salve" value="<?php echo $nome;?>">
                    <br>
                    <input type="submit" value="Salvar" name="salvar">
                </form>
                </fieldset>
            </div>
        </div>
    
    
    </div>
    
    
</body>
</html>