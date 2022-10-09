BEGIN TRANSACTION;
CREATE TABLE IF NOT EXISTS "manager" (
	"id"	INTEGER NOT NULL,
	"name"	VARCHAR(255) NOT NULL,
	PRIMARY KEY("id" AUTOINCREMENT)
);
CREATE TABLE IF NOT EXISTS "holiday_request" (
	"id"	INTEGER NOT NULL,
	"author"	INTEGER NOT NULL,
	"status"	VARCHAR(255) NOT NULL,
	"resolved_by"	INTEGER,
	"request_created_at"	DATETIME NOT NULL,
	"vacation_start_date"	DATETIME NOT NULL,
	"vacation_end_date"	DATETIME NOT NULL,
	PRIMARY KEY("id" AUTOINCREMENT)
);
CREATE TABLE IF NOT EXISTS "worker" (
	"id"	INTEGER NOT NULL,
	"name"	VARCHAR(255) NOT NULL,
	"leave_balance"	INTEGER NOT NULL,
	PRIMARY KEY("id" AUTOINCREMENT)
);
INSERT INTO "manager" ("id","name") VALUES (1,'Mrs. Verlie Auer'),
 (2,'Mrs. Mollie Feeney DVM'),
 (3,'Ms. Camila Marvin Sr.');
INSERT INTO "holiday_request" ("id","author","status","resolved_by","request_created_at","vacation_start_date","vacation_end_date") VALUES (1,1,'approved',2,'2022-10-09 01:27:16','2022-10-21 11:40:34','2022-11-05 06:27:48'),
 (2,2,'pending',NULL,'2022-10-09 01:27:16','2022-10-22 03:55:23','2022-10-27 14:09:15'),
 (3,1,'pending',NULL,'2022-10-09 01:27:16','2022-10-20 15:16:00','2022-10-28 11:08:08'),
 (4,1,'rejected',2,'2022-10-09 01:27:16','2022-10-20 12:10:42','2022-11-01 22:04:24'),
 (5,2,'rejected',1,'2022-10-09 01:27:16','2022-10-22 23:20:59','2022-11-01 20:01:40'),
 (6,8,'pending',NULL,'2022-10-09 01:27:16','2022-10-23 09:03:53','2022-11-07 11:55:37'),
 (7,4,'rejected',3,'2022-10-09 01:27:16','2022-10-23 09:27:27','2022-11-09 13:51:42'),
 (8,10,'rejected',3,'2022-10-09 01:27:16','2022-10-21 20:01:17','2022-11-05 22:48:38'),
 (9,2,'rejected',1,'2022-10-09 01:27:16','2022-10-23 14:24:27','2022-11-06 08:41:14'),
 (10,8,'pending',NULL,'2022-10-09 01:27:16','2022-10-23 18:44:49','2022-11-09 22:39:19'),
 (11,7,'pending',NULL,'2022-10-09 01:27:16','2022-10-21 07:15:33','2022-11-06 10:19:30'),
 (12,10,'rejected',1,'2022-10-09 01:27:16','2022-10-21 09:54:31','2022-10-28 07:44:36'),
 (13,6,'approved',3,'2022-10-09 01:27:16','2022-10-22 00:03:20','2022-10-30 00:25:24'),
 (14,10,'pending',NULL,'2022-10-09 01:27:16','2022-10-20 18:37:31','2022-11-08 03:16:52'),
 (15,7,'rejected',1,'2022-10-09 01:27:16','2022-10-24 05:51:58','2022-11-05 11:40:19'),
 (16,2,'pending',NULL,'2022-10-09 01:30:09','2022-10-10 18:15:56','2022-10-13 18:15:56'),
 (17,2,'pending',NULL,'2022-10-09 07:41:40','2022-10-10 18:15:56','2022-10-13 18:15:56'),
 (18,2,'pending',NULL,'2022-10-09 08:13:29','2022-10-10 18:15:56','2022-10-13 18:15:56'),
 (19,2,'pending',NULL,'2022-10-09 08:14:54','2022-10-10 18:15:56','2022-10-13 18:15:56'),
 (20,2,'pending',NULL,'2022-10-09 08:19:43','2022-10-10 18:15:56','2022-10-13 18:15:56');
INSERT INTO "worker" ("id","name","leave_balance") VALUES (1,'Ms. Laurence Hegmann',30),
 (2,'Sydnie Brown III',17),
 (3,'Corine Rice',11),
 (4,'Cynthia Crona',16),
 (5,'Prof. Priscilla Botsford III',10),
 (6,'Brigitte Flatley',19),
 (7,'Dr. Adeline Gislason',18),
 (8,'Justyn Baumbach',14),
 (9,'Hilma Larson',15),
 (10,'Madison Herman',13),
 (11,'Rashid',1);
CREATE INDEX IF NOT EXISTS "status_index" ON "holiday_request" (
	"status"
);
COMMIT;
