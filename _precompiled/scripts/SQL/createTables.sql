CREATE TABLE users(
	ID int PRIMARY KEY AUTO_INCREMENT,
	kennitala varchar(255) UNIQUE,
	name varchar(255),
	address varchar(255),
	schoolID int REFERENCES schools(ID),
	email varchar(255),
	phone varchar(255),
	time TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	positionID int REFERENCES positions(ID),
	password varchar(255),
	salt varchar(255)
);
CREATE TABLE schools(
	ID int PRIMARY KEY AUTO_INCREMENT,
	name varchar(255),
	city varchar(255),
	address varchar(255),
	postCode char(3),
	type varchar(255),
	headmasterID int REFERENCES users(ID),
	partnerID int REFERENCES users(ID)
);
CREATE TABLE uploads(
	ID int PRIMARY KEY AUTO_INCREMENT,
	name varchar(255),
	location varchar(255),
	description longtext,
	length varchar(255),
	size varchar(255),
	format varchar(255),
	time TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	userID int REFERENCES users(ID)
);
CREATE TABLE comments(
	ID int PRIMARY KEY AUTO_INCREMENT,
	content longtext,
	userID int REFERENCES users(ID),
	subjects varchar(50),
	time TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	uploadID int REFERENCES uploads(ID)
);
CREATE TABLE positions(
	ID int PRIMARY KEY AUTO_INCREMENT,
	name varchar(255)
);
CREATE TABLE votes(
	ID int PRIMARY KEY AUTO_INCREMENT,
	uploadID int REFERENCES uploads(ID),
	time TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
-- These are tables that contain only different types of tags
CREATE TABLE grades(
	ID int PRIMARY KEY AUTO_INCREMENT,
	name varchar(255)
);
CREATE TABLE subjects(
	ID int PRIMARY KEY AUTO_INCREMENT,
	name varchar(255)
);
CREATE TABLE tags(
	ID int PRIMARY KEY AUTO_INCREMENT,
	name varchar(255),
	userID int REFERENCES users(ID)
);
-- These are tables that connect two other tables together
CREATE TABLE uploadTags(
	uploadID int REFERENCES uploads(ID),
	tagID int REFERENCES tags(ID)
);
CREATE TABLE uploadGrades(
	uploadID int REFERENCES uploads(ID),
	gradeID int REFERENCES grades(ID)
);
CREATE TABLE uploadSubjects(
	uploadID int REFERENCES uploads(ID),
	subjectID int REFERENCES subjects(ID)
);
-- Tables for teacher tags
CREATE TABLE userGrades(
	userID int REFERENCES users(ID),
	gradeID int REFERENCES grades(ID)
);
CREATE TABLE userSubjects(
	userID int REFERENCES users(ID),
	subjectID int REFERENCES subjects(ID)
);
-- Table for connecting tags and comments
CREATE TABLE commentTags(
	commentID int REFERENCES comments(ID),
	tagID int REFERENCES tags(ID)
);