<?php 
if($_SESSION['user'] != 'admin@test'){
    print '<h3>Nu ai acces la aceasta pagina</h3>';
    return;
}
?>
<h1>Adauga un produs</h1>
<form method="post" enctype="multipart/form-data">
    <div class="mb-3" style='width:50%;'>
        <label for="denumire" class="form-label">Denumire produs:</label>
        <input type="text" class="form-control" id="denumire" name="denumire">
    </div>

    <div class="mb-3" style='width:10%;'>
        <label for="pret" class="form-label">Pret produs:</label>
        <input type="text" class="form-control" id="pret" name="pret">
    </div>

    <div class="mb-3" style='width:50%;'>
        <label for="imagine" class="form-label">Imagine:</label>
        <input type="file" class="form-control" id="imagine" name="imagine">
        <small class="form-text text-muted">In format: .jpg, .png</small>
    </div>
    <button type="submit" class="btn btn-primary" name="adauga">Adauga</button>
</form>
<?php
$phpFileUploadErrors = array(
    0 => 'There is no error, the file uploaded with success',
    1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
    2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
    3 => 'The uploaded file was only partially uploaded',
    4 => 'No file was uploaded',
    6 => 'Missing a temporary folder',
    7 => 'Failed to write file to disk.',
    8 => 'A PHP extension stopped the file upload.',
);


//var_dump(adaugaProdus('tricou', '55.5', 'test.jpg'));
if(isset($_POST['adauga'])){
    $denumire = $_POST['denumire'];
    $pret = $_POST['pret'];
    
    if(isset($_FILES['imagine'])){
        //verific daca exista vreo eroare
        if($_FILES['imagine']['error'] == 0){// nu avem eroare
            //verificare tip fisier
            switch($_FILES['imagine']['type']){
                case 'image/jpg':
                case 'image/jpeg':
                case 'image/png':
                case 'image/gif':
                case 'image/bmp':   
                    //$_FILES['image']['name']- nume fisier din pc user (poza.jpg)
                    $numeImagine = uniqid() . $_FILES['imagine']['name'];//adaugare id unic+ numele fisierul cu terminatie fisier ->imaginea este unica, nu se suprascrie
                    //salvare pe server -> mutare fisier din folderul temp
                    $salvareServer = move_uploaded_file($_FILES['imagine']['tmp_name'], 'imagini/' . $numeImagine);
                    
                    if($salvareServer){
                        $salvareDB = adaugaProdus($denumire, $pret, $numeImagine);
                        
                        if($salvareDB){
                            print '<div style="color:green">Produs adaugat cu succes</div>';
                        }else{//pentru cazul in care nu s-a salvat in db, sterg img de pe server
                           unlink('imagini/' . $numeImagine);
                           print '<div style="color:red">Eroare la salvearea in db</div>';
                        }
                    }else{
                        print '<div style="color:red">Eroare la salvarea pe server</div>';
                    }
                    break;
                default:
                    print '<div style="color:red">Fisierul adaugat nu este o imagine</div>';
                    break; 
            }
            
        }else{
            if($_FILES['imagine']['error'] == 4){//adaugare produs fara imagine
                $rezultatAdaugare = adaugaProdus($denumire, $pret, NULL);
                if($rezultatAdaugare){
                    print '<div style="color:green">Produs adaugat cu succes!</div>';
                }else{
                    print '<div style="color:red">Eroare la salvearea in db</div>';
                }
            }else{
                print '<div style="color:red">A aparut o eroare: '.$phpFileUploadErrors[$_FILES['imagine']['error']]. '</div>';
            }
            
        }  
    }
}
?>
