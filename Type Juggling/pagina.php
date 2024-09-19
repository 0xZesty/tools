<?php

if(isset($_POST['senha']) and !empty($_POST['senha'])) {
    if($_POST['senha'] == 'MinhaSup3rS3cr3tChav3') {
        echo 'Chave correta';
    }else {
        echo 'Chave incorreta';
    }
}

?>

<form method="POST" action="pagina.php">
    <input type="text" name="senha" placeholder="Sua senha">
    <input type="submit" value="Entrar">
</form>