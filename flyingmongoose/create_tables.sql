CREATE DATABASE IF NOT EXISTS clinic;
USE clinic;

CREATE TABLE IF NOT EXISTS patient (
	`patient_id` int auto_increment PRIMARY KEY,
	`ramq_id` varchar(12) NOT NULL,
	`last_name` varchar(50) NOT NULL,
	`first_name` varchar(50) NOT NULL,
	`phone_num_home` varchar(50) NOT NULL,
	`phone_num_emergency` varchar(50) NOT NULL,
	`primary_physician` varchar(50) NOT NULL,
	`existing_conditions` varchar(50) NOT NULL,
	`medication1` varchar(50) NOT NULL,
	`medication2` varchar(50) NOT NULL,
	`medication3` varchar(50) NOT NULL
);

CREATE TABLE IF NOT EXISTS visit (
	`visit_id` int auto_increment PRIMARY KEY,
	`patient_id` int NOT NULL,
	`time_of_registration` timestamp NOT NULL default 0,
	`time_of_triage` timestamp NOT NULL default 0,
	`time_of_examination` timestamp NOT NULL default 0,
	`code` int(1) NOT NULL default 0,
	`primary_complaint` varchar(255) NOT NULL default '',
	`symptom1` varchar(255) NOT NULL default '',
	`symptom2` varchar(255) NOT NULL default '',
	CONSTRAINT FOREIGN KEY (`patient_id`) REFERENCES `patient`(`patient_id`)
);

CREATE TABLE IF NOT EXISTS queue (
	`queue_id` int auto_increment PRIMARY KEY,
	`queue_name` varchar(8) NOT NULL,
	`queue_content` longtext default NULL
);

CREATE TABLE IF NOT EXISTS system (
	`current_position` int(1) NOT NULL
);

CREATE TABLE IF NOT EXISTS user (
	`user_id` int auto_increment PRIMARY KEY,
	`user_name` varchar(50) NOT NULL,
	`hashed_password` varchar(255) NOT NULL,
	`invalid_login_counter` int default 0,
	`reception_priv` boolean default 0,
	`triage_priv` boolean default 0,
	`nurse_priv` boolean default 0
);

CREATE TABLE IF NOT EXISTS medication (
	`medication_id` int auto_increment PRIMARY KEY,
	`medication_name` varchar(50) NOT NULL
);

INSERT INTO queue(`queue_name`) VALUES ('unsorted');
INSERT INTO queue(`queue_name`) VALUES ('1');
INSERT INTO queue(`queue_name`) VALUES ('2');
INSERT INTO queue(`queue_name`) VALUES ('3');
INSERT INTO queue(`queue_name`) VALUES ('4');
INSERT INTO queue(`queue_name`) VALUES ('5');

INSERT INTO medication(`medication_name`) VALUES ('NO MEDICATION LISTED.');
INSERT INTO medication(`medication_name`) VALUES ('BENZAMYCIN');
INSERT INTO medication(`medication_name`) VALUES ('ACCUTANE');
INSERT INTO medication(`medication_name`) VALUES ('TAMIFLU');
INSERT INTO medication(`medication_name`) VALUES ('KENALOG');
INSERT INTO medication(`medication_name`) VALUES ('ACETAMINOPHEN');
INSERT INTO medication(`medication_name`) VALUES ('ADVIL');
INSERT INTO medication(`medication_name`) VALUES ('LEVAQUIN');
INSERT INTO medication(`medication_name`) VALUES ('VIOXX');
INSERT INTO medication(`medication_name`) VALUES ('CELEBREX');
INSERT INTO medication(`medication_name`) VALUES ('DOXYCYCLINE');
INSERT INTO medication(`medication_name`) VALUES ('ZYPREXA');
INSERT INTO medication(`medication_name`) VALUES ('PAXIL');
INSERT INTO medication(`medication_name`) VALUES ('NICODERM');
INSERT INTO medication(`medication_name`) VALUES ('LORAZEPAM');
INSERT INTO medication(`medication_name`) VALUES ('ELIDEL');
INSERT INTO medication(`medication_name`) VALUES ('PEGASYS');
INSERT INTO medication(`medication_name`) VALUES ('CLIKSTAR');
INSERT INTO medication(`medication_name`) VALUES ('LEVAQUIN');
INSERT INTO medication(`medication_name`) VALUES ('ADVAIR DISKUS');
INSERT INTO medication(`medication_name`) VALUES ('NEXIUM');