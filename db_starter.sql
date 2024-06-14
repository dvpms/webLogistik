/*
 Navicat Premium Data Transfer

 Source Server         : arif_3307
 Source Server Type    : MySQL
 Source Server Version : 100424
 Source Host           : localhost:3307
 Source Schema         : db_starter

 Target Server Type    : MySQL
 Target Server Version : 100424
 File Encoding         : 65001

 Date: 02/02/2024 16:11:40
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for c_api_keys
-- ----------------------------
DROP TABLE IF EXISTS `c_api_keys`;
CREATE TABLE `c_api_keys`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `key` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `level` int NOT NULL,
  `ignore_limits` tinyint(1) NOT NULL DEFAULT 0,
  `is_private_key` tinyint(1) NOT NULL DEFAULT 0,
  `ip_addresses` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `date_created` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of c_api_keys
-- ----------------------------
INSERT INTO `c_api_keys` VALUES (1, 1, 'eofficey2vwXHA9BcT9ssAmvdAF7ZyrDovK1dMib2pnob6EktsfNRDq111pz1g3T', 1, 0, 0, NULL, 1);

-- ----------------------------
-- Table structure for c_brand
-- ----------------------------
DROP TABLE IF EXISTS `c_brand`;
CREATE TABLE `c_brand`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `logo` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `logo_light` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `favicon` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `created_date` timestamp NULL DEFAULT NULL,
  `updated_date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of c_brand
-- ----------------------------
INSERT INTO `c_brand` VALUES (1, 'Starter', '', '', '', 'brand-logo-20230412-1681269523.png', 'brand-logo-light-20230412-1681269523.png', 'brand-favicon-20230412-1681269523.png', NULL, '2023-04-12 10:18:42');

-- ----------------------------
-- Table structure for c_menus
-- ----------------------------
DROP TABLE IF EXISTS `c_menus`;
CREATE TABLE `c_menus`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_parent` int NULL DEFAULT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `url` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `position` int NULL DEFAULT NULL,
  `icon` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '',
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'active',
  `target_blank` tinyint(1) NOT NULL DEFAULT 0,
  `created_date` timestamp NULL DEFAULT NULL,
  `updated_date` timestamp NULL DEFAULT NULL,
  `deleted_date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id_parent`(`id_parent` ASC) USING BTREE,
  CONSTRAINT `c_menus_ibfk_1` FOREIGN KEY (`id_parent`) REFERENCES `c_menus` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 170 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of c_menus
-- ----------------------------
INSERT INTO `c_menus` VALUES (23, NULL, 'Control Panel', '#', 50, 'bx bx-cog', 'active', 0, '2022-02-19 15:51:53', '2023-03-15 09:04:28', NULL);
INSERT INTO `c_menus` VALUES (24, 23, 'Menu Admin', 'menu-admin', 2, '', 'active', 0, '2022-02-19 15:52:57', '2022-02-21 13:59:56', NULL);
INSERT INTO `c_menus` VALUES (29, NULL, 'Dashboard', 'dashboard', 1, 'bx bx-home-alt', 'active', 0, '2022-02-19 15:56:59', '2023-03-15 09:04:05', NULL);
INSERT INTO `c_menus` VALUES (32, 23, 'Set Privileges', 'role-permissions', 5, '', 'active', 0, '2022-02-19 16:07:19', '2022-02-23 02:20:43', NULL);
INSERT INTO `c_menus` VALUES (34, 23, 'Users', 'users', 4, '', 'active', 0, '2022-02-21 08:36:51', '2022-02-23 02:20:39', NULL);
INSERT INTO `c_menus` VALUES (164, 23, 'Brand', 'brand', 1, '', 'active', 0, '2023-03-07 15:05:37', NULL, NULL);

-- ----------------------------
-- Table structure for c_menus_main
-- ----------------------------
DROP TABLE IF EXISTS `c_menus_main`;
CREATE TABLE `c_menus_main`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_parent` int NULL DEFAULT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `url` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `position` int NULL DEFAULT NULL,
  `icon` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'active',
  `target_blank` tinyint(1) NULL DEFAULT 0,
  `created_date` timestamp NULL DEFAULT NULL,
  `updated_date` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `deleted_date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id_parent`(`id_parent` ASC) USING BTREE,
  CONSTRAINT `c_menus_main_ibfk_1` FOREIGN KEY (`id_parent`) REFERENCES `c_menus_main` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of c_menus_main
-- ----------------------------
INSERT INTO `c_menus_main` VALUES (1, NULL, 'Home', '/', NULL, NULL, 'active', 0, '2022-12-26 09:10:47', NULL, NULL);

-- ----------------------------
-- Table structure for c_menus_privileges
-- ----------------------------
DROP TABLE IF EXISTS `c_menus_privileges`;
CREATE TABLE `c_menus_privileges`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_user_group` int NULL DEFAULT NULL,
  `id_menu` int NULL DEFAULT NULL,
  `created_date` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id_user_group`(`id_user_group` ASC) USING BTREE,
  INDEX `id_menu`(`id_menu` ASC) USING BTREE,
  CONSTRAINT `c_menus_privileges_ibfk_1` FOREIGN KEY (`id_user_group`) REFERENCES `c_users_group` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `c_menus_privileges_ibfk_2` FOREIGN KEY (`id_menu`) REFERENCES `c_menus` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 7553 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of c_menus_privileges
-- ----------------------------
INSERT INTO `c_menus_privileges` VALUES (7532, 1, 29, '2023-03-17 23:46:47');
INSERT INTO `c_menus_privileges` VALUES (7537, 1, 23, '2023-03-17 23:46:47');
INSERT INTO `c_menus_privileges` VALUES (7538, 1, 164, '2023-03-17 23:46:47');
INSERT INTO `c_menus_privileges` VALUES (7539, 1, 24, '2023-03-17 23:46:47');
INSERT INTO `c_menus_privileges` VALUES (7540, 1, 34, '2023-03-17 23:46:47');
INSERT INTO `c_menus_privileges` VALUES (7541, 1, 32, '2023-03-17 23:46:47');

-- ----------------------------
-- Table structure for c_users
-- ----------------------------
DROP TABLE IF EXISTS `c_users`;
CREATE TABLE `c_users`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_user_pegawai` int NULL DEFAULT NULL,
  `id_user_group` int NULL DEFAULT NULL,
  `nip` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `nama_pegawai` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `id_non_pegawai` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_pegawai` int NULL DEFAULT NULL,
  `id_unor` int NULL DEFAULT NULL,
  `kode_unor` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `nama_unor` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `nomor_hp` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `gender` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tempat_lahir` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tanggal_lahir` date NULL DEFAULT NULL,
  `status_asn` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `nama_golongan` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `kode_golongan` int NULL DEFAULT NULL,
  `status_perkawinan` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `nomenklatur_pada` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `jab_type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_jenjang_jabatan` int NULL DEFAULT NULL,
  `nama_jenjang` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tanggal_lulus` date NULL DEFAULT NULL,
  `tmt_pangkat` date NULL DEFAULT NULL,
  `mk_gol_tahun` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `gelar_nonakademis` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `mk_gol_bulan` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `instansi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `gelar_belakang` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `nama_jenjang_rumpun` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `nama_unor_parent` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tmt_cpns` date NULL DEFAULT NULL,
  `tugas_tambahan` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `agama` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `gelar_depan` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tmt_pns` date NULL DEFAULT NULL,
  `nomenklatur_jabatan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `kode_ese` int NULL DEFAULT NULL,
  `tmt_ese` date NULL DEFAULT NULL,
  `tmt_jabatan` date NULL DEFAULT NULL,
  `status_kepegawaian` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `nama_ese` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `nama_pangkat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `foto_pegawai` blob NULL,
  `is_pegawai` int NULL DEFAULT 1,
  `is_active` int NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `id_dewan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `nip`(`nip` ASC) USING BTREE,
  INDEX `id_user_group`(`id_user_group` ASC) USING BTREE,
  CONSTRAINT `c_users_ibfk_1` FOREIGN KEY (`id_user_group`) REFERENCES `c_users_group` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 396 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of c_users
-- ----------------------------
INSERT INTO `c_users` VALUES (392, NULL, 1, 'taqwaw', '$2y$10$nekxEZY/tK7n9DLpXNu5Ie9tQDIq7RYhlIlUmoLpT8n8ek1OGegRW', 'taqwaw', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0x6176617461722D32303233303431322D313638313236383539392E706E67, 0, 1, '2023-04-12 10:03:20', NULL, NULL);

-- ----------------------------
-- Table structure for c_users_group
-- ----------------------------
DROP TABLE IF EXISTS `c_users_group`;
CREATE TABLE `c_users_group`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_date` timestamp NULL DEFAULT NULL,
  `updated_date` timestamp NULL DEFAULT NULL,
  `deleted_date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 14 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of c_users_group
-- ----------------------------
INSERT INTO `c_users_group` VALUES (1, 'Super Admin', '2023-03-17 23:46:47', '2022-02-19 19:32:27', NULL);

-- ----------------------------
-- Table structure for c_users_log
-- ----------------------------
DROP TABLE IF EXISTS `c_users_log`;
CREATE TABLE `c_users_log`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `nip` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `login` datetime NULL DEFAULT NULL,
  `logout` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of c_users_log
-- ----------------------------
INSERT INTO `c_users_log` VALUES (1, 'taqwaw', 'taqwaw', '2023-04-12 10:05:54', NULL);
INSERT INTO `c_users_log` VALUES (2, 'taqwaw', 'taqwaw', '2023-04-12 10:22:22', NULL);
INSERT INTO `c_users_log` VALUES (3, 'taqwaw', 'taqwaw', '2023-04-12 10:35:34', NULL);
INSERT INTO `c_users_log` VALUES (4, 'taqwaw', 'taqwaw', '2023-11-17 10:39:33', NULL);
INSERT INTO `c_users_log` VALUES (5, 'taqwaw', 'taqwaw', '2024-02-02 14:40:02', NULL);
INSERT INTO `c_users_log` VALUES (6, 'taqwaw', 'taqwaw', '2024-02-02 16:07:54', NULL);
INSERT INTO `c_users_log` VALUES (7, 'taqwaw', 'taqwaw', '2024-02-02 16:08:19', NULL);

SET FOREIGN_KEY_CHECKS = 1;
