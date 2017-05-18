<html>
<head>
    <link type="text/css" rel="stylesheet"  href="estilo/estilo.css">
          
</head>
    
    <?php
    include 'conecta.php';
    $sucesso ="";
   
    if( isset($_POST['nome']) )
    {
       
        $nome = $_POST['nome'];
        $matricula = $_POST['matricula'];
        $senha = $_POST['senha'];
        
        
        if(isset($_POST['adm'])){
            $adm = "a";
        }else{
            $adm = "n";
        }
        
        $id = $_POST['id'];
        if ($senha==""){
            $sql = "UPDATE `funcionario` SET `nome` = '$nome', `matricula` = '$matricula', `adm` = '$adm' WHERE `funcionario`.`idfuncionario` = '$id'"; 
            $result = mysqli_query($conecta,$sql);     
        }else{
            $sql = "UPDATE `funcionario` SET `nome` = '$nome', `matricula` = '$matricula', `senha` = '$senha', `adm` = '$adm' WHERE `funcionario`.`idfuncionario` = '$id'"; 
            $result = mysqli_query($conecta,$sql);     
            
        }
        
    
        if($result){
            $sucesso = "salvou";
        }else{
            $sucesso = "Erro ao Salvar";
        }
        mysqli_close($conecta); 
    }
    
    if( isset($_GET['id'])){
        
        if(isset($_GET['del'])){
            
            $id = $_GET['id'];
            
            if(!$id ==""){
                
                echo "<SCRIPT LANGUAGE='JavaScript' TYPE='text/javascript'>
                                
                    decisao = confirm('Deseja REALMENTE desativar este funcionario???');

                    if (decisao){
                         location.href = 'editafuncionario.php?confdel=".$id."';
                    } else {
                         location.href = 'funcionario.php';
                    }

                    </SCRIPT>";
              
            }else{
                
                echo "<SCRIPT LANGUAGE='JavaScript' TYPE='text/javascript'>
                                
                        decisao = alert('Não é possível desativar este funcionario!!!');
                        location.href = 'funcionario.php';
                  
                    </SCRIPT>";
             }
            
           
            
            
        }else{
            
            $id = $_GET['id'];
            $sql = "SELECT * FROM `funcionario` WHERE idfuncionario =".$id;
            $result = mysqli_query($conecta,$sql); 


            while($consulta = mysqli_fetch_array($result)) { 
                $nome = $consulta['nome'];
                $matricula= $consulta['matricula'];
                $adm = $consulta['adm'];
                if ($adm == "a"){
                    $adm = "checked";
                }else{
                    $adm = "";
                }
            }
            
            
        }
        
       


        
        
        if(mysqli_num_rows($result) > 0){
            $localiza = "Localizado";
            
        }else{
            $localiza = "Usuário não localizado";
             echo"<SCRIPT LANGUAGE='JavaScript' TYPE='text/javascript'>
                                
            decisao = confirm('Funcionario não localizado!');

            if (decisao){
                 location.href = 'funcionario.php';
            } else {
                 location.href = 'funcionario.php';
            }

            </SCRIPT>";
        }
        mysqli_close($conecta); 
        
        
    }
    
    if( isset($_GET['confdel'])){
        
        $id = $_GET['confdel'];
        $sql = "UPDATE `funcionario` SET `status` = '1'  WHERE `funcionario`.`idfuncionario` =".$id;
        
        $result = mysqli_query($conecta,$sql); 
        
        echo"<SCRIPT LANGUAGE='JavaScript' TYPE='text/javascript'>
                                
            alert('Funcionario DESATIVADO COM SUCESSO!');
            location.href = 'funcionario.php';
   
            </SCRIPT>";
                
    }
   
    
    ?>
<body>
    <div class="content">
        <div class="topo">
           
            <div class="userlogado">
                <div class="btnsup"><p><a href="funcionario.php">Voltar</a></p></div>
                
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
                <p><h3><a href="geral.php">Início</a> > <a href="funcionario.php">Funcionários</a> > Editar Funcionário</h3></p>   
        </div>
        <div class="corpo">
            
            <div class="interna">
                <?php 
                    if($sucesso == "salvou"){
                        echo"<SCRIPT LANGUAGE='JavaScript' TYPE='text/javascript'>
                                
                                decisao = confirm('Salvo com sucesso, retonar??');
                                
                                if (decisao){
                                        location.href = 'funcionario.php';
                                } else {
                                        location.href = 'funcionario.php';
                                }
                                
                                </SCRIPT>";
                    }elseif($sucesso=="Erro ao Salvar"){
                        echo"<script>alert('Ocorreu algum erro ao Salvar!Consulte o suporte!');</script>";
                    }
                
                ?>
                <fieldset>
                    <legend> Cadastrar nova operação</legend>
                <form name="cadoperacao" action="editafuncionario.php" method="post">
                   <div class="label">
                            <p>
                            Funcionário:
                            </p>
                             <p>
                                Matrícula:
                            </p>
                             <p>
                                Senha:
                            </p>
                    </div>
                    <div class="input">
                        <input type="hidden" name="id" size="40" value="<?php echo $id; ?>" >
              
                        <input type="text" name="nome" size="40" value="<?php echo $nome; ?>" placeholder="Digite o nome do Funcinario">
                  
                        <input type="text" name="matricula" size="40" value="<?php echo $matricula; ?>" placeholder="Digite a matricula">
                        
                        <input type="text" name="senha" size="40" placeholder="Digite a nova senha, caso queira mudar"><br>
                        <input type="checkbox" name="adm" value="a" <?php echo $adm; ?>>É administrador do Sistema?
                        <br>
                        <input type="submit" value="Salvar" name="salvar">
                    </div>
                        
                   
                  
                   
                    
                    
                    
                    <?php     ?>
                    
                </form>
                </fieldset>
            </div>
        </div>
    
    
    </div>
    
    
</body>
</html>