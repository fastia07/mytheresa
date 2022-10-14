BEGIN TRANSACTION;
CREATE TABLE IF NOT EXISTS "product" (
"id"	INTEGER NOT NULL,
"sku"	VARCHAR(255) NOT NULL,
"name"	VARCHAR(255) NOT NULL,
"category"	VARCHAR(255) NOT NULL,
"cost"	INTEGER NOT NULL,
PRIMARY KEY("id" AUTOINCREMENT)
);
INSERT INTO "product" ("id","sku","name","category","cost") VALUES (1,'000008','Et qui.','women',45000),
(2,'000007','Nam aut ut.','boots',46791),
(3,'000005','Maiores similique qui.','men',27020),
(4,'000003','Soluta consequuntur qui.','men',36444),
(5,'000007','Vero corrupti pariatur.','women',41893),
(6,'000001','Sunt quam.','electronics',81639),
(7,'000006','Aut illum.','electronics',37955),
(8,'000001','Tempore vel.','women',25755),
(9,'000003','Voluptatum similique sed.','kitchen',30195),
(10,'000002','Repellendus consequatur pariatur.','electronics',12794),
(11,'000007','Sequi consequuntur qui.','kitchen',91146),
(12,'000006','Doloribus aut rerum.','kitchen',15318),
(13,'000004','Consequuntur tempora.','electronics',56541),
(14,'000008','Eum unde.','electronics',55288),
(15,'000003','Aperiam quo recusandae.','boots',63079),
(16,'000004','Aliquid molestiae est.','women',89924),
(17,'000005','Adipisci et voluptatem.','electronics',99407),
(18,'000003','Aut aut aliquam.','kitchen',98915),
(19,'000007','Quos vero voluptas.','boots',99227),
(20,'000008','Ipsa autem voluptatum.','kitchen',83814);
CREATE INDEX IF NOT EXISTS "category_index" ON "product" (
"category"
);
CREATE INDEX IF NOT EXISTS "price_index" ON "product" (
"cost"
);
COMMIT;
