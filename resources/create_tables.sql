CREATE TABLE Team (
  name  VARCHAR(255)  PRIMARY KEY,
  city    VARCHAR(255),
  num_win INTEGER,
  num_loss INTEGER
);

CREATE TABLE GamePlay(
  team1 VARCHAR(255) NOT NULL,
  team2 VARCHAR(255) NOT NULL,
  game_time DATETIME,
  game_location VARCHAR(255),
  team1_score INTEGER,
  team2_score INTEGER,
  PRIMARY KEY(game_time, game_location),
  FOREIGN KEY(team1) REFERENCES Team (name)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  FOREIGN KEY(team2) REFERENCES Team (name)
    ON DELETE CASCADE
    ON UPDATE CASCADE
);

CREATE TABLE PlayerHas (
  name   VARCHAR(255) PRIMARY KEY,
  nationality VARCHAR(255),
  age INTEGER,
  jersey_Num INTEGER,
  teamName VARCHAR(255) NOT NULL,
  FOREIGN KEY (teamName) REFERENCES Team (name)
);

CREATE TABLE Career (
  player_name VARCHAR(255),
  MVP_Num INTEGER,
  AllStar_Num INTEGER,
  draft VARCHAR(255) PRIMARY KEY,
  UNIQUE (player_name),
  FOREIGN KEY (player_name) REFERENCES PlayerHas (name)
  ON DELETE CASCADE
  ON UPDATE CASCADE
);


CREATE TABLE Coach (
  coachName VARCHAR(255),
  college    VARCHAR(255),
  isAssistant  CHAR(1),
  teamName    VARCHAR(255),
  winNumber   INTEGER,
  loseNumber  INTEGER,
  PRIMARY KEY (coachName),
  FOREIGN KEY (teamName) REFERENCES Team (name)
  ON DELETE CASCADE
  ON UPDATE CASCADE
);

CREATE TABLE Attends (
  player_name VARCHAR(255),
  game_time DATETIME,
  game_location VARCHAR(255),
  points INTEGER,
  rebounds INTEGER,
  assists INTEGER,
  blocks INTEGER,
  steals INTEGER,
  PRIMARY KEY (player_name, game_time, game_location),
  FOREIGN KEY (player_name) REFERENCES PlayerHas (name)
  ON DELETE CASCADE
  ON UPDATE CASCADE,
  FOREIGN KEY (game_time, game_location) REFERENCES GamePlay (game_time, game_location)
  ON DELETE CASCADE
  ON UPDATE CASCADE
);

CREATE TABLE Users (
  userID VARCHAR(255) PRIMARY KEY,
  isAdmin CHAR(1),
  password VARCHAR(255)
# CHECK (CHAR_LENGTH(password) >= 8))
);

CREATE TABLE User_likeTeam(
  UserID  VARCHAR(255),
  team_name VARCHAR(255),
  PRIMARY KEY (UserID, team_name),
  FOREIGN KEY (UserID) REFERENCES Users (userID)
  ON DELETE CASCADE
  ON UPDATE CASCADE,
  FOREIGN KEY (team_name) REFERENCES Team (name)
  ON DELETE CASCADE
  ON UPDATE CASCADE
);

CREATE TABLE User_likePlayer(
  UserID  VARCHAR(255),
  player_name VARCHAR(255),
  PRIMARY KEY (UserID, player_name),
  FOREIGN KEY (UserID) REFERENCES Users (userID)
  ON DELETE CASCADE
  ON UPDATE CASCADE,
  FOREIGN KEY (player_name) REFERENCES PlayerHas (name)
  ON DELETE CASCADE
  ON UPDATE CASCADE
);
