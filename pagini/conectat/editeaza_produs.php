<?php 
if($_SESSION['user'] != 'admin@test'){
    print '<h3>Nu ai acces la aceasta pagina</h3>';
    return;
}
$id = $_GET['id_editare'];
$produs = getProductsById($id);
?>
<h1>Editeaza un produs</h1>
<form method="post" enctype="multipart/form-data">
    <div class="mb-3 adauga">
        <label for="denumire" class="form-label">Denumire produs:</label>
        <input type="text" class="form-control" id="denumire" name="denumire" value='<?php  print $produs['denumire'];?>'>
    </div>

    <div class="mb-3 adauga">
        <label for="pret" class="form-label">Pret produs:</label>
        <input type="text" class="form-control" id="pret" name="pret" value='<?php  print $produs['pret'];?>'>
    </div>

    <div class="mb-3 adauga">
        <label for="imagine" class="form-label">Imagine:</label>
        <input type="file" class="form-control" id="imagine" name="imagine">
        <small class="form-text text-muted">In format: .jpg, .png</small>
    </div>
    <button type="submit" class="btn btn-primary" name="editeaza">Editeaza</button>
    <input type='hidden' name='id' value='<?php print $id; ?>'>
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

if(isset($_POST['editeaza'])){
    $denumire = $_POST['denumire'];
    $pret = $_POST['pret'];
    $id = $_POST['id'];
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
                        $salvareDB = editeazaProdus($id, $denumire, $pret, $numeImagine);
                        
                        if($salvareDB){
                            header("location:index.php");
                            //print '<div style="color:green">Produs editat cu succes</div>';
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
                $rezultatEditare = editeazaProdus($id, $denumire, $pret, NULL);
                if($rezultatEditare){
                    header("location:index.php");
                    //print '<div style="color:green">Produs editat cu succes!</div>';
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
