CREATE TABLE user
(
    id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    mail VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(50) NOT NULL
);

CREATE TABLE transaction_type
(
    id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    user INTEGER NOT NULL REFERENCES user(id),
    type INTEGER NOT NULL CHECK(type = -1 OR type = 1 ),
    daily BOOLEAN NOT NULL DEFAULT FALSE,
    UNIQUE(name,user)
);

CREATE TABLE banking
(
    id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    user INTEGER NOT NULL REFERENCES user(id),
    UNIQUE(name,user)
);

CREATE TABLE transaction
(
    id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
    type INTEGER NOT NULL REFERENCES transaction_type(id),
    banking INTEGER NOT NULL REFERENCES banking(id),
    user INTEGER NOT NULL REFERENCES user(id),
    transaction_date DATE NOT NULL DEFAULT current_date,
    label VARCHAR(50),
    amount DECIMAL(13,2) NOT NULL CHECK (amount > 0)
);

CREATE OR REPLACE VIEW v_transaction AS SELECT t.id,tp.name type_name,tp.id type_id,b.name banking_name,b.id banking_id,t.user,t.transaction_date,t.label,t.amount*tp.type amount FROM transaction t JOIN transaction_type tp ON tp.id = t.type JOIN banking b ON b.id = t.banking;

CREATE TABLE planned_transaction
(
    id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
    type INTEGER NOT NULL REFERENCES transaction_type(id),
    banking INTEGER NOT NULL REFERENCES banking(id),
    transaction_day INTEGER NOT NULL CHECK(transaction_day > 0 AND transaction_day < 32),
    transaction_month INTEGER NOT NULL CHECK(transaction_month > 0 AND transaction_month < 13),
    label VARCHAR(50),
    amount DECIMAL(13,2) NOT NULL CHECK (amount > 0)
);