# A faire
## Version 1
## Initialisation & Base de Données
- [ ] Initialiser le dépôt Git public 
- [ ] Configurer CodeIgniter  pour utiliser SQLite
- [ ] Créer les Migrations pour la base de données :
- [ ] configurations : Pour stocker les préfixes valides (ex: 033, 037).
- [ ] clients : id, numero_telephone (unique), solde (par défaut 0).
- [ ] type_operations : id, nom (depot, retrait, transfert).
- [ ] baremes_frais : id, type_operation_id, montant_min, montant_max, frais.
- [ ] mouvement : id, type_operation_id, client_source_id (null si dépôt), client_destination_id (null si retrait ou dépôt), montant_brut, frais, montant_net, date_creation.
- [ ] Créer un seeder .

## Espace Client (Authentification & Vues)
- [ ] Connexion automatique :
- [ ] Créer un formulaire demandant uniquement le numéro de téléphone.
- [ ] Logique Controller : Si le numéro commence par un préfixe valide :

            S'il existe en base ➔ Ouvrir la session.

            S'il n'existe pas ➔ Créer le client en base (pas d'inscription préalable) ➔ Ouvrir la session.

- [ ] Tableau de bord Client :
- [ ] Afficher le numéro connecté et le solde actuel.
- [ ] Intégrer les formulaires pour les opérations (Dépôt, Retrait, Transfert).
- [ ] Afficher le tableau de l'historique des transactions du client (trié par date décroissante).

## Espace Opérateur 
- [ ] Créer une zone "Admin/Opérateur" .
- [ ] Implémenter la fonction Dépôt 
- [ ] Implémenter la fonction Retrait 
- [ ] Implémenter la fonction Transfert
- [ ] Gestion des configurations :
- [ ] Interface pour ajouter/supprimer les préfixes valides (ex: ajouter 034).
- [ ] Gestion des barèmes :
- [ ] Interface CRUD pour modifier les tranches de frais par type d'opération.
- [ ] Tableaux de bord de situation :
- [ ] Situation des gains : Afficher la somme totale des frais perçus, filtrable par type (Retrait vs Transfert).
- [ ] Situation des comptes : Liste de tous les clients avec leur numéro et leur solde actuel.