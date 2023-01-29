CREATE TABLE 'users'(
  'id' int(10) NOT NULL AUTO_INCREMENT,
  'username' varchar(30) NOT NULL UNIQUE,
  'first_name' varchar(20) NOT NULL,
  'last_name' varchar(30) NOT NULL,
  'email' varchar(255) NOT NULL UNIQUE,
  'mobile_no' varchar(60) DEFAULT NULL,
  'password' varchar(255) NOT NULL,
  PRIMARY KEY (id)
);
