use mysql;

CREATE TABLE IF NOT EXISTS users(
		user_id int AUTO_INCREMENT PRIMARY KEY,
		user_name varchar(20) NOT  NULL,
		pass_word varchar(80) NOT  NULL,
		first_name varchar(10) NOT  NULL,
		last_name varchar(10) NOT  NULL,
		email varchar(20) NOT  NULL,
		phone_no varchar(10) NOT  NULL,
		address varchar(50) NOT  NULL
    	
		);