<?php 

        include 'conecta.php';
        $id = $_GET['idreferencia'];
        $sql = 'SELECT operacao.nomeoperacao, operacao.codigo, operacao.idoperacao FROM operacao 
        INNER JOIN operacaoreferencia ON (operacao.idoperacao = operacaoreferencia.idoperacao) 
        INNER JOIN referencia ON (operacaoreferencia.idreferencia = referencia.idreferencia)
        INNER JOIN operacaofaccionista ON (operacao.idoperacao = operacaofaccionista.idoperacao)
        WHERE operacaofaccionista.valor > 0 AND operacao.status = 0 AND referencia.idreferencia='.$id;



        $result = mysqli_query($conecta,$sql);

        $json = array();
        while ($row = $result->fetch_assoc()) {
          $json[] = array(
            'id' => $row['idoperacao'],
            'cod' => $row['codigo'],
            'nome' => $row['nomeoperacao'] // Don't you want the name?
          );
        }
        echo json_encode($json);

?>