# A faire

## Version 1

### Initialisation & Base de Données

- **X** pour Sundy
- **ok** pour Randi

- [ok] Initialiser le dépôt Git public (Randi)
- [ok] init models dans le projet (Randi)
    - [ok] configurations : Pour stocker les préfixes valides (ex: 033, 037).
    - [ok] clients : id, numero_telephone , solde.
    - [ok] type_operations : id, nom (depot, retrait, transfert).
    - [ok] baremes_frais : id, type_operation_id, montant_min, montant_max, frais.
    - [ok] mouvements : id, type_operation_id, client_source_id (null si dépôt), client_destination_id (null si retrait ou dépôt), montant_brut, frais, date_creation.
- [X] Configurer CodeIgniter  pour utiliser SQLite (Sundy)
- [X] Créer les Migrations pour la base de données :  (Sundy)
    - [X] configurations : Pour stocker les préfixes valides (ex: 033, 037).    (Sundy)
    - [X] clients : id, numero_telephone , solde.   (Sundy)
    - [X] type_operations : id, nom (depot, retrait, transfert).    (Sundy)
    - [X] baremes_frais : id, type_operation_id, montant_min, montant_max, frais.   (Sundy)
    - [X] mouvemens : id, type_operation_id, client_source_id (null si dépôt), client_destination_id (null si retrait ou dépôt), montant_brut, frais, montant_net, date_creation.   (Sundy)
    - [X] operateurs : id, nom, mot_de_passe    (Sundy)
- [X] Créer un seeder .     (Sundy)

### Espace Client (Authentification & Vues)

- [X] Connexion automatique :
- [X] Créer un formulaire demandant uniquement le numéro de téléphone.
- [X] Logique Controller : Si le numéro commence par un préfixe valide :

            S'il existe en base ➔ Ouvrir la session.

            S'il n'existe pas ➔ Créer le client en base ➔ Ouvrir la session.

- [X] Tableau de bord Client :
- [X] Afficher le numéro connecté et le solde actuel.
- [ok] fonction pour Afficher le numéro connecté et le solde actuel.
- [ok] fonction pour afficher l'historique des transactions du client (trié par date décroissante).
- [X] Intégrer les formulaires pour les opérations (Dépôt, Retrait, Transfert).
- [X] Afficher le tableau de l'historique des transactions du client (trié par date décroissante).

### Espace Opérateur

- [X] Créer une zone "Admin/Opérateur" .

- [ok] Implémenter la fonction Dépôt (Randi)

- [ok] Implémenter la fonction Retrait (Randi)

- [ok] Implémenter la fonction Transfert (Randi)

- [X] Gestion des configurations :
- [ok] fonctions pour ajouter/supprimer les préfixes valides 
    - [X] Interface pour ajouter/supprimer les préfixes valides 
- [X] Gestion des barèmes :
    - [X] Interface CRUD pour modifier les tranches de frais par type d'opération.
    - [ok] fonctions pour modifier les tranches de frais par type d'opération.

- [X] Tableaux de bord de situation :
    - [ok] fonction situation des gains : 
    - [ok] fonction situation des comptes
- [X] vue situation des gains : Afficher la somme totale des frais perçus
- [X] vue situation des comptes  : Liste de tous les clients avec leur numéro et leur solde actuel.

## Version 2
### Base de données & Migrations 
- [X] Mise à jour de configurations 
- [X] création table réseaux

### Espace Client
- [ ] Option "Inclure les frais de retrait" :
- [ ] Modifier le formulaire de transfert pour ajouter une case à cocher (Checkbox).
- [ ] Côté contrôleur (OperationsController), si cochée : calculer en plus les frais que le destinataire subira s'il retire cet argent, et les ajouter au total débité du compte source.

- [ ] Envoi multiple (Multi-transfert) :
- [ ] Modifier l'interface pour permettre la saisie de plusieurs numéros séparés par des virgules ou via des champs dynamiques.
- [ ] Côté contrôleur : diviser le montant brut saisi par le nombre de destinataires valides

### Espace Opérateur / Admin 
- [X] Créer Model Reseau 
- [X] Gestion des configurations étendues :

    - [X] Mettre à jour l'interface pour spécifier si le préfixe ajouté (ex: 032) est un "Autre Opérateur".

    - [X] Ajouter un champ pour configurer le % de commission supplémentaire lié à ce préfixe externe.

- [X] Tableau de bord des Gains :

    - [X] Modifier la vue situation gains via les différents frais
    
 - [ ] Nouveau rapport de compensation :

    - [ ] Créer la fonction et la vue situation des montants à envoyer à chaque opérateur 