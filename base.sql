CREATE TABLE configurations (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    prefixe TEXT NOT NULL UNIQUE,
    reseau_id INTEGER NOT NULL
);

CREATE TABLE clients (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    numero_telephone TEXT NOT NULL UNIQUE,
    solde REAL NOT NULL DEFAULT 0.0
);

CREATE TABLE type_operations (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nom TEXT NOT NULL UNIQUE
);

CREATE TABLE baremes_frais (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    type_operation_id INTEGER NOT NULL,
    montant_min REAL NOT NULL,
    montant_max REAL NOT NULL,
    frais REAL NOT NULL
);

CREATE TABLE mouvements (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    type_operation_id INTEGER NOT NULL,
    client_source_id INTEGER,
    client_destination_id INTEGER,
    montant_brut REAL NOT NULL,
    frais REAL NOT NULL,
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE operateurs (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nom TEXT NOT NULL UNIQUE,
    mot_de_passe TEXT NOT NULL
);

CREATE TABLE reseaux (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nom TEXT NOT NULL UNIQUE,
    commission_transfert REAL NOT NULL DEFAULT 0.0
);

INSERT INTO `configurations` (`prefixe`) VALUES 
('033'),
('037');

INSERT INTO `type_operations` (`id`, `nom`) VALUES 
(1, 'depot'),
(2, 'retrait'),
(3, 'transfert');

INSERT INTO `clients` (`numero_telephone`, `solde`) VALUES 
('0331234567', 100000.0),
('0379876543', 50000.0),
('0335555555', 250000.0);

INSERT INTO `baremes_frais` (`type_operation_id`, `montant_min`, `montant_max`, `frais`) VALUES 
-- DEPOT (id: 1)
(1, 0, 999999999, 0),

-- RETRAIT (id: 2)
(2, 0, 50000, 500),
(2, 50001, 100000, 1000),

-- TRANSFERT (id: 3)
(3, 0, 50000, 200),
(3, 50001, 100000, 500);

-- 5. OPERATEURS DE TEST
-- Les mots de passe correspondent à 'password1' et 'password2' hashés avec PASSWORD_DEFAULT
INSERT INTO `operateurs` (`nom`, `mot_de_passe`) VALUES 
('Operateur1', '$2y$10$e0MYzXy5J1pEE86w3rGvO.N03yH13nB/FmJ3W8tG/F325/P0aLh3W'),
('Operateur2', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');