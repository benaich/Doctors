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

-- SHOW ENGINE INNODB STATUS\G;
-- select * from meds;
-- update meds set expdate = '2014-09-01 12:36:49' where name ='OxyContin'
-- update person set gender = 'Masculin' where gender ='garcon';
-- select gender from person;

-- select cnsstype as label, count(*) as data from person group by label; 
-- select count(*) as data from consultation where motiftype = 'CONSULTATION MEDICALE A LA DEMANDE';
-- select gender as label, count(*) as data from person p inner join consultation c on c.person_id = p.id where motiftype = 'CONSULTATION MEDICALE A LA DEMANDE' group by gender;
-- select count(*) as data from person p inner join consultation c on c.person_id = p.id where motiftype = 'CONSULTATION MEDICALE A LA DEMANDE' and resident = true;
-- select count(*) as data from person p inner join consultation c on c.person_id = p.id where motiftype = 'CONSULTATION MEDICALE A LA DEMANDE' and resident = true group by gender;

-- select count(*) as data from consultation where motiftype = 'EXAMEN MEDICAL SYSTEMATIQUE';
-- select gender as label, count(*) as data from person p inner join consultation c on c.person_id = p.id where motiftype = 'EXAMEN MEDICAL SYSTEMATIQUE' group by gender;
-- select count(*) as data from person p inner join consultation c on c.person_id = p.id where motiftype = 'EXAMEN MEDICAL SYSTEMATIQUE' and resident = true;
-- select count(*) as data from person p inner join consultation c on c.person_id = p.id where motiftype = 'EXAMEN MEDICAL SYSTEMATIQUE' and resident = true group by gender;

-- select count(*) as data from test where hasvisualissue = 1; 
-- select gender, name as label, count(*) as data from person p inner join consultation c on c.person_id = p.id where type = 'Consultation specialise' group by name, gender;
-- select count(*) from consultation where chronic = 1;
-- select count(*) from consultation where chronic = 0;

-- select infrastructure as label, count(*) as data from consultation where type = 'Consultation specialise' group by label;

-- update person set resident = 1;

-- select * from meds;
-- select fixedvisualissue as label, count(*) as data from test left join consultation c on c.id = test.consultation_id where hasvisualissue = 1 group by fixedvisualissue;


use benlogement;
SELECT name FROM university;