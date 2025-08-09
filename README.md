git remote set-url origin  https://github.com/kgsdev9/-news-backend-laravel-apps.git clone  https://github.com/kgsdev9/-news-backend-laravel-apps.git

 

# Commnde pour gerer le prevelemet de l'activation du compte (2 000) et aussi pour l'abonnement annuel de 5 000 fcfa 
php artisan abonnement:prelever(la job queue)
php artisan schedule:work(lancer cette command een production)



php artisan tinker
$user = App\Models\User::find(1); // Remplace 1 par l'id de ton utilisateur
$user->dernier_paiement_abonnement = null;
$user->dernier_essai_prelevement = null; // si tu veux aussi réinitialiser la date de dernier essai
$user->save();
