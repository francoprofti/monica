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
        
        $datarecebe = implode("-",array_reverse(explode("/",$_POST['datareceb'])));
        $status = $_POST['status'];
        $id = $_POST['id'];
        
         $sql = "UPDATE `ordemservico` SET 
         datarecebido = '".$datarecebe."', 
         status = '".$status."'
         WHERE `idordemservico` = ".$id.";";
        
        echo $sql;
        
         $result = mysqli_query($conecta,$sql); 
        
        
       
    
        
        
        if($result){
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
             header("Location: localizaos.php");
            
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
                
                    echo "<p><h3>><a href='geral.php'>Início</a> > <a href='localizaos.php'>Localizar OS</a> > Receber OS OS</h3></p>";
                
            ?>
                
        </div>
        <div class="corpo">
            <div class="interna">
                <?php 
                    if($sucesso == "salvou"){
                        
                        
                            echo"<SCRIPT LANGUAGE='JavaScript' TYPE='text/javascript'>
                                
                                decisao = confirm('Recebida com sucesso, deseja receber mais?');
                                
                                if (decisao){
                                        location.href = 'localizaos.php';
                                } else {
                                        location.href = 'geral.php';
                                }
                                
                                </SCRIPT>";    
                        
                        
                            
                       
                        
                    }elseif($sucesso=="Erro ao Salvar"){
                        echo"<script>alert('Ocorreu algum erro ao Salvar!Consulte o suporte!');</script>";
                    }
                ?>
                
                
                
                
                <fieldset>
                    <legend> Editar Ordem de Serviço</legend>
                    <br><br>
                <form name="cadordem" action="recebeos.php" method="post" style="height: 500px" >
                    <div style="width: 100%;margin-left: 160px;">
                        <div class="label" style="heigth:300px">
                                   <p>
                                        Código da OA
                                    </p> 
                                    <p>
                                        Data de saída
                                    </p>
                                    

                                    <p>
                                        Data Prevista de Entrega
                                    </p>
                                    
                                    <p>
                                        Faccionista
                                    </p>
                                      <p>
                                    Quantidade
                                </p>
                                <p>
                                    Modelo
                                </p>
                                <p>
                                        Data Recebimento
                                    </p>
                                    <p>
                                        Status
                                    </p> 
                               


                            </div>
                          
                            <div style="  height: 300px;    width: 200px;    float: left;   ">
                                <input type="text" name="codigo" size="30" placeholder=" Este código será exibido após salvar" value=" <?php  echo $codordem;?>" disabled><br>

                                <input type="text" name="datasaida" size="30" placeholder=" Hoje" value="<?php echo date("d/m/y",strtotime($datacriacao));?>" disabled><br>
                                
                                

                                <input type="date" value= "<?php echo date("d/m/y",strtotime($dataprevreceb));?>" name="dataprev" size="30" style="margin-top: 5px;" disabled><br><br>

                                

                                <select disabled name="faccionista" id="faccao" style="margin-top: 5px;">
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
                                
                               <input type="text" value="<?php  echo $qnt;?>"name="qnt" size="40" placeholder="Digite a Quantidade" disabled><br>


                                <input type="text" value="<?php  echo $modelo;?>" name="modelo" size="40" placeholder="Digite o modelo" disabled><br>
                                
                                <input type="hidden" name="id" value="<?php echo $id;?>">

                                <input type="text" name="datareceb" size="30" placeholder=" Hoje" value="" required><br>    
                                
                                <select name="status" style="width:250px;">
                                        <option value=2 <?php if($status ==2 ){echo "selected";}?>>Aprovada</option>
                                        <option selected value=3 <?php if($status ==3 ){echo "selected";}?>>Concluída</option>
                                </select>

                                
                               </div>
                               
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