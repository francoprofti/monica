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
    session_start();
    $sucesso ="";
   
    if( isset($_POST['salvar']) )
    {
    
        $funcionario = $_POST['funcionario'];
        $faccionista = $_POST['faccionista'];
        $operacao = $_POST['operacao'];
        $referencia = $_POST['referencia'];
        $qnt = $_POST['qnt'];
        $modelo = $_POST['modelo'];
        $obs = $_POST['obs'];
    
        $sql = "INSERT INTO `ordemservico` (`idordemservico`, `idfuncionario`, `idfaccionista`, `idoperacao`, `referencia`, `qnt`, `modelo`, `obs`) 
                VALUES (NULL, '$funcionario', '$faccionista', '$operacao', '$referencia', '$qnt', '$modelo', '$obs');"; 
        
       
        $result = mysqli_query($conecta,$sql); 
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
                    echo " <a href='geralordem.php'><div class='btnsup'><p>Voltar</p></div></a>";
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
                    echo "<p><h3><a href='geral.php'>Início</a> > <a href='geralordem.php'>OS</a> > Nova OS</h3></p>";
                }else{
                    echo "<p><h3><a href='geral.php'>Início</a> > Nova OS</h3></p>";
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
                <form name="cadordem" action="novaordem.php" method="post" style="height: 500px">
                     <div class="label">
                            <p>
                                Solicitante
                            </p>
                            <p>
                                Faccionista
                            </p>
                            <p>
                                Operação
                            </p>
                            <p>
                                Referência
                            </p>
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
                        <select name="funcionario">
                            <?php
                              while($opcaofunc = mysqli_fetch_array($resultfunc)){
                                  if($opcaofunc['idfuncionario'] ==  $_SESSION['id'] ){
                                        echo "<option selected value='".$opcaofunc['idfuncionario']."'>".$opcaofunc['nome']."</option>";
                                  }else{
                                        echo "<option value='".$opcaofunc['idfuncionario']."'>".$opcaofunc['nome']."</option>";                                  
                                  }


                                }   ?>  
                        </select>

                        <select name="faccionista" id="faccao">
                            <option > Selecione</option>
                            <?php 
                                while($opcaofac = mysqli_fetch_array($resultfac)){
                                    echo "<option value='".$opcaofac['idfaccionista']."'>".$opcaofac['nome']."</option>";

                                }
                            ?>

                        </select>

                        <select name="operacao" id="operacao">
                            <option>Selecione um Faccionista acima</option>


                        </select>
                        <br>



                        <input type="text" name="referencia" size="40" placeholder="Digite a Referência"><br>

                        <input type="text" name="qnt" size="40" placeholder="Digite a Quantidade" onkeypress='numeros(this,moedanum)'><br>


                        <input type="text" name="modelo" size="40" placeholder="Digite o modelo"><br>


                       <textarea rows="6" cols="36" name="obs"></textarea><br>



                        <br>
                         <input type="submit" value="Salvar" name="salvar">
                       </div>
                   
                </form>
                </fieldset>
            </div>
        </div>
    
    
    </div>
    
    
</body>
</html>