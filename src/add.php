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

            if($_FILES['upload']['size'] > 1000000) {
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
