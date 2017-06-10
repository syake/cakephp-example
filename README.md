# cakephp-example

## テーブルの作成

### users テーブル

```mysql
CREATE TABLE `users` (
    `id` BIGINT(20) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `username` VARCHAR(50) UNIQUE NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `nickname` VARCHAR(255),
    `role` ENUM('owner','author') NOT NULL DEFAULT 'author'
    `status` TINYINT(1) NOT NULL DEFAULT 0,
    `created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `modified` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

__role__
* owner（最高権限）
* author（一般利用者）

__status__
* 0（仮登録）
* 1（本登録）

#### bakeコマンド
```console
$ bin/cake bake all users
```

### posts テーブル

```mysql
CREATE TABLE `posts` (
    `id` BIGINT(20) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `uuid` BIGINT(20) UNSIGNED UNIQUE NOT NULL,
    `status` TINYINT(1) NOT NULL DEFAULT 0,
    `created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `modified` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

__status__
* 0（非公開）
* 1（公開）

#### bakeコマンド

```console
$ bin/cake bake all posts
```

### posts_users テーブル

```mysql
CREATE TABLE `posts_users` (
  `id` BIGINT(20) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `post_id` BIGINT(20) UNSIGNED NOT NULL,
  `user_id` BIGINT(20) UNSIGNED NOT NULL,
  `role` ENUM('admin','author') NOT NULL DEFAULT 'author'
);
```

__role__
* admin（管理者）
* author（投稿者）

#### bakeコマンド

```console
$ bin/cake bake model posts_users
```

### articles テーブル

```mysql
CREATE TABLE `articles` (
    `id` BIGINT(20) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `post_id` BIGINT(20) UNSIGNED NOT NULL,
    `author_id` BIGINT(20) UNSIGNED NOT NULL,
    `status` ENUM('publish','future','draft','pending') NOT NULL DEFAULT 'draft',
    `title` VARCHAR(255),
    `content` LONGTEXT,
    `created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `modified` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

__status__
* publish（公開）
* future（予約投稿）
* draft（下書き）
* pending（保留/レビュー待ち）

#### bakeコマンド

```console
$ bin/cake bake model articles
```

### sections テーブル

```mysql
CREATE TABLE `sections` (
    `section_id` BIGINT(20) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `article_id` BIGINT(20) UNSIGNED NOT NULL,
    `tag` VARCHAR(20) NOT NULL,
    `order` INT(11) NOT NULL DEFAULT 0,
    `title` VARCHAR(255),
    `description` TEXT,
    `image` VARCHAR(255) UNIQUE
);
```

#### bakeコマンド

```console
$ bin/cake bake model sections
```
