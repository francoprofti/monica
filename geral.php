<html>
<head>
    <link type="text/css" rel="stylesheet"  href="estilo/estilo.css">
          
</head>
    <?php 
         session_start();
    ?>
<body>
    <div class="content">
        <div class="topo">
           
            <div class="userlogado" style="padding-left:20px;">
                <p>Olá <b><?php echo $_SESSION['nome'];?></b>, por favor, escolha uma opção...<p>
            </div>
            
            <div class="botaosup">
                <a href="index.php?sair=true">
                    <div class="sair" style="top:50px;">
                      
                        <p>SAIR</p>
                    </div>
                </a>
            </div>
             
        </div>
        <div class="caminho">
                
        </div>
        
        <div class="corpo">
            
                <?php
                    if($_SESSION['adm'] =="n"){
                        
                        header('location: geralordem.php');
                    }
                ?>
                <div>
                    <a href="funcionario.php">
                        <div class="bigbutton">
                            <p>FUNCIONÁRIOS</p>
                        </div>
                    </a>
                    <a href="refop.php">
                        <div class="bigbutton">
                            <p>REFRÊNCIAS E OPERAÇÕES</p>
                        </div>
                    </a>
                </div>
                <div>
                    <a href="faccionista.php">
                        <div class="bigbutton">
                            <p>FACCIONISTAS</p>
                        </div>
                    </a>
                   <a href="geralordem.php">
                    <div class="bigbutton">
                        <p>ORDEM DE SERVIÇO</p>
                    </div>
                    </a>
                </div>
                
             <!---   <div>
                   <a href="novaordem.php"> 
                       <div class="bigbutton" style="margin-left: 275px; margin-top: 68px;">
                        <p>ORDEM DE SERVIÇO</p>
                       </div>
                    </a>
                </div> --->

            
            
            
               
            
        </div>
    
    
    </div>
    
    
</body>
</html>