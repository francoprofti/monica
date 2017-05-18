<?php 

        include 'conecta.php';
        $id = $_GET['idfaccao'];
        $sql = 'SELECT operacao.nomeoperacao, operacao.idoperacao FROM faccionista 
        INNER JOIN operacaofaccionista ON (faccionista.idfaccionista = operacaofaccionista.idfaccionista) 
        INNER JOIN operacao ON (operacaofaccionista.idoperacao = operacao.idoperacao)
        WHERE operacaofaccionista.valor > 0 AND faccionista.idfaccionista =' . $id;


        $result = mysqli_query($conecta,$sql);

        $json = array();
        while ($row = $result->fetch_assoc()) {
          $json[] = array(
            'id' => $row['idoperacao'],
            'nome' => $row['nomeoperacao'] // Don't you want the name?
          );
        }
        echo json_encode($json);

?>