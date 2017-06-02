<html>
    
<head>
    <link type="text/css" rel="stylesheet"  href="estilo/estilo.css">
    <script language="JavaScript" type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
     <script type="text/javascript" charset="utf-8">
        $(document).ready(function(){
            $('#parte').on('change', function (){
                $.getJSON('listaopreferencia.php', {parte: $(this).val()}, function(data){
                    var options = '';
                    for (var x = 0; x < data.length; x++) {
                        options += '<option value="' + data[x]['id'] + '">' + data[x]['codigo'] + " - " + data[x]['nome'] + '</option>';
                    }
                    $('#operacaoop').html(options);
                    
                    
                });
            });
            
        
            //remove a linha da tabela e também removoe a hidden que associa quando salva
             remove = function(item) {
                 
                var tr = $(item).closest('tr');
                var idhidden = (item.id);
                alert(idhidden);
                tr.fadeOut(400, function() {
                  tr.remove();  
                
                    
                   $('#input'+idhidden).remove();
                });

                return false;
            }

           
            // adiciona a linha a tabela, e criar as hiddens para salvar a associação
            $('#adicionar').on('click',function(){
              
                var $this = $( this );
                
                var $codigo = $("#codigo").val();
                var $operacao = $("#operacaoop option:selected").text();
                var $idoperacao = $("#operacaoop").val();
                
                var $parte = $("#parte").val();
                 

                var tr = '<tr>'+
                    '<td>'+$operacao+'</td>'+
                    '<td>'+$parte+'</td>'+
                    '<td><button type="button" onclick="remove(this)" id='+$parte+$idoperacao+' >Excluir</button></td>'+
                    '</tr>';
                $('#grid').find('tbody').append( tr );
                
              
                var hiddens = '<input type="hidden" name="parte-'+$idoperacao+'" value="'+$parte+'" id="input'+$parte+$idoperacao+'" />';

                $('#cadreferencia').append( hiddens );
                

                return false;
            });
            
            
            
        });
         
         
         
    </script>      
</head>
    
    <?php
    include 'conecta.php';
    $sucesso ="";
    
    //ini_set('display_errors', 1); 
    //error_reporting(E_ALL);
   
    if( isset($_POST['nome']) )
    {
      //  var_dump($_REQUEST);
       
    
        $nome = $_POST['nome'];
        $codigo = $_POST['codigoref'];

        $sql = "INSERT INTO referencia (idreferencia, codigoref,nomereferencia) VALUES (NULL, '$codigo','$nome');"; 
        $result = mysqli_query($conecta,$sql); 
        $ultimareferencia =  mysqli_insert_id($conecta);
        
      
        
        
     
        if($result){
             $sql = "SELECT idoperacao FROM `operacao`"; 
             $result = mysqli_query($conecta,$sql);
            
            
             $sqlinsert ="INSERT INTO operacaoreferencia (idoperacaoreferencia, idoperacao,idreferencia,parte) VALUES";
             while($consulta = mysqli_fetch_array($result)) { 
                    $posicao = "parte-".$consulta['idoperacao'];
                  
                      if(isset($_POST[$posicao]))  {   

                               $parte = $_POST[$posicao];
                               $operacao = $consulta['idoperacao'];

                                $sqlinsert .= "(NULL, '$operacao','$ultimareferencia','$parte'),"; 
                     }
        
              }
            if($sqlinsert !=""){
                  
               $sqlinsert = substr($sqlinsert, 0, -1);
                
               $resultassocia = mysqli_query($conecta,$sqlinsert);  
            
                if($resultassocia){
                  $sucesso = "salvou";
                }else{
                    $sucesso = "Erro ao Salvar";
                }
                
            }

            
               
           
            
            $sucesso = "salvou";
        }else{
            $sucesso = "Erro ao Salvar";
        }
        mysqli_close($conecta); 
    
    }
   
    
    ?>
<body>
    <div class="content">
        <div class="topo">
            <div class="topo">
           
            <div class="userlogado">
                <div class="btnsup"><p><a href="operacao.php">Voltar</a></p></div>
               
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
            <p><h3><a href="geral.php">Início</a> > <a href="referencia.php">Referências</a> > Nova Referência</h3></p>   
        </div>
        <div class="corpo">
            <div class="interna" style="text-aling:left;">
                <?php 
                    if($sucesso == "salvou"){
                        echo"<SCRIPT LANGUAGE='JavaScript' TYPE='text/javascript'>
                                
                                decisao = confirm('Salvo com sucesso, deseja salvar mais?');
                                
                                if (decisao){
                                        location.href = 'novareferencia.php';
                                } else {
                                        location.href = 'referencia.php';
                                }
                                
                                </SCRIPT>";
                    }elseif($sucesso=="Erro ao Salvar"){
                        echo"<script>alert('Ocorreu algum erro ao Salvar!Consulte o suporte!');</script>";
                    }
                ?>
                <fieldset style="height: 600px;" >
                    <legend> Cadastrar nova Referência</legend>
                    <br>
                <form name="cadreferencia" action="novareferencia.php" method="post" id="cadreferencia">
                    
                    <div style="width:200px;height:150px;float:left;text-align:right; ">
                        Referência:<br><br>
                        Descrição(Nome):<br><br>
                        Parte:<br><br>
                        Operação:<br>
                    </div>
                    
                    <div style="width:200px;height:150px;float:left;">
                        <input type="text" name="codigoref" size="40" placeholder="Ex: 14A7">
                        <input type="text" name="nome" size="40" placeholder="Ex: Blusa">
                        
                        
                        <select name="parte" id="parte">
                            <option value="">Selecione</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                        </select>
                        
                        <select name="operacaoop" id="operacaoop">
                            <option value="">Selecione uma parte</option>
                            
                        </select>
                         <div class="btnsup" style="position: absolute;top: 180px;left: 500px;" id="adicionar"><p><a href="">Adicionar</a></p></div>
                        
                        <div style=" width: 500px; height: 350px; overflow-y: scroll; overflow-x: hidden;">        
                            <table id="grid">
                                <tr>
                                    <th style="width:200px;">Código/Operação</th>
                                    <th style="width:80px;">Parte</th>
                                    <th style="width:50px;">Editar</th>

                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>


                                
                            </table>
                      </div>
                    
                    
                   
                         <input type="submit" value="Salvar" name="salvar">
                    
                    </div>
                    
                     
                   
                </form>
                </fieldset>
            </div>
        </div>
    
    
    </div>
    
    
</body>
</html>