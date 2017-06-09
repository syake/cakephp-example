# cakephp-example

## テーブルの作成

### users テーブル

```mysql
CREATE TABLE `users` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
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
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `uuid` BIGINT UNSIGNED UNIQUE,
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
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `post_id` BIGINT UNSIGNED,
  `user_id` BIGINT UNSIGNED,
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
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `post_id` BIGINT UNSIGNED,
    `active` TINYINT(1),
    `title` VARCHAR(255),
    `content` LONGTEXT,
    `created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `modified` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```
bakeコマンド

```console
$ bin/cake bake model articles
```

### sections テーブル

```mysql
CREATE TABLE `sections` (
    `section_id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `article_id` BIGINT UNSIGNED,
    `tag` VARCHAR(20),
    `order` INT(11),
    `title` VARCHAR(255),
    `description` TEXT,
    `image` VARCHAR(255) UNIQUE
);
```
bakeコマンド

```console
$ bin/cake bake model sections
```
