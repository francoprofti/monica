<html>
<head>
    <link type="text/css" rel="stylesheet"  href="estilo/estilo.css">
          
</head>
    
    <?php
    include 'conecta.php';
    $sucesso ="";
   
    if( isset($_POST['nome']) )
    {
       
       
    
        $nomeoperacao = $_POST['nome'];

        $sql = "INSERT INTO operacao (idoperacao, nomeoperacao) VALUES (NULL, '$nomeoperacao');"; 
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
            <p><h3><a href="geral.php">Início</a> > <a href="operacao.php">Operações</a> > Nova Operação</h3></p>   
        </div>
        <div class="corpo">
            <div class="interna">
                <?php 
                    if($sucesso == "salvou"){
                        echo"<SCRIPT LANGUAGE='JavaScript' TYPE='text/javascript'>
                                
                                decisao = confirm('Salvo com sucesso, deseja salvar mais?');
                                
                                if (decisao){
                                        location.href = 'novaoperacao.php';
                                } else {
                                        location.href = 'operacao.php';
                                }
                                
                                </SCRIPT>";
                    }elseif($sucesso=="Erro ao Salvar"){
                        echo"<script>alert('Ocorreu algum erro ao Salvar!Consulte o suporte!');</script>";
                    }
                ?>
                <fieldset>
                    <legend> Cadastrar nova operação</legend>
                <form name="cadoperacao" action="novaoperacao.php" method="post">
                    <label>
                        Operação:
                    </label>
                    <input type="text" name="nome" size="80" placeholder="Digite o nome da operação e salve">
                    <br>
                    <input type="submit" value="Salvar" name="salvar">
                </form>
                </fieldset>
            </div>
        </div>
    
    
    </div>
    
    
</body>
</html>