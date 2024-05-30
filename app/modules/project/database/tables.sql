CREATE TABLE `Staff` (
  `StaffID` smallint(6) NOT NULL PRIMARY key AUTO_INCREMENT,
  `StaffName` varchar(150) NOT NULL,
  `StaffCode` varchar(5) DEFAULT NULL,
  `ContactNo` varchar(15) NOT NULL,
  `EmailID` varchar(200) DEFAULT NULL,
  `GenderCode` varchar(5) NOT NULL,
  `DOB` date NOT NULL,
  `ReligionID` tinyint(4) NOT NULL,
  `CasteCode` varchar(10) NOT NULL,
  `CommunityID` tinyint(4) NOT NULL,
  `NationalityID` tinyint(4) NOT NULL,
  `Address` text NOT NULL,
  `Photo` varchar(100) DEFAULT NULL,
  `DesignationID` tinyint(4) NOT NULL,
  `DepartmentID` tinyint(4) DEFAULT NULL,
  `JoinedDate` date DEFAULT NULL,
  `BloodGroup` varchar(5) NOT NULL DEFAULT 'B+',
  `RFIDcardNo` varchar(30) DEFAULT NULL,
  `OfficeID` int(11) NOT NULL,
  `isPhotoUpdateEnable` bit(1) DEFAULT NULL,
  `isRemoved` bit(1) NOT NULL DEFAULT b'0',
  `SessionID` tinyint(4) NOT NULL
) 

-- itpl.project definition

CREATE TABLE `Project` (
  `ProjectID` smallint(6) NOT NULL AUTO_INCREMENT,
  `ProjectTitle` varchar(50) NOT NULL,
  `ProjectDescription` text NOT NULL,
  `ManagerID` smallint(6) NOT NULL,
  `ClientID` smallint(6) DEFAULT NULL,
  `WorkorderNumber` varchar(50) DEFAULT NULL,
  `WorkorderDate` date DEFAULT NULL,
  `WorkorderFileName` varchar(20) DEFAULT NULL,
  `ProjectCoordinatorStaffID` smallint(6) DEFAULT NULL,
  `ClientCoordinatorName` varchar(100) DEFAULT NULL,
  `ClientCoordinatorContactNo` varchar(20) DEFAULT NULL,
  `ProjectBudget` float DEFAULT NULL,
  `StartDate` date DEFAULT NULL,
  `DueDate` date DEFAULT NULL,
  `LastUpdated` date DEFAULT NULL,
  `workOrderFileID` int(100) DEFAULT NULL,
  `attachmentsID` int(100) DEFAULT NULL,
  PRIMARY KEY (`ProjectID`),
  KEY `ManagerID` (`ManagerID`),
  KEY `ProjectCoordinatorStaffID` (`ProjectCoordinatorStaffID`),
  CONSTRAINT `project_ibfk_1` FOREIGN KEY (`ManagerID`) REFERENCES `staff` (`StaffID`),
  CONSTRAINT `project_ibfk_2` FOREIGN KEY (`ProjectCoordinatorStaffID`) REFERENCES `staff` (`StaffID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- itpl.task definition

CREATE TABLE `Task` (
  `TaskId` smallint(6) NOT NULL AUTO_INCREMENT,
  `ProjectModuleID` smallint(6) NOT NULL,
  `TaskTitle` varchar(100) NOT NULL,
  `TaskDescription` varchar(300) NOT NULL,
  `AssignedToStaffIDs` varchar(300) DEFAULT NULL,
  `AssignedFromStaffID` smallint(6) DEFAULT NULL,
  `CreatedAt` datetime NOT NULL DEFAULT current_timestamp(),
  `StartDate` datetime DEFAULT NULL,
  `DueDate` datetime DEFAULT NULL,
  `TaskStatus` tinyint(1) DEFAULT 0,
  `LastUpdated` datetime DEFAULT current_timestamp(),
  `Report` blob DEFAULT NULL,
  `Priority` smallint(6) DEFAULT 0,
  `DocumentID` int(11) DEFAULT NULL,
  PRIMARY KEY (`TaskId`),
  KEY `ProjectModuleID` (`ProjectModuleID`),
  KEY `AssignedFromStaffID` (`AssignedFromStaffID`),
  CONSTRAINT `task_ibfk_1` FOREIGN KEY (`ProjectModuleID`) REFERENCES `projectmodule` (`ProjectModuleID`),
  CONSTRAINT `task_ibfk_2` FOREIGN KEY (`AssignedFromStaffID`) REFERENCES `staff` (`StaffID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- itpl.projectmodule definition

CREATE TABLE `Projectmodule` (
  `ProjectModuleID` smallint(6) NOT NULL AUTO_INCREMENT,
  `ModuleName` varchar(255) NOT NULL,
  `ModuleDescription` text DEFAULT NULL,
  `ModulePriority` smallint(6) DEFAULT NULL,
  `ProjectID` smallint(6) NOT NULL,
  `ReportManagerStaffID` smallint(6) DEFAULT NULL,
  `Planning` tinyint(1) DEFAULT 0,
  `Designing` tinyint(1) DEFAULT 0,
  `Development` tinyint(1) DEFAULT 0,
  `Testing` tinyint(1) DEFAULT 0,
  `Deployment` tinyint(1) DEFAULT 0,
  `isCompleted` tinyint(1) NOT NULL DEFAULT 0,
  `CompletionDate` date DEFAULT NULL,
  `UpdatedDate` date DEFAULT NULL,
  PRIMARY KEY (`ProjectModuleID`),
  KEY `ProjectID` (`ProjectID`),
  KEY `ReportManagerStaffID` (`ReportManagerStaffID`),
  CONSTRAINT `projectmodule_ibfk_1` FOREIGN KEY (`ProjectID`) REFERENCES `project` (`ProjectID`),
  CONSTRAINT `projectmodule_ibfk_2` FOREIGN KEY (`ReportManagerStaffID`) REFERENCES `staff` (`StaffID`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- itpl.projectteammembers definition

CREATE TABLE `Projectteammembers` (
  `ProjectTeamMemberID` smallint(6) NOT NULL AUTO_INCREMENT,
  `StaffID` smallint(6) NOT NULL,
  `ProjectModuleID` smallint(6) NOT NULL,
  `AddedDate` datetime NOT NULL DEFAULT current_timestamp(),
  `isRemoved` tinyint(1) DEFAULT NULL,
  `RemovedRemarks` varchar(300) DEFAULT NULL,
  `RemovedDate` datetime DEFAULT NULL,
  `isActive` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`ProjectTeamMemberID`),
  KEY `StaffID` (`StaffID`),
  KEY `ProjectModuleID` (`ProjectModuleID`),
  CONSTRAINT `projectteammembers_ibfk_1` FOREIGN KEY (`StaffID`) REFERENCES `staff` (`StaffID`),
  CONSTRAINT `projectteammembers_ibfk_2` FOREIGN KEY (`ProjectModuleID`) REFERENCES `projectmodule` (`ProjectModuleID`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- itpl.setting_designation definition

CREATE TABLE `Setting_designation` (
  `DesignationID` int(11) NOT NULL AUTO_INCREMENT,
  `DesignationName` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`DesignationID`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- itpl.projectmeetings definition

CREATE TABLE `Projectmeetings` (
  `MeetingID` smallint(6) NOT NULL AUTO_INCREMENT,
  `ProjectID` smallint(6) NOT NULL,
  `MeetingDescription` varchar(200) NOT NULL,
  `MeetingDate` date DEFAULT NULL,
  `AttendeeStaffIDs` varchar(255) DEFAULT NULL,
  `MeetingDocumentID` int(100) DEFAULT NULL,
  PRIMARY KEY (`MeetingID`),
  KEY `ProjectID` (`ProjectID`),
  CONSTRAINT `projectmeetings_ibfk_1` FOREIGN KEY (`ProjectID`) REFERENCES `project` (`ProjectID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



-- itpl.projectdocuments definition

CREATE TABLE `Projectdocuments` (
  `DocumentID` int(11) NOT NULL AUTO_INCREMENT,
  `DocumentPath` varchar(100) DEFAULT NULL,
  `DocumentTitle` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`DocumentID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- itpl.meetingsdocuments definition

CREATE TABLE `Meetingsdocuments` (
  `DocumentID` int(11) NOT NULL AUTO_INCREMENT,
  `DocumentPath` varchar(100) DEFAULT NULL,
  `DocumentTitle` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`DocumentID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- itpl.taskdocuments definition

CREATE TABLE `Taskdocuments` (
  `DocumentID` int(11) NOT NULL AUTO_INCREMENT,
  `DocumentPath` varchar(100) DEFAULT NULL,
  `DocumentTitle` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`DocumentID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- itpl.clients definition

CREATE TABLE `Clients` (
  `ClientID` int(11) NOT NULL,
  `ClientName` varchar(200) NOT NULL,
  `TelephoneNo` varchar(15) NOT NULL,
  `MobileNo` varchar(15) NOT NULL,
  `Fax` varchar(15) DEFAULT NULL,
  `ContactPersonName` varchar(200) NOT NULL,
  `ContactPersonMobileNo` varchar(15) NOT NULL,
  `ContactPersonDesignation` varchar(100) DEFAULT NULL,
  `StateID` tinyint(4) NOT NULL,
  `DistrictID` smallint(6) NOT NULL,
  `CityName` varchar(100) NOT NULL,
  `PinCode` varchar(10) NOT NULL,
  `Landmark` text NOT NULL,
  `Logo` varchar(100) DEFAULT NULL,
  `MaxUsers` varchar(10) DEFAULT NULL,
  `CreatedDateTime` timestamp NOT NULL DEFAULT current_timestamp(),
  `CreatedBy` int(11) NOT NULL,
  `isActive` bit(1) NOT NULL DEFAULT b'1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;