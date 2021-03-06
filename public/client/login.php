<a href="/rainbow/public/index.php">
                    <img class="logo" src="/rainbow/public/photos/logo.png" alt="rainbowlogo">
                </a>
                <?php

use App\Model\Client; 
use App\SessionManager;

require_once __DIR__.'/../../src/SessionManager.php';

if(SessionManager::loggedClient() instanceof Client) {
    header('location: ../index.php');
    exit(); 
}

    $error = null;
    $email = $_POST['email'] ?? null;
    $password = $_POST['password'] ?? null;
    $message = $_GET['message'] ?? null; 
    //ou alors=> $email = isset($_POST['email']) ? $_POST['email'] : null;
    
    if (null !== $message) {
        switch ($message) {
            case 1:
                echo "Vous devez vous connecter pour effectuer une commande";
                break;
            case 2:
                echo "i equals 1";
                break;
            case 3:
                echo "i equals 2";
                break;
        }
    }
    
    if (null !== $email &&
        false === filter_var($email, FILTER_VALIDATE_EMAIL)
    ) {
        $error = "L'identifiant fourni n'est pas un email valide !\n";
    }

    if (null === $error && null!== $email) {
        $client = require __DIR__.'/../../includes/client-par-email.php';
        if ($client instanceof Client) {
             //Verif mdp 
             if (true === password_verify($password, $client->password())) {
                SessionManager::loginClient($client);
                header("location:../index.php");
                exit();
             } else {
                $error = "Mauvais mdp";
            } 
        } else {
            $error = 'Aucun client avec ces informations, merci de rééssayer.';
        }    
    }
?><form method="post">
    <input type="email" name="email" placeholder="Email" value="<?= $email ?>"/>
    <input type="password" name="password" placeholder="Mot de passe"/>
    <input type="submit" value="Login" />
    <?php if (null !== $error): ?>
            <p><?= $error ?></p>
    <?php endif; ?>

<p><a href="forgot-password.php">j'ai oublié mon mot de passe</a></p>

<p>OR <a href="signup.php">Create account</a></p>

</form>
