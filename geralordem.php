<html>
<head>
    <link type="text/css" rel="stylesheet"  href="estilo/estilo.css">
          
</head>
    <?php session_start();?>
<body>
    <div class="content">
        <div class="topo">
            <div class="topo">
           
           <div class="userlogado" style="padding-left:20px;">
                <p>Olá <b><?php echo $_SESSION['nome'];?></b>, por favor, escolha uma opção...<p>
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
                <p><h3><a href="geral.php">Início</a> > Ordem de Serviço</h3></p>   
        </div>
    <div class="corpo">
            <div>
                <br><br><br><br><br>
                
                <?php
                
                    if($_SESSION['adm'] == "a"){ 
                ?>
                <a href="ordemservico.php">
                    <div class="bigbutton">
                        <p>Consultar Ordem serviço</p>
                    </div>
                </a>
                <?php
               
                }else{    
                    
                ?>
                <a href="novaordem.php">
                    <div class="bigbutton">
                        <p>Nova Ordem Serviço</p>
                    </div>
                </a>
                
                
                <?php
                }    
                    
                ?>
                
                <a href="localizaos.php">
                    <div class="bigbutton">
                        <p>Receber Ordem de Serviço</p>
                    </div>
                </a>
            </div>
    </div>
    
    
    </div>
    
    
</body>
</html>