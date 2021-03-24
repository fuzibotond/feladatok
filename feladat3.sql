#1.feladat
select  user.name, count(user_car.car) as how_many from user join user_car on user.id = user_car.user 
where user.name like 'Kis%'
group by user_car.user
having count(user_car.car)=0;

#2.feladat
select  user.name, count(user_car.car) as how_many from user join user_car on user.id = user_car.user 
group by user_car.user
having count(user_car.car)>=2;

#3.feladat
select  user.name as Owner,  group_concat(car.brand, car.model ) as Cars  from user join user_car on user.id = user_car.user 
join car on car.id = user_car.car
group by user_car.user
having count(user_car.car)>=2;

#4.feladat
ALTER TABLE user ADD COLUMN nem varchar(10) AFTER name;
ALTER TABLE user ADD COLUMN szemelyi_igazolvany_szam varchar(10) AFTER nem;
#5.feladat
insert into car(id, brand, model)
values(default, 'volkswagen', 'arteon');

#5.feladat
update car
set model = 'Fiesta'
where model like 'Focus';


#SET SQL_SAFE_UPDATES = 0;
#6.feladat
insert into user_car(user, car)
	select id, (select id from car where car.brand like 'volkswagen' and car.model like 'arteon') from user 
	where user.id <10 
	and (user.name like '%o%'
	or user.name like '%r%');
    
#7.feladat
create unique index ind_uc on user_car(user, car);
