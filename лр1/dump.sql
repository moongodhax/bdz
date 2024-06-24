CREATE TABLE Individuals (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(255),
    last_name VARCHAR(255),
    middle_name VARCHAR(255),
    passport VARCHAR(20),
    tax_id VARCHAR(20),
    pension_id VARCHAR(20),
    driver_license VARCHAR(20),
    additional_docs TEXT,
    notes TEXT
);

CREATE TABLE Credits (
    id INT AUTO_INCREMENT PRIMARY KEY,
    individual_id INT,
    amount DECIMAL(18, 2),
    interest_rate DECIMAL(5, 2),
    term INT,
    conditions TEXT,
    notes TEXT,
    FOREIGN KEY (individual_id) REFERENCES Individuals(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE CompanyCredits (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT,
    individual_id INT,
    amount DECIMAL(18, 2),
    term INT,
    interest_rate DECIMAL(5, 2),
    conditions TEXT,
    notes TEXT,
    FOREIGN KEY (individual_id) REFERENCES Individuals(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE Borrowers (
    borrower_id INT AUTO_INCREMENT PRIMARY KEY,
    tax_id VARCHAR(20),
    entity_type BOOLEAN,
    address VARCHAR(255),
    total_amount DECIMAL(18, 2),
    conditions TEXT,
    legal_notes TEXT,
    contracts_list TEXT
);

-- Добавление внешнего ключа в таблицу Credits для связи с Borrowers
ALTER TABLE Credits ADD COLUMN borrower_id INT;
ALTER TABLE Credits ADD FOREIGN KEY (borrower_id) REFERENCES Borrowers(borrower_id) ON DELETE CASCADE ON UPDATE CASCADE;

-- Заполнение таблицы Individuals данными
INSERT INTO Individuals (first_name, last_name, middle_name, passport, tax_id, pension_id, driver_license, additional_docs, notes)
VALUES ('Иван', 'Иванов', 'Иванович', '1234567890', '0987654321', '111222333', 'А111ББ222777', 'Справка о доходах', 'Примечания по клиенту 1'),
       ('Петр', 'Петров', 'Петрович', '0987654321', '2468135790', '444555666', 'А777ББ888999', 'Копия паспорта', 'Примечания по клиенту 2');

-- Заполнение таблицы Credits данными
INSERT INTO Credits (individual_id, amount, interest_rate, term, conditions, notes)
VALUES (1, 10000.00, 10.5, 12, 'Условия кредита №1', 'Примечания кредита 1'),
       (2, 15000.00, 8.2, 24, 'Условия кредита №2', 'Примечания кредита 2');

-- Заполнение таблицы CompanyCredits данными
INSERT INTO CompanyCredits (company_id, individual_id, amount, term, interest_rate, conditions, notes)
VALUES (1, 1, 20000.00, 18, 12.0, 'Условия кредита в компании №1', 'Примечания кредита в компании 1'),
       (2, 2, 25000.00, 36, 9.5, 'Условия кредита в компании №2', 'Примечания кредита в компании 2');

-- Заполнение таблицы Borrowers данными
INSERT INTO Borrowers (tax_id, entity_type, address, total_amount, conditions, legal_notes, contracts_list)
VALUES ('0987654321', 1, 'г. Москва, ул. Ленина, д. 10', 5000000.00, 'Условия для заемщика №1', 'Юридические замечания', 'Список контрактов заемщика 1');
