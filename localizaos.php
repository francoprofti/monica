<html>
<head>
<link type="text/css" rel="stylesheet"  href="estilo/estilo.css">
    <meta charset="utf-8">

</head>
<?php
include 'conecta.php';
session_start();

    
    if(isset($_GET['busca'])){
        
        $nome = $_GET['busca'];
        
        $sql = "SELECT ordemservico.idordemservico AS id, funcionario.nome AS nomefuncionario,  ordemservico.datacriacao as data, faccionista.nomefac as faccionista, ordemservico.idreferencia, ordemservico.qnt, ordemservico.modelo, ordemservico.obs,  referencia.codigoref
        FROM funcionario INNER JOIN ordemservico
        ON (funcionario.idfuncionario = ordemservico.idfuncionario) INNER JOIN faccionista
        ON (ordemservico.idfaccionista = faccionista.idfaccionista) INNER JOIN operacaofaccionista
        ON (faccionista.idfaccionista = operacaofaccionista.idfaccionista) INNER JOIN referencia
        ON (ordemservico.idreferencia = referencia.idreferencia)
        WHERE  ordemservico.idordemservico = $nome AND ordemservico.status = 2 GROUP BY ordemservico.idordemservico"; 
        
    
        
        $result = mysqli_query($conecta,$sql);
        
        $row_cnt = mysqli_num_rows($result);
         if($row_cnt == 0){
                    echo"<SCRIPT LANGUAGE='JavaScript' TYPE='text/javascript'>

                        decisao = confirm('Ordem de Serviço não localizada, ou já recebida!!');

                        if (decisao){
                                location.href = 'localizaos.php';
                        } else {
                                location.href = 'localizaos.php';
                        }

                        </SCRIPT>";   
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
                <p><h3><a href="geral.php">Início</a> > <a href="geralordem.php">OS</a> > Receber Ordem de Serviço  </h3></p>   
        </div>
        
        <div class="corpo">
            <div class="interna">



        <fieldset>
            <legend>Pesquisar</legend>
            <form name="formpesquisa" action="localizaos.php" method="get">
                <select disabled name="tipo" style="width: 100px;">
                    <option value="fac">Nº da OS</option>
                </select>
                <input type="text" name="busca" size="30" placeholder="Digite o texto de busca">
                <input type="submit" name="buscar" value="Buscar">




            </form>  
        </fieldset>
            <br><br>
                
             
                
            <table>
               <tr>
                   <th style="width:200px;">Nº da OS</th>
                   <th style="width:200px;">Faccionista</th>
                   <th style="width:200px;">Referência</th>
                   <th style="width:50px;">Quantidade</th>
                   <th style="width:100px;">Modelo</th>
                   <th style="width:100px;">Funcionario</th>
                   <th style="width:100px;">Data</th>
                   <th style="width:50px;">Receber</th>
               </tr>
                <tr>


                <?php
                   
                if(isset($_GET['busca'])){        
                    
                 while($consulta = mysqli_fetch_array($result)) { 
                ?>


                <tr>
                    <td> <?php echo $consulta['id']; ?></td>
                    <td> <?php echo $consulta['faccionista']; ?></td>
                    <td> <?php echo $consulta['codigoref']; ?></td>
                    <td> <?php echo $consulta['qnt']; ?></td>
                    <td> <?php echo $consulta['modelo']; ?></td>
                    <td> <?php echo $consulta['nomefuncionario']; ?></td>
                    <td> <?php echo  date("d/m/y",strtotime($consulta['data'])); ?></td>
                    <td>
                        <a href="recebeos.php?id=<?php echo $consulta['id']?>"><img src="imagens/editar.png" width="20px" height="20px"></a>
                    </td>

                </tr>
                <?php 
                    } 
                }
                ?>
            </table>
           
        </div>
    </div>


</div>


</body>
</html>