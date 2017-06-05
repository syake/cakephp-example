# cakephp-example

## users

### step1. MYSQL に users テーブルを用意する

```mysql
CREATE TABLE `users` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `username` VARCHAR(50),
    `password` VARCHAR(255),
    `role` ENUM('admin','author','invalid'),
    `nickname` VARCHAR(255),
    `created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `modified` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

### step2. bakeコマンドでMVC生成

```console
$ bin/cake bake all users
```

## projects

### step1. MYSQL に projects テーブルを用意する

```mysql
CREATE TABLE `projects` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `uid` INT UNIQUE,
    `name` VARCHAR(255),
    `created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `modified` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

### step2. bakeコマンドでMVC生成

```console
$ bin/cake bake all projects
```
