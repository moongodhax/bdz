CREATE TABLE Position (
    positionId INT PRIMARY KEY,
    EarthPosition VARCHAR(50),
    SunPosition VARCHAR(50),
    MoonPosition VARCHAR(50)
);

CREATE TABLE Sector (
    id INT PRIMARY KEY,
    coordinates VARCHAR(255),
    lightIntensity DECIMAL(10,2),
    foreignObjects VARCHAR(255),
    numberOfStars INT,
    numberOfUnidentifiedObjects INT,
    numberOfIdentifiedObjects INT,
    notes TEXT,
    date_update DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE Objects (
    objectId INT PRIMARY KEY,
    id INT,
    objectType VARCHAR(50),
    accuracy VARCHAR(255),
    PositionId INT,
    count INT,
    detectedDate DATE,
    detectedTime TIME,
    notes TEXT,
    FOREIGN KEY (PositionId) REFERENCES Position (positionId) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE NaturalObjects (
    objectId INT AUTO_INCREMENT PRIMARY KEY,
    type VARCHAR(255),
    galaxy VARCHAR(255),
    accuracy VARCHAR(255),
    lightFlux VARCHAR(255),
    associatedObjects VARCHAR(255),
    note TEXT
);

CREATE TABLE ObjectPosition (
    id INT PRIMARY KEY,
    sectorId INT,
    objectId INT,
    naturalObjectId INT,
    positionId INT,
    FOREIGN KEY (sectorId) REFERENCES Sector (id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (objectId) REFERENCES Objects (objectId) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (naturalObjectId) REFERENCES NaturalObjects (objectId) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (positionId) REFERENCES Position (positionId) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Создание триггера для таблицы Sector
DELIMITER //
CREATE TRIGGER after_sector_update
    AFTER UPDATE ON Sector
    FOR EACH ROW
BEGIN
    UPDATE Sector SET date_update = CURRENT_TIMESTAMP WHERE id = NEW.id;
END //
DELIMITER ;

-- Создание процедуры для объединения выборки из двух таблиц
DELIMITER //
CREATE PROCEDURE join_tables_data(IN table1_name VARCHAR(50), IN table2_name VARCHAR(50))
BEGIN
    SET @sql = CONCAT('SELECT * FROM ', table1_name, ' NATURAL JOIN ', table2_name);
    PREPARE stmt FROM @sql;
    EXECUTE stmt;
    DEALLOCATE PREPARE stmt;
END //
DELIMITER ;

-- Данные для таблицы Position
INSERT INTO Position (positionId, EarthPosition, SunPosition, MoonPosition) VALUES
    (1, '37.7749° N, 122.4194° W', '150,000,000 km', '384,400 km'),
    (2, '51.5074° N, 0.1278° W', '150,000,000 km', '384,400 km');

-- Данные для таблицы Sector
INSERT INTO Sector (id, coordinates, lightIntensity, foreignObjects, numberOfStars, numberOfUnidentifiedObjects, numberOfIdentifiedObjects, notes) VALUES
    (1, '00:42:44.3 / +41:16:09', 5.28, 'unknown debris', 27, 3, 24, 'High star concentration'),
    (2, '12:51:26.282 / -27:07:41.55', 4.75, 'space dust', 15, 1, 14, 'Medium star concentration');

-- Данные для таблицы Objects
INSERT INTO Objects (objectId, id, objectType, PositionId, accuracy, count, detectedDate, detectedTime, notes) VALUES
    (1, 101, 'asteroid', 1, 99.75, 1, '2023-09-20', '10:15:45', 'Potential threat'),
    (2, 102, 'planet', 2, 97.50, 1, '2023-10-05', '09:00:00', 'stable orbit');

-- Данные для таблицы NaturalObjects
INSERT INTO NaturalObjects (objectId, type, galaxy, accuracy, lightFlux, associatedObjects, note) VALUES
    (1, 'star', 'Milky Way', 99.75, 4.4, 'none', 'Stable star with high brightness'),
    (2, 'black hole', 'Milky Way', 97.50, 9.3, 'several stars nearby', 'High gravitational influence');

-- Данные для таблицы ObjectPosition
INSERT INTO ObjectPosition (id, sectorId, objectId, naturalObjectId, positionId) VALUES
    (1, 1, 1, 1, 1),
    (2, 2, 2, 2, 2);