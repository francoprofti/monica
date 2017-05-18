<html>
<head>
    <link type="text/css" rel="stylesheet"  href="estilo/estilo.css">
    <script language="JavaScript" type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
     <script type="text/javascript" src="js/mascara.js"></script>
        
     <script type="text/javascript" charset="utf-8">
    $(document).ready(function(){
        $('#faccao').on('change', function (){
            $.getJSON('listaop.php', {idfaccao: $(this).val()}, function(data){
                var options = '';
                for (var x = 0; x < data.length; x++) {
                    options += '<option value="' + data[x]['id'] + '">' + data[x]['nome'] + '</option>';
                }
                $('#operacao').html(options);
            });
        });
    });
    </script>
    
</head>
    
    <?php
    include 'conecta.php';
    $sucesso ="";
   
    if( isset($_POST['salvar']) )
    {
        $id = $_POST['id'];
        $funcionario = $_POST['funcionario'];
        $faccionista = $_POST['faccionista'];
        $operacao = $_POST['operacao'];
        $referencia = $_POST['referencia'];
        $qnt = $_POST['qnt'];
        $modelo = $_POST['modelo'];
        $obs = $_POST['obs'];
    
        $sql = "    UPDATE `ordemservico` SET `idfuncionario` = $funcionario, 
        `idfaccionista` = $faccionista, 
        `idoperacao` = $operacao, 
        `referencia` = '$referencia',
        `qnt` = $qnt,
        `modelo` = '$modelo',
        `obs` = '$obs'
        WHERE `ordemservico`.`idordemservico` =".$id;
        
        
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
            $sqlordem = "SELECT * FROM ordemservico WHERE ordemservico.idordemservico =".$id;
            $resultordem = mysqli_query($conecta,$sqlordem); 

            while($valordem = mysqli_fetch_array($resultordem)){
                $func = $valordem['idfuncionario'];
                $fac = $valordem['idfaccionista'];
                $op = $valordem['idoperacao'];
                $ref = $valordem['referencia'];
                $qnt = $valordem['qnt'];
                $modelo = $valordem['modelo'];
                $obs = $valordem['obs'];

            }

            $sqlfaccao = "SELECT idfaccionista, nomefac as nome FROM faccionista ORDER BY nome ASC";
            $resultfac = mysqli_query($conecta,$sqlfaccao); 

            $sqloperacao = "SELECT operacao.idoperacao as idop, nomeoperacao as nome FROM operacao INNER JOIN operacaofaccionista ON (operacao.idoperacao = operacaofaccionista.idoperacao) 
            WHERE operacaofaccionista.idfaccionista = ".$fac." ORDER BY nome ASC";

            $resultop = mysqli_query($conecta,$sqloperacao); 
            
            $sqlfunc = "SELECT idfuncionario, nome FROM funcionario WHERE status = 0 ORDER BY nome ASC";
            $resultfunc = mysqli_query($conecta,$sqlfunc); 
        

        }
        
        
        if(isset($_GET['del'])){
            
            $id = $_GET['id'];
            
            if(!$id ==""){
                
                echo "<SCRIPT LANGUAGE='JavaScript' TYPE='text/javascript'>
                                
                    decisao = confirm('Deseja REALMENTE desativar esta Ordem de Serviço???');

                    if (decisao){
                         location.href = 'editaordem.php?confdel=".$id."';
                    } else {
                         location.href = 'ordemservico.php';
                    }

                    </SCRIPT>";
              
            }else{
                
                echo "<SCRIPT LANGUAGE='JavaScript' TYPE='text/javascript'>
                                
                        decisao = alert('Não é possível desativar esta ordem!!');
                        location.href = 'funcionario.php';
                  
                    </SCRIPT>";
             }
            
           
            
            
        }
        
        
         if( isset($_GET['confdel'])){
        
            $id = $_GET['confdel'];
            $sql = "UPDATE `ordemservico` SET `status` = '1'  WHERE `ordemservico`.`idordemservico` =".$id;

            $result = mysqli_query($conecta,$sql); 

            echo"<SCRIPT LANGUAGE='JavaScript' TYPE='text/javascript'>

                alert('ORDEM DE SERVIÇO DESATIVADA COM SUCESSO!');
                location.href = 'ordemservico.php';

                </SCRIPT>";
                
        }
        
        
    }
    
   
        
    
    
    ?>
    
    
<body>
    <div class="content">
        <div class="topo">
           
            <div class="userlogado">
                <a href="ordemservico.php"><div class="btnsup"><p>Voltar</p></div></a>
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
                <p><h3><a href="geral.php">Início</a> > <a href="ordemservico.php">OS</a> > Editar Ordem de Serviço</h3></p>   
        </div>
        <div class="corpo">
            <div class="interna">
                <?php 
                    if($sucesso == "salvou"){
                        echo"<SCRIPT LANGUAGE='JavaScript' TYPE='text/javascript'>
                                
                                decisao = confirm('Salvo com sucesso, deseja salvar mais?');
                                
                                if (decisao){
                                        location.href = 'ordemservico.php';
                                } else {
                                        location.href = 'geral.php';
                                }
                                
                                </SCRIPT>";
                    }elseif($sucesso=="Erro ao Salvar"){
                        echo"<script>alert('Ocorreu algum erro ao Salvar!Consulte o suporte!');</script>";
                    }
                ?>
                
                
                
                
                <fieldset>
                    <legend> Cadastrar nova Ordem de Serviço</legend>
                <form name="cadordem" action="editaordem.php" method="post">
                    <label>
                        Solicitante:
                    </label>
                    <select name="funcionario">
                        <?php
                              while($opcaofunc = mysqli_fetch_array($resultfunc)){
                                  if($func == $opcaofunc['idfuncionario']){
                                      echo "<option selected value='".$opcaofunc['idfuncionario']."'>".$opcaofunc['nome']."</option>";
                                  }else{
                                      echo "<option value='".$opcaofunc['idfuncionario']."'>".$opcaofunc['nome']."</option>";  
                                  }
                              } 
                        ?>
                    
                    </select>
                    
                    <input type="hidden" name="id" size="80" value="<?php echo $_GET['id'];?>" placeholder="Funcionario X"><br>
                    
                      <label>
                        Faccionista
                    </label>
                    <select name="faccionista" id="faccao">
                        <option > Selecione</option>
                        <?php 
                            while($opcaofac = mysqli_fetch_array($resultfac)){
                                if($opcaofac['idfaccionista'] == $fac){
                                    echo "<option selected value='".$opcaofac['idfaccionista']."'>".$opcaofac['nome']."</option>";
                                }else{
                                    echo "<option value='".$opcaofac['idfaccionista']."'>".$opcaofac['nome']."</option>";    
                                }
                                
                                        
                            }
                        ?>
               
                    </select>
                    <Br>
                    <label>
                        Operação
                    </label>
                    <select name="operacao" id="operacao">
                        <?php 
                            while($opcaoop = mysqli_fetch_array($resultop)){
                                if($opcaoop['idop'] == $op){
                                    echo "<option selected value='".$opcaoop['idop']."'>".$opcaoop['nome']."</option>"; 
                                }else{
                                    echo "<option value='".$opcaoop['idop']."'>".$opcaoop['nome']."</option>";    
                                }
                                 
                            }
                           
                        ?>
                    
                    </select>
                    <br>
                    
                    
                    <label>
                        Referência:
                    </label>
                    <input type="text" name="referencia" value="<?php echo $ref; ?>" size="40" placeholder="Digite a Referência"><br>
                    <label>
                        Quantidade:
                    </label>
                    <input type="text" name="qnt" value="<?php echo $qnt; ?>" size="40" placeholder="Digite a Quantidade" onkeypress='numeros(this,moedanum)'><br>
                    
                    <label>
                        Modelo:
                    </label>
                    <input type="text" name="modelo" value="<?php echo $modelo; ?>" size="40" placeholder="Digite o modelo"><br>
                    
                    <label>
                    Observação
                    </label>
                   <textarea rows="4" cols="50" name="obs"><?php echo $obs; ?></textarea><br>
                    
                    
                    
                    <br>
                    <input type="submit" value="Salvar" name="salvar">
                </form>
                </fieldset>
            </div>
        </div>
    
    
    </div>
    
    
</body>
</html>