<html>
    
   
    
    
    
<head>
    <link type="text/css" rel="stylesheet"  href="estilo/estilo.css">
    <?php
    include 'conecta.php';
    
    $formmat = "";
    $formsenha = "";
    $mat = "";
    $senha = "";
    
    
    
    if(isset($_POST['acessar'])){
        $mat = $_POST['matricula'];
        $senha = $_POST['senha'];
        
        if($mat ==""){
            echo "<script>alert('A Matricula deve ser preenchida!')</script>";
            $formmat = "formmat";
        }
        if($senha ==""){
            echo "<script>alert(A SENHA deve ser preenchida!')</script>";
            $formsenha = "formsenha";
        }
        
        
         if($mat !="" && $senha !=""){
                $sql = "SELECT * FROM funcionario WHERE senha='$senha' AND matricula='".$mat."'";

                $result = mysqli_query($conecta,$sql);
                $total = mysqli_num_rows($result);

                if($total > 0 ){

                    session_start([
                        'cookie_lifetime' => 86400,
                    ]);

                    while($consulta = mysqli_fetch_array($result)) { 
                        $_SESSION['nome'] = $consulta['nome'];
                        $_SESSION['id']   = $consulta['idfuncionario'];
                        $_SESSION['adm']   = $consulta['adm'];
                   }
                    echo $_SESSION['nome'];
                    header('Location: geral.php');
                }else{
                    header('Location: index.php?erro');
                }
         }
    }
    
    
    if(isset($_GET['sair'])){
        $sair = $_GET['sair'];
        if($sair){
            session_destroy();
            header('Location: index.php?');
        }
    }
    
    ?>
          
</head>
<body>
    <div class="content">
        <div id="topologin">
            <br>
            <br>
            <h1>Sistema de Ordens de Serviço para Faccionistas</h1>
            <br>
            <br>
            <img src="imagens/logo_monica.png">
        </div>
            <br>
            <br>
        <div id="login">
              <?php
          if(isset($_GET['erro'])){
              echo "<p style='color:red;text-align:center;'>Matricula e Senha não conferem!<br>Tente novamente ou fale com a gerência!</p>";
          }
        ?>
      
         <fieldset>
                <legend>Login</legend>
                <p>Por gentileza, digite sua matricula e sua senha e clique em Acessar</p>
                <form name="formpesquisa" action="index.php" method="post">
                    <label>Matrícula</label><br>
                    <input id="<?php echo $formmat; ?>" type="text" name="matricula" size="30" placeholder="" value="<?php echo $mat; ?>"><br>
                    <label>Senha</label><br>
                    <input id="<?php echo $formsenha; ?>" type="password" name="senha" size="30" placeholder=""  value="<?php echo $senha; ?>">
                    <p>
                        <input type="submit" name="acessar" value="Acessar">
                    </p>




                </form>  
        </fieldset>
            
        </div>
            <div id="creditos" style="text-align:center;margin-top:210px; font-size:8pt;">
                © 2017 - Direitos Reservados - Mônica Confecções. v1.0<br> Realizado por<img src="imagens/kwaba.png" width="40px" height="14px"> Laboratório de Soluções Digitais<br>
                Suporte: 47 99111-7188
            </div>
    </div>
   
    
    
</body>
</html>