<html>
<head>
    <link type="text/css" rel="stylesheet"  href="estilo/estilo.css">
          
</head>
    <?php
    include 'conecta.php';
    
    $numtotal =  0;
  
    if(!isset($_GET['busca'])){
        $sql = "SELECT * FROM operacao WHERE status = 0 ORDER BY nomeoperacao ASC LIMIT 0,10"; 
        $result = mysqli_query($conecta,$sql); 
        
        
    }else{
        $nome = $_GET['busca'];
        $sql = "SELECT * FROM operacao WHERE status = 0 AND nomeoperacao LIKE '%$nome%' ORDER BY nomeoperacao ASC"; 
        $result = mysqli_query($conecta,$sql); 
        
        $pagina = (isset($_GET['pag']))? $_GET['pag'] : 1;
        $total = mysqli_num_rows($result);
        $numtotal =  $total;
        $registros = 10;
        $numPaginas = ceil($total/$registros);
        $inicio = ($registros*$pagina)-$registros;
        
        $cmd = "$sql LIMIT $inicio,$registros";
        
        $result = mysqli_query($conecta,$cmd);
        $total = mysqli_num_rows($result);
        
        
        $varpag = "&busca=".$nome."&buscar=Buscar";
        
        
    }
    
   
    
   
    
    ?>
<body>
    <div class="content">
        <div class="topo">
            <div class="topo">
           
            <div class="userlogado">
                <div class="btnsup"><p><a href="geral.php">Voltar</a></p></div>
                <div class="btnsup"><p><a href="novaoperacao.php">Novo</a></p></div>
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
                <p><h3><a href="geral.php">Início</a> > Operações</h3></p>   
        </div>
        <div class="corpo">
            <div class="interna">
            
                 <fieldset>
                    <legend>Pesquisar</legend>
                    <form name="formpesquisa" action="operacao.php" method="get">
                        
                        <input type="text" name="busca" size="40" placeholder="Digite o texto de busca">
                        
                        <input type="submit" name="buscar" value="Buscar">


                    </form>  
                </fieldset>
            
            
            <br>
            <br>
            
                <table>
                   <tr>
                        <th>Operações</th>
                        <th style="width:200px;">Editar</th>
                   </tr>
                    <tr>
                        
                    
                    <?php
                        while($consulta = mysqli_fetch_array($result)) { 
                    ?>
    

                    <tr>
                        <td> <?php echo $consulta['nomeoperacao'] ?></td>
                        <td style="text-align:center">
                            <a href="editaoperacao.php?id=<?php echo $consulta['idoperacao']?>"><img src="imagens/editar.png" width="20px" height="20px"></a>
                            <a href="editaoperacao.php?id=<?php echo $consulta['idoperacao']?>&del=true"><img src="imagens/excluir.png" width="20px" height="20px"></a>
                        </td>

                    </tr>
                    <?php 
                        } 
                    ?>
                </table>
                 <?php
                
                    if($numtotal != 0){
                        echo "<br>Foram localizado(s) ".$numtotal." resultado(s)<br>";
                        echo "Veja mais resultados ";

                        for($i = 1; $i < $numPaginas + 1; $i++) {
                            echo " <a href='operacao.php?pag=$i&".$varpag."'>".$i."</a> ";
                        }    
                    }

                    ?>
            </div>
        </div>
    
    
    </div>
    
    
</body>
</html>