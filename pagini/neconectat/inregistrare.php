<h1 class="header-reg-login">Inregistrare</h1>

<form method="post">
  <div class="form-group login">
    <label for="email">Adresa Email:</label>
    <input type="email" class="form-control" id="email" aria-describedby="emailHelp" name="email_user" required>
  </div>
  <div class="form-group login">
    <label for="pass">Parola:</label>
    <input type="password" class="form-control" id="pass" name="password_user" required><br>
    <button type="submit" class="btn btn-primary" name="inregistrare">Inregistreaza</button>
  </div>
    <br>
</form>
<?php

if(isset($_POST['inregistrare'])){
    $email = $_POST['email_user'];
    $pass = $_POST['password_user'];
    
    $rezultatInregistrare = inregistrare($email, $pass);
    
    if($rezultatInregistrare){
        //print '<div style="color:green">Cont creat cu succes!</div>';
        $_SESSION['user'] = $email;// autologin si apoi redirect la index pt a verificare $_SESSION[user]
        header("location: index.php");
    }else{
        print '<div style="color:red">A aparut o eroare la crearea contului!</div>';
    }
}