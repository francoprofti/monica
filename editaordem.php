<html>
<head>
    <link type="text/css" rel="stylesheet"  href="estilo/estilo.css">
    <script language="JavaScript" type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="js/mascara.js"></script>
        
     <script type="text/javascript" charset="utf-8">
    $(document).ready(function(){
        $('#faccao').on('change', function (){
            $.getJSON('listaref.php', {idfaccao: $(this).val()}, function(data){
                var options = '';
                for (var x = 0; x < data.length; x++) {
                    options += '<option value="' + data[x]['id'] + '">' + data[x]['nome'] + '</option>';
                }
                $('#referencia').html(options);
            });
        });
        
        
        $('#referencia').on('change', function (){
                $('#referenciatab').empty();
             var options = '<tr> <th>Cod</th><th>Operação</th><th>Excluir</th></tr>';
            
            $.getJSON('listaop.php', {idreferencia: $(this).val()}, function(data){
            
                 
               
                for (var x = 0; x < data.length; x++) {
                    options += '<tr><input name="operacao-'+data[x]['id']+'" type="hidden" value="'+data[x]['id']+'"><td>' + data[x]['cod'] + '</td><td>' + data[x]['nome'] + '</td><td><button type="button" onclick="remove(this)">Excluir</button></td></tr>';
                }
                  
              
                 $('#referenciatab').append(options);
            });
           
        });
        
        
           //remove a linha da tabela e também removoe a hidden que associa quando salva
             remove = function(item) {
                 
                var tr = $(item).closest('tr');
                var idhidden = (item.id);
                tr.fadeOut(400, function() {
                  tr.remove();  
                
                    
                   $('#input'+idhidden).remove();
                   
                });

                return false;
            }

        
        
    });
    </script>
    
</head>
    
    <?php
    include 'conecta.php';
    session_start();
    $sucesso ="";
   
    if( isset($_POST['salvar']) )
    {
        $funcionario = $_POST['funcionario'];
        $faccionista = $_POST['faccionista'];
        $dataprevretorno = implode("-",array_reverse(explode("/",$_POST['dataprev'])));
        $referencia = $_POST['referencia'];
        $qnt = $_POST['qnt'];
        $modelo = $_POST['modelo'];
        $obs = $_POST['obs'];
        $status = $_POST['status'];
        $id = $_POST['id'];
        
         $sql = "UPDATE `ordemservico` SET 
         idfuncionario = '".$funcionario."', 
         idfaccionista = '".$faccionista."', 
         dataprevreceb = '".$dataprevretorno."', 
         idreferencia  = '".$referencia."', 
         qnt = '".$qnt."', 
         modelo = '".$modelo."', 
         obs = '".$obs."', 
         status = '".$status."'
         WHERE `idordemservico` = ".$id.";";
        
         $result = mysqli_query($conecta,$sql); 
        
        
        $sqlatualizaassocia = "SELECT * FROM ordemoperacao where ordemoperacao.idordemservico =".$id;
        
        $resultatualizaassocia = mysqli_query($conecta,$sqlatualizaassocia); 
        
        $sqlatualiza = "";
        while($atualizaop = mysqli_fetch_array($resultatualizaassocia)) { 
            $texto = "operacao-".$atualizaop['idoperacao'];
            
            if(isset($_POST[$texto])){
                $valor =  str_replace(",", ".", $_POST[$texto]);
                $sqlatualiza = "UPDATE `ordemoperacao` SET valor = ".$valor." WHERE `idordemservico` =".$id." AND idoperacao =".$atualizaop['idoperacao'].";";
                $resultatualiza = mysqli_query($conecta,$sqlatualiza); 
               
            }else{
                $sqlatualiza = "DELETE FROM `ordemoperacao` WHERE `idordemservico` =".$id." AND idoperacao =".$atualizaop['idoperacao'].";";
                $resultatualiza = mysqli_query($conecta,$sqlatualiza); 
            }
        
        }
        
        
        if($resultatualiza){
          $sucesso = "salvou";
        }else{
          $sucesso = "Erro ao Salvar";
        }
        mysqli_close($conecta); 
   
    
    }else{
    
        if(isset($_GET['id'])){
            $id = $_GET['id'];
            $sqlordem = "SELECT * FROM ordemservico INNER JOIN ordemoperacao ON (ordemservico.idordemservico = ordemoperacao.idordemservico) WHERE ordemservico.idordemservico =".$id;
            $result = mysqli_query($conecta,$sqlordem);  
            while($consultaoperacoes = mysqli_fetch_array($result)) { 
                $codordem = $consultaoperacoes['idordemservico'];
                $funcionario = $consultaoperacoes['idfuncionario'];
                $faccionista = $consultaoperacoes['idfaccionista'];
                $referencia = $consultaoperacoes['idreferencia'];
                $qnt = $consultaoperacoes['qnt'];
                $modelo = $consultaoperacoes['modelo'];
                $obs = $consultaoperacoes['obs'];
                $status = $consultaoperacoes['status'];
                $datacriacao = $consultaoperacoes['datacriacao'];
                $dataprevreceb = $consultaoperacoes['dataprevreceb'];
                $datarecebido = $consultaoperacoes['datarecebido'];
            
            }
      
         
            
        }else{
             header("Location: ordemservico.php");
            
        }
                $sqlfaccao = "SELECT idfaccionista, nomefac as nome FROM faccionista ORDER BY nome ASC";
                $resultfac = mysqli_query($conecta,$sqlfaccao); 

                $sqloperacao = "SELECT idoperacao, nomeoperacao as nome FROM operacao WHERE valor > 0 ORDER BY nome ASC";
                $resultop = mysqli_query($conecta,$sqloperacao); 

    
                if($_SESSION['adm'] == "a"){
        
                    $sqlfunc = "SELECT idfuncionario, nome FROM funcionario WHERE status = 0 ORDER BY nome ASC";
                    $resultfunc = mysqli_query($conecta,$sqlfunc); 
                }else{
                    $sqlfunc = "SELECT idfuncionario, nome FROM funcionario WHERE idfuncionario =".$_SESSION['id'];
                    $resultfunc = mysqli_query($conecta,$sqlfunc); 
                    
                }
        
        
    }
    
    
    ?>
    
    
<body>
    <div class="content">
        <div class="topo">
           
            <div class="userlogado">
                <?php
                if($_SESSION['adm'] == "a"){
                    echo " <a href='ordemservico.php'><div class='btnsup'><p>Voltar</p></div></a>";
                }else{
                    echo "<a href='geral.php'><div class='btnsup'><p>Voltar</p></div></a>";
                }
                ?>
                
               
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
            <?php
                if($_SESSION['adm'] == "a"){
                    echo "<p><h3><a href='geral.php'>Início</a> > <a href='ordemservico.php'>OS</a> > Editar OS</h3></p>";
                }else{
                    echo "<p><h3><a href='geral.php'>Início</a> > Editar OS</h3></p>";
                }
            ?>
                
        </div>
        <div class="corpo">
            <div class="interna">
                <?php 
                    if($sucesso == "salvou"){
                        
                        if($_SESSION['adm'] == "a"){
                            echo"<SCRIPT LANGUAGE='JavaScript' TYPE='text/javascript'>
                                
                                decisao = confirm('Salvo com sucesso, deseja salvar mais?');
                                
                                if (decisao){
                                        location.href = 'ordemservico.php';
                                } else {
                                        location.href = 'ordemservico.php';
                                }
                                
                                </SCRIPT>";    
                        }else{
                          
                              echo"<SCRIPT LANGUAGE='JavaScript' TYPE='text/javascript'>
                                
                                decisao = confirm('Salvo com sucesso, deseja salvar mais?');
                                
                                if (decisao){
                                        location.href = 'ordemservico.php';
                                } else {
                                        location.href = 'ordemservico.php';
                                }
                                
                                </SCRIPT>";
                            
                        }
                        
                    }elseif($sucesso=="Erro ao Salvar"){
                        echo"<script>alert('Ocorreu algum erro ao Salvar!Consulte o suporte!');</script>";
                    }
                ?>
                
                
                
                
                <fieldset>
                    <legend> Editar Ordem de Serviço</legend>
                    <br><br>
                <form name="cadordem" action="editaordem.php" method="post" style="height: 500px" >
                    <div id="esquerda" style="width: 50%;float:left;">
                        <div class="label" style="heigth:300px">
                                   <p>
                                        Código da OA
                                    </p> 
                                    <p>
                                        Data de saída
                                    </p> 
                                    <p>
                                        Status
                                    </p> 

                                    <p>
                                        Data Prevista de Entrega
                                    </p>
                                    <p>
                                        Solicitante
                                    </p>
                                    <p>
                                        Faccionista
                                    </p>
                                    <p>
                                        Referência
                                    </p>


                            </div>
                          
                            <div style="  height: 300px;    width: 200px;    float: left;   ">
                                <input type="text" name="codigo" size="30" placeholder=" Este código será exibido após salvar" value=" <?php  echo $codordem;?>" disabled><br>

                                <input type="text" name="datasaida" size="30" placeholder=" Hoje" value="<?php echo date("d/m/y",strtotime($datacriacao));?>" disabled><br>
                                    
                                <select name="status" style="width:250px;">
                                        <option value=0 <?php if($status ==0 ){echo "selected";}?>>Cancelada</option>
                                        <option value=1 <?php if($status ==1 ){echo "selected";}?>>Pendente</option>
                                        <option value=2 <?php if($status ==2 ){echo "selected";}?>>Aprovada</option>
                                        <option value=3 <?php if($status ==3 ){echo "selected";}?>>Concluída</option>
                                </select>


                                <input type="date" value= "<?php echo date("d/m/y",strtotime($dataprevreceb));?>" name="dataprev" size="30" style="margin-top: 5px;"><br><br>

                                <select name="funcionario" style="margin-top: 1px;">
                                    <?php
                                      while($opcaofunc = mysqli_fetch_array($resultfunc)){
                                          if($opcaofunc['idfuncionario'] ==  $funcionario ){
                                                echo "<option selected value='".$opcaofunc['idfuncionario']."'>".$opcaofunc['nome']."</option>";
                                          }else{
                                                echo "<option value='".$opcaofunc['idfuncionario']."'>".$opcaofunc['nome']."</option>";                                  
                                          }


                                        }   ?>  
                                </select>

                                <select name="faccionista" id="faccao" style="margin-top: 5px;">
                                    <option > Selecione</option>
                                    <?php 
                                        while($opcaofac = mysqli_fetch_array($resultfac)){
                                            if($opcaofac['idfaccionista'] == $faccionista ){
                                                echo "<option selected value='".$opcaofac['idfaccionista']."'>".$opcaofac['nome']."</option>";    
                                            }else{
                                                echo "<option value='".$opcaofac['idfaccionista']."'>".$opcaofac['nome']."</option>";    
                                            }
                                            

                                        }
                                    ?>

                                </select>
                                
                                <?php 
                                    $sqlref = "SELECT 
                                                referencia.idreferencia, referencia.codigoref FROM referencia
                                                INNER JOIN operacaoreferencia ON (referencia.idreferencia = operacaoreferencia.idreferencia)
                                                INNER JOIN operacao ON (operacaoreferencia.idoperacao = operacao.idoperacao)
                                                INNER JOIN operacaofaccionista ON (operacao.idoperacao = operacaofaccionista.idoperacao)
                                                INNER JOIN faccionista ON (operacaofaccionista.idfaccionista =  faccionista.idfaccionista)
                                                WHERE operacaofaccionista.valor > 0 AND faccionista.idfaccionista ='".$faccionista."' GROUP BY referencia.idreferencia";
                                    $resultsqlref = mysqli_query($conecta,$sqlref); 
                                                           ?>
                                <input type="hidden" name="referencia" value="<?php echo $referencia;?>">
                                <input type="hidden" name="id" value="<?php echo $id;?>">
                                <select name="referencia" id="referencia" style="margin-top: 5px;" disabled>
                                    <?php 
                                        while($listaref = mysqli_fetch_array($resultsqlref)){
                                            if($listaref['idreferencia'] == $referencia){
                                                echo "<option selected value='".$listaref['idreferencia']."'>".$listaref['codigoref']."</option>";
                                            }else{
                                                echo "<option value='".$listaref['idreferencia']."'>".$listaref['codigoref']."</option>";
                                            }
                                        }
                                    
                                    ?>
                                    


                                </select>
                               </div>
                                <div style="margin-left:200px;width: 500px;height: 200px;overflow-y: scroll;overflow-x: hidden;">    
                                
                                <?php 
                                    $sqlassociaop = "SELECT * FROM ordemoperacao INNER JOIN operacao ON (ordemoperacao.idoperacao = operacao.idoperacao) WHERE idordemservico =".$id;
                                    
                                    $resultassociaop = mysqli_query($conecta,$sqlassociaop); 
                                    
                                ?>    
                                <table id="referenciatab">
                                    <tr>    
                                        <th>Cod</th>
                                        <th>Operação</th>
                                        <th>Custo</th>
                                        <th>Excluir</th>
                                    </tr>
                                    <?php 
                                        while($listaref = mysqli_fetch_array($resultassociaop)){
                                            $listaref['valor'] = str_replace(".", ",", $listaref['valor']);
                                            echo "<tr>";
                                            echo "<td>".$listaref['codigo']."</td><td>".$listaref['nomeoperacao']."</td><td><input style='text-align:right;' type='text' value='".$listaref['valor']."' name='operacao-".$listaref['idoperacao']."'></td><td><button type='button' onclick='remove(this)'>Excluir</button></td>";
                                            echo "</tr>";
                                        }
                                    
                                    ?>
                                    

                                </table>
                                </div>
                    </div>
                      
                    <div id="direita" style="width: 50%;float:left;">
                         <div class="labeldireita">
                                 <p>
                                    Quantidade
                                </p>
                                <p>
                                    Modelo
                                </p>
                                <p>
                                    Observação
                                </p>
                            
                            </div>   
                        
                            <div class="input">
                                <input type="text" value="<?php  echo $qnt;?>"name="qnt" size="40" placeholder="Digite a Quantidade" onkeypress='numeros(this,moedanum)'><br>


                                <input type="text" value="<?php  echo $modelo;?>" name="modelo" size="40" placeholder="Digite o modelo"><br>


                                <textarea rows="6" value="<?php  echo $obs;?>" cols="36" name="obs" style="width: 320px; height: 211px;"></textarea><br>
                            </div>



                            <br>
                        </div>
                        
                    <div style="margin-top: 0px;padding-top: 400px;padding-left: 700px;">
                        <input type="submit" value="Salvar" name="salvar">
                    </div>
                    
                </form>
                </fieldset>
            </div>
        </div>
    
    
    </div>
    
    
</body>
</html>