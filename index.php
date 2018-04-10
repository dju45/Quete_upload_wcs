<?php

$data = __DIR__ . '/images';
$target_file = $data . basename($_FILES['upload']);
$iterator = new FilesystemIterator($data, FilesystemIterator::SKIP_DOTS);
$extensions = array('png', 'gif', 'jpg', 'jpeg');
$errors = [];

if(isset($_POST['submit'])) {
    if (count($_FILES['upload']['name']) > 0) {
        for ($i = 0; $i < count($_FILES['upload']['name']); $i++) {
            $extension = new SplFileInfo($_FILES['upload']['name'][$i]);
            $tmpFilePath = $_FILES['upload']['tmp_name'][$i];
            if($_FILES['upload']['size'][$i] > 1000000) {
                $errors[] = 'Le fichier est trop lourd';
            }
            if(!in_array($extension->getExtension(), $extensions)) {
                $errors[] = 'extension de fichier invalide';
            }
            if (empty($errors)) {
                $shortname = $_FILES['upload']['name'][$i];
                $filepath = 'images/' . uniqid('image') . '.' . pathinfo($_FILES['upload']['name'][$i], PATHINFO_EXTENSION);
                (move_uploaded_file($tmpFilePath, $filepath));
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <title>Bibliotheque d image</title>
</head>
<body>
<div class="container">
    <h1 class="col-md-6 col-md-offset-4">Bibliotheque d'images</h1>
    <form class="container" id="form1" enctype="multipart/form-data" method="post" action="">
        <div class="row setup-content" id="step-1">
            <div class="col-xs-12">
                <div class="col-md-12 well text-center">

                    <label for="upload">Selectionner une image</label><br />
                    <input type="file" name="upload[]" multiple="multiple" id="upload" />
                </div>
                <div class="row">
                    <input type="submit"  class="btn btn-success" name="submit" value="Envoyer" />
                </div>
            </div>
        </div>
    </form>
    <?php foreach ($errors as $error) : ?>
        <ul>
            <li><small class="text-danger"><?= $error; ?></small></li>
        </ul>
    <?php endforeach; ?>
    <h2>Galerie</h2>
    <div class="row">
        <?php foreach ($iterator as $file) : ?>
            <div class="col-md-3">
                <div class="thumbnail">
                    <img src="<?= 'images/' . $file->getfilename() ?>" alt="" >
                    <div class="caption">
                        <p><?=$file->getfilename() ?></p>
                        <form action="src/delete.php" method="post">
                            <input type="hidden" name="delete" value="<?= $file->getfilename() ?>" />
                            <button type="submit"  class="btn btn-danger">Effacer</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
</body>
</html>







