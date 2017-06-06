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

### projects テーブル

```mysql
CREATE TABLE `projects` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `article_id` INT,
    `uuid` INT UNIQUE,
    `name` VARCHAR(255),
    `created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `modified` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```
bakeコマンド

```console
$ bin/cake bake all projects
```

### projects_users テーブル

```mysql
CREATE TABLE `projects_users` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `project_id` INT,
  `user_id` INT,
  `role` ENUM('admin','author')
);
```

bakeコマンド

```console
$ bin/cake bake model projects_users
```

### articles テーブル

```mysql
CREATE TABLE `articles` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `project_id` INT,
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

