git remote set-url origin  https://github.com/kgsdev9/-news-backend-laravel-apps.git clone  https://github.com/kgsdev9/-news-backend-laravel-apps.git

 

# Commnde pour gerer le prevelemet de l'activation du compte (2 000) et aussi pour l'abonnement annuel de 5 000 fcfa 
php artisan abonnement:prelever(la job queue)
php artisan schedule:work(lancer cette command een production)



php artisan tinker
$user = App\Models\User::find(1); // Remplace 1 par l'id de ton utilisateur
$user->dernier_paiement_abonnement = null;
$user->dernier_essai_prelevement = null; // si tu veux aussi réinitialiser la date de dernier essai
$user->save();

automasiation 

/usr/bin/php /var/www/kgsinformatique.com/htdocs/api-moyo.kgsinformatique.com/artisan schedule:run >> /var/www/kgsinformatique.com/htdocs/api-moyo.kgsinformatique.com/storage/logs/cron.log 2>&1

INSERT INTO ecoles (
    nom, sigle, code, email, adresse, siteweb, rib, telephone, fixe, logo,
    num_rccm, active, user_id, category_school_id, created_at, updated_at
) VALUES
-- 🔹 Abobo
('Collège IBC Abobo', 'IBC', 'ABO001', 'contact@ibcabobo.ci', 'Abobo Centre, Abidjan', 'http://ibcabobo.ci', 'CI1000000001', '+2250700000001', '+225212000001', 'ibc_logo.png', 'RCCM-ABO-001', 1, 1, 1, NOW(), NOW()),
('Fusos Cours Sociaux Abobo', 'FCS', 'ABO002', 'info@fcsabobo.ci', 'Abobo Derrière Rail', 'http://fcsabobo.ci', 'CI1000000002', '+2250700000002', '+225212000002', 'fcs_logo.png', 'RCCM-ABO-002', 1, 2, 3, NOW(), NOW()),
('École Primaire Abobo Avocatier', 'EPA', 'ABO003', 'contact@epaavocatier.ci', 'Quartier Avocatier, Abobo', 'http://epaavocatier.ci', 'CI1000000003', '+2250700000003', '+225212000003', 'epa_logo.png', 'RCCM-ABO-003', 1, 3, 1, NOW(), NOW()),
('Collège Moderne Abobo Baoulé', 'CMAB', 'ABO004', 'info@cmab.ci', 'Abobo Baoulé', 'http://cmab.ci', 'CI1000000004', '+2250700000004', '+225212000004', 'cmab_logo.png', 'RCCM-ABO-004', 1, 4, 3, NOW(), NOW()),
('Lycée Municipal Abobo', 'LMA', 'ABO005', 'contact@lma.ci', 'Abobo PK18', 'http://lma.ci', 'CI1000000005', '+2250700000005', '+225212000005', 'lma_logo.png', 'RCCM-ABO-005', 1, 5, 1, NOW(), NOW()),
('École Privée Les Élites Abobo', 'EPEA', 'ABO006', 'info@epea.ci', 'Abobo Kennedy', 'http://epea.ci', 'CI1000000006', '+2250700000006', '+225212000006', 'epea_logo.png', 'RCCM-ABO-006', 1, 1, 3, NOW(), NOW()),
('Groupe Scolaire Lumière Abobo', 'GSLA', 'ABO007', 'contact@gsla.ci', 'Abobo Belle-ville', 'http://gsla.ci', 'CI1000000007', '+2250700000007', '+225212000007', 'gsla_logo.png', 'RCCM-ABO-007', 1, 2, 1, NOW(), NOW()),
('Collège Excellence Abobo', 'CEA', 'ABO008', 'info@cea.ci', 'Abobo Anonkoua Kouté', 'http://cea.ci', 'CI1000000008', '+2250700000008', '+225212000008', 'cea_logo.png', 'RCCM-ABO-008', 1, 3, 3, NOW(), NOW()),
('École Sainte Marie Abobo', 'ESMA', 'ABO009', 'contact@esma.ci', 'Abobo Plateau Dokui', 'http://esma.ci', 'CI1000000009', '+2250700000009', '+225212000009', 'esma_logo.png', 'RCCM-ABO-009', 1, 4, 1, NOW(), NOW()),
('Lycée Technique Abobo', 'LTA', 'ABO010', 'info@lta.ci', 'Abobo Banco', 'http://lta.ci', 'CI1000000010', '+2250700000010', '+225212000010', 'lta_logo.png', 'RCCM-ABO-010', 1, 5, 3, NOW(), NOW()),

-- 🔹 Yopougon
('Collège IBC Yopougon', 'IBC', 'YOP001', 'contact@ibcyop.ci', 'Yopougon Sideci', 'http://ibcyop.ci', 'CI2000000001', '+2250700000011', '+225212000011', 'ibc_logo.png', 'RCCM-YOP-001', 1, 1, 1, NOW(), NOW()),
('Fusos Cours Sociaux Yopougon', 'FCS', 'YOP002', 'info@fcsyop.ci', 'Yopougon Toit Rouge', 'http://fcsyop.ci', 'CI2000000002', '+2250700000012', '+225212000012', 'fcs_logo.png', 'RCCM-YOP-002', 1, 2, 3, NOW(), NOW()),
('École Primaire Yopougon Académie', 'EPYA', 'YOP003', 'contact@epya.ci', 'Yopougon Niangon', 'http://epya.ci', 'CI2000000003', '+2250700000013', '+225212000013', 'epya_logo.png', 'RCCM-YOP-003', 1, 3, 1, NOW(), NOW()),
('Collège Moderne Yopougon', 'CMY', 'YOP004', 'info@cmy.ci', 'Yopougon Wassakara', 'http://cmy.ci', 'CI2000000004', '+2250700000014', '+225212000014', 'cmy_logo.png', 'RCCM-YOP-004', 1, 4, 3, NOW(), NOW()),
('Lycée Classique Yopougon', 'LCY', 'YOP005', 'contact@lcy.ci', 'Yopougon Kouté', 'http://lcy.ci', 'CI2000000005', '+2250700000015', '+225212000015', 'lcy_logo.png', 'RCCM-YOP-005', 1, 5, 1, NOW(), NOW()),
('École Privée Les Élites Yopougon', 'EPEY', 'YOP006', 'info@epey.ci', 'Yopougon Andokoi', 'http://epey.ci', 'CI2000000006', '+2250700000016', '+225212000016', 'epey_logo.png', 'RCCM-YOP-006', 1, 1, 3, NOW(), NOW()),
('Groupe Scolaire Lumière Yopougon', 'GSLY', 'YOP007', 'contact@gsly.ci', 'Yopougon Selmer', 'http://gsly.ci', 'CI2000000007', '+2250700000017', '+225212000017', 'gsly_logo.png', 'RCCM-YOP-007', 1, 2, 1, NOW(), NOW()),
('Collège Excellence Yopougon', 'CEY', 'YOP008', 'info@cey.ci', 'Yopougon Sicogi', 'http://cey.ci', 'CI2000000008', '+2250700000018', '+225212000018', 'cey_logo.png', 'RCCM-YOP-008', 1, 3, 3, NOW(), NOW()),
('École Sainte Marie Yopougon', 'ESMY', 'YOP009', 'contact@esmy.ci', 'Yopougon Niangon Adjamé', 'http://esmy.ci', 'CI2000000009', '+2250700000019', '+225212000019', 'esmy_logo.png', 'RCCM-YOP-009', 1, 4, 1, NOW(), NOW()),
('Lycée Technique Yopougon', 'LTY', 'YOP010', 'info@lty.ci', 'Yopougon Maroc', 'http://lty.ci', 'CI2000000010', '+2250700000020', '+225212000020', 'lty_logo.png', 'RCCM-YOP-010', 1, 5, 3, NOW(), NOW());
