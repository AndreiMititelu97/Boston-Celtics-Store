<?php
 /*
function conectareBD($host = 'localhost', //Conectare procedural
                     $user = 'root',
                     $password = '',
                     $database = 'magazin'   
                    )
{
    return mysqli_connect($host, $user, $password, $database);
}

*/
function connectDB($host = 'boston-celtics-store_mysql_1', 
                   $user = 'root', 
                   $password = 'root', 
                   $database = 'magazin'
                  )
{
   $conn = new mysqli($host, $user, $password, $database);
   if($conn->connect_error) die($conn->connect_error);
   
   return $conn;
}

function clearData($input, $link)
{
    $input = trim($input);// functie ce elimina spatiile libere din <- si -> unui string => _John_Doe__ devine John_Doe
    $input = htmlspecialchars($input); //nu permite adaugare taguri html in variabila
    $input = stripslashes($input);//nu permite adaugarea de url -> scoate / si \
    //$input = mysqli_real_escape_string($link, $input);// nu permite sql injection --procedural
    $input= $link->real_escape_string($input);// nu permite sql injection
    
    return $input;
}
/*
function inregistrare($email, $pass) //Procedural
{
    $link = conectareBD(); //conectare db
    $email = clearData($email, $link); //curatare data de intrare
    $pass = clearData($pass, $link);//curatare data de intrare
    $pass = md5($pass); //encodare parola unidirectionala
    
    $userExistent = preiaUtilizatorDupaEmail($email);//verificare daca exista deja adresa
    if($userExistent){
        return false;
    }
    
    $query = "INSERT INTO utilizator(email, parola) VALUES ('$email', '$pass')";
    
    return mysqli_query($link, $query);
}
*/
function inregistrare($email, $pass){
    $link = connectDB(); //conectare db
    $email = clearData($email, $link);//curatare data de intrare
    $pass = clearData($pass, $link);//curatare data de intrare
    $pass = hash('ripemd160', $pass);
    
    $user = getUserByEmail($email);//  |verificare daca 
    if($user) return false;//          |exista deja user
    
    $query = "INSERT INTO utilizator VALUES(NULL, '$email', '$pass')";
    $result = $link->query($query);
    
    if(!$result) return $link->error;
    
    return $result;
}

function getUserByEmail($email)
{
    $link = connectDB(); //conectare db
    $email = clearData($email, $link);//curatare data de intrare
    
    $query = "SELECT * FROM utilizator WHERE email = '$email'";
    $resultSet = $link->query($query); //result set - returneazat un obiect
    if(!$resultSet) return $link->error;
    
    $resultArray = $resultSet->fetch_array(MYSQLI_ASSOC);
    
    return $resultArray;
}
 
function getUsers()
{
    $link = connectDB();//conectare db
    
    $query = "SELECT id, email from utilizator";
    $resultSet = $link->query($query);//result set
    
    $resultArray = $resultSet->fetch_all(MYSQLI_ASSOC);
    
    foreach($resultArray as $user){
        print 'id: '.$user['id'].' email:'.$user['email'].'<br>';
    }
}

function conectare($email, $pass)
{
    $link = connectDB();//conectare db
    $email = clearData($email, $link);//curatare data de intrare
    $pass = clearData($pass, $link);//curatare data de intrare
    $user = getUserByEmail($email);// incarc toate linia in $user
   
    if($user){//verific adresa de email din db
        return hash('ripemd160', $pass) == $user['parola'];//verific si parola
    }else{
        return false;
    }
}

function adaugaProdus($denumire, $pret, $imagine)
{
    $link = connectDB();
    $denumire = clearData($denumire, $link);
    $pret = clearData($pret, $link);
    $imagine = clearData($imagine, $link);
    
    $query = "INSERT INTO produs VALUES (NULL, '$denumire', '$pret', '$imagine')";
    $result = $link->query($query);
    if(!$result) return ($link->error);
    
    return $result;
    
}
function stergeProdus($idProdus){
    $link = connectDB();
    $idProdus = clearData($idProdus, $link);
    $query = "DELETE FROM produs where id = '$idProdus'";
    
    $result = $link->query($query);
    if(!$result) return ($link->error);
    
    return $result;
}
function editeazaProdus($idProdus, $denumireProdus, $pretProdus, $imagineProdus){
    $link = connectDB();
    $denumireProdus = clearData($denumireProdus, $link);
    $pretProdus = clearData($pretProdus, $link);
    $imagineProdus = clearData($imagineProdus, $link);
    
    if($imagineProdus){
        $query = "UPDATE produs SET denumire = '$denumireProdus', pret = '$pretProdus', imagine = '$imagineProdus' where id = '$idProdus'";
    }else{// in caz ca nu modific imaginea, setez doar denumire si pret ca sa nu suprascriu imaginea existena
        $query = "UPDATE produs SET denumire = '$denumireProdus', pret = '$pretProdus' where id = '$idProdus'";
    }
    $result = $link->query($query);
    if(!$result) return ($link->error);
    
    return $result;
}

function getProducts()
{
    $link = connectDB();
    $query = "Select * from produs";
    $resultSet = $link->query($query);
    
    $resultArray = $resultSet->fetch_all(MYSQLI_ASSOC);
    
    return $resultArray;
}

function getProductsById($id)
{
    $link = connectDB();
    $id = clearData($id, $link);
    $query = "SELECT denumire,pret from produs where id='$id'";
    $resultSet = $link->query($query);
    $resultArray = $resultSet->fetch_array(MYSQLI_ASSOC);
    
    return $resultArray;
}


