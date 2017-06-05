<html>
<head>
</head>
    <?php
    
        include 'conecta.php';
        session_start();
    
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
        
        $sql = "SELECT operacao.codigo, operacao.nomeoperacao,ordemservico.idordemservico AS id, ordemservico.datacriacao as data, faccionista.nomefac as faccionista, ordemservico.idreferencia, ordemservico.qnt, ordemservico.modelo, ordemservico.obs, referencia.codigoref,SUM(ordemoperacao.valor) as valor FROM ordemservico INNER JOIN faccionista ON (ordemservico.idfaccionista = faccionista.idfaccionista) INNER JOIN ordemoperacao ON (ordemservico.idordemservico = ordemoperacao.idordemservico) INNER JOIN operacao ON (ordemoperacao.idoperacao = operacao.idoperacao) INNER JOIN referencia ON (ordemservico.idreferencia = referencia.idreferencia)  
        WHERE  ordemservico.status  = '$status' $tipo '%$nome%' $data
        GROUP BY id ORDER BY id ASC"; 
        
        
        $result = mysqli_query($conecta,$sql);
             
       
    ?>
    
<body>
    <table>
        <tr style="text-align:center;">
            <th style="width:50px;">Data saída</th>
            <th style="width:80px;">Cod. OS</th>
            <th style="width:50px;">Faccionista</th>
            <th style="width:50px;">Ref.:</th>
            <th style="width:50px;">Modelo</th>
            <th style="text-align:left;max-width:200px;">Obs.:</th>
            <th style="width:50px;">Qnt</th>
            <th style="width:100px;">Custo</th>
            <th style="width:100px;">Total</th>
            
            
        
        </tr>
    
    <?php
                    $linha = 1;
                    $totalfinal=0;
                    while($consulta = mysqli_fetch_array($result)) { 
                        $datasaida = $consulta['data'];
                        $idordem = $consulta['id'];
                        $faccionista = $consulta['faccionista'];
                        $referencia = $consulta['codigoref'];
                        $modelo = $consulta['modelo'];
                        $codop = $consulta['codigo'];
                        $nomeop = $consulta['nomeoperacao'];
                        $obs = $consulta['obs'];
                        $qnt = $consulta['qnt'];
                        $custo = $consulta['valor'];
                    if($linha ==0){
                        $cor = "";
                        $linha = 1;
                    }else{
                        $cor = "#eee";
                        $linha = 0;
                    }
                        
    ?>
                    <tr style="background: <?php echo $cor?>;">
                        <td style="text-align:center;"><?php echo date("d/m/y",strtotime($datasaida));?></td>
                        <td style="text-align:center;"><?php echo $idordem ;?></td>
                        <td style="text-align:center;"><?php echo $faccionista;?></td>
                        <td style="text-align:center;"><?php echo $referencia ;?></td>
                        <td style="text-align:center;"><?php echo $modelo ;?></td>
                        <td style="text-align:left;max-width:200px;"><?php echo $obs ;?></td>
                        <td style="text-align:center;"><?php echo $qnt;?></td>
                        <td style="text-align:right;"><?php echo  number_format($custo,2,",",".");?></td>
                        <td style="text-align:right;"><?php echo number_format($custo*$qnt,2,",",".");?></td>
                    </tr>
    
    
    
    <?php
              $totalfinal = $totalfinal + ($custo*$qnt);
                }
             echo "</table>";
             echo "<h3 style='margin-left: 540px;'>TOTAL: R$ ".number_format($totalfinal,2,",",".")."</h3>";
    ?>
    
    
</body>    
    <?php 
        }
    
    ?>


</html>