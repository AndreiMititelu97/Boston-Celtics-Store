<nav class="nav">
  <a class="nav-link" href="index.php">Conectare</a>
  <a class="nav-link" href="index.php?page=1">Inregistrare</a>
</nav>
<section id="continut">
<?php
    if(isset($_GET['page'])){
        $page = $_GET['page'];
        if($page == 1){
            require_once 'pagini/neconectat/inregistrare.php';
        }else{
            require_once 'pagini/eroare.php';
        }
    }else{
        require_once 'pagini/neconectat/conectare.php';
    }
?>
</section>



