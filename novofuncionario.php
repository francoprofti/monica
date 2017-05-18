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
        $adm = $_POST['adm'];
        
      
        

        $sql = "INSERT INTO `funcionario` (`idfuncionario`, `nome`, `matricula`, `senha`, `adm`, `status`) 
                VALUES (NULL, '$nome', '$matricula', '$senha', '$adm', '0');"; 
        
        echo "$sql";
        $result = mysqli_query($conecta,$sql); 
        if($result){
            $sucesso = "salvou";
        }else{
            $sucesso = "Erro ao Salvar";
        }
        mysqli_close($conecta); 
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
                <p><h3><a href="geral.php">Início</a> > <a href="funcionario.php">Funcionários</a> > Novo Funcionário</h3></p>   
        </div>
        <div class="corpo">
            <div class="interna">
                <?php 
                    if($sucesso == "salvou"){
                        echo"<SCRIPT LANGUAGE='JavaScript' TYPE='text/javascript'>
                                
                                decisao = confirm('Salvo com sucesso, deseja salvar mais?');
                                
                                if (decisao){
                                        location.href = 'novofuncionario.php';
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
                <form name="cadoperacao" action="novofuncionario.php" method="post">
                    <div>
                     
                    </div>
                    
                    <div>
                        <input type="text" name="nome" size="40" placeholder="Digite o nome do Funcinario"><br>
                   
                        <input type="text" name="matricula" size="40" placeholder="Digite a Matrícula"><br>

                        <input type="text" name="senha" size="40" placeholder="Digite a Senha"><br>
                        <input type="checkbox" name="adm" value="a">É administrador do Sistema?
                    
                    </div>
                    
                    <br>
                    <input type="submit" value="Salvar" name="salvar">
                </form>
                </fieldset>
            </div>
        </div>
    
    
    </div>
    
    
</body>
</html>