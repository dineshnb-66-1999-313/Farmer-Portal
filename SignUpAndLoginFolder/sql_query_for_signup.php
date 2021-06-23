<?php

$sign_up_farmer_information ="CREATE TABLE IF NOT EXISTS sign_up_farmer_information(
    ID int(50) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	first_name varchar(150) NOT NULL,
	last_name varchar(150) NOT NULL,
	E_mail_id varchar(150) NOT NULL,
    User_Type varchar(120) NOT NULL,
    date_of_birth date NOT NULL,
    phone_number bigint(15) NOT NULL,
    P_N_status varchar(150) NOT NULL,
    profile_picture varchar(150) NOT NULL,
    land_document varchar(150) NOT NULL,
    aadhar_document varchar(150) NOT NULL,
    document_status varchar(150) NOT NULL,
    cre_password varchar(150) NOT NULL,
    date_time_of_sign_up datetime NOT NULL
)";

$sign_up_user ="CREATE TABLE IF NOT EXISTS sign_up_user_information(
    ID int(50) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	full_name varchar(150) NOT NULL,
	E_mail_id varchar(150) NOT NULL,
    User_Type varchar(120) NOT NULL,
    user_gender varchar(120) NOT NULL,
    date_of_birth date NOT NULL,
    phone_number bigint(15) NOT NULL,
    cre_password varchar(150) NOT NULL,
    date_time_of_sign_up datetime NOT NULL
)";
$profile_image_farmer = "CREATE TABLE IF NOT EXISTS user_profile_information(
	ID int(50) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    E_mail_id varchar(150) NOT NULL,
    Profile_Status varchar(150) NOT NULL,
    Default_profile varchar(200) NOT NULL,
    Actual_profile_image varchar(200) NOT NULL,
    date_of_profile_update_info datetime NOT NULL
)";
$addcropimage = "CREATE TABLE IF NOT EXISTS add_crop_image_table(
    ID int(50) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    E_mail_id varchar(120) NOT NULL,
	crop_name varchar(150) NOT NULL,
    crop_status varchar(150) NOT NULL,
    crop_category varchar(120) NOT NULL,
	crop_quantity int(120) NOT NULL,
    crop_price int(120) NOT NULL,
   	crop_image varchar(200) NOT NULL
)";

$crop_catogory = "CREATE TABLE crop_category (
    ID int(50) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    category varchar(120) NOT NULL
)";

$crop_category_item = "CREATE TABLE crop_category_items(
	ID int(50) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    Name_Of_Crop varchar(100) NOT NUll,
    Crop_Category int(20) NOT NULL
)";
$userAndFarmeraddress = "CREATE TABLE IF NOT EXISTS farmer_user_address_table(
    ID int(50) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	first_name varchar(150) NOT NULL,
	last_name varchar(150) NOT NULL,
	full_name varchar(150) NOT NULL,
	E_mail_id varchar(150) NOT NULL,
    default_address varchar(120) NOT NULL,
    User_Type varchar(120) NOT NULL,
    phone_number bigint(15) NOT NULL,
    pin_code int(120) NOT NULL,
    country varchar(120) NOT NULL,
    user_state varchar(120) NOT NULL,
    user_city varchar(120) NOT NULL,
    village varchar(120) NOT NULL,
    house_number varchar(120) NOT NULL,
    landmark varchar(120) NOT NULL
)";

$order_crop = "CREATE TABLE purchased_crop_item (
	ID int(120) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    order_id bigint(120) NOT NULL,
    Crop_id int(120) NOT NULL,
    crop_name varchar(120) NOT NULL,
    crop_category varchar(120) NOT NULL,
    crop_image varchar(120) NOT NULL,
    crop_price int(120) NOT NULL,
    total_quantity int(120) NOT NULL,
    selected_quantity int(120) NOT NULL,
    total_price int(120) NOT NULL,
    purchaser_name varchar(120) NOT NULL,
    purchaser_phone_number Bigint(120) NOT NULL,
    farmer_E_mail_id varchar(120) NOT NULL,
    purchaser_E_mail_id varchar(120) NOT NULL,
    purchaser_profile_image varchar(300) NOT NULL,
    date_of_order date NOT NULL
)";

$farmer_user_favourites = "CREATE TABLE farmer_user_favourite (
	ID int(120) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    Crop_id int(120) NOT NULL,
    E_mail_id varchar(120) NOT NULL,
    first_name varchar(120) NOT NULL,
    last_name varchar(120) NOT NULL
)";

$commentscrop = "CREATE TABLE crop_comments(
	ID int(120) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    Crop_id int(120) NOT NULL,
    order_id Bigint(120) NOT NULL,
    purchaser_name varchar(120) NOT NULL,
    crop_rating varchar(120) NOT NULL,
    comments varchar(120) NOT NULL,
    date_of_comments datetime NOT NULL
)";
?>