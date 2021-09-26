<h1>Cos cumparaturi</h1>
<?php
    if(isset($_SESSION['produs_sters'])){
        print '<h3 style="color:#ff8000;">'.$_SESSION['produs_sters'].'</h3>';
        unset($_SESSION['produs_sters']);
    }

//var_dump(getProductsById(4));

//if(isset($_SESSION['cos']) && $_SESSION['cos'] != NULL){} //verific daca este setat $_SESSion['cos'] si este != NULL

if(!empty($_SESSION['cos'])){//verific daca este setat $_SESSion['cos'] si este != NULL
    ?>
<table class="table table-striped table-secondary table-bordered">
    <thead>
        <tr>
            <th scope="col">Denumire</th>
            <th scope="col"> Pret</th>
            <th scope="col">Cantitate</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
<?php
    $totalPret = 0;
    foreach($_SESSION['cos'] as $idProdus => $cantitate){
        $produs = getProductsById($idProdus);
        $totalPret = $totalPret + ($cantitate * $produs['pret']);
        ?>
    <tr>
        <td scope="row"><?php print $produs['denumire']; ?></td>
        <td><?php print $produs['pret']; ?></td>
        <td><?php print $cantitate; ?></td>
        <td><a href='index.php?page=2&id_stergere=<?php print $idProdus; ?>' class="btn btn-danger">Sterge</a></td>
    </tr>
        <?php
    }
    print '</tbody></table> <br> <br>';
    print '<h3>Total: '.$totalPret.' RON</h3>';
}else{
    print '<h3>Cosul este gol</h3>';
}
?>