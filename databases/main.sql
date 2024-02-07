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
    UNIQUE(name,user)
);

CREATE TABLE banking
(
    id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    user INTEGER NOT NULL REFERENCES user(id),
    UNIQUE(name,user)
);


CREATE TABLE planned_transaction
(
    id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
    type INTEGER NOT NULL REFERENCES transaction_type(id),
    banking INTEGER NOT NULL REFERENCES banking(id),
    transaction_day INTEGER NOT NULL CHECK(transaction_day > 0 AND transaction_day < 32),
    transaction_month INTEGER NOT NULL CHECK(transaction_month > 0 AND transaction_month < 13),
    label VARCHAR(50),
    debit DECIMAL(13,2) NOT NULL DEFAULT 0 CHECK (debit >= 0),
    credit DECIMAL(13,2) NOT NULL DEFAULT 0 CHECK (credit >= 0)
);

CREATE TABLE transactions
(
    id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
    type INTEGER NOT NULL REFERENCES transaction_type(id),
    banking INTEGER NOT NULL REFERENCES banking(id),
    transaction_date DATE NOT NULL DEFAULT current_date,
    label VARCHAR(50),
    debit DECIMAL(13,2) NOT NULL DEFAULT 0 CHECK (debit >= 0),
    credit DECIMAL(13,2) NOT NULL DEFAULT 0 CHECK (credit >= 0)
);