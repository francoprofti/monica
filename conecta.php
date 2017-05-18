<?php
header('Content-Type: text/html; charset=utf-8');

 $conecta = mysqli_connect("localhost", "root", "123456") or print ("erro ao conectar"); 
    mysqli_select_db($conecta,"servicofaccao") or die (mysqli_error($conecta)); 
  //  print "Conexão e Seleção OK!"; 

mysqli_query($conecta,"SET NAMES 'utf8'");

mysqli_query($conecta,'SET character_set_connection=utf8');

mysqli_query($conecta,'SET character_set_client=utf8');

mysqli_query($conecta,'SET character_set_results=utf8');

   
?>