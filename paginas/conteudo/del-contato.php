<?php
include('../../config/conexao.php');

if (isset($_GET['idDel'])) {
    $id = $_GET['idDel'];
    
    // Primeiro, recupere o id do contato selecionado
    $select = "SELECT foto_contatos FROM tb_contatos WHERE id_contatos = :id";
    try {
        $result = $conect->prepare($select);
        $result->bindValue(':id', $id, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount() > 0) {
            $show = $result->fetch(PDO::FETCH_OBJ);
            $foto = $show->foto_contatos;

            if ($foto != 'avatar-padrao.png') {
                // Caminho da imagem no servidor
                $filePath = "../../img/cont/" . $foto;
                
                // Verifica se o arquivo existe e o deleta
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }

            // Agora, delete o registro do banco de dados
            $delet = "DELETE FROM tb_contatos WHERE id_contatos = :id";
            try {
                $result = $conect->prepare($delet);
                $result->bindValue(':id', $id, PDO::PARAM_INT);
                $result->execute();

                // Redireciona após a exclusão
                header("Location: ../home.php");
                exit();
            } catch (PDOException $e) {
                // Tratar erro de exclusão
                echo "<strong>Erro ao excluir o contato:</strong> " . $e->getMessage();
            }
        } else {
            // Contato não encontrado
            header("Location: ../home.php");
            exit();
        }
    } catch (PDOException $e) {
        // Tratar erro de seleção
        echo "<strong>Erro ao recuperar o contato:</strong> " . $e->getMessage();
    }
}
