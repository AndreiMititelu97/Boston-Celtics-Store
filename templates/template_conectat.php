<nav class="nav">
  <a class="nav-link" href="index.php">Lista produse</a>
  <?php if($_SESSION['user'] == 'admin@test'){?>
       <a class="nav-link" href="index.php?page=1">Adauga produs</a>
    <?php } ?>
  <a class="nav-link" href="index.php?page=2">Cos de cumparaturi</a>
  <a class="nav-link" href="index.php?logout">Deconectare, (<?php  print $_SESSION['user'];?>)</a>
</nav>



<section>
<?php
    if(isset($_GET['page'])){
        $page = $_GET['page'];
        if($page == 1){
            require_once 'pagini/conectat/adauga_produs.php';
        }else if ($page == 2){
            require_once 'pagini/conectat/cos_de_cumparaturi.php';
        }else{
            require_once 'pagini/eroare.php';
        }
    }else{
        require_once 'pagini/conectat/lista_produse.php';
    }
    
?>
</section>
