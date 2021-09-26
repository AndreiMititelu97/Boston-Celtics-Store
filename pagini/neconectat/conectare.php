<h1 class="header-reg-login">Conectare</h1>

<form method="post">
  <div class="form-group login">
    <label for="email">Adresa Email:</label>
    <input type="email" class="form-control" id="email" name="email_user">
  </div>
  <div class="form-group login">
    <label for="pass">Parola:</label>
    <input type="password" class="form-control" id="pass" name="password_user"><br>
    <button type="submit" class="btn btn-primary" name="conectare">Conectare</button>
  </div>
  
</form>
<?php

//var_dump(connectDB());
//var_dump(clearData('<>fgssa~#!<b>test</b>// SELECT * From user', connectDB()));
//var_dump(inregistrare('test@zza', 'abc'));
//var_dump(getUserByEmail('test@zza'));die();
//var_dump(getUsers());die();
//var_dump(conectare('test5@test', 'abc'));

if(isset($_SESSION['eroare_login'])){
    print '<div style="color:red">'.$_SESSION['eroare_login'].'</div>';
}

?>