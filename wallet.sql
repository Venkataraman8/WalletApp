USE mysql;
CREATE TABLE IF NOT EXISTS wallet(
	user_id int Not NULL,
	type varchar(10) NOT NULL,
    date_time datetime NOT NULL,
    title varchar(10) NOT NULL,
    description varchar(100) NOT NULL,
    amount int NOT NULL
	);