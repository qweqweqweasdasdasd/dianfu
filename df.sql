/*
Navicat MySQL Data Transfer

Source Server         : test
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : df

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2018-09-05 16:05:37
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for df_client
-- ----------------------------
DROP TABLE IF EXISTS `df_client`;
CREATE TABLE `df_client` (
  `u_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nikename` char(20) DEFAULT '',
  `realname` varchar(10) DEFAULT '',
  `tel` char(12) DEFAULT '',
  `pingtai` varchar(10) DEFAULT '',
  `regtime` varchar(20) DEFAULT '',
  `loginlasttime` varchar(20) DEFAULT '',
  `daili` varchar(100) DEFAULT '',
  `http` varchar(100) DEFAULT '',
  `c_money` varchar(150) DEFAULT '',
  `t_money` varchar(150) DEFAULT '',
  `status` char(5) DEFAULT '0' COMMENT '回访状态',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `order_li` varchar(20) DEFAULT '',
  `desc` text,
  PRIMARY KEY (`u_id`),
  UNIQUE KEY `nikename` (`nikename`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of df_client
-- ----------------------------

-- ----------------------------
-- Table structure for df_export
-- ----------------------------
DROP TABLE IF EXISTS `df_export`;
CREATE TABLE `df_export` (
  `e_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `e_order` char(30) DEFAULT '',
  `mg_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`e_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of df_export
-- ----------------------------

-- ----------------------------
-- Table structure for df_fenpei
-- ----------------------------
DROP TABLE IF EXISTS `df_fenpei`;
CREATE TABLE `df_fenpei` (
  `f_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(20) DEFAULT '',
  `r_id` int(11) DEFAULT NULL,
  `sum` varchar(20) DEFAULT '',
  `status` varchar(10) DEFAULT '1',
  `desc` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`f_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of df_fenpei
-- ----------------------------
INSERT INTO `df_fenpei` VALUES ('11', '当日回访700', '31', '5', '1', '当日回访200', '2018-08-31 20:21:04', '2018-09-05 12:21:57', null);
INSERT INTO `df_fenpei` VALUES ('12', '当日回访300', '32', '200', '0', '当日回访300', '2018-08-31 20:21:25', '2018-09-01 16:22:45', null);
INSERT INTO `df_fenpei` VALUES ('13', '当日回访400', '33', '300', '0', '当日回访400', '2018-08-31 20:21:48', '2018-09-01 15:07:59', null);
INSERT INTO `df_fenpei` VALUES ('14', '当日回访100', '30', '100', '0', '当日回访100', '2018-08-31 20:22:50', '2018-08-31 21:00:24', '2018-08-31 21:00:24');
INSERT INTO `df_fenpei` VALUES ('15', '回访100', '31', '100', '0', '规则重复', '2018-08-31 20:27:58', '2018-09-04 13:16:39', null);

-- ----------------------------
-- Table structure for df_import
-- ----------------------------
DROP TABLE IF EXISTS `df_import`;
CREATE TABLE `df_import` (
  `i_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `order_li` varchar(20) DEFAULT '',
  `mg_id` int(11) DEFAULT '0',
  `count` char(11) DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`i_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of df_import
-- ----------------------------

-- ----------------------------
-- Table structure for df_jobs
-- ----------------------------
DROP TABLE IF EXISTS `df_jobs`;
CREATE TABLE `df_jobs` (
  `j_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `u_id` int(11) DEFAULT '0',
  `mg_id` int(11) DEFAULT '0',
  `status` int(11) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`j_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of df_jobs
-- ----------------------------

-- ----------------------------
-- Table structure for df_manager
-- ----------------------------
DROP TABLE IF EXISTS `df_manager`;
CREATE TABLE `df_manager` (
  `mg_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `mg_name` varchar(64) DEFAULT '',
  `password` char(70) DEFAULT '',
  `role_id` int(11) DEFAULT NULL,
  `session_id` varchar(50) DEFAULT '',
  `IP` varchar(10) DEFAULT '',
  `last_login_time` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `status` enum('0','1') DEFAULT '1' COMMENT '1,开启0,冻结',
  `remember_token` varchar(255) DEFAULT '',
  PRIMARY KEY (`mg_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of df_manager
-- ----------------------------
INSERT INTO `df_manager` VALUES ('1', 'admin123', '$2y$10$Cnbfxcd0OCWPklg9aw7esebnZYN96VXwsnwSwOAnJbvilRc50VIgG', null, 'Een1XH73k1G0VlnEwj56Hf0q8FoDLCaZGuimVgKy', '127.0.0.1', '2018-09-05 15:46:02', '2018-08-19 18:47:39', '2018-09-05 15:46:35', null, '1', 'pgTQSr2KlJCDfuou99deBSDppzwQ1EnH3e7FxhwIRReAhVva2QEHednHiiyO');
INSERT INTO `df_manager` VALUES ('2', '乐乐', '$2y$10$xVz58Z4wovBhCnEHo6kVge28z9.kna.mxicsHxUEQQADFrx.proji', '31', '648mtlgHerrVWPnsN6xoqNiYDefbDDgb8ey0Wc9H', '127.0.0.1', '2018-09-05 14:21:52', '2018-08-21 19:01:45', '2018-09-05 15:46:09', null, '1', 'WDnmXYzahPckrFmNHw4z9lW84AstPND0oMqxJkItHGivyR3a7khhvSDyLPCo');
INSERT INTO `df_manager` VALUES ('4', '鹏飞', '$2y$10$xtpQt4LnOlEuSrBZ.dIHIOqsJC3wWy6se018xDY/5zZe4/JslCG0G', '31', '8FqRYMCBSemxpdsIcJrfLNxuUZeT31Iwu6lh0KHg', '127.0.0.1', '2018-09-05 14:28:28', '2018-08-22 04:31:21', '2018-09-05 14:28:28', null, '1', '2LsA0Y721hLE6ZDG3Dahg0Li9xMrWQYQxGshkvauSg7sFUO7dzYHus64wxec');
INSERT INTO `df_manager` VALUES ('18', '阿里', '$2y$10$XrDBHCUa8DykKRBXuRps/OXs1kUKM5/tFjoN0aiEHnmpVMk3QSeOS', '32', 'epZSfELQYXU2xFUgCEKktp5q0xnnp7laGGWC45dC', '127.0.0.1', '2018-08-22 15:10:56', '2018-08-22 15:09:11', '2018-08-31 21:22:57', null, '1', 'oZ6OWY9e0m6KapDS2rQEzdEPx2KFPS6ZlCvdWXKCzlZuPlMoldKhHWBdLvb0');

-- ----------------------------
-- Table structure for df_permission
-- ----------------------------
DROP TABLE IF EXISTS `df_permission`;
CREATE TABLE `df_permission` (
  `p_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `p_name` varchar(20) DEFAULT '',
  `ps_pid` int(11) DEFAULT NULL,
  `ps_c` varchar(32) DEFAULT '',
  `ps_a` varchar(32) DEFAULT '',
  `ps_route` varchar(100) DEFAULT '',
  `ps_level` char(10) DEFAULT '',
  `icon` varchar(20) DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`p_id`)
) ENGINE=InnoDB AUTO_INCREMENT=156 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of df_permission
-- ----------------------------
INSERT INTO `df_permission` VALUES ('100', '客户管理', null, '', '', '', '0', '', '2018-08-20 14:30:55', '2018-08-20 11:19:09', null);
INSERT INTO `df_permission` VALUES ('101', '回访管理', null, null, null, null, '0', '', '2018-08-20 14:30:57', '2018-08-24 21:00:12', null);
INSERT INTO `df_permission` VALUES ('102', '工作管理', null, null, null, null, '0', '', '2018-08-20 14:31:00', '2018-08-31 13:47:37', null);
INSERT INTO `df_permission` VALUES ('103', '权限管理', null, '', '', '', '0', '', '2018-08-20 14:31:02', '2018-08-20 11:20:25', null);
INSERT INTO `df_permission` VALUES ('104', '客户信息', '100', 'client', 'show', '/client/show', '1', '', '2018-08-20 14:31:05', '2018-08-30 17:49:35', null);
INSERT INTO `df_permission` VALUES ('105', '客户导入', '100', 'client', 'index', '/client/index', '1', '', '2018-08-20 15:15:07', '2018-08-29 13:41:09', null);
INSERT INTO `df_permission` VALUES ('106', '权限列表', '103', 'permission', 'index', '/permission/index', '1', '', '2018-08-20 15:17:08', '2018-08-20 11:33:53', null);
INSERT INTO `df_permission` VALUES ('107', '显示编辑权限', '106', 'permission', 'show', '/permission/show', '2', '', '2018-08-20 10:00:27', '2018-08-20 11:20:29', null);
INSERT INTO `df_permission` VALUES ('108', '显示添加权限', '106', 'permission', 'create', '/permission/create', '2', '', '2018-08-20 10:03:56', '2018-08-20 11:20:31', null);
INSERT INTO `df_permission` VALUES ('109', '用户组列表', '103', 'role', 'index', '/role/index', '1', '', '2018-08-20 10:05:13', '2018-08-20 11:33:33', null);
INSERT INTO `df_permission` VALUES ('110', '显示添加组', '109', 'role', 'create', '/role/create', '2', '', '2018-08-20 10:05:15', '2018-08-21 04:17:22', null);
INSERT INTO `df_permission` VALUES ('111', '添加保存', '109', 'role', 'store', '/role/store', '2', '', '2018-08-20 10:06:34', '2018-08-21 04:19:16', null);
INSERT INTO `df_permission` VALUES ('112', '用户管理', '103', 'manager', 'index', '/manager/index', '1', '', '2018-08-20 10:06:56', '2018-09-04 19:42:52', null);
INSERT INTO `df_permission` VALUES ('113', '删除角色', '109', 'role', 'del', '/role/del', '2', '', '2018-08-20 10:06:58', '2018-08-21 04:15:32', null);
INSERT INTO `df_permission` VALUES ('114', '删除权限', '106', 'permission', 'del', '/permission/del', '2', '', '2018-08-20 10:07:07', '2018-08-20 11:27:38', null);
INSERT INTO `df_permission` VALUES ('115', '保存编辑权限', '106', 'permission', 'save', '/permission/save', '2', '', '2018-08-20 10:07:49', '2018-08-20 10:49:30', null);
INSERT INTO `df_permission` VALUES ('116', '保存权限', '106', 'permission', 'store', '/permission/store', '2', '', '2018-08-20 10:28:48', '2018-08-20 10:28:48', null);
INSERT INTO `df_permission` VALUES ('117', '显示权限页面', '109', 'role', 'qxview', '/role/qxview', '2', '', '2018-08-21 04:25:40', '2018-08-21 08:30:59', null);
INSERT INTO `df_permission` VALUES ('118', '保存分配权限', '109', 'role', 'qxsave', '/role/qxsave', '2', '', '2018-08-21 08:31:24', '2018-08-21 08:31:33', null);
INSERT INTO `df_permission` VALUES ('119', '用户删除', '112', 'manager', 'del', '/manager/del', '2', '', '2018-08-21 08:35:24', '2018-08-21 11:37:56', null);
INSERT INTO `df_permission` VALUES ('120', '用户修改状态', '112', 'manager', 'setstatus', '/manager/setstatus', '2', '', '2018-08-21 12:25:13', '2018-08-21 12:25:13', null);
INSERT INTO `df_permission` VALUES ('121', '白名单设置', '112', 'whitelist', 'index', '/whitelist', '2', '', '2018-08-21 12:27:58', '2018-08-22 20:58:47', null);
INSERT INTO `df_permission` VALUES ('122', '用户添加页面', '112', 'manager', 'create', '/manager/create', '2', '', '2018-08-21 13:02:45', '2018-08-21 13:02:45', null);
INSERT INTO `df_permission` VALUES ('123', '用户添加保存', '112', 'manager', 'stroe', '/manager/stroe', '2', '', '2018-08-22 04:24:18', '2018-08-22 04:24:18', null);
INSERT INTO `df_permission` VALUES ('124', '用户编辑显示', '112', 'manager', 'edit', '/manager/edit', '2', '', '2018-08-22 04:46:55', '2018-08-22 04:46:55', null);
INSERT INTO `df_permission` VALUES ('125', '用户编辑更新', '112', 'manager', 'update', '/manager/update', '2', '', '2018-08-22 13:19:28', '2018-08-22 13:19:28', null);
INSERT INTO `df_permission` VALUES ('126', '修改用户密码', '112', 'manager', 'resetpwd', '/manager/resetpwd', '2', '', '2018-08-22 14:07:35', '2018-08-22 14:11:24', null);
INSERT INTO `df_permission` VALUES ('127', '保存白名单', '112', 'whitelist', 'store', '/whitelist/store', '2', '', '2018-08-22 21:53:27', '2018-08-22 21:53:27', null);
INSERT INTO `df_permission` VALUES ('128', '删除白名单', '112', 'whitelist', 'destroy', '/whitelist/destroy', '2', '', '2018-08-23 12:57:31', '2018-08-23 12:57:31', null);
INSERT INTO `df_permission` VALUES ('129', '导入csv', '105', 'server', 'import', '/import', '2', '', '2018-08-23 15:53:52', '2018-08-29 14:24:12', null);
INSERT INTO `df_permission` VALUES ('130', '数据回滚(物理)', '105', 'server', 'rollback', '/rollback', '2', '', '2018-08-24 15:50:37', '2018-08-30 17:09:40', null);
INSERT INTO `df_permission` VALUES ('131', '客户详情页面', '104', 'client', 'info', '/client/info', '2', '', '2018-08-24 17:39:56', '2018-08-30 20:47:35', null);
INSERT INTO `df_permission` VALUES ('132', '编辑显示', '104', 'client', 'edit', '/client/edit', '2', '', '2018-08-24 18:49:55', '2018-09-02 17:56:45', null);
INSERT INTO `df_permission` VALUES ('133', '编辑更新', '104', 'client', 'update', '/client/update', '2', '', '2018-08-24 19:42:15', '2018-09-02 18:17:26', null);
INSERT INTO `df_permission` VALUES ('134', '回访导出', '134', 'server', 'show', '/export/show', '2', '', '2018-08-24 20:34:22', '2018-09-04 15:19:51', null);
INSERT INTO `df_permission` VALUES ('135', '工作流', '101', 'work', 'workflow', '/work/index', '1', '', '2018-08-25 12:48:41', '2018-08-31 13:28:34', null);
INSERT INTO `df_permission` VALUES ('136', '已回访记录', '101', 'work', 'visit', '/work/visit', '1', '', '2018-08-25 12:49:29', '2018-09-02 12:43:05', null);
INSERT INTO `df_permission` VALUES ('137', '删除分配', '140', 'fenpei', 'destroy', '/fenpei/destroy', '2', '', '2018-08-25 14:39:41', '2018-08-31 18:47:57', null);
INSERT INTO `df_permission` VALUES ('138', '添加保存', '140', 'fenpei', 'store', '/fenpei/store', '2', '', '2018-08-25 14:54:33', '2018-08-31 16:27:52', null);
INSERT INTO `df_permission` VALUES ('139', '添加显示', '140', 'fenpei', 'create', '/fenpei/create', '2', '', '2018-08-25 17:08:28', '2018-09-05 15:42:47', null);
INSERT INTO `df_permission` VALUES ('140', '工作分配', '102', 'fenpei', 'index', '/fenpei/index', '1', '', '2018-08-25 20:00:29', '2018-08-31 14:46:02', null);
INSERT INTO `df_permission` VALUES ('141', '发送短信接口', '136', 'sms', 'send', '/sms/send', '2', '', '2018-08-25 20:32:44', '2018-08-25 20:35:38', '2018-08-25 20:35:38');
INSERT INTO `df_permission` VALUES ('142', '显示编辑', '140', 'fenpei', 'edit', '/fenpei/edit', '2', '', '2018-08-31 19:14:08', '2018-08-31 19:14:08', null);
INSERT INTO `df_permission` VALUES ('143', '更新编辑', '140', 'fenpei', 'update', '/fenpei/update', '2', '', '2018-08-31 19:47:44', '2018-08-31 19:47:44', null);
INSERT INTO `df_permission` VALUES ('144', '当月统计', '155', 'count', 'month', '/count/month', '2', '', '2018-08-31 21:53:45', '2018-09-05 14:22:14', '2018-09-05 14:22:14');
INSERT INTO `df_permission` VALUES ('145', '定时任务', '140', 'work', 'jobs', '/work/jobs', '2', '', '2018-09-01 14:07:29', '2018-09-01 14:07:53', null);
INSERT INTO `df_permission` VALUES ('146', '修改处理中', '135', 'work', 'workingstatus', '/work/workingstatus', '2', '', '2018-09-01 19:14:17', '2018-09-01 19:14:50', null);
INSERT INTO `df_permission` VALUES ('147', '显示添加回访', '135', 'work', 'add_visit', '/work/add_visit', '2', '', '2018-09-01 19:40:00', '2018-09-01 19:40:00', null);
INSERT INTO `df_permission` VALUES ('148', '保存回访', '135', 'work', 'store', '/work/store', '2', '', '2018-09-01 20:02:44', '2018-09-01 20:02:44', null);
INSERT INTO `df_permission` VALUES ('149', '查看客户信息', '136', 'work', 'info', '/work/info', '2', '', '2018-09-02 13:37:36', '2018-09-02 13:37:36', null);
INSERT INTO `df_permission` VALUES ('150', '会员回访详情', '136', 'work', 'visitzi', '/work/visitzi', '2', '', '2018-09-02 14:03:27', '2018-09-03 14:34:01', null);
INSERT INTO `df_permission` VALUES ('151', '退回重新回访', '136', 'work', 'rollback', '/work/rollback', '2', '', '2018-09-02 14:56:54', '2018-09-02 14:56:54', null);
INSERT INTO `df_permission` VALUES ('152', '回访导出', '101', 'server', 'show', '/export/show', '1', '', '2018-09-04 15:19:33', '2018-09-04 15:22:12', null);
INSERT INTO `df_permission` VALUES ('153', '回访操作', '152', 'server', 'export', '/export', '2', '', '2018-09-04 15:23:18', '2018-09-04 17:55:21', null);
INSERT INTO `df_permission` VALUES ('154', '自带下载方法', '152', 'server', 'download', '/download', '2', '', '2018-09-04 17:58:56', '2018-09-04 18:08:43', null);
INSERT INTO `df_permission` VALUES ('155', '回访统计', '102', 'count', 'index', '/count/index', '1', '', '2018-09-04 19:16:00', '2018-09-05 14:22:17', '2018-09-05 14:22:17');

-- ----------------------------
-- Table structure for df_role
-- ----------------------------
DROP TABLE IF EXISTS `df_role`;
CREATE TABLE `df_role` (
  `r_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `r_name` char(10) DEFAULT '',
  `ps_ids` text,
  `ps_ca` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`r_id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of df_role
-- ----------------------------
INSERT INTO `df_role` VALUES ('30', '主管', '100,104,131,132,133,105,129,130,101,135,146,147,148,136,149,150,151,152,153,154,102,140,137,138,139,142,143,145,155,144,103,106,107,108,114,115,116,109,110,111,113,117,118,112,119,120,121,122,123,124,125,126,127,128', 'client-show,client-index,permission-index,permission-show,permission-create,role-index,role-create,role-store,manager-index,role-del,permission-del,permission-save,permission-store,role-qxview,role-qxsave,manager-del,manager-setstatus,whitelist-index,manager-create,manager-stroe,manager-edit,manager-update,manager-resetpwd,whitelist-store,whitelist-destroy,server-import,server-rollback,client-info,client-edit,client-update,work-workflow,work-visit,fenpei-destroy,fenpei-store,fenpei-create,fenpei-index,fenpei-edit,fenpei-update,count-month,work-jobs,work-workingstatus,work-add_visit,work-store,work-info,work-visitzi,work-rollback,server-show,server-export,server-download,count-index', '2018-08-20 20:14:06', '2018-09-04 20:35:17', null);
INSERT INTO `df_role` VALUES ('31', '回访一组', '100,104,131,132,133,105,129,130,101,135,146,147,148,136,149,150,151,152,153,154,102,140,137,138,139,142,143,145,155,144', 'client-show,client-index,server-import,server-rollback,client-info,client-edit,client-update,work-workflow,work-visit,fenpei-destroy,fenpei-store,fenpei-create,fenpei-index,fenpei-edit,fenpei-update,count-month,work-jobs,work-workingstatus,work-add_visit,work-store,work-info,work-visitzi,work-rollback,server-show,server-export,server-download,count-index', '2018-08-20 20:14:09', '2018-09-04 20:35:03', null);
INSERT INTO `df_role` VALUES ('32', '回访二组', '100,104,131,132,133,105,129,130,101,135,146,147,148,136,149,150,151,152,153,154,102,140,137,138,139,142,143,145,155,144', 'client-show,client-index,server-import,server-rollback,client-info,client-edit,client-update,work-workflow,work-visit,fenpei-destroy,fenpei-store,fenpei-create,fenpei-index,fenpei-edit,fenpei-update,1-1,work-jobs,work-workingstatus,work-add_visit,work-store,work-info,work-visitzi,work-rollback,server-show,server-export,server-download,count-index', '2018-08-20 13:30:21', '2018-09-04 19:33:18', null);
INSERT INTO `df_role` VALUES ('33', '回访三组', '100,104,131,132,133,105,129,130,101,135,146,147,148,136,149,150,151,152,153,154,102,140,137,138,139,142,143,145,155,144', 'client-show,client-index,server-import,server-rollback,client-info,client-edit,client-update,work-workflow,work-visit,fenpei-destroy,fenpei-store,fenpei-create,fenpei-index,fenpei-edit,fenpei-update,1-1,work-jobs,work-workingstatus,work-add_visit,work-store,work-info,work-visitzi,work-rollback,server-show,server-export,server-download,count-index', '2018-08-20 13:31:03', '2018-09-04 19:33:26', null);

-- ----------------------------
-- Table structure for df_visit
-- ----------------------------
DROP TABLE IF EXISTS `df_visit`;
CREATE TABLE `df_visit` (
  `v_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT '',
  `content` text,
  `j_id` int(11) DEFAULT '0',
  `is_yuehui` char(11) DEFAULT 'F',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`v_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of df_visit
-- ----------------------------

-- ----------------------------
-- Table structure for df_whitelist
-- ----------------------------
DROP TABLE IF EXISTS `df_whitelist`;
CREATE TABLE `df_whitelist` (
  `w_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_addr` text,
  `mg_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`w_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of df_whitelist
-- ----------------------------
