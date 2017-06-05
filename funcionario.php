<html>
<head>
    <link type="text/css" rel="stylesheet"  href="estilo/estilo.css">
     <script language="JavaScript" type="text/javascript" src="js/jquery-3.2.1.min.js"></script>    
    <script type="text/javascript">
    
        $(function(){
            $('tbody tr').mouseover(function(){
                 $(this).addClass('over');
            }).mouseout(function(){
                $(this).removeClass('over');
            });
        });
    
    </script>
    <style type="text/css">

            .over {
            background: coral;
            }
    </style>
          
</head>
    <?php
    include 'conecta.php';
    
    $numtotal =  0;


    if(isset($_GET['busca'])){
        $nome = $_GET['busca'];
        $sql = "SELECT * FROM funcionario WHERE status = 0 AND nome LIKE '%$nome%' ORDER BY nome ASC"; 
        
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
    
    }else{
           $sql = "SELECT * FROM funcionario WHERE status = 0 ORDER BY nome ASC LIMIT 0,10"; 
           $result = mysqli_query($conecta,$sql); 
    }
 
   
    
   
    
    ?>
<body>
    <div class="content">
        <div class="topo">
           
            <div class="userlogado">
                <div class="btnsup"><p><a href="geral.php">Voltar</a></p></div>
                <div class="btnsup"><p><a href="novofuncionario.php">Novo</a></p></div>
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
                <p><h3><a href="geral.php">Início</a> > Funcionários</h3></p>   
        </div>
        <div class="corpo">
            <div class="interna">
            
            
            
                <fieldset>
                    <legend>Pesquisar</legend>
                    <form name="formpesquisa" action="funcionario.php" method="get">
                        
                        <input type="text" name="busca" size="40" placeholder="Digite o texto de busca">
                        
                        <input type="submit" name="buscar" value="Buscar">


                    </form>  
                </fieldset>
            
            <br>
            <br>
            
                <table>
                   <tr>
                        <th>Matricula</th>
                        <th>Nome do Func.</th>
                        <th style="width:200px;">Editar</th>
                   </tr>
                    <tr>
                        
                    
                    <?php
                        while($consulta = mysqli_fetch_array($result)) { 
                    ?>
    

                    <tr>
                        <td> <?php echo $consulta['matricula'] ?></td>
                        <td> <?php echo $consulta['nome'] ?></td>
                        <td style="text-align:center;">
                            <a href="editafuncionario.php?id=<?php echo $consulta['idfuncionario']?>"><img src="imagens/editar.png" width="20px" height="20px"></a>
                            <a href="editafuncionario.php?id=<?php echo $consulta['idfuncionario']?>&del=true"><img src="imagens/excluir.png"  width="20px" height="20px"></a>
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
                            echo " <a href='funcionario.php?pag=$i&".$varpag."'>".$i."</a> ";
                        }    
                    }

                    ?>
            </div>
        </div>
    
    
    </div>
    
    
</body>
</html>