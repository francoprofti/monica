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
    
        $sql = "INSERT INTO `ordemservico` (`idordemservico`, `idfuncionario`, `idfaccionista`, `idreferencia`,`dataprevreceb`, `qnt`, `modelo`, `obs`,`status` ) 
                VALUES (NULL, '$funcionario', '$faccionista', '$referencia', '$dataprevretorno','$qnt', '$modelo', '$obs','1');"; 
        
        $result = mysqli_query($conecta,$sql); 
        $ultimaordem =  mysqli_insert_id($conecta);
        
        
        $sqloperacoes =  "SELECT * FROM operacaoreferencia INNER JOIN operacao ON (operacaoreferencia.idoperacao = operacao.idoperacao) INNER JOIN operacaofaccionista ON (operacao.idoperacao = operacaofaccionista.idoperacao) WHERE operacaofaccionista.idfaccionista = '".$faccionista."' AND operacaoreferencia.idreferencia = '".$referencia."'";
        $resultoperacoes = mysqli_query($conecta,$sqloperacoes); 
        
        $sqlassociaop = "INSERT INTO ordemoperacao (idordemoperacao,idoperacao,idordemservico,valor) VALUES";
      
        
        while($consultaoperacoes = mysqli_fetch_array($resultoperacoes)) { 
           
            $texto = "operacao-".$consultaoperacoes['idoperacao'];
             
            if(isset($_POST[$texto])){
                 
            $sqlassociaop .= "(NULL,".$consultaoperacoes['idoperacao'].",".$ultimaordem.",'".$consultaoperacoes['valor']."'),";     
        
            }
        }
        
           
         if($sqlassociaop !=""){
                  
               $sqlassociaop = substr($sqlassociaop, 0, -1);
                
               $resultassocia = mysqli_query($conecta,$sqlassociaop);  
            
                if($resultassocia){
                  $sucesso = "salvou";
               }else{
                  $sucesso = "Erro ao Salvar";
               }
                
        }
        
        
        
        if($result){
          $sucesso = "salvou";
        }else{
          $sucesso = "Erro ao Salvar";
        }
        mysqli_close($conecta); 
   
    
    }else{
    
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
                    echo "<a href='geralordem.php'><div class='btnsup'><p>Voltar</p></div></a>";
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
                    echo "<p><h3><a href='geral.php'>Início</a> > <a href='ordemservico.php'>OS</a> > Nova OS</h3></p>";
                }else{
                   echo "<p><h3><a href='geral.php'>Início</a> > <a href='geralordem.php'>OS</a> > Nova OS</h3></p>";
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
                                        location.href = 'novaordem.php';
                                } else {
                                        location.href = 'geralordem.php';
                                }
                                
                                </SCRIPT>";    
                        }else{
                          
                              echo"<SCRIPT LANGUAGE='JavaScript' TYPE='text/javascript'>
                                
                                decisao = confirm('Salvo com sucesso, deseja salvar mais?');
                                
                                if (decisao){
                                        location.href = 'novaordem.php';
                                } else {
                                        location.href = 'geral.php';
                                }
                                
                                </SCRIPT>";
                            
                        }
                        
                    }elseif($sucesso=="Erro ao Salvar"){
                        echo"<script>alert('Ocorreu algum erro ao Salvar!Consulte o suporte!');</script>";
                    }
                ?>
                
                
                
                
                <fieldset>
                    <legend> Cadastrar nova Ordem de Serviço</legend>
                    <br><br>
                <form name="cadordem" action="novaordem.php" method="post" style="height: 500px" >
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
                                <input type="text" name="codigo" size="30" placeholder=" Este código será exibido após salvar" disabled><br>

                                <input type="text" value= "" required name="datasaida" size="30" placeholder=" Hoje" disabled><br>

                                <input type="text" value= "" required name="status" size="30" placeholder="Pendente" disabled><br>

                                <input type="date" value= "" required name="dataprev" size="30" style="margin-top: 5px;"><br><br>

                                <select name="funcionario" style="margin-top: 1px;">
                                    <?php
                                      while($opcaofunc = mysqli_fetch_array($resultfunc)){
                                          if($opcaofunc['idfuncionario'] ==  $_SESSION['id'] ){
                                                echo "<option selected value='".$opcaofunc['idfuncionario']."'>".$opcaofunc['nome']."</option>";
                                          }else{
                                                echo "<option value='".$opcaofunc['idfuncionario']."'>".$opcaofunc['nome']."</option>";                                  
                                          }


                                        }   ?>  
                                </select>

                                <select required name="faccionista" id="faccao" style="margin-top: 5px;">
                                    <option > Selecione</option>
                                    <?php 
                                        while($opcaofac = mysqli_fetch_array($resultfac)){
                                            echo "<option value='".$opcaofac['idfaccionista']."'>".$opcaofac['nome']."</option>";

                                        }
                                    ?>

                                </select>


                                <select required name="referencia" id="referencia" style="margin-top: 5px;">
                                    <option>Selecione um Faccionista acima</option>


                                </select>
                               </div>
                                <div style="margin-left:200px;width: 500px;height: 200px;overflow-y: scroll;overflow-x: hidden;">    
                                    <br>
                                <table id="referenciatab">
                                    
                                    <tr>
                                        <td></td>
                                        <td>Escolha uma referência acima para exibir as operações!</td>
                                        <td></td>
                                    </tr>

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
                                <input type="text" required name="qnt" size="40" placeholder="Digite a Quantidade" onkeypress='numeros(this,moedanum)'><br>


                                <input type="text" required name="modelo" size="40" placeholder="Digite o modelo"><br>


                                <textarea rows="6"  cols="36" name="obs" style="width: 320px; height: 211px;"></textarea><br>
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