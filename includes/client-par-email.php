<!-- 
fichier permet de recuperer un client par email 
utilisé pour login mais aussi afficher page compte client  
    -->

<?php
require_once __DIR__.'/../src/DbConnection.php';
require_once __DIR__.'/../src/Model/Client.php';


if( null === $email) {
    throw new RuntimeException('La variable $email doit être définie!');
}

$pdo = \App\DbConnection::current(); 
$statement = $pdo->prepare(
<<<SQL
    SELECT email, password, created_at, name, address
    FROM clients
    WHERE email=?;
SQL
);
if (false === $statement->execute([$email])) { //valeur $email recupéré grace au require 
    throw new RuntimeException('Erreur avec la requête !');
}


if($ligne = $statement->fetch()) {
    return new App\Model\Client(
        $ligne['email'],
        $ligne['password'],
        $ligne['name'],
        $ligne['address'],
        new DateTimeImmutable($ligne['created_at'])
    );
}
