/*
 Navicat Premium Data Transfer

 Source Server         : yiyao
 Source Server Type    : MySQL
 Source Server Version : 50558
 Source Host           : 122.114.42.177:3306
 Source Schema         : run_4hl_cn

 Target Server Type    : MySQL
 Target Server Version : 50558
 File Encoding         : 65001

 Date: 17/12/2018 15:38:40
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for sd_135k_equipment_cart
-- ----------------------------
DROP TABLE IF EXISTS `sd_135k_equipment_cart`;
CREATE TABLE `sd_135k_equipment_cart`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `gid` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '商品id',
  `spec` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '规格id',
  `is_del` tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '是否删除或已购买',
  `rid` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '配送员id',
  `num` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '数量',
  `create_time` int(11) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '装备商城购物车' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for sd_135k_equipment_cat
-- ----------------------------
DROP TABLE IF EXISTS `sd_135k_equipment_cat`;
CREATE TABLE `sd_135k_equipment_cat`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `is_del` int(1) UNSIGNED NOT NULL DEFAULT 0,
  `store_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `sort` int(6) UNSIGNED NOT NULL DEFAULT 0 COMMENT '排序',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `name`(`name`, `store_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for sd_135k_equipment_goods
-- ----------------------------
DROP TABLE IF EXISTS `sd_135k_equipment_goods`;
CREATE TABLE `sd_135k_equipment_goods`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `store_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `name` char(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '商品名',
  `pic` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL COMMENT '商品图',
  `pics` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL COMMENT '商品轮播图',
  `des` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '商品描述',
  `is_del` int(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '0正常，1下架',
  `cid` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '分类表',
  `sort` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '排序',
  `create_time` int(11) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `name`(`name`, `store_id`) USING BTREE COMMENT '商品名不可重复'
) ENGINE = InnoDB AUTO_INCREMENT = 72 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '装备商城商品表' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for sd_135k_equipment_goods_attr
-- ----------------------------
DROP TABLE IF EXISTS `sd_135k_equipment_goods_attr`;
CREATE TABLE `sd_135k_equipment_goods_attr`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `store_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `attr` char(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '属性名',
  `content` varchar(3000) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '属性值',
  `is_del` int(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '0，正常，1，下架',
  `gid` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '商品id',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 49 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '装备商城商品属性表' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for sd_135k_equipment_goods_spec
-- ----------------------------
DROP TABLE IF EXISTS `sd_135k_equipment_goods_spec`;
CREATE TABLE `sd_135k_equipment_goods_spec`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `store_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `name` char(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '规格名',
  `num` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '库存',
  `is_del` int(1) UNSIGNED NOT NULL COMMENT '0，正常，1，下架',
  `gid` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '商品id',
  `price` decimal(10, 2) UNSIGNED NOT NULL DEFAULT 0.00 COMMENT '价格',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 42 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '装备商城商品规格' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for sd_135k_equipment_order
-- ----------------------------
DROP TABLE IF EXISTS `sd_135k_equipment_order`;
CREATE TABLE `sd_135k_equipment_order`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `price` decimal(10, 2) UNSIGNED NOT NULL DEFAULT 0.00 COMMENT '订单金额',
  `create_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '下单时间',
  `status` int(2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '1待付款，2已付款待发货，3待收货，4完成待评价，6取消订单',
  `pay_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '支付时间',
  `rid` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '配送员id',
  `complete_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '订单完成时间',
  `quit_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '取消订单时间',
  `receive_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '配送员确认收货时间',
  `deliver_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '平台发货时间',
  `store_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `pay_type` tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '0余额支付，1微信支付',
  `order_no` char(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '订单号',
  `prepay_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 18 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for sd_135k_equipment_order_detail
-- ----------------------------
DROP TABLE IF EXISTS `sd_135k_equipment_order_detail`;
CREATE TABLE `sd_135k_equipment_order_detail`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `oid` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '订单id',
  `price` decimal(10, 2) UNSIGNED NOT NULL COMMENT '商品金额',
  `num` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '商品数量',
  `spec_name` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '商品规格名',
  `spec_price` decimal(10, 2) UNSIGNED NOT NULL DEFAULT 0.00 COMMENT '商品规格单价',
  `spec` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '规格id',
  `name` char(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '商品名',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 18 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '装备商城订单详情' ROW_FORMAT = Compact;

SET FOREIGN_KEY_CHECKS = 1;
