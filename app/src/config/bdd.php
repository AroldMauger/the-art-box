<?php

function connexion() {
    return new PDO('mysql:dbname=database;host=database', 'user', 'password');
}