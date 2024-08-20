<?php
include('../../config/conexao.php');

if(isset($_GET['idDel'])){
    $id = $_GET['idDel'];
    
    //Primeiro, recupere o id do contato selecionado
    $select = "SELECT foto_contatos FROM tb_contato WHERE id_contatos=:id";
        try{
            $result = $conect->prepare($select);
            $result->bindValue(':id',$id,PDO::PARAM_INT);
            $result->execute();

            $contar = $result->rowCount();
            if($contar > 0){
                $show = $result->fetch(PDO::FETCH_OBJ);
                $foto = $show->foto_contatos;
            
            if($foto != 'avatar-padrao.png'){
                //caminho da imagem no servidor
                $filePath = "../../img/cont/". $foto;
                
                //verifica se o arquivo existe e o deleta
                if(file_exists($filePath)){
                    unlink($filePath);
                }
            }
            //agora, delete o registro do banco de dados
            $delet = "DELETE FROM tb_contatos WHERE id_contatos-:id";
            try{
                $result = $conect->prepare($select);
                $result->bindValue(':id',$id,PDO::PARAM_INT);
                $result->execute();

                $contar = $result->rowCount();
                if($contar > 0){
                    header("location: ../home.php");
                } else{
                    header("location: ../home.php");
                }
            }catch(PDOException $e){

            }
        } else{
            header("location: ../home.php");
        }
        }catch(PDOException $e){
            echo "<strong>ERRO de PDO</strong>";
        }
}