use mysql;

CREATE TABLE IF NOT EXISTS group_name(

		group_id int AUTO_INCREMENT PRIMARY KEY,
		name varchar(20) NOT NULL,
		group_members int NOT NULL
);