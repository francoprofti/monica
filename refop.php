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
                 <p><h3><a href="geral.php">Início</a> > Referências/Operação</h3></p>   
        </div>
        
        <div class="corpo">
            
                <?php
                    if($_SESSION['adm'] =="a"){
                ?>
                <div>
                    <a href="referencia.php">
                        <div class="bigbutton">
                            <p>REFERÊNCIAS</p>
                        </div>
                    </a>
                    <a href="operacao.php">
                        <div class="bigbutton">
                            <p>OPERAÇÕES</p>
                        </div>
                    </a>
                </div>
                
                <?php
                    }else{
                ?>
                <div>
                
                        <p>Vôce não tem acesso a esta tela</p>
                
                </div>

            
            
            
                <?php
                    }
                ?>
            
        </div>
    
    
    </div>
    
    
</body>
</html>