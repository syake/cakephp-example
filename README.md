# cakephp-example

## テーブルの作成

### users テーブル

```mysql
CREATE TABLE `users` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `username` VARCHAR(50) UNIQUE,
    `password` VARCHAR(255),
    `nickname` VARCHAR(255),
    `owner` TINYINT(1),
    `invite` TINYINT(1),
    `created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `modified` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

bakeコマンド

```console
$ bin/cake bake all users
```

### posts テーブル

```mysql
CREATE TABLE `posts` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `article_id` INT,
    `uuid` BIGINT UNIQUE,
    `name` VARCHAR(255),
    `status` ENUM('publish','future','draft','pending','private'),
    `created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `modified` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```
bakeコマンド

```console
$ bin/cake bake all posts
```

### posts_users テーブル

```mysql
CREATE TABLE `posts_users` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `post_id` INT,
  `user_id` INT,
  `role` ENUM('admin','author')
);
```

bakeコマンド

```console
$ bin/cake bake model posts_users
```

### articles テーブル

```mysql
CREATE TABLE `articles` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `post_id` INT,
    `title` VARCHAR(255),
    `description` TEXT,
    `status` ENUM('publish','future','draft','pending','private'),
    `created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `modified` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```
bakeコマンド

```console
$ bin/cake bake all articles
```

### sections テーブル

```mysql
CREATE TABLE `sections` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `article_id` INT,
    `title` VARCHAR(255),
    `description` TEXT,
    `image_name` VARCHAR(255) UNIQUE,
    `order` INT(11),
    `status` ENUM('publish','future','draft','pending','private')
);
```
bakeコマンド

```console
$ bin/cake bake model sections
```

