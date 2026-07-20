```bash

# 1. Créer le dossier de la base SQLite
mkdir -p writable/db

# 2. Créer les tables et les données de démonstration
php spark migrate
php spark db:seed Donnees

# 3. Lancer le serveur
php spark serve
```