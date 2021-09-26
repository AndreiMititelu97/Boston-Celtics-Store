<?php
require_once 'functions/sql_functions.php';
session_start();//pornesc sesiunea imediat ca a pornit aplicatia
if(isset($_POST['conectare'])){
    $email = $_POST['email_user'];
    $pass = $_POST['password_user'];
    
    $rezultatConectare = conectare($email, $pass);
    if($rezultatConectare){
        if(isset($_SESSION['eroare_login'])){//sterg cheia-valoare din sesiune daca conectarea a fost cu succes
            unset($_SESSION['eroare_login']);
        }
        $_SESSION['user'] = $email;//setez email pe sesiune, cand emailul este setat pe sesiune -> utilizator conectat -> incarc template_conectat.php
    }else{
        $_SESSION['eroare_login'] = 'Conectare esuata';
    }  
}
if(isset($_GET['id_produs'])){
    $id = $_GET['id_produs'];
    //verific daca am deja produsul in cos, daca il am deja -> cresc cantitatea 
    if(isset($_SESSION['cos'][$id])){
        $_SESSION['cos'][$id]++;
    }else{//altfel il setez ca 1 (pt produs care nu este deja in cos)
        $_SESSION['cos'][$id] = 1;
    }  
}
if(isset($_GET['id_stergere'])){
    $id = $_GET['id_stergere'];
    if($_SESSION['cos'][$id] > 1){// daca am mai multe produse de acelasi fel, elimin cate 1
        $_SESSION['cos'][$id]--;
    }else {// daca am doar un singur produs la cantitate -> il elimin din cos
        unset($_SESSION['cos'][$id]);
    }
}
if(isset($_GET['logout'])){
        session_destroy();//inchei sesiunea
        header("location: index.php");// redirect la index.php, unde verifica sesiunea si incarca template_neconectat
    }
if(isset($_GET['id_eliminare'])){
        $id = $_GET['id_eliminare'];
        $rezultatEliminare = stergeProdus($id);
        if($rezultatEliminare){
            if(isset($_SESSION['cos'][$id])){
                unset($_SESSION['cos'][$id]);//daca am reusit sa il sterg din db, il scot si din cos
            }
            $_SESSION['produs_sters'] = 'Unele produse nu mai sunt in stoc si au fost sterse din cosul de cumparaturi';
            header("location: index.php");
        }else{
            print 'A aparut o eroare';
        }    
    }
?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Boston Celtics Online Store</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="https://cdn.rawgit.com/dreampulse/computer-modern-web-font/master/fonts.css">
        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>
    <body>
        <header id="banner">
           <img src="imagini/logo.svg" alt="image" class="header-img" id="img-left">
           <img src="imagini/logo.svg" alt="image" class="header-img"id="img-right">
           <div id="header-title">Boston Celtics Store</div>
        </header>
        <?php
        
        if(isset($_SESSION['user'])){//daca e setat -> utilizatorul este conectat
            require_once 'templates/template_conectat.php';
        }else{
            require_once 'templates/template_neconectat.php';
        }
        ?>
        
    </body>
</html>
