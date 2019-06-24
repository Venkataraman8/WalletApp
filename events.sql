use mysql;

CREATE TABLE IF NOT EXISTS events (

	name varchar(20) NOT NULL,
	event varchar(20) NOT NULL,
	total_cost int NOT NULL,
	user_name varchar(20) NOT NULL,
	amount_paid int NOT NULL,
	amount_split float NOT NULL,
	amount_due float NOT NULL
);