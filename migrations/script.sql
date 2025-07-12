CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    login VARCHAR(100) UNIQUE NOT NULL,
    password TEXT NOT NULL,
    typeUser VARCHAR(50) NOT NULL,
    adresse TEXT,
    numeros VARCHAR(20) NOT NULL,
    numeroCNI VARCHAR(20) UNIQUE,
    photoIdentite TEXT
);

CREATE TABLE compte (
    id SERIAL PRIMARY KEY,
    numero VARCHAR(50) UNIQUE NOT NULL,
    typeCompte VARCHAR(50) NOT NULL,
    solde NUMERIC(15,2) DEFAULT 0.00,
    dateCreation DATE NOT NULL DEFAULT CURRENT_DATE,
    id_user INTEGER NOT NULL,
    FOREIGN KEY (id_user) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE transaction (
    id SERIAL PRIMARY KEY,
    dateTransaction TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    typeTransaction VARCHAR(50) NOT NULL,
    montant NUMERIC(15,2) NOT NULL CHECK (montant >= 0),
    client_id INTEGER NOT NULL,
    compte_id INTEGER NOT NULL,
    FOREIGN KEY (client_id) REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (compte_id) REFERENCES compte(id) ON DELETE CASCADE
);

INSERT INTO transaction (datetransaction, typetransaction, montant, client_id, compte_id, libelle) VALUES
('2025-07-01 09:30:00', 'DEPOT', 200000.00, 5, 4, 'dépôt Orange Money'),
('2025-07-01 11:15:00', 'RETRAIT', 50000.00, 5, 4, 'retrait Orange Money'),
('2025-07-02 08:00:00', 'PAIEMENT', 25000.00, 5, 4, 'paiement woyofal par Orange Money'),
('2025-07-02 14:45:00', 'TRANSFERT', 100000.00, 5, 4, 'transfert vers wave'),
('2025-07-03 10:00:00', 'DEPOT', 300000.00, 5, 4, 'depot orange Money'),
('2025-07-03 16:30:00', 'RETRAIT', 20000.00, 5, 4, 'retrait orange money'),
('2025-07-04 09:00:00', 'PAIEMENT', 15000.00, 5, 4, 'paiement sen eau'),
('2025-07-04 12:20:00', 'DEPOT', 100000.00, 5, 4, 'depot orange money'),
('2025-07-05 08:15:00', 'TRANSFERT', 75000.00, 5, 4, 'achat de credit 500'),
('2025-07-05 18:00:00', 'RETRAIT', 35000.00, 5, 4, 'retrait Orange Money'),
('2025-07-06 11:45:00', 'PAIEMENT', 18000.00, 5, 4, 'paiement fixe sonatel'),
('2025-07-07 13:10:00', 'DEPOT', 120000.00, 5, 4, 'depot orange et moi'),
('2025-07-07 15:00:00', 'TRANSFERT', 50000.00, 5, 4, 'transfert OM');