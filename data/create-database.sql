CREATE DATABASE internship

-- set default engine to InnoDB
use internship

SET storage_engine=INNODB;

-- create tables

CREATE TABLE IF NOT EXISTS `student` (
  `studentId` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `grad_year` int(11) NOT NULL,
  `advisor` varchar(100) NOT NULL,
  PRIMARY KEY (`studentId`),
  UNIQUE KEY `unique_student` (`first_name`,`last_name`,`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Table constraints: first,last name and email' AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `company` (
  `companyId` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `website` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `state` varchar(50) NOT NULL,
  PRIMARY KEY (`companyId`),
  UNIQUE KEY `name` (`name`,`website`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Table constraints: name, website' AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `supervisor` (
  `supervisorId` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `companyId` int(11) NOT NULL COMMENT 'forgien key to company table',
  PRIMARY KEY (`supervisorId`),
  UNIQUE KEY `email` (`email`,`companyId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Table constraints: email' AUTO_INCREMENT=1 ;

ALTER TABLE `supervisor` ADD CONSTRAINT `supervisor_fk` FOREIGN KEY (`companyId`) REFERENCES company(`companyId`);

CREATE TABLE IF NOT EXISTS `position` (
  `positionId` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `term` varchar(100) NOT NULL,
  `year` int(4) NOT NULL,
  `is_paid` tinyint(1) NOT NULL,
  `notes` text NOT NULL,
  `est_hours_week` int(11) NOT NULL,
  `studentId` int(11) NOT NULL,
  `companyId` int(11) NOT NULL,
  `supervisorId` int(11) NOT NULL,
  PRIMARY KEY (`positionId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

ALTER TABLE `position` ADD CONSTRAINT `supervisor_student_fk` FOREIGN KEY (`studentId`) REFERENCES student(`studentId`);
ALTER TABLE `position` ADD CONSTRAINT `supervisor_company_fk` FOREIGN KEY (`companyId`) REFERENCES company(`companyId`);
ALTER TABLE `position` ADD CONSTRAINT `supervisor_supervisor_fk` FOREIGN KEY (`supervisorId`) REFERENCES supervisor(`supervisorId`);

-- create view to view a specific position, joining all the tables together (http://skyontech.com/blog/create-MySQL-view-in-phpMyAdmin)
SELECT s.first_name AS StudentFirstName, s.last_name AS StudentLastName, s.email AS StudentEmail, 
	   s.grad_year AS StudentGradYear, s.advisor AS StudentAdvisor,
	   c.name AS CompanyName, 
	   sv.first_name AS SVFirstName, sv.last_name AS SVLastName, sv.email AS SVEmail, sv.phone AS SVPhone,
	   p.title AS PositionTitle, p.term AS PositionTerm, p.year as PositionYear, p.is_paid AS PositionIsPaid,
	   p.notes AS PositionNotes, p.est_hours_week AS PositionHourEst
FROM position p
INNER JOIN student s ON p.studentId = s.studentId
INNER JOIN company c ON p.companyId = c.companyId
INNER JOIN supervisor sv ON p.supervisorId = sv.supervisorId

-- create a view to view a supervisor and join the company table
SELECT s.supervisorId AS SupervisorId, s.first_name AS SupervisorFirstName, s.last_name AS SupervisorLastName, s.email AS SupervisorEmail, s.phone AS SupervisorPhone, 
       c.companyId AS CompanyId, c.name AS CompanyName
FROM supervisor s
INNER JOIN company c ON s.companyId = c.companyId