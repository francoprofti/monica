<?php 

        include 'conecta.php';
        $id = $_GET['parte'];
        $sql = 'SELECT operacao.nomeoperacao, operacao.idoperacao, operacao.codigo FROM operacao
        WHERE operacao.parte = '.$id.' AND operacao.status = 0 ORDER BY operacao.nomeoperacao ASC ';


        $result = mysqli_query($conecta,$sql);

        $json = array();
        while ($row = $result->fetch_assoc()) {
          $json[] = array(
            'id' => $row['idoperacao'],
            'codigo' => $row['codigo'],
            'nome' => $row['nomeoperacao'] // Don't you want the name?
          );
        }
        echo json_encode($json);

?>