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
session_start();
$numtotal =  0;


if(!isset($_GET['busca'])){
    
 
    
    
    $sql = "SELECT ordemservico.idordemservico AS id, funcionario.nome AS nomefuncionario,  ordemservico.datacriacao as data, faccionista.nomefac as faccionista, ordemservico.idreferencia, ordemservico.qnt, ordemservico.modelo, ordemservico.obs, referencia.codigoref
    FROM funcionario INNER JOIN ordemservico
    ON (funcionario.idfuncionario = ordemservico.idfuncionario) INNER JOIN faccionista
    ON (ordemservico.idfaccionista = faccionista.idfaccionista) INNER JOIN operacaofaccionista
    ON (faccionista.idfaccionista = operacaofaccionista.idfaccionista) INNER JOIN referencia
    ON (ordemservico.idreferencia = referencia.idreferencia)
    WHERE ordemservico.status <> '0' GROUP BY ordemservico.idordemservico ORDER BY datcadastro DESC LIMIT 10"; 
    $result = mysqli_query($conecta,$sql);
    
   $nome = "";
   $tipo = "";
   $status = "";
   $tipoetiqueta = "";
   $data="";
   $datini = "";
   $datfim = "";
        
    
        
   
    
}else{
    
    if($_GET['tipo'] != ""){
        
        $nome = $_GET['busca'];
        $tipo = $_GET['tipo'];
        $status = $_GET['status'];
        $tipoetiqueta = $_GET['tipo'];
        
        if($tipo == "fac"){
            
            $tipo = "AND faccionista.nomefac like";    
            
        }elseif($tipo == "r"){
            $tipo = "AND ordemservico.referencia like";
            
        }elseif($tipo == "m"){
            $tipo = "AND ordemservico.modelo like";
            
        }elseif($tipo == "fun"){
            $tipo = "AND funcionario.nome like";
            
        }
        
        
        if($_GET['datini'] != ""  AND $_GET['datfim'] != ""){
            $datini =  date('Y-m-d', strtotime($_GET['datini']));
            $datfim =  date('Y-m-d', strtotime($_GET['datfim']));
            $data =  "AND ordemservico.datacriacao BETWEEN '$datini' AND '$datfim'";    
        }else{
            $data="";
            $datini = "";
            $datfim = "";
        }
        
        $sql = "SELECT ordemservico.idordemservico AS id, funcionario.nome AS nomefuncionario,  ordemservico.datacriacao as data, faccionista.nomefac as faccionista, ordemservico.idreferencia, ordemservico.qnt, ordemservico.modelo, ordemservico.obs,  referencia.codigoref
        FROM funcionario INNER JOIN ordemservico
        ON (funcionario.idfuncionario = ordemservico.idfuncionario) INNER JOIN faccionista
        ON (ordemservico.idfaccionista = faccionista.idfaccionista) INNER JOIN operacaofaccionista
        ON (faccionista.idfaccionista = operacaofaccionista.idfaccionista) INNER JOIN referencia
        ON (ordemservico.idreferencia = referencia.idreferencia)
        WHERE  ordemservico.status  = '$status' $tipo '%$nome%' $data
        GROUP BY ordemservico.idordemservico ORDER BY datcadastro DESC"; 
        
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
        
        
        $varpag = "tipo=".$tipo."&busca=".$nome."&datini=".$datini."&datfim=".$datfim."&buscar=Buscar&status=".$status;
        $varetiqueta = "tipo=".$tipoetiqueta."&busca=".$nome."&datini=".$datini."&datfim=".$datfim."&status=".$status;
        
        
    }
    
    
    
}



?>
<body>
<div class="content">
    <div class="topo">
        <div class="topo">
           
            <div class="userlogado">
                <a href="geralordem.php"><div class="btnsup"><p>Voltar</p></div></a>
                <a href="novaordem.php"><div class="btnsup"><p>Nova OS</p></div></a>
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
                <p><h3><a href="geral.php">Início</a> > <a href="geralordem.php">OS</a> > Consultar e Imprimir Etiquetas</h3></p>   
        </div>
        
        <div class="corpo">
            <div class="interna">



        <fieldset>
            <legend>Pesquisar</legend>
            <form name="formpesquisa" action="ordemservico.php" method="get">
                <select name="tipo" style="width: 100px;">
                    <?php 
                        if($tipo != ""){
                            if($tipoetiqueta == "fac"){
            
                              
                                echo " <option selected value='fac'>Faccionista</option>
                                        <option value='r'>Referência</option>
                                        <option value='m'>Modelo</option>
                                        <option value='fun'>Funcionario</option>";

                            }elseif($tipoetiqueta == "r"){
                              
                                 echo " <option  value='fac'>Faccionista</option>
                                        <option selected value='r'>Referência</option>
                                        <option value='m'>Modelo</option>
                                        <option value='fun'>Funcionario</option>";

                            }elseif($tipoetiqueta == "m"){
                              
                                echo " <option  value='fac'>Faccionista</option>
                                        <option  value='r'>Referência</option>
                                        <option selected value='m'>Modelo</option>
                                        <option value='fun'>Funcionario</option>";

                            }elseif($tipoetiqueta == "fun"){
                              
                                echo " <option  value='fac'>Faccionista</option>
                                        <option  value='r'>Referência</option>
                                        <option  value='m'>Modelo</option>
                                        <option selected value='fun'>Funcionario</option>";

                            }
                               

                            
                        }else{
                             echo " <option  value='fac'>Faccionista</option>
                                <option  value='r'>Referência</option>
                                <option  value='m'>Modelo</option>
                                <option  value='fun'>Funcionario</option>";
                        }
                    ?>
                   
                </select>
                <input type="text" name="busca" size="30" value="<?php echo $nome; ?>" placeholder="Digite o texto de busca">
                <input type="date" name="datini" size="10" value="<?php echo $datini; ?>" placeholder="Data de início">
                <input type="date" name="datfim" size="10" value="<?php echo $datfim; ?>"placeholder="Data de fim">
                <select name="status" style="width:100px; ">
                     <?php 
                        if($status != ""){
                            if($status == "0"){
            
                              
                                echo " <option selected value='0'>Excluido</option>
                                        <option value='1'>Pendente</option>
                                        <option value='2'>Aprovada</option>
                                        <option value='3'>Recebida</option>";

                            }elseif($status == "1"){
                              
                                 echo " <option  value='0'>Excluido</option>
                                        <option selected value='1'>Pendente</option>
                                        <option value='2'>Aprovada</option>
                                        <option value='3'>Recebida</option>";

                            }elseif($status == "2"){
                              
                                echo " <option  value='0'>Excluido</option>
                                        <option value='1'>Pendente</option>
                                        <option selected value='2'>Aprovada</option>
                                        <option value='3'>Recebida</option>";

                            }elseif($status == "3"){
                              
                               echo " <option  value='0'>Excluido</option>
                                        <option value='1'>Pendente</option>
                                        <option value='2'>Aprovada</option>
                                        <option selected value='3'>Recebida</option>";

                            }
                               

                            
                        }else{
                             echo " <option value='0'>Excluido</option>
                                    <option selected value='1'>Pendente</option>
                                    <option value='2'>Aprovada</option>
                                    <option value='3'>Recebida</option>";
                        }
                    ?>
                    
                    
                   
                </select>
                <input type="submit" name="buscar" value="Buscar">




            </form>  
        </fieldset>
            <br><br>
            <table>
               <tr>
                   <th style="width:200px;">Faccionista</th>
                   <th style="width:200px;">Referência</th>
                   <th style="width:50px;">Quantidade</th>
                   <th style="width:100px;">Modelo</th>
                   <th style="width:100px;">Funcionário</th>
                   <th style="width:100px;">Data</th>
                   <th style="width:50px;">Editar</th>
               </tr>
                <tr>


                <?php
                   
                        
                    
                 while($consulta = mysqli_fetch_array($result)) { 
                ?>


                <tr>
                    <td> <?php echo $consulta['faccionista']; ?></td>
                    <td> <?php echo $consulta['codigoref']; ?></td>
                    <td> <?php echo $consulta['qnt']; ?></td>
                    <td> <?php echo $consulta['modelo']; ?></td>
                    <td> <?php echo $consulta['nomefuncionario']; ?></td>
                    <td> <?php echo  date("d/m/y",strtotime($consulta['data'])); ?></td>
                    <td>
                        <a href="editaordem.php?id=<?php echo $consulta['id']?>"><img src="imagens/editar.png" width="20px" height="20px"></a>
                        <a href="editaordem.php?id=<?php echo $consulta['id']?>&del=true"><img src="imagens/excluir.png" width="20px" height="20px"></a>
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
                        echo " <a href='ordemservico.php?pag=$i&".$varpag."'>".$i."</a> ";
                    } 
                
                    echo " <a href='etiquetas.php?".$varetiqueta."'>Imprimir Etiquetas</a>  / 
                        <a href='relsimples.php?".$varetiqueta."'>Imprimir Relatório Simples</a> / 
                        <a href='reldetalhado.php?".$varetiqueta."'>Imprimir Relatório Detalhado</a>
                    ";
                    
                }
                
            ?>
        </div>
    </div>


</div>


</body>
</html>