CREATE USER vlad WITH PASSWORD 'password';
CREATE DATABASE tennis_db;
GRANT ALL PRIVILEGES ON DATABASE tennis_db TO vlad;

\connect tennis_db;

CREATE TABLE players
(
    ID   SERIAL PRIMARY KEY UNIQUE,
    Name VARCHAR(100) UNIQUE
);

INSERT INTO players (name)
VALUES ('John'),
       ('Alex'),
       ('Dasha'),
       ('Katya'),
       ('Mark'),
       ('Oleg'),
       ('Masha');


CREATE TABLE matches
(
    ID        SERIAL PRIMARY KEY UNIQUE,
    Player1ID INTEGER REFERENCES players (ID),
    Player2ID INTEGER REFERENCES players (ID),
    WinnerID  INTEGER REFERENCES players (ID)
);
INSERT INTO matches (Player1ID, Player2ID, WinnerID)
VALUES (1, 2, 1),
       (1, 3, 1),
       (1, 4, 1),
       (1, 5, 5),
       (1, 6, 6),
       (4, 2, 4),
       (2, 3, 2),
       (3, 4, 3),
       (4, 5, 5),
       (5, 6, 5),
       (2, 5, 2),
       (3, 7, 7),
       (4, 6, 4),
       (5, 1, 5),
       (6, 2, 2),
       (3, 5, 3),
       (5, 7, 7);
GRANT ALL PRIVILEGES ON ALL TABLES IN SCHEMA public TO vlad;