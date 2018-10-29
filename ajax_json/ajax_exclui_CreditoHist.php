<?php
require_once ('../model/Cliente.php');

echo Cliente::excluiHist($_GET['id']);

?>