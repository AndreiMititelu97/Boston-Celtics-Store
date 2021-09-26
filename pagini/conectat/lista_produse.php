<?php
    
    if(isset($_GET['id_editare'])){
            require_once 'pagini/conectat/editeaza_produs.php';
    }

$produse = getProducts();

if(count($produse) == 0){
    print '<h2>Fara produse in stoc<h2>';
}else{
    print '<div class="item-container">';
    foreach($produse as $items){?>

    <div class="card-body item-card text-center">
        <div class="card-img">
            <img class="card-img-top" src="imagini/<?php print $items['imagine'];?>" alt="Imaginea nu este disponibila momentan" wdith="180px" height="250px" >
        </div>
        
        <div class="card-text">
            <h5><b><?php print $items['denumire']; ?></b></h5>
            <h5><?php print $items['pret'].' RON'; ?></h5>
            <a href="index.php?id_produs=<?php print $items['id'];?>" class="btn btn-primary">Adauga in cos</a>
            <?php
                if($_SESSION['user'] == 'admin@test'){
                    print "<a class = 'btn btn-warning' href= 'index.php?id_editare=" . $items['id']. "' >Editeaza</a>";
                    print "<a class = 'btn btn-danger' href= 'index.php?id_eliminare=" . $items['id']. "'>Elimina</a>";
                }
            ?>
            
        </div>
    </div>    
<?php }
    print '</div>';
    }
    ?>


