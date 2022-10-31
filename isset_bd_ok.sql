/*
 Navicat Premium Data Transfer

 Source Server         : localhost_3306
 Source Server Type    : MySQL
 Source Server Version : 50736
 Source Host           : localhost:3306
 Source Schema         : isset_bd

 Target Server Type    : MySQL
 Target Server Version : 50736
 File Encoding         : 65001

 Date: 31/10/2022 08:27:17
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for agents
-- ----------------------------
DROP TABLE IF EXISTS `agents`;
CREATE TABLE `agents`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NULL DEFAULT NULL,
  `matricule` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `fonction` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `users_email_unique`(`email`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 20 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of agents
-- ----------------------------
INSERT INTO `agents` VALUES (12, 11, 'MKER', 'KOUASSI', 'KARINE', NULL, 'agent1@gmail.com', '2021-12-14 05:39:25', '2021-12-15 07:40:02');
INSERT INTO `agents` VALUES (13, 11, 'MVGT', 'PENAH', 'POLAI EMILIE', NULL, 'agent2@gmail.com', '2021-12-14 05:51:12', '2021-12-15 07:35:05');
INSERT INTO `agents` VALUES (14, 11, 'kjhjkhjk', 'DOUMBIA', 'YAYA', NULL, 'agent3@gmail.com', '2021-12-14 05:51:52', '2021-12-15 07:39:49');
INSERT INTO `agents` VALUES (15, 11, 'zzerr', 'BEKOIN', 'VICTORINE', NULL, 'kssks@gmail.com', '2021-12-15 07:36:25', '2021-12-15 07:36:25');
INSERT INTO `agents` VALUES (16, 11, 'khdjhksdf', 'YAO', 'ALOU HENRI', NULL, 'mskdlsmdkm@gmail.com', '2021-12-15 07:37:24', '2021-12-15 07:37:24');
INSERT INTO `agents` VALUES (17, 11, 'dskhfksfhskj', 'KOUADIO', 'BOZAME', NULL, 'lsjdjsl@gmail.com', '2021-12-15 07:37:54', '2021-12-15 07:37:54');
INSERT INTO `agents` VALUES (18, 11, 'ehrthrhr', 'DJENEB', 'MATOGOMA', NULL, 'trhrhtr@gmail.com', '2021-12-15 07:38:36', '2021-12-15 07:38:36');
INSERT INTO `agents` VALUES (19, 11, 'ezhfksvkjf', 'BAHINCHI', 'BEATRICE', NULL, 'lnfjksljf@gmail.com', '2021-12-15 07:39:08', '2021-12-15 07:39:08');

-- ----------------------------
-- Table structure for failed_jobs
-- ----------------------------
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `failed_jobs_uuid_unique`(`uuid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (1, '2014_10_12_000000_create_users_table', 1);
INSERT INTO `migrations` VALUES (2, '2014_10_12_100000_create_password_resets_table', 1);
INSERT INTO `migrations` VALUES (3, '2019_08_19_000000_create_failed_jobs_table', 1);

-- ----------------------------
-- Table structure for password_resets
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets`  (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  INDEX `password_resets_email_index`(`email`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for rapports
-- ----------------------------
DROP TABLE IF EXISTS `rapports`;
CREATE TABLE `rapports`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NULL DEFAULT NULL,
  `id_agent` int(11) NULL DEFAULT NULL,
  `id_user` int(11) NULL DEFAULT NULL,
  `nomcomplet` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `nbre_tf_impactes` int(11) NULL DEFAULT 0,
  `nbre_inscription` int(11) NULL DEFAULT 0,
  `nbre_tf_crees` int(11) NULL DEFAULT 0,
  `date_save` date NULL DEFAULT NULL,
  `screenshot` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `is_matched` int(1) NULL DEFAULT 1,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 39 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of rapports
-- ----------------------------
INSERT INTO `rapports` VALUES (6, '2021-12-14', 12, 11, 'KOUASSI KARINE', 3, 2, 3, NULL, NULL, 1, '2021-12-14 05:47:40', '2021-12-14 05:47:40');
INSERT INTO `rapports` VALUES (7, '2021-12-15', 13, 11, 'PENAH POLAI EMILIE', 30, 45, 30, NULL, NULL, 1, '2021-12-14 06:27:13', '2021-12-14 07:01:42');
INSERT INTO `rapports` VALUES (8, '2021-12-14', 12, 11, 'KOUASSI KARINE', 6, 10, 6, NULL, NULL, 1, '2021-12-14 07:12:56', '2021-12-14 07:12:56');
INSERT INTO `rapports` VALUES (9, '2021-12-15', 13, 11, 'PENAH POLAI EMILIE', 5, 3, 11, NULL, NULL, 1, '2021-12-15 06:43:52', '2021-12-15 06:43:52');
INSERT INTO `rapports` VALUES (10, '2021-12-16', 13, 11, 'PENAH POLAI EMILIE', 5, 3, 12, NULL, NULL, 1, '2021-12-15 06:45:18', '2021-12-15 06:45:18');
INSERT INTO `rapports` VALUES (11, '2021-12-16', 13, 11, 'PENAH POLAI EMILIE', 1, 1, 1, NULL, NULL, 1, '2021-12-15 06:49:59', '2021-12-15 06:49:59');
INSERT INTO `rapports` VALUES (12, '2021-12-16', 13, 11, 'PENAH POLAI EMILIE', 4, 3, 3, NULL, NULL, 1, '2021-12-15 07:13:06', '2021-12-15 07:13:06');
INSERT INTO `rapports` VALUES (13, '2021-12-16', 13, 11, 'PENAH POLAI EMILIE', 1, 1, 11, NULL, NULL, 1, '2021-12-15 07:18:14', '2021-12-15 07:18:14');
INSERT INTO `rapports` VALUES (14, '2021-12-23', 14, 11, 'DOUMBIA YAYA', 1, 1, 1, NULL, NULL, 1, '2021-12-15 07:18:39', '2021-12-15 07:18:39');
INSERT INTO `rapports` VALUES (17, '2021-12-16', 14, 11, 'DOUMBIA YAYA', 4, 4, 4, NULL, NULL, 1, '2021-12-15 07:41:35', '2021-12-15 07:41:35');
INSERT INTO `rapports` VALUES (18, '2021-12-16', 12, 11, 'KOUASSI KARINE', 6, 7, 6, NULL, NULL, 1, '2021-12-16 06:28:39', '2021-12-16 06:28:39');
INSERT INTO `rapports` VALUES (29, '2021-12-20', 19, 11, 'BAHINCHI BEATRICE', 2, 3, 2, '2021-12-20', NULL, 1, '2021-12-20 02:06:52', '2021-12-20 02:06:52');
INSERT INTO `rapports` VALUES (31, '2021-12-21', 13, 11, 'PENAH POLAI EMILIE', 6, 10, 6, '2021-12-21', NULL, 1, '2021-12-21 08:01:53', '2021-12-21 08:01:53');
INSERT INTO `rapports` VALUES (32, '2021-12-21', 16, 11, 'YAO ALOU HENRI', 3, 6, 3, '2021-12-21', NULL, 1, '2021-12-21 08:02:18', '2021-12-21 08:02:18');
INSERT INTO `rapports` VALUES (33, '2021-12-23', 12, 11, 'KOUASSI KARINE', 6, 6, 2, '2021-12-23', NULL, 1, '2021-12-23 02:46:17', '2021-12-23 02:55:24');
INSERT INTO `rapports` VALUES (36, '2022-10-29', 12, 8, 'KOUASSI KARINE', 50, 45, 50, '2022-10-30', '202210300702202210051326CHI.png', 1, '2022-10-30 06:51:03', '2022-10-30 19:45:54');
INSERT INTO `rapports` VALUES (38, '2022-10-30', 14, 8, 'DOUMBIA YAYA', 50, 25, 30, '2022-10-30', '202210301953202210292015202210051316chiffres.png', 1, '2022-10-30 19:53:50', '2022-10-30 20:18:26');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `telephone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `role` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp(0) NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `users_email_unique`(`email`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (8, 'Gagne', 'Ocladd', '0767123451', 'Administrateur', 'admin@gmail.com', NULL, '$2y$10$hh1Tpm91zzWkDUWODeWKFuJlyxxOmftStuV4ilExLr1Mp05SbIrzS', NULL, '2021-12-10 07:01:39', '2021-12-23 03:06:32');
INSERT INTO `users` VALUES (11, 'Kouli', 'Serge', '0656125521', 'Agent', 'agent@gmail.com', NULL, '$2y$10$Rtmm36xL4Ke8Iz/RnYzehuy/rObUOKqdeFbL/DTqUUlpmaqW6CLvS', NULL, '2021-12-13 10:49:42', '2022-01-10 06:02:58');
INSERT INTO `users` VALUES (12, 'Kouamé', 'Genevieve', '6125588', 'Chef de service', 'chefdeservice@gmail.com', NULL, '$2y$10$BBeGD8wAi4XxEkEwlfiqf.DXxc5D6sd5dGnFOarkbS90rm53.Glyu', NULL, '2021-12-13 10:50:45', '2022-01-10 06:22:44');

SET FOREIGN_KEY_CHECKS = 1;
