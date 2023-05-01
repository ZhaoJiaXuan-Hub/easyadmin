-- MySQL dump 10.13  Distrib 5.7.42, for Linux (x86_64)
--
-- Host: localhost    Database: easyadmin
-- ------------------------------------------------------
-- Server version	5.7.42

/*!40101 SET @OLD_CHARACTER_SET_CLIENT = @@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS = @@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION = @@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE = @@TIME_ZONE */;
/*!40103 SET TIME_ZONE = '+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS = @@UNIQUE_CHECKS, UNIQUE_CHECKS = 0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS = @@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS = 0 */;
/*!40101 SET @OLD_SQL_MODE = @@SQL_MODE, SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES = @@SQL_NOTES, SQL_NOTES = 0 */;

--
-- Table structure for table `app_account`
--

DROP TABLE IF EXISTS `app_account`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `app_account`
(
    `id`         int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
    `nickname`   varchar(255) DEFAULT NULL COMMENT '昵称',
    `username`   varchar(255) DEFAULT NULL COMMENT '用户名',
    `phone`      varchar(50)  DEFAULT NULL COMMENT '手机号',
    `created_at` datetime     DEFAULT NULL COMMENT '创建时间',
    `updated_at` datetime     DEFAULT NULL COMMENT '更新时间',
    `avatar`     text COMMENT '头像地址',
    `deleted_at` datetime     DEFAULT NULL COMMENT '删除时间',
    `status`     int(11)      DEFAULT NULL COMMENT '状态',
    `password`   varchar(255) DEFAULT NULL COMMENT '密码',
    `salting`    varchar(255) DEFAULT NULL COMMENT '密码盐',
    `login_at`   datetime     DEFAULT NULL COMMENT '登录时间',
    PRIMARY KEY (`id`),
    UNIQUE KEY `id` (`id`)
) ENGINE = InnoDB
  AUTO_INCREMENT = 2
  DEFAULT CHARSET = utf8 COMMENT ='应用用户表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `app_account`
--

LOCK TABLES `app_account` WRITE;
/*!40000 ALTER TABLE `app_account`
    DISABLE KEYS */;
INSERT INTO `app_account`
VALUES (1, '测试用户', 'ocink', '18613708269', '2023-04-21 13:10:46', '2023-04-28 11:28:32', NULL, NULL, 0,
        'e69ab2583b2f4818900876c1b59720ee', '4f0b3150b52248f6b6ba3ac4708a38ef', NULL);
/*!40000 ALTER TABLE `app_account`
    ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `app_order`
--

DROP TABLE IF EXISTS `app_order`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `app_order`
(
    `id`           int(11)       NOT NULL AUTO_INCREMENT COMMENT '主键',
    `out_trade_no` varchar(255) CHARACTER SET latin1 DEFAULT NULL COMMENT '订单号',
    `trade_no`     varchar(255) CHARACTER SET latin1 DEFAULT NULL COMMENT '交易号',
    `title`        varchar(255)                      DEFAULT NULL COMMENT '支付订单',
    `money`        decimal(9, 2) NOT NULL,
    `code`         varchar(55) CHARACTER SET latin1  DEFAULT NULL COMMENT '插件CODE',
    `refund_no`    varchar(255) CHARACTER SET latin1 DEFAULT NULL COMMENT '退款交易号',
    `status`       int(11)                           DEFAULT '0' COMMENT '订单状态',
    `client`       varchar(55) CHARACTER SET latin1  DEFAULT NULL COMMENT '客户端',
    `updated_at`   datetime                          DEFAULT NULL COMMENT '最后更新时间',
    `created_at`   datetime                          DEFAULT NULL COMMENT '创建时间',
    `deleted_at`   datetime                          DEFAULT NULL COMMENT '删除时间',
    PRIMARY KEY (`id`),
    UNIQUE KEY `id` (`id`)
) ENGINE = InnoDB
  AUTO_INCREMENT = 3
  DEFAULT CHARSET = utf8 COMMENT ='应用订单表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `app_order`
--

LOCK TABLES `app_order` WRITE;
/*!40000 ALTER TABLE `app_order`
    DISABLE KEYS */;
INSERT INTO `app_order`
VALUES (2, '2023042798062', NULL, '测试商品', 0.01, 'Alipay', NULL, 0, 'page', '2023-04-27 17:22:34',
        '2023-04-27 17:22:34', NULL);
/*!40000 ALTER TABLE `app_order`
    ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `system_account`
--

DROP TABLE IF EXISTS `system_account`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `system_account`
(
    `id`         int(11) NOT NULL AUTO_INCREMENT COMMENT '用户ID',
    `username`   varchar(255)     DEFAULT NULL COMMENT '用户名',
    `password`   varchar(255)     DEFAULT NULL COMMENT '密码',
    `salting`    varchar(255)     DEFAULT NULL COMMENT '密码盐',
    `email`      varchar(255)     DEFAULT NULL COMMENT '邮箱地址',
    `phone`      varchar(255)     DEFAULT NULL COMMENT '手机号',
    `nickname`   varchar(255)     DEFAULT NULL COMMENT '昵称',
    `login_at`   datetime         DEFAULT NULL COMMENT '登录时间',
    `tenant_id`  int(11)          DEFAULT NULL COMMENT '创建者ID',
    `status`     int(11) NOT NULL DEFAULT '0' COMMENT '状态',
    `created_at` datetime         DEFAULT NULL COMMENT '创建时间',
    `updated_at` datetime         DEFAULT NULL COMMENT '更新时间',
    `avatar`     text COMMENT '头像地址',
    `deleted_at` datetime         DEFAULT NULL COMMENT '删除时间',
    PRIMARY KEY (`id`),
    UNIQUE KEY `id` (`id`)
) ENGINE = InnoDB
  AUTO_INCREMENT = 15
  DEFAULT CHARSET = utf8 COMMENT ='系统用户表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `system_account`
--

LOCK TABLES `system_account` WRITE;
/*!40000 ALTER TABLE `system_account`
    DISABLE KEYS */;
INSERT INTO `system_account`
VALUES (1, 'admin', '8692fc4515b033ef763c0f396d321e25', 'e38e178f9185b040d250bf55f11da90c', 'admin@ocink.com',
        '18888888888', '管理员', '2023-04-29 07:46:21', NULL, 0, '2023-03-09 06:25:06', '2023-04-29 07:46:21', NULL,
        NULL),
       (13, 'ocink', '00c552f5cd8c83a6b340546846717ef6', 'b16cfd2ce47355fdbe0a4a4b96e8fce4', '2687409344@qq.com',
        '17777777777', 'ocink', '2023-03-15 14:33:06', NULL, 0, '2023-03-15 14:29:33', '2023-03-21 05:42:53', NULL,
        NULL),
       (14, 'inkccc', 'ffe9d93b9774804d83250f860fc99e33', '2e9b0bd65376fc82dc757a1e0ca28a1d', 'inkccc@qq.com',
        '16666666666', 'inkccc', NULL, NULL, 0, '2023-03-15 14:55:25', '2023-03-24 09:38:03', NULL, NULL);
/*!40000 ALTER TABLE `system_account`
    ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `system_account_role`
--

DROP TABLE IF EXISTS `system_account_role`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `system_account_role`
(
    `id`         int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
    `user_id`    int(11)  DEFAULT NULL COMMENT '用户ID',
    `role_id`    int(11)  DEFAULT NULL COMMENT '角色ID',
    `created_at` datetime DEFAULT NULL COMMENT '创建时间',
    PRIMARY KEY (`id`),
    UNIQUE KEY `id` (`id`)
) ENGINE = InnoDB
  AUTO_INCREMENT = 13
  DEFAULT CHARSET = utf8 COMMENT ='系统用户角色关联表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `system_account_role`
--

LOCK TABLES `system_account_role` WRITE;
/*!40000 ALTER TABLE `system_account_role`
    DISABLE KEYS */;
INSERT INTO `system_account_role`
VALUES (3, 1, 1, NULL),
       (11, 13, 1, NULL),
       (12, 14, 1, NULL);
/*!40000 ALTER TABLE `system_account_role`
    ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `system_log_login`
--

DROP TABLE IF EXISTS `system_log_login`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `system_log_login`
(
    `id`           int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
    `username`     varchar(255) DEFAULT NULL COMMENT '用户名',
    `ip`           varchar(255) DEFAULT NULL COMMENT 'IP地址',
    `status`       int(11)      DEFAULT NULL COMMENT '登录状态',
    `des`          text COMMENT '备注',
    `created_time` datetime     DEFAULT NULL COMMENT '登录时间',
    PRIMARY KEY (`id`),
    UNIQUE KEY `id` (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `system_log_login`
--

LOCK TABLES `system_log_login` WRITE;
/*!40000 ALTER TABLE `system_log_login`
    DISABLE KEYS */;
/*!40000 ALTER TABLE `system_log_login`
    ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `system_log_operate`
--

DROP TABLE IF EXISTS `system_log_operate`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `system_log_operate`
(
    `id`         int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
    `model`      text COMMENT '操作模块',
    `status`     int(11)      DEFAULT NULL COMMENT '操作状态',
    `error`      text COMMENT '错误信息',
    `router`     text COMMENT '访问路由',
    `ip`         varchar(55)  DEFAULT NULL COMMENT '操作IP',
    `account`    int(11)      DEFAULT NULL COMMENT '登录用户ID',
    `name`       varchar(255) DEFAULT NULL COMMENT '业务名称',
    `created_at` datetime     DEFAULT NULL COMMENT '创建时间',
    PRIMARY KEY (`id`),
    UNIQUE KEY `id` (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8 COMMENT ='操作日志';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `system_log_operate`
--

LOCK TABLES `system_log_operate` WRITE;
/*!40000 ALTER TABLE `system_log_operate`
    DISABLE KEYS */;
/*!40000 ALTER TABLE `system_log_operate`
    ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `system_options`
--

DROP TABLE IF EXISTS `system_options`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `system_options`
(
    `key`         text COMMENT '标识',
    `type`        varchar(255) DEFAULT NULL COMMENT '表单类型',
    `title`       text COMMENT '键值标题',
    `placeholder` text COMMENT '配置项说明',
    `value`       text COMMENT '配置项值',
    `options`     json         DEFAULT NULL COMMENT '配置项数据',
    `updated_at`  datetime     DEFAULT NULL COMMENT '更新时间',
    `created_at`  datetime     DEFAULT NULL COMMENT '创建时间'
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8 COMMENT ='系统配置项';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `system_options`
--

LOCK TABLES `system_options` WRITE;
/*!40000 ALTER TABLE `system_options`
    DISABLE KEYS */;
INSERT INTO `system_options`
VALUES ('app_name', 'text', '应用名称', '请输入应用名称', 'EasyAdmin', NULL, '2023-04-03 09:46:37',
        '2023-04-02 22:27:15'),
       ('app_type', 'select', '应用类型', '请选择应用类型', '1', '[
         {
           \"title\": \"网站应用\",
           \"value\": \"1\"
         },
         {
           \"title\": \"微信小程序应用\",
           \"value\": \"2\"
         }
       ]', '2023-04-03 09:46:37', '2023-04-03 16:47:47'),
       ('app_des', 'textarea', '应用描述', '请输入应用描述', '', NULL,
        '2023-04-03 09:46:37', '2023-04-03 16:58:08');
/*!40000 ALTER TABLE `system_options`
    ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `system_plugins`
--

DROP TABLE IF EXISTS `system_plugins`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `system_plugins`
(
    `id`         int(11) NOT NULL AUTO_INCREMENT COMMENT '插件ID',
    `code`       text COMMENT '插件标识',
    `status`     int(11)  DEFAULT '0' COMMENT '开启状态',
    `options`    json     DEFAULT NULL COMMENT '插件配置项',
    `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
    `created_at` datetime DEFAULT NULL COMMENT '创建时间',
    `type`       int(11)  DEFAULT '0' COMMENT '插件类型 0 支付插件 1 工具插件',
    PRIMARY KEY (`id`),
    UNIQUE KEY `id` (`id`)
) ENGINE = InnoDB
  AUTO_INCREMENT = 2
  DEFAULT CHARSET = utf8 COMMENT ='插件表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `system_plugins`
--

LOCK TABLES `system_plugins` WRITE;
/*!40000 ALTER TABLE `system_plugins`
    DISABLE KEYS */;
/*!40000 ALTER TABLE `system_plugins`
    ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `system_role`
--

DROP TABLE IF EXISTS `system_role`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `system_role`
(
    `id`         int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
    `name`       varchar(55)  DEFAULT NULL COMMENT '权限名称',
    `code`       varchar(55)  DEFAULT NULL COMMENT '权限标识',
    `des`        varchar(255) DEFAULT NULL COMMENT '权限说明',
    `deleted_at` datetime     DEFAULT NULL COMMENT '删除时间',
    `updated_at` datetime     DEFAULT NULL COMMENT '更新时间',
    `created_at` datetime     DEFAULT NULL COMMENT '创建时间',
    PRIMARY KEY (`id`),
    UNIQUE KEY `id` (`id`)
) ENGINE = InnoDB
  AUTO_INCREMENT = 2
  DEFAULT CHARSET = utf8 COMMENT ='系统角色表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `system_role`
--

LOCK TABLES `system_role` WRITE;
/*!40000 ALTER TABLE `system_role`
    DISABLE KEYS */;
INSERT INTO `system_role`
VALUES (1, '管理员', 'admin', '系统管理员', NULL, '2023-03-12 23:32:21', '2023-03-12 23:32:23');
/*!40000 ALTER TABLE `system_role`
    ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `system_role_router`
--

DROP TABLE IF EXISTS `system_role_router`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `system_role_router`
(
    `id`         int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
    `role_id`    int(11)  DEFAULT NULL COMMENT '角色ID',
    `router_id`  int(11)  DEFAULT NULL,
    `created_at` datetime DEFAULT NULL COMMENT '创建时间',
    PRIMARY KEY (`id`),
    UNIQUE KEY `id` (`id`)
) ENGINE = InnoDB
  AUTO_INCREMENT = 62
  DEFAULT CHARSET = utf8 COMMENT ='系统角色权限关联表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `system_role_router`
--

LOCK TABLES `system_role_router` WRITE;
/*!40000 ALTER TABLE `system_role_router`
    DISABLE KEYS */;
INSERT INTO `system_role_router`
VALUES (1, 1, 1, '2023-03-13 00:40:34'),
       (2, 1, 2, '2023-03-13 00:41:42'),
       (3, 1, 3, '2023-03-13 14:47:00'),
       (4, 1, 4, '2023-03-13 15:05:12'),
       (5, 1, 5, '2023-03-13 15:05:18'),
       (6, 1, 6, '2023-03-15 14:21:00'),
       (8, 1, 7, '2023-03-21 23:17:01'),
       (13, 1, 10, NULL),
       (14, 1, 11, NULL),
       (15, 1, 12, NULL),
       (16, 1, 13, NULL),
       (17, 1, 14, NULL),
       (18, 1, 15, NULL),
       (19, 1, 16, NULL),
       (20, 1, 17, NULL),
       (21, 1, 18, NULL),
       (22, 1, 19, NULL),
       (23, 1, 20, NULL),
       (24, 1, 21, NULL),
       (25, 1, 22, NULL),
       (26, 1, 23, NULL),
       (27, 1, 24, NULL),
       (28, 1, 25, NULL),
       (29, 1, 26, NULL),
       (30, 1, 27, NULL),
       (31, 1, 28, NULL),
       (32, 1, 29, NULL),
       (33, 1, 30, NULL),
       (34, 1, 31, NULL),
       (35, 1, 32, NULL),
       (36, 1, 33, NULL),
       (43, 1, 40, NULL),
       (44, 1, 41, NULL),
       (45, 1, 42, NULL),
       (46, 1, 43, NULL),
       (47, 1, 44, NULL),
       (48, 1, 45, NULL),
       (49, 1, 46, NULL),
       (50, 1, 47, NULL),
       (51, 1, 48, NULL),
       (52, 1, 49, NULL),
       (53, 1, 50, NULL),
       (54, 1, 51, NULL),
       (55, 1, 52, NULL),
       (56, 1, 53, NULL),
       (57, 1, 54, NULL),
       (58, 1, 55, NULL),
       (59, 1, 56, NULL),
       (60, 1, 57, NULL),
       (61, 1, 58, NULL);
/*!40000 ALTER TABLE `system_role_router`
    ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `system_router`
--

DROP TABLE IF EXISTS `system_router`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `system_router`
(
    `id`          int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
    `title`       varchar(55) DEFAULT NULL COMMENT '权限名称',
    `icon`        varchar(55) DEFAULT NULL COMMENT '菜单图标',
    `path`        text COMMENT '路由地址',
    `component`   text COMMENT '组件地址',
    `authority`   text COMMENT '权限标识',
    `sort`        int(32)     DEFAULT NULL COMMENT '排序',
    `hide`        int(11)     DEFAULT '0' COMMENT '可见状态',
    `router_type` int(11)     DEFAULT '0' COMMENT '权限类型',
    `open_type`   int(11)     DEFAULT NULL COMMENT '打开方式',
    `target`      varchar(25) DEFAULT NULL COMMENT '打开方式',
    `parent_id`   int(32)     DEFAULT NULL COMMENT '父级菜单ID',
    `updated_at`  datetime    DEFAULT NULL COMMENT '更新时间',
    `created_at`  datetime    DEFAULT NULL COMMENT '创建时间',
    `deleted_at`  datetime    DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `id` (`id`)
) ENGINE = InnoDB
  AUTO_INCREMENT = 59
  DEFAULT CHARSET = utf8 COMMENT ='系统菜单和权限表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `system_router`
--

LOCK TABLES `system_router` WRITE;
/*!40000 ALTER TABLE `system_router`
    DISABLE KEYS */;
INSERT INTO `system_router`
VALUES (1, '控制面板', 'home-outlined', '/dashboard', NULL, NULL, 0, 0, 0, 0, '_self', NULL, '2023-03-12 21:48:56',
        '2023-03-12 21:48:53', NULL),
       (2, '工作台', 'desktop-outlined', '/dashboard/workplace', '/dashboard/workplace', NULL, 0, 0, 1, 0, '_self', 1,
        '2023-03-22 12:15:41', '2023-03-13 01:13:33', NULL),
       (3, '分析页', 'bar-chart-outlined', '/dashboard/analysis', '/dashboard/analysis', NULL, 1, 0, 1, 0, '_self', 1,
        '2023-03-21 15:15:15', '2023-03-13 14:46:23', NULL),
       (4, '系统管理', 'control-outlined', '/system', NULL, NULL, 1, 0, 0, 0, '_self', 0, '2023-03-30 06:35:26',
        '2023-03-13 15:03:35', NULL),
       (5, '用户管理', 'team-outlined', '/system/account', '/system/account', NULL, 0, 0, 1, 0, '_self', 4,
        '2023-03-21 15:15:47', '2023-03-13 15:04:43', NULL),
       (6, '菜单管理', 'bars-outlined', '/system/menu', '/system/menu', NULL, 1, 0, 1, 0, '_self', 4,
        '2023-03-21 15:14:54', '2023-03-21 16:02:12', NULL),
       (7, '角色管理', 'idcard-outlined', '/system/role', '/system/role', '', 2, 0, 1, 0, NULL, 4,
        '2023-03-21 15:17:56', '2023-03-21 14:43:29', NULL),
       (10, '分页列表', '', '', '', 'system:account:page', 0, 0, 2, 0, NULL, 5, '2023-03-21 17:31:11',
        '2023-03-21 17:31:11', NULL),
       (11, '字段查重', '', '', '', 'system:account:existence', 1, 0, 2, 0, NULL, 5, '2023-03-22 11:49:09',
        '2023-03-22 11:49:09', NULL),
       (12, '添加数据', '', '', '', 'system:account:create', 2, 0, 2, 0, NULL, 5, '2023-03-22 11:50:04',
        '2023-03-22 11:50:04', NULL),
       (13, '更新数据', '', '', '', 'system:account:edit', 3, 0, 2, 0, NULL, 5, '2023-03-22 11:50:51',
        '2023-03-22 11:50:51', NULL),
       (14, '删除数据', '', '', '', 'system:account:del', 4, 0, 2, 0, NULL, 5, '2023-03-22 11:51:48',
        '2023-03-22 11:51:48', NULL),
       (15, '批量删除', '', '', '', 'system:account:batch', 5, 0, 2, 0, NULL, 5, '2023-03-22 11:52:48',
        '2023-03-22 11:52:48', NULL),
       (16, '更改状态', '', '', '', 'system:account:status', 6, 0, 2, 0, NULL, 5, '2023-03-22 11:53:12',
        '2023-03-22 11:53:12', NULL),
       (17, '获取列表', '', '', '', 'system:router:getList', 0, 0, 2, 0, NULL, 6, '2023-03-24 09:19:16',
        '2023-03-24 09:19:16', NULL),
       (18, '添加数据', '', '', '', 'system:router:create', 1, 0, 2, 0, NULL, 6, '2023-03-24 09:20:24',
        '2023-03-24 09:20:11', NULL),
       (19, '编辑数据', '', '', '', 'system:router:edit', 2, 0, 2, 0, NULL, 6, '2023-03-24 09:21:39',
        '2023-03-24 09:21:39', NULL),
       (20, '删除数据', '', '', '', 'system:router:del', 3, 0, 2, 0, NULL, 6, '2023-03-24 09:22:21',
        '2023-03-24 09:22:21', NULL),
       (21, '批量删除', '', '', '', 'system:router:batch', 4, 0, 2, 0, NULL, 6, '2023-03-24 09:23:02',
        '2023-03-24 09:23:02', NULL),
       (22, '获取列表', '', '', '', 'system:router:getList', 0, 0, 2, 0, NULL, 7, '2023-03-24 09:26:28',
        '2023-03-24 09:26:28', NULL),
       (23, '分页列表', '', '', '', 'system:router:page', 1, 0, 2, 0, NULL, 7, '2023-03-24 09:27:08',
        '2023-03-24 09:26:52', NULL),
       (24, '添加数据', '', '', '', 'system:router:create', 2, 0, 2, 0, NULL, 7, '2023-03-24 09:27:29',
        '2023-03-24 09:27:29', NULL),
       (25, '编辑数据', '', '', '', 'system:router:edit', 3, 0, 2, 0, NULL, 7, '2023-03-24 09:27:52',
        '2023-03-24 09:27:52', NULL),
       (26, '删除数据', '', '', '', 'system:router:del', 4, 0, 2, 0, NULL, 7, '2023-03-24 09:29:02',
        '2023-03-24 09:29:02', NULL),
       (27, '权限列表', '', '', '', 'system:router:listRouters', 5, 0, 2, 0, NULL, 7, '2023-03-24 09:30:47',
        '2023-03-24 09:30:10', NULL),
       (28, '更新权限', '', '', '', 'system:router:updateRoleMenus', 6, 0, 2, 0, NULL, 7, '2023-03-24 09:30:39',
        '2023-03-24 09:30:39', NULL),
       (29, '批量删除', '', '', '', 'system:router:batch', 7, 0, 2, 0, NULL, 7, '2023-03-24 09:31:06',
        '2023-03-24 09:31:06', NULL),
       (30, '应用管理', 'appstore-outlined', '/app', '', '', 2, 0, 0, 0, NULL, 0, '2023-03-29 15:55:54',
        '2023-03-29 15:55:54', NULL),
       (31, '应用配置', 'setting-outlined', '/app/option', '/app/option', '', 0, 0, 1, 0, NULL, 30,
        '2023-03-29 15:57:40', '2023-03-29 15:57:18', NULL),
       (32, '支付配置', 'sketch-outlined', '/app/pay', '/app/pay', '', 1, 0, 1, 0, NULL, 30, '2023-03-29 16:17:18',
        '2023-03-29 15:59:35', NULL),
       (33, '用户管理', 'team-outlined', '/app/account', '/app/account', '', 2, 0, 1, 0, NULL, 30,
        '2023-03-29 16:00:46', '2023-03-29 16:00:29', NULL),
       (34, '文件管理', 'folder-outlined', '/app/file', '/app/file', '', 3, 0, 1, 0, NULL, 30, '2023-03-30 14:28:04',
        '2023-03-29 16:01:39', '2023-03-30 14:28:04'),
       (35, '系统设置', 'setting-outlined', '/system/setting', '/system/setting', '', 3, 0, 1, 0, NULL, 0,
        '2023-03-30 14:25:39', '2023-03-29 16:09:24', '2023-03-30 14:25:39'),
       (36, '操作日志', 'file-search-outlined', '/log/system/operate', '/log/system/operate', '', 3, 1, 1, 0, NULL, 4,
        '2023-03-30 14:25:15', '2023-03-29 16:09:48', '2023-03-30 14:25:15'),
       (37, '登录日志', 'calendar-outlined', '/log/system/login', '/log/system/login', '', 4, 1, 1, 0, NULL, 4,
        '2023-03-30 14:25:17', '2023-03-29 16:11:29', '2023-03-30 14:25:17'),
       (38, '插件管理', 'appstore-add-outlined', '/plugins', '/plugins', '', 4, 0, 1, 0, NULL, 0, '2023-03-30 14:28:54',
        '2023-03-29 16:13:02', '2023-03-30 14:28:54'),
       (39, '登录日志', 'calendar-outlined', '/log/app/login', '/log/app/login', '', 4, 1, 1, 0, NULL, 30,
        '2023-03-30 14:24:57', '2023-03-29 16:13:43', '2023-03-30 14:24:57'),
       (40, '支付订单', 'file-search-outlined', '/app/order', '/app/order', '', 5, 0, 1, 0, NULL, 30,
        '2023-04-26 08:36:50', '2023-03-29 16:15:20', NULL),
       (41, '获取列表', '', '', '', 'system:options:getList', 0, 0, 2, 0, NULL, 31, '2023-04-28 10:40:50',
        '2023-04-28 10:40:50', NULL),
       (42, '保存配置', '', '', '', 'system:options:save', 1, 0, 2, 0, NULL, 31, '2023-04-28 10:41:15',
        '2023-04-28 10:41:15', NULL),
       (43, '获取列表', '', '', '', 'app:plugins:payment:getList', 0, 0, 2, 0, NULL, 32, '2023-04-28 10:45:54',
        '2023-04-28 10:44:12', NULL),
       (44, '获取信息', '', '', '', 'app:plugins:payment:getInfo', 1, 0, 2, 0, NULL, 32, '2023-04-28 10:45:59',
        '2023-04-28 10:44:31', NULL),
       (45, '初始化', '', '', '', 'app:plugins:payment:load', 2, 0, 2, 0, NULL, 32, '2023-04-28 10:46:03',
        '2023-04-28 10:44:43', NULL),
       (46, '配置插件', '', '', '', 'app:plugins:payment:edit', 3, 0, 2, 0, NULL, 32, '2023-04-28 10:46:08',
        '2023-04-28 10:45:02', NULL),
       (47, '变更状态', '', '', '', 'app:plugins:status', 4, 0, 2, 0, NULL, 32, '2023-04-28 10:46:12',
        '2023-04-28 10:45:20', NULL),
       (48, '分页列表', '', '', '', 'app:account:page', 0, 0, 2, 0, NULL, 33, '2023-04-28 11:23:47',
        '2023-04-28 11:23:47', NULL),
       (49, '字段查重', '', '', '', 'app:account:existence', 1, 0, 2, 0, NULL, 33, '2023-04-28 11:24:05',
        '2023-04-28 11:24:05', NULL),
       (50, '添加数据', '', '', '', 'app:account:create', 2, 0, 2, 0, NULL, 33, '2023-04-28 11:24:36',
        '2023-04-28 11:24:23', NULL),
       (51, '编辑数据', '', '', '', 'app:account:edit', 3, 0, 2, 0, NULL, 33, '2023-04-28 11:25:14',
        '2023-04-28 11:24:51', NULL),
       (52, '删除数据', '', '', '', 'app:account:del', 4, 0, 2, 0, NULL, 33, '2023-04-28 11:25:10',
        '2023-04-28 11:25:10', NULL),
       (53, '批量删除', '', '', '', 'app:account:batch', 5, 0, 2, 0, NULL, 33, '2023-04-28 11:25:29',
        '2023-04-28 11:25:29', NULL),
       (54, '更改状态', '', '', '', 'app:account:status', 6, 0, 2, 0, NULL, 33, '2023-04-28 11:25:46',
        '2023-04-28 11:25:46', NULL),
       (55, '重置密码', '', '', '', 'app:account:password', 7, 0, 2, 0, NULL, 33, '2023-04-28 11:26:05',
        '2023-04-28 11:26:05', NULL),
       (56, '分页列表', '', '', '', 'app:order:page', 0, 0, 2, 0, NULL, 40, '2023-04-28 11:27:45',
        '2023-04-28 11:27:45', NULL),
       (57, '删除数据', '', '', '', 'app:order:del', 1, 0, 2, 0, NULL, 40, '2023-04-28 11:28:00', '2023-04-28 11:28:00',
        NULL),
       (58, '批量删除', '', '', '', 'app:order:batch', 2, 0, 2, 0, NULL, 40, '2023-04-28 11:28:13',
        '2023-04-28 11:28:13', NULL);
/*!40000 ALTER TABLE `system_router`
    ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE = @OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE = @OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS = @OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS = @OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT = @OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS = @OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION = @OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES = @OLD_SQL_NOTES */;

-- Dump completed on 2023-05-01  7:11:05
