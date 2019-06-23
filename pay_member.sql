/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : qiswljuhe

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2019-04-28 01:57:07
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for pay_member
-- ----------------------------
DROP TABLE IF EXISTS `pay_member`;
CREATE TABLE `pay_member` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL COMMENT '用户名',
  `password` varchar(32) NOT NULL COMMENT '密码',
  `groupid` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '用户组',
  `salt` varchar(10) NOT NULL COMMENT '密码随机字符',
  `parentid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '代理ID',
  `agent_cate` int(11) NOT NULL DEFAULT '0' COMMENT '代理级别',
  `balance` decimal(15,4) unsigned NOT NULL DEFAULT '0.0000' COMMENT '可用余额',
  `blockedbalance` decimal(15,4) unsigned NOT NULL DEFAULT '0.0000' COMMENT '冻结可用余额',
  `email` varchar(100) NOT NULL,
  `activate` varchar(200) NOT NULL,
  `regdatetime` int(11) unsigned NOT NULL DEFAULT '0',
  `activatedatetime` int(11) unsigned NOT NULL DEFAULT '0',
  `realname` varchar(50) DEFAULT NULL COMMENT '姓名',
  `sex` tinyint(1) NOT NULL DEFAULT '1' COMMENT '性别',
  `birthday` int(11) NOT NULL DEFAULT '0',
  `sfznumber` varchar(20) DEFAULT NULL,
  `mobile` varchar(15) DEFAULT NULL COMMENT '联系电话',
  `qq` varchar(15) DEFAULT NULL COMMENT 'QQ',
  `address` varchar(200) DEFAULT NULL COMMENT '联系地址',
  `paypassword` varchar(32) DEFAULT NULL COMMENT '支付密码',
  `authorized` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '1 已认证 0 未认证 2 待审核',
  `apidomain` varchar(500) DEFAULT NULL COMMENT '授权访问域名',
  `apikey` varchar(32) NOT NULL COMMENT 'APIKEY',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态 1激活 0未激活',
  `receiver` varchar(255) DEFAULT NULL COMMENT '台卡显示的收款人信息',
  `unit_paying_number` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '单位时间已交易次数',
  `unit_paying_amount` decimal(11,4) unsigned NOT NULL DEFAULT '0.0000' COMMENT '单位时间已交易金额',
  `unit_frist_paying_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '单位时间已交易的第一笔时间',
  `last_paying_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '当天最后一笔已交易时间',
  `paying_money` decimal(15,4) unsigned NOT NULL DEFAULT '0.0000' COMMENT '当天已交易金额',
  `login_ip` varchar(255) NOT NULL DEFAULT ' ' COMMENT '登录IP',
  `last_error_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最后登录错误时间',
  `login_error_num` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '错误登录次数',
  `google_auth` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否开启谷歌身份验证登录',
  `df_api` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否开启代付API',
  `open_charge` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否开启充值功能',
  `df_domain` text NOT NULL COMMENT '代付域名报备',
  `df_auto_check` tinyint(1) NOT NULL DEFAULT '0' COMMENT '代付API自动审核',
  `google_secret_key` varchar(255) NOT NULL DEFAULT '' COMMENT '谷歌密钥',
  `df_ip` text NOT NULL COMMENT '代付域名报备IP',
  `session_random` varchar(50) NOT NULL DEFAULT '' COMMENT 'session随机字符串',
  `df_charge_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '代付API扣除手续费方式，0：从到账金额里扣，1：从商户余额里扣',
  `last_login_time` int(11) NOT NULL DEFAULT '0' COMMENT '最后登录时间',
  `yckbalance` decimal(11,4) NOT NULL DEFAULT '0.0000' COMMENT '预存款余额',
  `agbalance` decimal(11,4) NOT NULL DEFAULT '0.0000' COMMENT '需要代理结算的余额',
  `can_take_money` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否可以操作预存款',
  `can_sh` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否可以上号',
  `path_id` varchar(255) DEFAULT '0,',
  `codeblockedbalance` decimal(15,4) NOT NULL DEFAULT '0.0000' COMMENT '码商冻结余额',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=102 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pay_member
-- ----------------------------
INSERT INTO `pay_member` VALUES ('4', '测试代理', '', '7', '4795', '0', '5', '269.5480', '0.0000', '123@qq.com', '0ba9f6747b481338cd23acd442aab54d', '1539491041', '2018', '测试代理', '0', '-28800', '123', '123', '123', '123', 'e10adc3949ba59abbe56e057f20f883e', '1', null, 'fyih7q2fmzrqrb732dczsnk34ajjgeso', '1', null, '55', '389.9034', '0', '1555835029', '389.9034', '', '0', '0', '0', '1', '0', '', '0', '', '', 'HIerD3oPiaY6Z97EEyPIWPBWo1NItHqA', '0', '1541505024', '0.0000', '0.0000', '1', '1', '0,U4,', '0.0000');
INSERT INTO `pay_member` VALUES ('5', '测试用户', '', '4', '8125', '101', '0', '8525.3624', '9004.8000', '34534@qq.com', 'ca8f925d2a2cd525743813b20226325b', '1539491153', '0', '测试用户', '0', '-28800', '234', '13208952500', '2345', '123', 'e10adc3949ba59abbe56e057f20f883e', '1', null, 'ud7xh8rc24c6c7jm0l3cxdmcyewi84a2', '1', null, '65', '17528.9360', '0', '1556294654', '17528.9360', '', '0', '0', '0', '0', '1', '', '0', '', '', 'ruAnAsHIehxDK0MAJycmMH7ZSrxHomiy', '0', '1547190095', '99.9460', '0.0000', '0', '1', '0,U5,U67,C96,C101,U5,', '0.0000');
INSERT INTO `pay_member` VALUES ('67', 'qingmiao', '', '7', '5294', '101', '7', '600.2460', '4992.5000', '834429797@qq.com', '5e9d736ce99e8efbd9ac9f8798638784', '1554277643', '2019', '轻描淡写', '1', '1554220800', '410523', '1230', '834429797', '123', 'e10adc3949ba59abbe56e057f20f883e', '1', null, 's0qiaegxern7s8tf9v73omcauebxhoeg', '1', null, '1', '4992.5000', '0', '1555147703', '4992.5000', '', '0', '0', '0', '0', '0', '', '0', '', '', '5M8SaSA8522ON74Rlde6JKL1r8qiRXac', '0', '1555446759', '11.6490', '0.0000', '0', '1', '0,C96,C101,U67,', '0.0000');
INSERT INTO `pay_member` VALUES ('68', 'feiniao', '', '7', '1649', '67', '7', '709.9700', '0.0000', '1107821400@qq.com', '8feb6e5b35cfdcd5db3f004eab10a8de', '1554278640', '2019', '飞鸟网络工作室', '1', '-28800', '1107821400', '1107821400', '1107821400', '123', 'e10adc3949ba59abbe56e057f20f883e', '1', null, 'iz65gw7dq2hzdb5x68mwbmr4xqidns37', '1', null, '3', '11.9640', '0', '1555498235', '11.9640', '', '0', '0', '0', '0', '0', '', '0', '', '', 'ZwaBrumL9KzNfYomLdt4bZoIw0Wwa08C', '0', '1555470152', '98.9940', '0.0000', '1', '1', '0,C96,C101,U67,U68,', '0.0000');
INSERT INTO `pay_member` VALUES ('69', 'cs123456', '', '4', '9772', '67', '0', '1.7360', '0.0000', '123456@qq.com', 'aa16475764c471b2cabef2917b73f02d', '1554285370', '0', 'www.baidu.com', '1', '-28800', '百度', '15860111111', '123456', '123', 'e10adc3949ba59abbe56e057f20f883e', '1', null, 'o36e3d0ca0uv526yduyt7zo677m6xik2', '1', null, '3', '11.7360', '0', '1555147642', '11.7360', ' ', '0', '0', '0', '0', '1', '', '0', '', '', '3r7R19IwvJhiAS73rNtNDMi5rzvQ7cpn', '0', '1555147505', '11.2000', '0.0000', '0', '0', '0,U5,U67,U69,', '0.0000');
INSERT INTO `pay_member` VALUES ('70', 'baofu2000', '', '7', '4611', '0', '7', '0.0000', '0.0000', '2168223369', 'b014811ce8dd66c922faf3a34245263a', '1554299323', '2019', 'baofu2000', '1', '1554220800', 'baofu2000', 'baofu2000', '2168223369', '2168223369', 'e10adc3949ba59abbe56e057f20f883e', '1', null, 'cpikjhq3v8htcjyf3kgic1biunkbh82n', '0', null, '0', '0.0000', '0', '0', '0.0000', '', '0', '0', '0', '0', '0', '', '0', '', '', 'Cx3vyKS1eCOd1xin9l4PvsoPUUG9cuO1', '0', '1554430540', '99.9700', '0.0000', '0', '0', '0,70,', '0.0000');
INSERT INTO `pay_member` VALUES ('71', 'baofu200', '427b3d2ee510b9ec2d70a2700bff2077', '4', '6404', '70', '0', '0.0000', '0.0000', '3425343@qq.com', '0320cedd632d47f64a1e5eb77c7aef8c', '1554303178', '0', '三只熊', '1', '0', 'www.szxpay.com', '13202023030', '34532452', null, 'e10adc3949ba59abbe56e057f20f883e', '1', null, '0q5loq3hxvv126hmog6uedeyudgrblo9', '0', null, '1', '9.9700', '0', '1554349915', '9.9700', ' ', '0', '0', '0', '0', '1', '', '0', '', '', 'r6dM2nrep2jkoCStnX8ZPqpZsfdXt0Uu', '0', '1554350913', '0.0000', '0.0000', '0', '0', '0,', '0.0000');
INSERT INTO `pay_member` VALUES ('72', 'xiaxia', '', '7', '9975', '0', '7', '0.0000', '0.0000', 'xiaxia', '9deb6aa39973439f41b335a1a3d56385', '1554304213', '2019', 'xiaxia', '1', '1554220800', 'xiaxia', 'xiaxia', 'xiaxia', 'xiaxia', 'e10adc3949ba59abbe56e057f20f883e', '1', null, 'omkqvl5xrpmaczmaq1xt665d244brsp0', '1', null, '0', '0.0000', '0', '0', '0.0000', '', '0', '0', '0', '0', '0', '', '0', '', '', 'if8GGMP1Eh2ydTqiovgU6YPTX0QmUhdx', '0', '1555602863', '0.0000', '0.0000', '0', '1', '0,U72,', '0.0000');
INSERT INTO `pay_member` VALUES ('73', 'ha520as', '86a993d7984cc344a8ddd516449f62af', '4', '7112', '0', '0', '0.0000', '0.0000', '1107821400@qq.com', '3ba8f8be814e5299f6057b3cbedf2d42', '1554608066', '0', null, '1', '0', null, null, null, null, 'e10adc3949ba59abbe56e057f20f883e', '1', null, '5odkx9b3bwr5wux0q03w1uvta1hjzhgp', '0', null, '0', '0.0000', '0', '0', '0.0000', ' ', '0', '0', '0', '0', '0', '', '0', '', '', '', '0', '0', '0.0000', '0.0000', '0', '0', '0,', '0.0000');
INSERT INTO `pay_member` VALUES ('74', 'feiniao123', '', '7', '2470', '68', '0', '600.0000', '0.0000', '1849722399@qq.com', '806ca9a1a7236a593b97d826cb767259', '1554614089', '0', 'qianduoduo', '1', '-28800', 'http://www.cfepay.ne', '13636959932', '1849722399', '123456', 'e10adc3949ba59abbe56e057f20f883e', '1', null, 'psm1vbtyngqxh8myj7kew38bltmnfdfl', '1', null, '0', '0.0000', '0', '0', '0.0000', ' ', '0', '0', '0', '0', '0', '', '0', '', '', 'P1lbMJc7gMgz6FxVCUxlQ01a0duGIv68', '0', '1554619669', '1.0000', '0.0000', '0', '1', '0,C96,C101,U67,U68,U74,', '0.0000');
INSERT INTO `pay_member` VALUES ('75', 'feiniao111', '', '7', '7294', '68', '0', '0.0000', '0.0000', '1325865@qq.com', 'eef8534aa2db04ffc138d53ba6f270ad', '1554614436', '0', 'http://www.cfepay.net', '1', '-28800', 'http://www.cfepay.ne', '13325636532', '1325865', '123456', 'e10adc3949ba59abbe56e057f20f883e', '1', null, 'rzxadswd3lbdzrlyk0qd65n51tpqqi0y', '1', null, '8', '7.9790', '0', '1555165388', '7.9790', ' ', '0', '0', '0', '0', '0', '', '0', '', '', '2LI2oO6IEbrvshZT72EFKvCvCOrgRLGH', '0', '1555501675', '9.9790', '0.0000', '0', '1', '0,U5,U67,U68,U75,', '0.0000');
INSERT INTO `pay_member` VALUES ('76', 'feiniao1111', '', '5', '5596', '68', '0', '0.0000', '0.0000', '132586588@qq.com', 'fd239f1ec13b7f0c4ce611a62eba4543', '1554614459', '0', 'http://www.cfepay.net', '1', '-28800', 'http://www.cfepay.ne', '13325636532', '132586588', '123', 'e10adc3949ba59abbe56e057f20f883e', '1', null, 'trgps5l2n8byo5w9lptmsczfumzeu41u', '1', null, '0', '0.0000', '0', '0', '0.0000', ' ', '0', '0', '0', '0', '0', '', '0', '', '', '5VinFg65VfAGXDGo44j30ZWsM5U9bmE7', '0', '1554619706', '0.0000', '0.0000', '0', '0', '0,5,67,68,76,', '0.0000');
INSERT INTO `pay_member` VALUES ('77', 'hyy123456', '', '4', '8171', '0', '0', '0.0000', '0.0000', '410883@qq.com', 'a894d58b2bb817f60c2f7fd26a6ae66e', '1554618652', '0', '12344', '1', '-28800', 'hyy123456', 'hyy123456', 'hyy123456', 'hyy123456', 'e10adc3949ba59abbe56e057f20f883e', '1', null, '262h56rq4fbwyal76rqscgnunuwjllw1', '1', null, '0', '0.0000', '0', '0', '0.0000', ' ', '0', '0', '0', '0', '0', '', '0', '', '', '', '0', '0', '0.0000', '0.0000', '0', '0', '0,U77,', '0.0000');
INSERT INTO `pay_member` VALUES ('78', '一路有你', '61fac9e6bb1709ea42d37fa65b8ab0c5', '4', '8376', '75', '0', '0.0000', '0.0000', 'ww@163.com', '921c468ae59edc29d990401aa553f4a2', '1554625740', '0', 'www', '1', '0', 'www', '12343434232', '4444', null, 'e10adc3949ba59abbe56e057f20f883e', '1', null, 'vvle4jmzibrslj4azqovk2cloq2z5yoy', '1', null, '0', '0.0000', '0', '0', '0.0000', ' ', '0', '0', '0', '0', '0', '', '0', '', '', 'lSOMIzNehykWXJx4suUzTNUtk1JLaIDt', '0', '1554799992', '0.0000', '0.0000', '0', '0', '0,', '0.0000');
INSERT INTO `pay_member` VALUES ('79', 'testdiyici', 'b6ab9598fc8b587d6d9f356f32a11159', '4', '1351', '0', '0', '0.0000', '0.0000', 'testdiyici@163.com', 'b7ed1a4695c473a6c85d0c45e8d89ef0', '1554720513', '0', null, '1', '0', null, null, null, null, 'e10adc3949ba59abbe56e057f20f883e', '1', null, 'fee3us71b85ssntko70hg9ju1zi60h5o', '1', null, '0', '0.0000', '0', '0', '0.0000', ' ', '0', '0', '0', '0', '0', '', '0', '', '', '', '0', '0', '0.0000', '0.0000', '0', '0', '0,', '0.0000');
INSERT INTO `pay_member` VALUES ('80', 'skwx', '', '7', '4666', '0', '7', '0.0000', '0.0000', 'skwx', '10c254a4eff4cff70d0596fff34a998d', '1554783228', '2019', 'skwx', '0', '1554739200', 'skwx', 'skwx', 'skwx', 'skwx', 'e10adc3949ba59abbe56e057f20f883e', '1', null, 'g235mx9wt6d7r3bnhjre9he0pk77ujj6', '1', null, '1', '0.0100', '0', '1554786333', '0.0100', '', '0', '0', '0', '0', '0', '', '0', '', '', 'Kb2OJgEZAtFIW4TvPSeuupAEL1PxqmOi', '0', '1555397972', '0.0000', '0.0000', '0', '1', '0,80,', '0.0000');
INSERT INTO `pay_member` VALUES ('81', 'qas123459', '', '7', '6969', '0', '7', '0.0000', '0.0000', '277613829', '78dbe2dae67717541f61bf0a32dd654e', '1554785498', '2019', 'qas123459', '1', '-28800', 'qas123459', 'qas123459', '277613829', '277613829', 'e10adc3949ba59abbe56e057f20f883e', '1', null, 'e29q589lo412k2odk1c22co1ctet2x2k', '1', null, '0', '0.0000', '0', '0', '0.0000', '', '0', '0', '0', '0', '0', '', '0', '', '', 'eA35i8CEtHpOCZQ2cZT79nNdECaWHXb7', '0', '1555425415', '0.0000', '0.0000', '0', '1', '0,81,', '0.0000');
INSERT INTO `pay_member` VALUES ('82', 'defier', '', '7', '5768', '0', '7', '0.0000', '0.0000', 'defier', '4256558be293f1d83ac8e831c2db9801', '1554795958', '2019', 'defier', '0', '-28800', 'defier', 'defier', 'defier', 'defier', 'e10adc3949ba59abbe56e057f20f883e', '1', null, 'e6ihptppmzskmkeazhhl2c027tcmfqir', '1', null, '6', '0.0600', '0', '1555500571', '0.0600', '', '0', '0', '0', '0', '0', '', '0', '', '', '3LLTpIOE8nRHjc3JAkncxn6ShZMJfviC', '0', '1555500386', '1000.9968', '0.0000', '0', '1', '0,82,', '0.0000');
INSERT INTO `pay_member` VALUES ('83', '309600055', '', '4', '2009', '0', '7', '0.0000', '0.0000', '309600055', '338433d9b959a3568f09aa0dae5eef18', '1554805520', '2019', '漫画客户', '1', '-28800', '309600055', '309600055', '309600055', '309600055', 'e10adc3949ba59abbe56e057f20f883e', '1', null, '1yvnrjk9k1dq7xuqi9mkakiptl3oyc04', '1', null, '0', '0.0000', '0', '0', '0.0000', '', '0', '0', '0', '0', '0', '', '0', '', '', '', '0', '0', '0.0000', '0.0000', '0', '0', '0,', '0.0000');
INSERT INTO `pay_member` VALUES ('84', 'ceshi', '', '4', '3764', '74', '7', '409.0540', '0.0000', '51564', 'ecea30e793693538060615756dd384ee', '1554829431', '2019', '测试', '0', '-28800', '22222222', '123566', '123566', '号码', 'e10adc3949ba59abbe56e057f20f883e', '1', null, 'bu2szq9byioxc1undh0kpuan6gxdtbwa', '1', null, '8', '409.0540', '0', '1555864874', '409.0540', '', '0', '0', '0', '0', '1', '', '0', '', '', 'NGvsnwYrz1NACGObBIYvRMnAl7Mm8sLm', '0', '1555395663', '94700.0000', '0.0000', '0', '0', '0,C96,C101,U67,U68,U74,U84,', '0.0000');
INSERT INTO `pay_member` VALUES ('85', 'feidu', '90682e26a5802588363dfcbcd8657aa5', '4', '2537', '82', '0', '0.0100', '0.0000', '1390252632@qq.com', '72c40aebc2c556018b2382f571ead6c4', '1554863265', '0', '支付通道', '1', '-28800', 'www.baidu.com', '15638590310', '', '123', 'e10adc3949ba59abbe56e057f20f883e', '1', null, 'slrkogmvo13hb92d8i5w27bxm8q8euc7', '1', null, '3', '1.0170', '0', '1555500567', '1.0170', ' ', '0', '0', '0', '0', '0', '', '0', '', '', '1bHV3l0VWBQHVZFJoZwoT8CteWfS24LJ', '0', '1555307298', '0.0000', '0.0000', '0', '0', '0,', '0.0000');
INSERT INTO `pay_member` VALUES ('86', 'feiniao666', '', '7', '8573', '68', '0', '0.0000', '0.0000', 'feiniao666', 'd0f19257d47f0e9dc3e00a31ea5e0bb1', '1555071874', '0', 'feiniao666', '1', '-28800', 'feiniao666', 'feiniao666', 'feiniao666', 'qq', 'e10adc3949ba59abbe56e057f20f883e', '1', null, '14pv7knlex0nlzzifbljmu2eeo8e9o1t', '1', null, '3', '2.9940', '0', '1555333902', '2.9940', ' ', '0', '0', '0', '0', '1', '', '0', '', '', 'VRIT9oHAbZH4IaMou0I157s7PnqKZeCA', '0', '1555072110', '0.0000', '0.0000', '0', '1', '0,5,67,68,86,', '0.0000');
INSERT INTO `pay_member` VALUES ('87', '2280799523', 'b3b56f312f1b466f57fde743e29357fa', '4', '8959', '0', '0', '0.0000', '0.0000', '1055283442@qq.com', '728544809cee5e53839de7b99229c60b', '1555341879', '0', null, '1', '0', null, null, null, null, 'e10adc3949ba59abbe56e057f20f883e', '0', null, '60gb89avjhvoq9wdq5yjapydjtc3bohy', '0', null, '0', '0.0000', '0', '0', '0.0000', ' ', '0', '0', '0', '0', '0', '', '0', '', '', '', '0', '0', '0.0000', '0.0000', '0', '0', '0,', '0.0000');
INSERT INTO `pay_member` VALUES ('88', '1055283442', 'd2ba5050f9825ce6a4f40ee2e82cf656', '4', '7568', '0', '0', '0.0000', '0.0000', '1055283442@qq.com', '58e4c1bbba1fd251ebd00083d434cc82', '1555385582', '0', null, '1', '0', null, null, null, null, 'e10adc3949ba59abbe56e057f20f883e', '0', null, 'j8dfecw2o8d917igqzlr9ml2jghsofyw', '0', null, '0', '0.0000', '0', '0', '0.0000', ' ', '0', '0', '0', '0', '0', '', '0', '', '', '', '0', '0', '0.0000', '0.0000', '0', '0', '0,', '0.0000');
INSERT INTO `pay_member` VALUES ('89', 'a343052969', 'b138280433bde991ccc7769434757098', '4', '2919', '0', '0', '0.0000', '0.0000', '343052969@qq.com', '8a19d48d0fa00b7ed9d86473d38e72f5', '1555428199', '0', null, '1', '0', null, null, null, null, 'e10adc3949ba59abbe56e057f20f883e', '0', null, '01kc2djpl7yv7iudg5a2q9lhavv6ukb0', '0', null, '0', '0.0000', '0', '0', '0.0000', ' ', '0', '0', '0', '0', '0', '', '0', '', '', '', '0', '0', '0.0000', '0.0000', '0', '0', '0,', '0.0000');
INSERT INTO `pay_member` VALUES ('95', 'ccccc', '37f8b8f18951cb772c44bd9b0db753f0', '8', '7620', '1', '8', '0.0000', '0.0000', 'ccccc', '0a9f9792d81ca8572f8ee8028d982da8', '1555592485', '2019', '123', '0', '-28800', 'ccccc', 'cccc', 'cccc', 'cccc', 'e10adc3949ba59abbe56e057f20f883e', '0', null, 'fxlg1mrahwyrnk82rvelackx2gf1aimm', '0', null, '0', '0.0000', '0', '0', '0.0000', '', '0', '0', '0', '0', '0', '', '0', '', '', '', '0', '0', '0.0000', '0.0000', '0', '0', '0,', '0.0000');
INSERT INTO `pay_member` VALUES ('96', 'dsdsd', '8013933240c2adbe1b7944916533ca07', '8', '5844', '0', '8', '2100.0000', '0.0000', 'dsdsd', '1a141b3e28db237a5d308352e52c0d32', '1555593153', '2019', 'dsdsd', '0', '-28800', 'dsdsd', 'dsdsd', 'dsdsd', 'dsdsd', 'e10adc3949ba59abbe56e057f20f883e', '1', null, 'cv1g7poj15kxrzkoqfryr9eamxv3eupw', '1', null, '0', '0.0000', '0', '0', '0.0000', '', '0', '0', '0', '0', '0', '', '0', '', '', 'hFxTwexzZyoApz5uCtjwpnsxMw3X9UZk', '0', '1556377902', '0.0000', '0.0000', '0', '1', '0,C96,', '0.0000');
INSERT INTO `pay_member` VALUES ('97', 'f1234', '16358c77c4a08fe457d4a05dddff68c0', '6', '2838', '75', '0', '0.0000', '0.0000', 'f1234', '97012f080610027eac5ae34bfe9ae9ba', '1555594702', '0', 'f1234', '1', '0', 'f1234', 'f1234', 'f1234', null, 'e10adc3949ba59abbe56e057f20f883e', '0', null, 'z29yaa2wbmbaktu7vxdw69cfe37fkm2j', '1', null, '0', '0.0000', '0', '0', '0.0000', ' ', '0', '0', '0', '0', '0', '', '0', '', '', '', '0', '0', '0.0000', '0.0000', '0', '0', '0,5,67,68,75,97,', '0.0000');
INSERT INTO `pay_member` VALUES ('98', 'cs1111', 'ccd0964f259b309fcb70b2315cda04bc', '8', '8645', '96', '0', '0.0000', '0.0000', 'cs1111', '033b14a9fb47713ea40069f071f82194', '1555668324', '0', 'cs1111', '1', '0', 'cs1111', 'cs1111', 'cs1111', 'cs1111', 'e10adc3949ba59abbe56e057f20f883e', '0', null, 'twme0rc7k3vrlxcyj4niui0nst3e07jr', '0', null, '0', '0.0000', '0', '0', '0.0000', ' ', '0', '0', '0', '0', '0', '', '0', '', '', '', '0', '0', '0.0000', '0.0000', '0', '0', '0,5,67,96,98,', '0.0000');
INSERT INTO `pay_member` VALUES ('99', 'mas111', 'bad1b5cf458e7cdbdfe9d94aa497b4e3', '8', '5434', '98', '0', '0.0000', '0.0000', 'mas111', 'e68a77a2a3dac523a441ece8779a8b03', '1555730856', '0', 'mas111', '1', '0', 'mas111', 'mas111', 'mas111', 'mas111', 'e10adc3949ba59abbe56e057f20f883e', '0', null, '2hdsmpigzr82m2rj6bqvwox3ievnfkz9', '0', null, '0', '0.0000', '0', '0', '0.0000', ' ', '0', '0', '0', '0', '0', '', '0', '', '', '', '0', '0', '0.0000', '0.0000', '0', '0', '0,5,67,96,98,99,', '0.0000');
INSERT INTO `pay_member` VALUES ('100', 'dddddds', '0c33cfa02f243e90827f65af17e69ab8', '8', '6351', '96', '0', '0.0000', '0.0000', 'dddddds', 'fb8dbcdefc4f1e6ed0e48fda3a55b637', '1555834245', '0', 'dddddds', '1', '0', 'dddddds', 'dddddds', 'dddddds', 'dddddds', 'e10adc3949ba59abbe56e057f20f883e', '0', null, 'nyj46hv5apa6dp7kh0ia4umposdr0p9x', '0', null, '0', '0.0000', '0', '0', '0.0000', ' ', '0', '0', '0', '0', '0', '', '0', '', '', '', '0', '0', '0.0000', '0.0000', '0', '0', '0,U5,U67,C96,100,', '0.0000');
INSERT INTO `pay_member` VALUES ('101', 'dddddds2', '', '8', '6276', '96', '0', '5000.0000', '0.0000', 'dddddds2', '0db786416fa032ce24f0f13b40017464', '1555834364', '0', 'dddddds2', '1', '-28800', 'dddddds2', 'dddddds2', 'dddddds2', 'dddddds2', 'e10adc3949ba59abbe56e057f20f883e', '1', null, '6yocvjayl4z59e1xf1o6uoe5h6416ha2', '1', null, '5', '12011.0000', '0', '1556358155', '12011.0000', ' ', '0', '0', '0', '0', '0', '', '0', '', '', '', '0', '0', '0.0000', '0.0000', '0', '1', '0,C96,C101,', '4931.0000');
