<html>
<head>
<link type="text/css" rel="stylesheet"  href="estilo/estilo.css">
    <meta charset="utf-8">
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
    
    $numtotal=0;
   if(isset($_GET['busca'])){
       
        $nome = $_GET['busca'];
        $sql = "SELECT * FROM referencia WHERE status = 0 AND codigoref LIKE '%$nome%'ORDER BY codigoref ASC"; 
       
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
       
       $sql = "SELECT * FROM referencia WHERE status = 0 ORDER BY codigoref ASC LIMIT 0,10"; 
       $result = mysqli_query($conecta,$sql); 
       
   }






?>
<body>
<div class="content">
     <div class="topo">
            <div class="topo">
           
            <div class="userlogado">
                <div class="btnsup"><p><a href="refop.php">Voltar</a></p></div>
                <div class="btnsup"><p><a href="novareferencia.php">Nova</a></p></div>
                <div class="btnsup" style="width:200px;"><p><a href="refplanilha.php">Atualizar via Planilha</a></p></div>
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
                <p><h3><a href="geral.php">Início</a> > <a href="refop.php">Referências / Operações</a> > Referência</h3></p>   
        </div>
    <div class="corpo">
        <div class="interna">

            <fieldset>
                <legend>Pesquisar</legend>
                <form name="formpesquisa" action="referencia.php" method="get">

                    <input type="text" name="busca" size="40" placeholder="Digite o texto de busca">

                    <input type="submit" name="buscar" value="Buscar">


                </form>  
            </fieldset>
            

      <br><br>

            <table>
               <tr>
                    <th>Referências</th>
                    <th style="width:20px;">Editar</th>
               </tr>
                <tr>


                <?php
                    while($consulta = mysqli_fetch_array($result)) { 
                ?>


                <tr>
                    <td> <?php print $consulta['codigoref'] ?></td>
                    <td>
                        
                        <a href="editareferencia.php?id=<?php echo $consulta['idreferencia']?>"><img src="imagens/editar.png" width="20px" height="20px"></a>
                      <!--  <a href="editareferencia.php?id=<?php echo $consulta['idreferencia']?>&del=true"><img src="imagens/excluir.png" width="20px" height="20px"></a> -->
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
                            echo " <a href='referencia.php?pag=$i&".$varpag."'>".$i."</a> ";
                        }    
                    }

                    ?>
        </div>
    </div>


</div>


</body>
</html>