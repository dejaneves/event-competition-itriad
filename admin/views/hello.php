<?php
session_start();

echo 'Nome logado: '.$_SESSION['name'].'<br>';
echo 'E-mail logado: '.$_SESSION['email'];
