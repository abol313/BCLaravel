
create table users (
	id int primary key auto_increment,
	unique_name varchar(255) unique not null,
	first_name varchar(30),
	last_name varchar(50) not null,
	phone varchar(20) unique not null,
	birth_date date not null,
	status enum('online','offline') not null default 'offline',
	created_at datetime,
	updated_at datetime,
	deleted_at datetime
);

insert into users (`id`,`unique_name`,`first_name`,`last_name`,`phone`,`birth_date`,`status`) values
	(1,'abol','Abolfazl','Rajaee nasab','+989363734021','2004-12-3','offline'),
	(2,'sajjad','Sajjad','Sooji','+989362366021','2004-10-6','offline'),
	(3,'sobhan','Sobhan','Rahamani','+985473716021','2004-10-3','offline'),
	(4,'abol313','Abolfazl','Roobari','+989547716021','2004-10-5','offline'),
	(5,'sara','Sara','Saraii','+989367686021','2004-11-12','offline'),
	(6,'saba','Saba','Sibi','+989367683421','2004-9-14','offline'),
	(7,'sama','Sama','Samayi','+989362386021','2004-4-12','offline'),
	(8,'sima','Sima','Simin','+989363659021','2004-5-10','offline'),
	(9,'saboor','Saboor','Sabri','+989361946021','2004-2-10','offline'),
	(10,'sanaz','Sanaz','Sona','+989363758021','2004-1-11','online'),
	(11,'saba2','Saba','Sedaii','+989361296021','2004-1-24','offline'),
	(12,'sadra2','Sadra','Sadri','+989363654021','2004-11-25','offline'),
	(13,'safa30t','Safa','Safaii','+989363764821','2004-11-21','offline'),
	(14,'soma','Soma','Somaii','+989363775821','2004-10-29','offline'),
	(15,'sana','Sana','Sari','+989363749021','2004-10-20','online'),
	(16,'tari','Tarrah','Risi','+989318546021','2004-7-22','online'),
	(17,'tafa','Taleb','Talabei','+989362239601','2004-7-23','offline'),
	(18,'xing','Xing','Ping','+989363716123','2004-7-24','offline'),
	(19,'sadra','Sadra','Solmaz','+989363716752','2004-7-25','offline'),
	(20,'sajjad2','Sajjad','Sooghi','+989362346021','2004-10-6','offline');

create table todoes (
	id bigint unsigned primary key auto_increment,
	title varchar(100) not null,
	description text,
	due datetime,
	status enum('waiting','accepted','declined','done') default 'waiting'  not null,
	created_at datetime,
	updated_at datetime,
	deleted_at datetime

);

insert into todoes (`id`,`title`,`description`,`due`,`status`) values
	(1,'teeth','go to the dentist','2022-12-10 10:20:45','waiting'),
	(2,'programming','code js for dialog box view','2022-12-10 11:30:25','waiting'),
	(3,'learn','learn about laravel documents until...','2022-12-10 11:40:15','waiting'),
	(4,'linked in','go to linked in and check messages','2022-12-10 12:50:5','waiting'),
	(5,'gap','go to gap and check the messages and events',null,'waiting'),
	(6,'salat','go to and run Salat Zohr','2022-12-10 1:30:12','waiting'),
	(7,'food','cook an egg to fill stomache',null,'waiting'),
	(8,'todo','make another todo list as required','2022-12-10 3:40:53','waiting'),
	(9,'seba','odijoidjdw;odd ;oijd qo id p od','2022-12-10 14:20:24','waiting'),
	(10,'language','learn more abour languages','2022-12-10 15:10:25','waiting');

create table users_todoes (
	id bigint unsigned primary key auto_increment,
	todo bigint unsigned not null,
	commander bigint unsigned not null,
	soldier bigint unsigned not null,
	created_at datetime,
	updated_at datetime,
	deleted_at datetime
);

alter table users_todoes add constraint fk_todo foreign key (todo) references todoes(id);
alter table users_todoes add constraint fk_commander foreign key (commander) references users(id);
alter table users_todoes add constraint fk_soldier foreign key (soldier) references users(id);

insert into users_todoes (`id`,`todo`,`commander`,`soldier`) values
	(1,1,3,5), -- todo teeth 
	(2,1,3,9),
	(3,1,3,12),
	(4,2,9,1), -- todo programming
	(5,2,9,14),
	(6,3,17,20), -- todo learning
	(7,3,17,17),
	(8,3,17,1),
	(9,3,17,16),
	(10,3,17,10),
	(11,4,1,1), -- todo linked in
	(12,5,1,3), -- todo gap
	(13,5,1,11),
	(14,5,1,12),
	(15,5,1,10),
	(16,5,15,3),
	(17,6,1,1), -- todo salat
	(18,7,5,14), -- todo food
	(19,7,5,12),
	(20,7,5,10),
	(21,8,18,3), -- todo todo
	(22,8,18,2),
	(23,8,18,20),
	(24,9,2,4), -- todo seba
	(25,10,2,2),
	(26,10,2,5),
	(27,10,2,7),
	(28,10,2,9),
	(29,10,2,20),
	(30,10,2,12);

