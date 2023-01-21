
create table `user`(
    id int primary key auto_increment,
    login varchar(50),
    hash varchar(32)
);

create table `my_area`(
    id int primary key auto_increment,
    user_id int,
    area_id int,
    foreign key (user_id) references user (id),
    foreign key (area_id) references open_data (id)
)