<?php
if (!file_exists($_POST['delete'])) {
unlink('../images/' . $_POST['delete']);
}
header("Location:../index.php");