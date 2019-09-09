/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50553
 Source Host           : localhost:3306
 Source Schema         : jiancai

 Target Server Type    : MySQL
 Target Server Version : 50553
 File Encoding         : 65001

 Date: 09/09/2019 11:53:42
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for jc_cat
-- ----------------------------
DROP TABLE IF EXISTS `jc_cat`;
CREATE TABLE `jc_cat`  (
  `tid` int(10) UNSIGNED NOT NULL COMMENT 'ztreeid',
  `name` char(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '分类名',
  `pid` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '上级分类id',
  `sort` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '排序',
  `create_time` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '创建时间',
  `update_time` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '修改时间',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '1正常，0删除',
  `is_end` tinyint(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '是否最后一级分类，1是，0否',
  `pic` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '分类图片',
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 175 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '建材分类' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of jc_cat
-- ----------------------------
INSERT INTO `jc_cat` VALUES (1, '环境设计材料', 0, 1, 0, 0, 1, 1, '', 1);
INSERT INTO `jc_cat` VALUES (2, '石材', 1, 2, 0, 0, 1, 0, '', 2);
INSERT INTO `jc_cat` VALUES (3, '天然石材', 2, 3, 0, 0, 1, 1, '', 3);
INSERT INTO `jc_cat` VALUES (4, '大理石', 2, 4, 0, 0, 1, 1, '', 4);
INSERT INTO `jc_cat` VALUES (5, '踢脚线', 1, 5, 0, 0, 1, 0, '', 5);
INSERT INTO `jc_cat` VALUES (6, '墙角线', 5, 6, 0, 0, 1, 0, '', 6);
INSERT INTO `jc_cat` VALUES (7, '墙腰线', 6, 7, 0, 0, 1, 0, '', 7);
INSERT INTO `jc_cat` VALUES (8, '门窗洞口线', 7, 8, 0, 0, 1, 1, '', 8);
INSERT INTO `jc_cat` VALUES (9, '薄木饰面板', 7, 9, 0, 0, 1, 1, '', 9);
INSERT INTO `jc_cat` VALUES (10, '木门', 7, 10, 0, 0, 1, 1, '', 10);
INSERT INTO `jc_cat` VALUES (11, '木花格', 6, 11, 0, 0, 1, 1, '', 11);
INSERT INTO `jc_cat` VALUES (12, '竹制装饰品', 6, 12, 0, 0, 1, 0, '', 12);
INSERT INTO `jc_cat` VALUES (13, '竹地板', 12, 13, 0, 0, 1, 1, '', 13);
INSERT INTO `jc_cat` VALUES (14, '竹制家具', 12, 14, 0, 0, 1, 1, '', 14);
INSERT INTO `jc_cat` VALUES (15, '藤制装饰品', 12, 15, 0, 0, 1, 1, '', 15);
INSERT INTO `jc_cat` VALUES (16, '人造板材', 12, 16, 0, 0, 1, 1, '', 16);
INSERT INTO `jc_cat` VALUES (17, '细木工板', 12, 17, 0, 0, 1, 1, '', 17);
INSERT INTO `jc_cat` VALUES (18, '胶合板', 6, 18, 0, 0, 1, 1, '', 18);
INSERT INTO `jc_cat` VALUES (19, '宝丽板', 6, 19, 0, 0, 1, 0, '', 19);
INSERT INTO `jc_cat` VALUES (20, '刨花板', 19, 20, 0, 0, 1, 1, '', 20);
INSERT INTO `jc_cat` VALUES (21, '纤维板', 19, 21, 0, 0, 1, 1, '', 21);
INSERT INTO `jc_cat` VALUES (22, '澳松板', 6, 22, 0, 0, 1, 0, '', 22);
INSERT INTO `jc_cat` VALUES (23, '木丝木屑板', 22, 23, 0, 0, 1, 1, '', 23);
INSERT INTO `jc_cat` VALUES (24, '指接板', 22, 24, 0, 0, 1, 1, '', 24);
INSERT INTO `jc_cat` VALUES (25, '麦秸板', 22, 25, 0, 0, 1, 1, '', 25);
INSERT INTO `jc_cat` VALUES (26, '木材新材料', 22, 26, 0, 0, 1, 1, '', 26);
INSERT INTO `jc_cat` VALUES (27, '水泥刨花板', 6, 27, 0, 0, 1, 1, '', 27);
INSERT INTO `jc_cat` VALUES (28, '液态木liquid wood', 6, 28, 0, 0, 1, 1, '', 28);
INSERT INTO `jc_cat` VALUES (29, '木挂板', 6, 29, 0, 0, 1, 1, '', 29);
INSERT INTO `jc_cat` VALUES (30, '花岗岩', 6, 30, 0, 0, 1, 1, '', 30);
INSERT INTO `jc_cat` VALUES (31, '砂岩', 5, 31, 0, 0, 1, 0, '', 31);
INSERT INTO `jc_cat` VALUES (32, '板岩', 31, 32, 0, 0, 1, 1, '', 32);
INSERT INTO `jc_cat` VALUES (33, '青石', 31, 33, 0, 0, 1, 1, '', 33);
INSERT INTO `jc_cat` VALUES (34, '人造石材', 31, 34, 0, 0, 1, 1, '', 34);
INSERT INTO `jc_cat` VALUES (35, '人造水磨石', 31, 35, 0, 0, 1, 1, '', 35);
INSERT INTO `jc_cat` VALUES (36, '聚酯型人造石', 31, 36, 0, 0, 1, 1, '', 36);
INSERT INTO `jc_cat` VALUES (37, '复合型人造石', 31, 37, 0, 0, 1, 1, '', 37);
INSERT INTO `jc_cat` VALUES (38, '烧结型人造石', 31, 38, 0, 0, 1, 1, '', 38);
INSERT INTO `jc_cat` VALUES (39, '微晶玻璃型人造石', 31, 39, 0, 0, 1, 1, '', 39);
INSERT INTO `jc_cat` VALUES (40, '石材新材料', 31, 40, 0, 0, 1, 1, '', 40);
INSERT INTO `jc_cat` VALUES (41, '大理石瓷砖复合板', 5, 41, 0, 0, 1, 0, '', 41);
INSERT INTO `jc_cat` VALUES (42, '大理石铝塑复合板', 41, 42, 0, 0, 1, 1, '', 42);
INSERT INTO `jc_cat` VALUES (43, '超薄花岗岩铝塑复合板', 41, 43, 0, 0, 1, 1, '', 43);
INSERT INTO `jc_cat` VALUES (44, '蜂窝复合板', 41, 44, 0, 0, 1, 1, '', 44);
INSERT INTO `jc_cat` VALUES (45, '陶瓷', 1, 45, 0, 0, 1, 0, '', 45);
INSERT INTO `jc_cat` VALUES (46, '陶瓷墙地砖', 45, 46, 0, 0, 1, 0, '', 46);
INSERT INTO `jc_cat` VALUES (47, '抛光砖', 46, 47, 0, 0, 1, 1, '', 47);
INSERT INTO `jc_cat` VALUES (48, '玻化砖', 46, 48, 0, 0, 1, 1, '', 48);
INSERT INTO `jc_cat` VALUES (49, '劈离砖', 46, 49, 0, 0, 1, 1, '', 49);
INSERT INTO `jc_cat` VALUES (50, '陶瓷透水砖', 46, 50, 0, 0, 1, 1, '', 50);
INSERT INTO `jc_cat` VALUES (51, '仿古砖', 46, 51, 0, 0, 1, 1, '', 51);
INSERT INTO `jc_cat` VALUES (52, '金属光泽釉面砖', 46, 52, 0, 0, 1, 1, '', 52);
INSERT INTO `jc_cat` VALUES (53, '大颗粒瓷质砖', 46, 53, 0, 0, 1, 1, '', 53);
INSERT INTO `jc_cat` VALUES (54, '麻面砖', 46, 54, 0, 0, 1, 1, '', 54);
INSERT INTO `jc_cat` VALUES (55, '瓷质彩胎砖', 46, 55, 0, 0, 1, 1, '', 55);
INSERT INTO `jc_cat` VALUES (56, '仿天然石材墙面砖', 46, 56, 0, 0, 1, 1, '', 56);
INSERT INTO `jc_cat` VALUES (57, '装饰木纹砖', 46, 57, 0, 0, 1, 1, '', 57);
INSERT INTO `jc_cat` VALUES (58, '装饰玻璃', 45, 58, 0, 0, 1, 0, '', 58);
INSERT INTO `jc_cat` VALUES (59, '玻璃瓦', 58, 59, 0, 0, 1, 1, '', 59);
INSERT INTO `jc_cat` VALUES (60, '玻璃构建', 58, 60, 0, 0, 1, 1, '', 60);
INSERT INTO `jc_cat` VALUES (61, '新型装饰陶瓷品', 45, 61, 0, 0, 1, 0, '', 61);
INSERT INTO `jc_cat` VALUES (62, '陶瓷浮雕壁画', 61, 62, 0, 0, 1, 1, '', 62);
INSERT INTO `jc_cat` VALUES (63, '陶土板', 61, 63, 0, 0, 1, 1, '', 63);
INSERT INTO `jc_cat` VALUES (64, '软性陶瓷', 61, 64, 0, 0, 1, 1, '', 64);
INSERT INTO `jc_cat` VALUES (65, '陶瓷彩铝', 61, 65, 0, 0, 1, 1, '', 65);
INSERT INTO `jc_cat` VALUES (66, '皮革砖', 61, 66, 0, 0, 1, 1, '', 66);
INSERT INTO `jc_cat` VALUES (67, '黑瓷装饰板', 61, 67, 0, 0, 1, 1, '', 67);
INSERT INTO `jc_cat` VALUES (68, '陶瓷彩色波纹贴面砖', 61, 68, 0, 0, 1, 1, '', 68);
INSERT INTO `jc_cat` VALUES (69, '织物', 1, 69, 0, 0, 1, 0, '', 69);
INSERT INTO `jc_cat` VALUES (70, '墙面装饰织物', 69, 70, 0, 0, 1, 0, '', 70);
INSERT INTO `jc_cat` VALUES (71, '织物壁纸', 70, 71, 0, 0, 1, 1, '', 71);
INSERT INTO `jc_cat` VALUES (72, '塑料', 1, 72, 0, 0, 1, 0, '', 72);
INSERT INTO `jc_cat` VALUES (73, '聚碳酸酯', 72, 73, 0, 0, 1, 1, '', 73);
INSERT INTO `jc_cat` VALUES (74, '丙烯酸塑料', 72, 74, 0, 0, 1, 1, '', 74);
INSERT INTO `jc_cat` VALUES (75, '聚氯乙烯PVC', 72, 75, 0, 0, 1, 1, '', 75);
INSERT INTO `jc_cat` VALUES (76, '玻璃纤维增强塑料GRP', 72, 76, 0, 0, 1, 1, '', 76);
INSERT INTO `jc_cat` VALUES (77, '聚苯乙烯', 72, 77, 0, 0, 1, 1, '', 77);
INSERT INTO `jc_cat` VALUES (78, '塑料制品', 72, 78, 0, 0, 1, 0, '', 78);
INSERT INTO `jc_cat` VALUES (79, 'PC阳光板', 78, 79, 0, 0, 1, 1, '', 79);
INSERT INTO `jc_cat` VALUES (80, 'PC耐力板', 78, 80, 0, 0, 1, 1, '', 80);
INSERT INTO `jc_cat` VALUES (81, 'PC光扩散板', 78, 81, 0, 0, 1, 1, '', 81);
INSERT INTO `jc_cat` VALUES (82, '亚克力', 78, 82, 0, 0, 1, 1, '', 82);
INSERT INTO `jc_cat` VALUES (83, '塑木制品', 78, 83, 0, 0, 1, 1, '', 83);
INSERT INTO `jc_cat` VALUES (84, '塑料草皮', 78, 84, 0, 0, 1, 1, '', 84);
INSERT INTO `jc_cat` VALUES (85, '复合高分子井盖', 78, 85, 0, 0, 1, 1, '', 85);
INSERT INTO `jc_cat` VALUES (86, '橡胶地板', 78, 86, 0, 0, 1, 1, '', 86);
INSERT INTO `jc_cat` VALUES (87, '塑料盲道', 78, 87, 0, 0, 1, 1, '', 87);
INSERT INTO `jc_cat` VALUES (88, '绿化种植箱', 78, 88, 0, 0, 1, 1, '', 88);
INSERT INTO `jc_cat` VALUES (89, '植草格，树池篦子', 78, 89, 0, 0, 1, 1, '', 89);
INSERT INTO `jc_cat` VALUES (90, '混凝土', 1, 90, 0, 0, 1, 0, '', 90);
INSERT INTO `jc_cat` VALUES (91, '沥青混凝土', 90, 91, 0, 0, 1, 0, '', 91);
INSERT INTO `jc_cat` VALUES (92, '透水沥青', 91, 92, 0, 0, 1, 1, '', 92);
INSERT INTO `jc_cat` VALUES (93, '填料沥青', 91, 93, 0, 0, 1, 1, '', 93);
INSERT INTO `jc_cat` VALUES (94, '装式混凝土', 90, 94, 0, 0, 1, 0, '', 94);
INSERT INTO `jc_cat` VALUES (95, '压印混凝土', 94, 95, 0, 0, 1, 1, '', 95);
INSERT INTO `jc_cat` VALUES (96, '清水混凝土', 94, 96, 0, 0, 1, 1, '', 96);
INSERT INTO `jc_cat` VALUES (97, '彩色混凝土地坪', 94, 97, 0, 0, 1, 1, '', 97);
INSERT INTO `jc_cat` VALUES (98, '露石混凝土', 94, 98, 0, 0, 1, 1, '', 98);
INSERT INTO `jc_cat` VALUES (99, '聚合物仿石地坪', 94, 99, 0, 0, 1, 1, '', 99);
INSERT INTO `jc_cat` VALUES (100, '纤维混凝土', 90, 100, 0, 0, 1, 0, '', 100);
INSERT INTO `jc_cat` VALUES (101, '钢纤维混凝土', 100, 101, 0, 0, 1, 1, '', 101);
INSERT INTO `jc_cat` VALUES (102, '合成纤维混凝土', 100, 102, 0, 0, 1, 1, '', 102);
INSERT INTO `jc_cat` VALUES (103, '玻璃纤维混凝土', 100, 103, 0, 0, 1, 1, '', 103);
INSERT INTO `jc_cat` VALUES (104, '透水混凝土', 100, 104, 0, 0, 1, 0, '', 104);
INSERT INTO `jc_cat` VALUES (105, '外墙漆', 104, 105, 0, 0, 1, 0, '', 105);
INSERT INTO `jc_cat` VALUES (106, '乳胶外墙漆（合成树脂）', 105, 106, 0, 0, 1, 1, '', 106);
INSERT INTO `jc_cat` VALUES (107, '乳胶沙壁外墙漆（合成树脂）', 105, 107, 0, 0, 1, 1, '', 107);
INSERT INTO `jc_cat` VALUES (108, '溶剂型外墙漆', 105, 108, 0, 0, 1, 1, '', 108);
INSERT INTO `jc_cat` VALUES (109, '复层外墙漆', 105, 109, 0, 0, 1, 1, '', 109);
INSERT INTO `jc_cat` VALUES (110, '无机外墙漆', 105, 110, 0, 0, 1, 1, '', 110);
INSERT INTO `jc_cat` VALUES (111, '弹性建筑外墙漆', 105, 111, 0, 0, 1, 1, '', 111);
INSERT INTO `jc_cat` VALUES (112, '地面漆', 104, 112, 0, 0, 1, 0, '', 112);
INSERT INTO `jc_cat` VALUES (113, '乙烯类地面漆', 112, 113, 0, 0, 1, 1, '', 113);
INSERT INTO `jc_cat` VALUES (114, '环氧树脂漆', 112, 114, 0, 0, 1, 1, '', 114);
INSERT INTO `jc_cat` VALUES (115, '聚氨酯地面漆', 112, 115, 0, 0, 1, 1, '', 115);
INSERT INTO `jc_cat` VALUES (116, '丙烯酸地面漆', 112, 116, 0, 0, 1, 1, '', 116);
INSERT INTO `jc_cat` VALUES (117, '特种漆', 104, 117, 0, 0, 1, 0, '', 117);
INSERT INTO `jc_cat` VALUES (118, '防水漆', 117, 118, 0, 0, 1, 1, '', 118);
INSERT INTO `jc_cat` VALUES (119, '防火漆', 117, 119, 0, 0, 1, 1, '', 119);
INSERT INTO `jc_cat` VALUES (120, '防毒漆', 117, 120, 0, 0, 1, 1, '', 120);
INSERT INTO `jc_cat` VALUES (121, '抗静电漆', 117, 121, 0, 0, 1, 1, '', 121);
INSERT INTO `jc_cat` VALUES (122, '耐高温漆', 117, 122, 0, 0, 1, 1, '', 122);
INSERT INTO `jc_cat` VALUES (123, '防锈漆', 117, 123, 0, 0, 1, 1, '', 123);
INSERT INTO `jc_cat` VALUES (124, '木器漆', 117, 124, 0, 0, 1, 1, '', 124);
INSERT INTO `jc_cat` VALUES (125, '金属漆', 117, 125, 0, 0, 1, 1, '', 125);
INSERT INTO `jc_cat` VALUES (126, '新型混凝土', 90, 126, 0, 0, 1, 0, '', 126);
INSERT INTO `jc_cat` VALUES (127, '混凝土石', 126, 127, 0, 0, 1, 1, '', 127);
INSERT INTO `jc_cat` VALUES (128, '透光混凝土', 126, 128, 0, 0, 1, 1, '', 128);
INSERT INTO `jc_cat` VALUES (129, '混凝土制品', 90, 129, 0, 0, 1, 0, '', 129);
INSERT INTO `jc_cat` VALUES (130, '透水砖', 129, 130, 0, 0, 1, 1, '', 130);
INSERT INTO `jc_cat` VALUES (131, '废弃混凝土再利用', 129, 131, 0, 0, 1, 0, '', 131);
INSERT INTO `jc_cat` VALUES (132, '马来漆', 131, 132, 0, 0, 1, 1, '', 132);
INSERT INTO `jc_cat` VALUES (133, '真石漆', 131, 133, 0, 0, 1, 1, '', 133);
INSERT INTO `jc_cat` VALUES (134, '复层肌理漆', 131, 134, 0, 0, 1, 1, '', 134);
INSERT INTO `jc_cat` VALUES (135, '金属箔质感漆', 131, 135, 0, 0, 1, 1, '', 135);
INSERT INTO `jc_cat` VALUES (136, '液体壁纸', 131, 136, 0, 0, 1, 1, '', 136);
INSERT INTO `jc_cat` VALUES (137, '质感涂料', 131, 137, 0, 0, 1, 1, '', 137);
INSERT INTO `jc_cat` VALUES (138, '仿石漆', 131, 138, 0, 0, 1, 1, '', 138);
INSERT INTO `jc_cat` VALUES (139, '艺术帛', 131, 139, 0, 0, 1, 1, '', 139);
INSERT INTO `jc_cat` VALUES (140, '平面艺术漆', 131, 140, 0, 0, 1, 1, '', 140);
INSERT INTO `jc_cat` VALUES (141, '裂纹漆，贝母漆，砂岩雕刻漆，墙体浮雕漆', 131, 141, 0, 0, 1, 1, '', 141);
INSERT INTO `jc_cat` VALUES (142, '彩绘壁画', 131, 142, 0, 0, 1, 1, '', 142);
INSERT INTO `jc_cat` VALUES (143, '木材', 1, 143, 0, 0, 1, 0, '', 143);
INSERT INTO `jc_cat` VALUES (144, '木质装饰制品', 143, 144, 0, 0, 1, 0, '', 144);
INSERT INTO `jc_cat` VALUES (145, '实木地板', 144, 145, 0, 0, 1, 1, '', 145);
INSERT INTO `jc_cat` VALUES (146, '实木条木地板', 144, 146, 0, 0, 1, 1, '', 146);
INSERT INTO `jc_cat` VALUES (147, '实木拼花地板', 144, 147, 0, 0, 1, 1, '', 147);
INSERT INTO `jc_cat` VALUES (148, '实木马赛克', 144, 148, 0, 0, 1, 1, '', 148);
INSERT INTO `jc_cat` VALUES (149, '复合地板', 144, 149, 0, 0, 1, 1, '', 149);
INSERT INTO `jc_cat` VALUES (150, '防腐木', 143, 150, 0, 0, 1, 0, '', 150);
INSERT INTO `jc_cat` VALUES (151, '俄罗斯樟子松', 150, 151, 0, 0, 1, 1, '', 151);
INSERT INTO `jc_cat` VALUES (152, '北欧赤松', 150, 152, 0, 0, 1, 1, '', 152);
INSERT INTO `jc_cat` VALUES (153, '西部红雪松', 150, 153, 0, 0, 1, 1, '', 153);
INSERT INTO `jc_cat` VALUES (154, '芬兰木', 150, 154, 0, 0, 1, 1, '', 154);
INSERT INTO `jc_cat` VALUES (155, '菠萝格等', 150, 155, 0, 0, 1, 1, '', 155);
INSERT INTO `jc_cat` VALUES (156, '碳化木', 143, 156, 0, 0, 1, 0, '', 156);
INSERT INTO `jc_cat` VALUES (157, '软木', 156, 157, 0, 0, 1, 1, '', 157);
INSERT INTO `jc_cat` VALUES (158, '软木地板', 156, 158, 0, 0, 1, 1, '', 158);
INSERT INTO `jc_cat` VALUES (159, '软木墙板', 156, 159, 0, 0, 1, 1, '', 159);
INSERT INTO `jc_cat` VALUES (160, '木装饰线条', 156, 160, 0, 0, 1, 1, '', 160);
INSERT INTO `jc_cat` VALUES (161, '玻璃', 1, 161, 0, 0, 1, 0, '', 161);
INSERT INTO `jc_cat` VALUES (162, '装饰玻璃', 161, 162, 0, 0, 1, 0, '', 162);
INSERT INTO `jc_cat` VALUES (163, '平板玻璃', 162, 163, 0, 0, 1, 1, '', 163);
INSERT INTO `jc_cat` VALUES (164, '压花玻璃', 162, 164, 0, 0, 1, 1, '', 164);
INSERT INTO `jc_cat` VALUES (165, '釉面玻璃', 162, 165, 0, 0, 1, 1, '', 165);
INSERT INTO `jc_cat` VALUES (166, '镜面玻璃', 162, 166, 0, 0, 1, 1, '', 166);
INSERT INTO `jc_cat` VALUES (167, '冰花玻璃', 162, 167, 0, 0, 1, 1, '', 167);
INSERT INTO `jc_cat` VALUES (168, '玻璃砖', 162, 168, 0, 0, 1, 1, '', 168);
INSERT INTO `jc_cat` VALUES (169, '玻璃马赛克', 162, 169, 0, 0, 1, 1, '', 169);
INSERT INTO `jc_cat` VALUES (170, '彩绘玻璃', 162, 170, 0, 0, 1, 1, '', 170);
INSERT INTO `jc_cat` VALUES (171, '热熔玻璃', 162, 171, 0, 0, 1, 1, '', 171);
INSERT INTO `jc_cat` VALUES (172, '织物', 1, 172, 0, 0, 1, 0, '', 172);
INSERT INTO `jc_cat` VALUES (173, '墙面装饰织物', 172, 173, 0, 0, 1, 0, '', 173);
INSERT INTO `jc_cat` VALUES (174, '织物壁纸', 173, 174, 0, 0, 1, 1, '', 174);

SET FOREIGN_KEY_CHECKS = 1;
