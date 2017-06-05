<?php 

        include 'conecta.php';
        $id = $_GET['idfaccao'];
        $sql = 'SELECT 
referencia.idreferencia, referencia.codigoref FROM referencia
INNER JOIN operacaoreferencia ON (referencia.idreferencia = operacaoreferencia.idreferencia)
INNER JOIN operacao ON (operacaoreferencia.idoperacao = operacao.idoperacao)
INNER JOIN operacaofaccionista ON (operacao.idoperacao = operacaofaccionista.idoperacao)
INNER JOIN faccionista ON (operacaofaccionista.idfaccionista =  faccionista.idfaccionista)
WHERE operacaofaccionista.valor > 0 AND faccionista.idfaccionista ='.$id.' GROUP BY referencia.idreferencia';


        $result = mysqli_query($conecta,$sql);

        $json = array();
        $json[] = array(
            'id' => '',
            'nome' => 'Selecione uma referência' // Don't you want the name?
          );
        while ($row = $result->fetch_assoc()) {
          $json[] = array(
            'id' => $row['idreferencia'],
            'nome' => $row['codigoref'] // Don't you want the name?
          );
        }
        echo json_encode($json);

?>