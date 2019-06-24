use mysql;

CREATE TABLE IF NOT EXISTS debts(

	lender varchar(20) NOT NULL,
	receiver varchar(20) NOT NULL,
	amount float NOT NULL
);