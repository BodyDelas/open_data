
create table `user`(
    id int primary key auto_increment,
    login varchar(50),
    hash varchar(32)
);