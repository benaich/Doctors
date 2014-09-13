-- use doctors;
-- -- show tables;
-- -- select * from config;

-- #situation epidemiologique
-- -- select name as label, count(*) as data from consultation group by name;

-- -- select distinct city from person;

-- -- select * from consultation;

-- select count(*) as label from (select id from consultation c where c.type != 'Consultation generale' group by c.person_id)A;
-- select * from consultation;
-- select id from consultation c where c.type != 'Consultation generale' group by c.person_id;

SHOW ENGINE INNODB STATUS\G;