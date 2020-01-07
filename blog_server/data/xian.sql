/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50714
 Source Host           : localhost:3306
 Source Schema         : xian

 Target Server Type    : MySQL
 Target Server Version : 50714
 File Encoding         : 65001

 Date: 07/01/2020 20:30:46
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for tb_article
-- ----------------------------
DROP TABLE IF EXISTS `tb_article`;
CREATE TABLE `tb_article`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '编号',
  `title` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '标题',
  `title_pic` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '封面图片',
  `author` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '作者',
  `content` mediumtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '摘要',
  `content_md` mediumtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '内容-Markdown',
  `origin` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '来源',
  `state` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '状态',
  `eye_count` bigint(20) NULL DEFAULT 0 COMMENT '浏览量',
  `publish_time` timestamp(0) NOT NULL DEFAULT '1970-02-01 00:00:01' COMMENT '发布时间',
  `edit_time` timestamp(0) NOT NULL DEFAULT '1970-02-01 00:00:01' COMMENT '上次修改时间',
  `create_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `content_html` mediumtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '内容-HTML',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 288 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '文章表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tb_article
-- ----------------------------
INSERT INTO `tb_article` VALUES (273, 'A-simple-story', 'http://xcoding.com:8080/static/uploads/c5/25a4dbacc072dbc5db67555c8a86c4.jpg', 'Colborne', '关于简单的故事', '# 关于简单的故事\n\n* 作者提到一台打印机复杂的流程，大概经过几个小时安装和调试（查看安装手册、部件组装、检测硬件设置、调试设置开关、安装驱动）才能正常使用，\n甚至需要专业的技术支持人员才能够让一台打印机可以正常使用\n\n* 本来应该给我们带来便利的技术，经常又好像是和我们作对一样。\n现在在使用一台打印机就方便很多，基本上就和使用新的一台新的电视一样。\n\n* **为什么安装打印机不能像插电源插座那么简单？**', '', '2', 0, '2020-01-07 13:19:50', '2020-01-07 13:19:50', '2020-01-06 22:17:33', '');
INSERT INTO `tb_article` VALUES (274, 'Features', 'http://xcoding.com:8080/static/uploads/29/24a04e1a2500e47d0a881722b7d665.jpg', 'Colborne', '特征：简单并不意味着欠缺或低劣', '# 特征\n\n```text\n简单并不意味着欠缺或低劣，也不意味着不注重装饰或者完全赤裸裸。\n而是说装饰应该紧密贴近设计本身，任何无关紧要的要素都应该给予以剔除。  \n             ——— Paul Jacques Grillo ( Form, Function and Design)\n```\n\n* 简单的特征和个性应该源自使用的方法、要表现的产品，以及用户执行的任务。\n* 简单并不意味最少，朴素的设计仍然具有自身的特征和个性。\n用料、对关键要素的强调，甚至组合几个要素的方式，都会直接影响到最终设计。人们能够识别出差异，并为这些差异赋予相应的价值。  \n\n* 这两把椅子都很简单，但是各有各的独一无二的特征。  \n![](http://xcoding.com:8080/static/uploads/19/afff98b37e6bac3bbb197e82b566a4.jpeg)![](http://xcoding.com:8080/static/uploads/2e/590a96d842b7977f03fe29ea4352d5.jpeg)', '', '2', 0, '2020-01-07 13:20:34', '2020-01-07 13:20:34', '2020-01-06 23:57:36', '<h1>特征</h1>\n<pre><code data-language=\"text\" class=\"lang-text\">简单并不意味着欠缺或低劣，也不意味着不注重装饰或者完全赤裸裸。\n而是说装饰应该紧密贴近设计本身，任何无关紧要的要素都应该给予以剔除。  \n             ——— Paul Jacques Grillo ( Form, Function and Design)\n</code></pre>\n<ul>\n<li>\n<p>简单的特征和个性应该源自使用的方法、要表现的产品，以及用户执行的任务。</p>\n</li>\n<li>\n<p>简单并不意味最少，朴素的设计仍然具有自身的特征和个性。<br>\n用料、对关键要素的强调，甚至组合几个要素的方式，都会直接影响到最终设计。人们能够识别出差异，并为这些差异赋予相应的价值。</p>\n</li>\n<li>\n<p>这两把椅子都很简单，但是各有各的独一无二的特征。</p>\n</li>\n</ul>\n');
INSERT INTO `tb_article` VALUES (275, 'know-yourself', 'http://xcoding.com:8080/static/uploads/d2/5a259cc418815a3c60e97875d547a8.jpg', 'Colborne', '了解自己', '# 了解自己\n\n大多数的公司都是按照一个方程式进行运作的。例如： \n```text\n（销量）x （单价） - （成本） = （利润）\n```\n    \n* 要明白用户体验将会如何影响方程式中的每一项。到底是能够增加销量，还是能够提高价格，还是能够降低成本。\n而且还需要将这些改变排出先后次序（比较好的做法是对每项改变的重要性和可行性进行评估）。', '', '2', 0, '2020-01-07 13:20:49', '2020-01-07 13:20:49', '2020-01-07 00:01:27', '<h1>了解自己</h1>\n<p>大多数的公司都是按照一个方程式进行运作的。例如：</p>\n<pre><code data-language=\"text\" class=\"lang-text\">（销量）x （单价） - （成本） = （利润）\n</code></pre>\n<ul>\n<li>要明白用户体验将会如何影响方程式中的每一项。到底是能够增加销量，还是能够提高价格，还是能够降低成本。<br>\n而且还需要将这些改变排出先后次序（比较好的做法是对每项改变的重要性和可行性进行评估）。</li>\n</ul>\n');
INSERT INTO `tb_article` VALUES (276, 'not-that-simple-method', 'http://xcoding.com:8080/static/uploads/15/7814b7d1ed76cbcc8038098a0c0910.jpg', 'Colborne', '不是那种简单法', '# 不是那种简单法\n\n* 有些时候，我们设计产品功能的所谓简单，通常是将复杂的压力转嫁到这个产品的另外一部分人的身上。\n例如，有些内部管理系统的设计人员，为了给管理者便利，为普通员工设计了非常复杂的表单和流程。所以，我们在做技术产品设计时，至少要有3个角度：管理人员、工程师和用户。\n\n* 一个人在一种情况下觉得简单的事物，换一个人或者一种情况，可能就不会觉得简单了。\n例如，\n\n* 虽然为富有经验的用户设计复杂系统是一个有趣的话题，但是只有为广大用户考虑，技术才会真正落实到用户（特别是对于面向大众用户的产品），才能更好的推广和传播产品。\n\n', '', '2', 0, '2020-01-07 13:46:37', '2020-01-07 13:46:37', '2020-01-07 00:03:39', '<h1>不是那种简单法</h1>\n<ul>\n<li>\n<p>有些时候，我们设计产品功能的所谓简单，通常是将复杂的压力转嫁到这个产品的另外一部分人的身上。<br>\n例如，有些内部管理系统的设计人员，为了给管理者便利，为普通员工设计了非常复杂的表单和流程。所以，我们在做技术产品设计时，至少要有3个角度：管理人员、工程师和用户。</p>\n</li>\n<li>\n<p>一个人在一种情况下觉得简单的事物，换一个人或者一种情况，可能就不会觉得简单了。<br>\n例如，</p>\n</li>\n<li>\n<p>虽然为富有经验的用户设计复杂系统是一个有趣的话题，但是只有为广大用户考虑，技术才会真正落实到用户（特别是对于面向大众用户的产品），才能更好的推广和传播产品。</p>\n</li>\n</ul>\n');
INSERT INTO `tb_article` VALUES (277, 'seemingly-simple', 'http://xcoding.com:8080/static/uploads/f2/4929659b5472b48e90e0132e7c2973.jpg', 'Colborne', '貌似简单', '# 貌似简单\n\n* 貌似简单的例子随处可见。“减肥药”、“高尔夫俱乐部的激光瞄准镜”以及“足不出户发大财”的方案等。这些貌似简单的东西没有一个应验的。\n相反，它们的存在反而让事情变得更复杂，效果更差。\n\n* 热衷于做表面文章的人，永远不会创造出简单的用户体验来。\n\n* **简单可不是这种能够粘在用户界面上的装饰。**', '', '2', 0, '2020-01-07 13:49:29', '2020-01-07 13:49:29', '2020-01-07 00:04:03', '<h1>貌似简单</h1>\n<ul>\n<li>\n<p>貌似简单的例子随处可见。“减肥药”、“高尔夫俱乐部的激光瞄准镜”以及“足不出户发大财”的方案等。这些貌似简单的东西没有一个应验的。<br>\n相反，它们的存在反而让事情变得更复杂，效果更差。</p>\n</li>\n<li>\n<p>热衷于做表面文章的人，永远不会创造出简单的用户体验来。</p>\n</li>\n<li>\n<p><strong>简单可不是这种能够粘在用户界面上的装饰。</strong></p>\n</li>\n</ul>\n');
INSERT INTO `tb_article` VALUES (278, 'simple-force', 'http://xcoding.com:8080/static/uploads/bc/5d292e108f3e78c38f646e6fae1bc9.jpg', 'Colborne', '简单的力量', '# 简单的力量\n\n```text\n2007年，乔纳森.卡普兰(Jonathan Kaplan)和艾瑞.布朗斯坦(Ariel Braunstein)敏锐的意识到当时的便携式摄像机已经变得复杂难用，\n大家可能只想拍一些视频花絮传到视频网站分享给亲朋好友。\n于是设计了一款叫Flip的简单的便携式摄像机，一年左右占领了美国的1/6的摄像机市场。\nFlip的目标就是尽可能的简单，甩开一切不必要的功能。没有连接线，只有一个弹出式的USB接口，整个机身只有9个操作键，其中还包括一个大大的红色录像键。\n像File、早期的大众甲壳虫汽车以及Twitter这样简单的产品，都会对市场产生深远的影响。它们简单应用，因此能够为大众所接受；它们值得信赖，因此会赢得用户；它们适应性强，因此总会发展处别具一格的应用方式。\n```\n\n* **人们喜欢简单、值得信赖、适应性强的产品。**', '', '2', 0, '2020-01-07 13:49:34', '2020-01-07 13:49:34', '2020-01-07 00:04:21', '<h1>简单的力量</h1>\n<pre><code data-language=\"text\" class=\"lang-text\">2007年，乔纳森.卡普兰(Jonathan Kaplan)和艾瑞.布朗斯坦(Ariel Braunstein)敏锐的意识到当时的便携式摄像机已经变得复杂难用，\n大家可能只想拍一些视频花絮传到视频网站分享给亲朋好友。\n于是设计了一款叫Flip的简单的便携式摄像机，一年左右占领了美国的1/6的摄像机市场。\nFlip的目标就是尽可能的简单，甩开一切不必要的功能。没有连接线，只有一个弹出式的USB接口，整个机身只有9个操作键，其中还包括一个大大的红色录像键。\n像File、早期的大众甲壳虫汽车以及Twitter这样简单的产品，都会对市场产生深远的影响。它们简单应用，因此能够为大众所接受；它们值得信赖，因此会赢得用户；它们适应性强，因此总会发展处别具一格的应用方式。\n</code></pre>\n<ul>\n<li><strong>人们喜欢简单、值得信赖、适应性强的产品。</strong></li>\n</ul>\n');
INSERT INTO `tb_article` VALUES (279, 'a-clear-understanding-of', 'http://xcoding.com:8080/static/uploads/e2/0abaf19f9b9697fe01a66a14941141.jpg', 'Colborne', '明确认识', '# 明确认识\n```text\n乍一看到某个问题，你会觉得很简单，其实你并没有理解其复杂性。\n当你把问题搞清楚之后，优惠发现真的很复杂，于是你就拿出一套复杂的方案来。\n实际上，你的工作只做了一般，大多数人也都会到此为止......\n但是真正伟大的人还会继续向前，知道找到问题的关键和深层次原因，然后再拿出一个优雅的、堪称完美的有效方案。\n    -- 史蒂夫.乔布斯(摘自Steven Levy的Insanely Great:The Life and Times of Macintosh,the Computer that Changed Everything)\n```\n* 写出自己的认识，比自己想象的时间要长。\n\n* 太早开始设计意味着会遗漏重要的见解，甚至意味着设计思路完全错误。  \n\n* 花点时间理解问题，可以帮你想出更好、更简单的方案。 \n \n* 不要匆忙着手设计，理解核心问题需要时间。\n', '', '2', 0, '2020-01-07 13:49:40', '2020-01-07 13:49:40', '2020-01-07 00:05:38', '<h1>明确认识</h1>\n<pre><code data-language=\"text\" class=\"lang-text\">乍一看到某个问题，你会觉得很简单，其实你并没有理解其复杂性。\n当你把问题搞清楚之后，优惠发现真的很复杂，于是你就拿出一套复杂的方案来。\n实际上，你的工作只做了一般，大多数人也都会到此为止......\n但是真正伟大的人还会继续向前，知道找到问题的关键和深层次原因，然后再拿出一个优雅的、堪称完美的有效方案。\n    -- 史蒂夫.乔布斯(摘自Steven Levy的Insanely Great:The Life and Times of Macintosh,the Computer that Changed Everything)\n</code></pre>\n<ul>\n<li>\n<p>写出自己的认识，比自己想象的时间要长。</p>\n</li>\n<li>\n<p>太早开始设计意味着会遗漏重要的见解，甚至意味着设计思路完全错误。</p>\n</li>\n<li>\n<p>花点时间理解问题，可以帮你想出更好、更简单的方案。</p>\n</li>\n<li>\n<p>不要匆忙着手设计，理解核心问题需要时间。</p>\n</li>\n</ul>\n');
INSERT INTO `tb_article` VALUES (280, 'describe-the-user-experience', 'http://xcoding.com:8080/static/uploads/d2/5a259cc418815a3c60e97875d547a8.jpg', 'Colborne', '描述用户体验', '# 描述用户体验\n\n* 在研究某个问题的时候，你需要把它转换成一种认识。故事是描述认识的一种好方式。与一堆需求描述相比，故事可以让读者更容易明白什么重要和为什么重要。\n\n* 故事的一些核心要点：\n  1. 应该是用三言两语把核心体验表达出来。  \n  2. 故事可以把大量信息浓缩到寥寥数语之中，效率极高，而且，故事很容易记住，很方便与人分享。  \n  3. 有必要多花点时间把故事的每一个细节都想清楚，如果你想让自己的时间简单。每个细节都至关重要。\n\n* 故事例子：对于之前提到的Flip这样的摄像机\n```text\n你站在城市街头，突然一阵骚乱；帕里斯.希尔顿(Paris Hilton)正向你走来。\n你迅速从口袋里掏出你的Flip摄像机，把它交给一位路人，请他帮忙拍一段视频，帕里斯就在你身后，\n之后，你赶紧敲开附近朋友家的门，不需要任何安装配置，就通过他的电脑将这段视频传到网上。\n```\n    \n* 这个故事告诉你如下重要事项：\n  1. 这个摄像机很小，可以方便带到任何地方。\n  2. 开机速度快（因为帕里斯不会等你），并且拍摄简单，即使第一次，见到它的人都能够拿在手里就拍。\n  3. 要上传视频不需要特殊的软件或数据线。\n  4. 最后，拍摄视频的目的是为了和朋友分享。\n\n\n* **讲故事是一个产品设计者的重要能力。“想象一下，你正在做xx事情，突然......”**\n', '', '2', 0, '2020-01-07 13:49:46', '2020-01-07 13:49:46', '2020-01-07 00:05:55', '<h1>描述用户体验</h1>\n<ul>\n<li>\n<p>在研究某个问题的时候，你需要把它转换成一种认识。故事是描述认识的一种好方式。与一堆需求描述相比，故事可以让读者更容易明白什么重要和为什么重要。</p>\n</li>\n<li>\n<p>故事的一些核心要点：</p>\n<ol>\n<li>应该是用三言两语把核心体验表达出来。</li>\n<li>故事可以把大量信息浓缩到寥寥数语之中，效率极高，而且，故事很容易记住，很方便与人分享。</li>\n<li>有必要多花点时间把故事的每一个细节都想清楚，如果你想让自己的时间简单。每个细节都至关重要。</li>\n</ol>\n</li>\n<li>\n<p>故事例子：对于之前提到的Flip这样的摄像机</p>\n</li>\n</ul>\n<pre><code data-language=\"text\" class=\"lang-text\">你站在城市街头，突然一阵骚乱；帕里斯.希尔顿(Paris Hilton)正向你走来。\n你迅速从口袋里掏出你的Flip摄像机，把它交给一位路人，请他帮忙拍一段视频，帕里斯就在你身后，\n之后，你赶紧敲开附近朋友家的门，不需要任何安装配置，就通过他的电脑将这段视频传到网上。\n</code></pre>\n<ul>\n<li>\n<p>这个故事告诉你如下重要事项：</p>\n<ol>\n<li>这个摄像机很小，可以方便带到任何地方。</li>\n<li>开机速度快（因为帕里斯不会等你），并且拍摄简单，即使第一次，见到它的人都能够拿在手里就拍。</li>\n<li>要上传视频不需要特殊的软件或数据线。</li>\n<li>最后，拍摄视频的目的是为了和朋友分享。</li>\n</ol>\n</li>\n<li>\n<p><strong>讲故事是一个产品设计者的重要能力。“想象一下，你正在做xx事情，突然......”</strong></p>\n</li>\n</ul>\n');
INSERT INTO `tb_article` VALUES (281, 'describe-two-ways', 'http://xcoding.com:8080/static/uploads/29/24a04e1a2500e47d0a881722b7d665.jpg', 'Colborne', '描述要点的两种方式', '# 描述要点的两种方式\n\n* 每个设计都是在考虑诸多限制之后给出的方案。最好是在设计之初就搞清楚都存在哪些限制。\n然后才能保证自己的设计能够与用户的需求紧密贴合。\n\n* **先理解用户，再思考合适的设计。**\n', '', '2', 0, '2020-01-07 13:49:53', '2020-01-07 13:49:53', '2020-01-07 00:06:08', '<h1>描述要点的两种方式</h1>\n<ul>\n<li>\n<p>每个设计都是在考虑诸多限制之后给出的方案。最好是在设计之初就搞清楚都存在哪些限制。<br>\n然后才能保证自己的设计能够与用户的需求紧密贴合。</p>\n</li>\n<li>\n<p><strong>先理解用户，再思考合适的设计。</strong></p>\n</li>\n</ul>\n');
INSERT INTO `tb_article` VALUES (282, 'designed-for-mainstream-users', 'http://xcoding.com:8080/static/uploads/b4/d6396ac9a72920fc80be05269529f8.jpg', 'Colborne', '为主流用户而设计', '# 为主流用户而设计\n\n\n* 福特的T型车并不是市场上第一辆汽车，但确实第一辆为平民大众制造的汽车。\n福特所有的创新（他的生产流水线、汽车定价以及容易维修的引擎设计）都源自他为主流用户制造一部简单实用的汽车的愿望。\n```text\n我们要为大多数人制造一辆汽车。这辆车......足够小，哪怕一个人也可以驾驶它、修理它。\n我们要为它设计出最简单、最先进的引擎，然后再投入生产。但这辆车的售价却非常低，不会有人因为工资不高而买不起它。\n ----亨利.福特谈T型车\n```\n\n\n* **想吸引大众，必须要关注主流。**', '', '2', 0, '2020-01-07 13:50:02', '2020-01-07 13:50:02', '2020-01-07 00:06:23', '<h1>为主流用户而设计</h1>\n<ul>\n<li>福特的T型车并不是市场上第一辆汽车，但确实第一辆为平民大众制造的汽车。<br>\n福特所有的创新（他的生产流水线、汽车定价以及容易维修的引擎设计）都源自他为主流用户制造一部简单实用的汽车的愿望。</li>\n</ul>\n<pre><code data-language=\"text\" class=\"lang-text\">我们要为大多数人制造一辆汽车。这辆车......足够小，哪怕一个人也可以驾驶它、修理它。\n我们要为它设计出最简单、最先进的引擎，然后再投入生产。但这辆车的售价却非常低，不会有人因为工资不高而买不起它。\n ----亨利.福特谈T型车\n</code></pre>\n<ul>\n<li><strong>想吸引大众，必须要关注主流。</strong></li>\n</ul>\n');
INSERT INTO `tb_article` VALUES (283, 'easy-way', 'http://xcoding.com:8080/static/uploads/27/141aa83bf42f43afa9b0d8fb5cdde0.jpg', 'Colborne', '简便的方式', '# 简便的方式\n\n\n* 用简单的语言把正在设计的东西描述出来。如果自己感觉听起来不正常，或者听众们不理解我在说什么，我就知道应该修改措辞重新来过。\n\n* 目标是拿出一个简洁、清晰、完整的描述。\n\n* 如果能够只用一句简短的话来表述。如果这句话既能忽略细节而概况出主要活动，又能不让听众失去兴趣，那么就说明它一句达到简洁的标准。\n比如，对于Flip来说，就是“瞬间开始拍摄，不费吹灰之力分享”。\n\n* 想想白居易给老妪念自己写的诗的例子。\n\n* **尽可能用最简单的词汇描述你的想法**', '', '2', 0, '2020-01-07 13:50:09', '2020-01-07 13:50:09', '2020-01-07 00:06:40', '<h1>简便的方式</h1>\n<ul>\n<li>\n<p>用简单的语言把正在设计的东西描述出来。如果自己感觉听起来不正常，或者听众们不理解我在说什么，我就知道应该修改措辞重新来过。</p>\n</li>\n<li>\n<p>目标是拿出一个简洁、清晰、完整的描述。</p>\n</li>\n<li>\n<p>如果能够只用一句简短的话来表述。如果这句话既能忽略细节而概况出主要活动，又能不让听众失去兴趣，那么就说明它一句达到简洁的标准。<br>\n比如，对于Flip来说，就是“瞬间开始拍摄，不费吹灰之力分享”。</p>\n</li>\n<li>\n<p>想想白居易给老妪念自己写的诗的例子。</p>\n</li>\n<li>\n<p><strong>尽可能用最简单的词汇描述你的想法</strong></p>\n</li>\n</ul>\n');
INSERT INTO `tb_article` VALUES (284, 'emotional-needs', 'http://xcoding.com:8080/static/uploads/a3/84b96ecd7e3c5613160e364d2e8727.jpg', 'Colborne', '感情需求', '# 感情需求\n\n\n```text\n在思考为什么人们会用我们的软件这个问题时，我们意识到他们的工作日程通常都慢慢的。他们希望自己能够完成很多的工作，感觉一切尽在掌握。\n他们需要一个能够囊括上千条任务，但翻阅起来又不费事的工资表。因此，我们尽最大努力确保他们能够看到的始终都是少数重要的工作，同事也能方便找到其他的提醒或备忘。\n      ----获得2009年度最佳苹果应用奖的Things开发人员尤尔根.施魏策尔(Jvrgen Schweizer)\n```\n\n* 一个真正有用的应用不可能只是一个记事本。它还必须让用户感觉井然有序、轻松自在。\n\n* 人是有感情的动物。即使是工作表这样直观的应用，他们都希望找到一个使用它的理由。\n\n* **即使是任务列表，也要满足感情需求。**', '', '2', 0, '2020-01-07 13:50:14', '2020-01-07 13:50:14', '2020-01-07 00:06:53', '<h1>感情需求</h1>\n<pre><code data-language=\"text\" class=\"lang-text\">在思考为什么人们会用我们的软件这个问题时，我们意识到他们的工作日程通常都慢慢的。他们希望自己能够完成很多的工作，感觉一切尽在掌握。\n他们需要一个能够囊括上千条任务，但翻阅起来又不费事的工资表。因此，我们尽最大努力确保他们能够看到的始终都是少数重要的工作，同事也能方便找到其他的提醒或备忘。\n      ----获得2009年度最佳苹果应用奖的Things开发人员尤尔根.施魏策尔(Jvrgen Schweizer)\n</code></pre>\n<ul>\n<li>\n<p>一个真正有用的应用不可能只是一个记事本。它还必须让用户感觉井然有序、轻松自在。</p>\n</li>\n<li>\n<p>人是有感情的动物。即使是工作表这样直观的应用，他们都希望找到一个使用它的理由。</p>\n</li>\n<li>\n<p><strong>即使是任务列表，也要满足感情需求。</strong></p>\n</li>\n</ul>\n');
INSERT INTO `tb_article` VALUES (285, 'environments-characters-and-plot', 'http://xcoding.com:8080/static/uploads/16/36231773f6704edcf1f68fdd38ee49.jpg', 'Colborne', '环境、角色、情节', '# 环境、角色、情节\n\n\n >1. 可信的环境（故事中的“时间”和“地点”）\n>2. 可信的角色（“谁”和“为什么”）\n>3. 流畅的情节（“什么”和“怎么样”）\n\n* 很多复杂的设计都是因为没有考虑到线上世界的压力而导致的，或是因为设计者希望用户能够自己应付一切，或是因为他们不小心漏掉了某个重要的环境。\n\n* 你的设计应该与你讲的故事完美契合。 把你的设计放在一个情节中，情节中有可信的角色，发生在可信的环境中。\n', '', '2', 0, '2020-01-07 13:50:20', '2020-01-07 13:50:20', '2020-01-07 00:08:04', '<h1>环境、角色、情节</h1>\n<blockquote>\n<ol>\n<li>可信的环境（故事中的“时间”和“地点”）</li>\n<li>可信的角色（“谁”和“为什么”）</li>\n<li>流畅的情节（“什么”和“怎么样”）</li>\n</ol>\n</blockquote>\n<ul>\n<li>\n<p>很多复杂的设计都是因为没有考虑到线上世界的压力而导致的，或是因为设计者希望用户能够自己应付一切，或是因为他们不小心漏掉了某个重要的环境。</p>\n</li>\n<li>\n<p>你的设计应该与你讲的故事完美契合。 把你的设计放在一个情节中，情节中有可信的角色，发生在可信的环境中。</p>\n</li>\n</ul>\n');
INSERT INTO `tb_article` VALUES (286, 'extreme-availability', 'http://xcoding.com:8080/static/uploads/84/493ef6312d7fd03326c135db87b0d2.jpg', 'Colborne', '极端的可用性', '# 极端的可用性\n\n* 想要简单，务必把目标定得高些高些再高些，不要使用常规的可用性目标。 \n\n| *常规的可用性目标* | *简单性的目标* |\n| :---:| :---: |\n| 特殊人群可以使用 | 任何人都可以使用 |\n| 容易使用 | 毫不费力的使用 |\n| 快速响应 | 瞬间响应 |\n| 快速理解 | 一目了然 |\n| 工作可靠 | 始终工作 |\n| 直观的错误信息 | 不出错 |\n| 完整的信息 | 恰好够用的信息 |\n| 用户测试时工作 | 在混乱无序的环境中工作 |\n\n\n* 目标中“瞬间”和“毫不费力”听起来有点夸张，因为事实上这是做不到的。然而，争取你不可能达到的目标有一个重要的好吃：保持正确的方向。\n\n* 很多开始时简单的产品到最后都变得越来越复杂，很难使用。但是，如果你设定了一个极端的目标，你的产品就能随着时间推移越变越好（至少能够实现真正重要的目标）。\n\n* 瞄准极端的目标，即使是哪些无法完全实现的目标，也能够帮你保持产品简单。\n\n* **设计简单的体验意味着要追求极端的目标**\n# 第二段\n# 第三段', '', '2', 0, '2020-01-07 13:50:26', '2020-01-07 13:50:26', '2020-01-07 00:21:07', '<h1>极端的可用性</h1>\n<ul>\n<li>想要简单，务必把目标定得高些高些再高些，不要使用常规的可用性目标。</li>\n</ul>\n<table>\n<thead>\n<tr>\n<th align=\"center\"><em>常规的可用性目标</em></th>\n<th align=\"center\"><em>简单性的目标</em></th>\n</tr>\n</thead>\n<tbody>\n<tr>\n<td align=\"center\">特殊人群可以使用</td>\n<td align=\"center\">任何人都可以使用</td>\n</tr>\n<tr>\n<td align=\"center\">容易使用</td>\n<td align=\"center\">毫不费力的使用</td>\n</tr>\n<tr>\n<td align=\"center\">快速响应</td>\n<td align=\"center\">瞬间响应</td>\n</tr>\n<tr>\n<td align=\"center\">快速理解</td>\n<td align=\"center\">一目了然</td>\n</tr>\n<tr>\n<td align=\"center\">工作可靠</td>\n<td align=\"center\">始终工作</td>\n</tr>\n<tr>\n<td align=\"center\">直观的错误信息</td>\n<td align=\"center\">不出错</td>\n</tr>\n<tr>\n<td align=\"center\">完整的信息</td>\n<td align=\"center\">恰好够用的信息</td>\n</tr>\n<tr>\n<td align=\"center\">用户测试时工作</td>\n<td align=\"center\">在混乱无序的环境中工作</td>\n</tr>\n</tbody>\n</table>\n<ul>\n<li>\n<p>目标中“瞬间”和“毫不费力”听起来有点夸张，因为事实上这是做不到的。然而，争取你不可能达到的目标有一个重要的好吃：保持正确的方向。</p>\n</li>\n<li>\n<p>很多开始时简单的产品到最后都变得越来越复杂，很难使用。但是，如果你设定了一个极端的目标，你的产品就能随着时间推移越变越好（至少能够实现真正重要的目标）。</p>\n</li>\n<li>\n<p>瞄准极端的目标，即使是哪些无法完全实现的目标，也能够帮你保持产品简单。</p>\n</li>\n<li>\n<p><strong>设计简单的体验意味着要追求极端的目标</strong></p>\n</li>\n</ul>\n<h1>第二段</h1>\n<h1>第三段</h1>\n');
INSERT INTO `tb_article` VALUES (287, 'why-you-should-ignore-the-expert-user', 'http://xcoding.com:8080/static/uploads/a3/84b96ecd7e3c5613160e364d2e8727.jpg', 'Colborne', '为什么应该忽略专家型用户', '# 为什么应该忽略专家型用户\n\n* 专家并不是典型用户，他们不会体验到主流用户遇到的问题。他们追求主流用户根本不在乎的功能。\n\n**专家想要的功能往往会吓到主流用户。**', '', '2', 0, '2020-01-07 13:50:29', '2020-01-07 13:50:29', '2020-01-07 11:51:57', '<h1>为什么应该忽略专家型用户</h1>\n<ul>\n<li>专家并不是典型用户，他们不会体验到主流用户遇到的问题。他们追求主流用户根本不在乎的功能。</li>\n</ul>\n<p><strong>专家想要的功能往往会吓到主流用户。</strong></p>\n');

-- ----------------------------
-- Table structure for tb_article_category
-- ----------------------------
DROP TABLE IF EXISTS `tb_article_category`;
CREATE TABLE `tb_article_category`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '编号',
  `article_id` bigint(20) NOT NULL COMMENT '文章ID',
  `category_id` bigint(20) NOT NULL COMMENT '分类ID',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 49 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '文章&&分类关联表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tb_article_category
-- ----------------------------
INSERT INTO `tb_article_category` VALUES (34, 273, 55);
INSERT INTO `tb_article_category` VALUES (35, 274, 55);
INSERT INTO `tb_article_category` VALUES (36, 275, 55);
INSERT INTO `tb_article_category` VALUES (37, 276, 55);
INSERT INTO `tb_article_category` VALUES (38, 277, 55);
INSERT INTO `tb_article_category` VALUES (39, 278, 55);
INSERT INTO `tb_article_category` VALUES (40, 279, 55);
INSERT INTO `tb_article_category` VALUES (41, 280, 55);
INSERT INTO `tb_article_category` VALUES (42, 281, 55);
INSERT INTO `tb_article_category` VALUES (43, 282, 55);
INSERT INTO `tb_article_category` VALUES (44, 283, 55);
INSERT INTO `tb_article_category` VALUES (45, 284, 55);
INSERT INTO `tb_article_category` VALUES (46, 285, 55);
INSERT INTO `tb_article_category` VALUES (47, 286, 55);
INSERT INTO `tb_article_category` VALUES (48, 287, 55);

-- ----------------------------
-- Table structure for tb_article_tags
-- ----------------------------
DROP TABLE IF EXISTS `tb_article_tags`;
CREATE TABLE `tb_article_tags`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '编号',
  `article_id` bigint(20) NOT NULL COMMENT '文章ID',
  `tags_id` bigint(20) NOT NULL COMMENT '标签ID',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '文章&&标签关联表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tb_article_tags
-- ----------------------------
INSERT INTO `tb_article_tags` VALUES (6, 273, 58);

-- ----------------------------
-- Table structure for tb_category
-- ----------------------------
DROP TABLE IF EXISTS `tb_category`;
CREATE TABLE `tb_category`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '编号',
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '分类名称',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `tb_category_name_uindex`(`name`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 56 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '分类表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tb_category
-- ----------------------------
INSERT INTO `tb_category` VALUES (55, 'UI/UE');

-- ----------------------------
-- Table structure for tb_comments
-- ----------------------------
DROP TABLE IF EXISTS `tb_comments`;
CREATE TABLE `tb_comments`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `p_id` bigint(20) NULL DEFAULT 0 COMMENT '父级ID，给哪个留言进行回复',
  `c_id` bigint(20) NULL DEFAULT 0 COMMENT '子级ID，给哪个留言下的回复进行评论',
  `article_title` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '文章标题',
  `article_id` bigint(20) NULL DEFAULT NULL COMMENT '文章ID',
  `author` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '留言人',
  `author_id` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '给谁留言',
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '留言邮箱',
  `content` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '留言内容',
  `time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '留言时间',
  `url` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '链接',
  `state` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '正常' COMMENT '状态',
  `sort` bigint(20) NULL DEFAULT 0 COMMENT '分类：0默认文章详情页，1友链页，2关于我页',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 41 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '评论表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tb_comments
-- ----------------------------
INSERT INTO `tb_comments` VALUES (30, 0, 0, 'A-simple-story', 273, 'Aaron', '', '', '测试留言接口^-^', '2020-01-06 22:30:07', 'http://xcoding.com:8080/static/icons/12.png', '正常', 0);
INSERT INTO `tb_comments` VALUES (31, 30, 0, 'A-simple-story', 273, 'Abdieso  ', '@Aaron', '', '测试留言回复接口^-^', '2020-01-06 22:36:20', 'http://xcoding.com:8080/static/icons/2.png', '正常', 0);
INSERT INTO `tb_comments` VALUES (32, 0, 0, 'A-simple-story', 273, 'Dagobert ', '', '', '测试留言接口', '2020-01-06 23:00:44', 'http://xcoding.com:8080/static/icons/5.png', '正常', 0);
INSERT INTO `tb_comments` VALUES (33, 0, 0, 'A-simple-story', 273, 'Dahana ', '', '', '测试留言接口', '2020-01-06 23:02:38', 'http://xcoding.com:8080/static/icons/17.png', '正常', 0);
INSERT INTO `tb_comments` VALUES (34, 0, 0, 'A-simple-story', 273, 'Edmond ', '', '', '测试留言接口^-^\n\n', '2020-01-06 23:07:33', 'http://xcoding.com:8080/static/icons/2.png', '正常', 0);
INSERT INTO `tb_comments` VALUES (35, 0, 0, 'A-simple-story', 273, 'Eberhard ', '', '', '测试留言接口^-^', '2020-01-06 23:08:39', 'http://xcoding.com:8080/static/icons/25.png', '正常', 0);
INSERT INTO `tb_comments` VALUES (36, 0, 0, 'A-simple-story', 273, 'Edison ', '', '', '测试留言接口^-^\n\n', '2020-01-06 23:08:53', 'http://xcoding.com:8080/static/icons/29.png', '正常', 0);
INSERT INTO `tb_comments` VALUES (37, 36, 0, 'A-simple-story', 273, 'Edison ', '@Edison ', '', '我回复我自己 ===', '2020-01-06 23:09:43', 'http://xcoding.com:8080/static/icons/29.png', '正常', 0);
INSERT INTO `tb_comments` VALUES (38, 0, 0, 'A-simple-story', 273, 'Faraji ', '', '', '测试分页', '2020-01-06 23:11:36', 'http://xcoding.com:8080/static/icons/12.png', '正常', 0);
INSERT INTO `tb_comments` VALUES (40, 0, 0, 'describe-the-user-experience', 280, 'xian', '', '', 'it\'s awesome !', '2020-01-07 13:53:33', 'http://xcoding.com:8080/static/icons/24.png', '正常', 0);

-- ----------------------------
-- Table structure for tb_links
-- ----------------------------
DROP TABLE IF EXISTS `tb_links`;
CREATE TABLE `tb_links`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '编号',
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '连接名称',
  `url` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '连接URL',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '友链表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for tb_tags
-- ----------------------------
DROP TABLE IF EXISTS `tb_tags`;
CREATE TABLE `tb_tags`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '编号',
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '标签名称',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `tb_tags_name_uindex`(`name`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 59 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '标签表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tb_tags
-- ----------------------------
INSERT INTO `tb_tags` VALUES (58, '简约至上：交互式设计四策略');

-- ----------------------------
-- Table structure for tb_user
-- ----------------------------
DROP TABLE IF EXISTS `tb_user`;
CREATE TABLE `tb_user`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '编号',
  `username` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '用户名',
  `nickname` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '昵称',
  `password` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '密码',
  `salt` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '盐值',
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '邮箱',
  `avatar` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '头像',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `tb_user_username_uindex`(`username`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '标签表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tb_user
-- ----------------------------
INSERT INTO `tb_user` VALUES (1, 'Xian', 'Xian', '123456', '123456', 'x', 'http://xcoding.com:8080/static/icons/3.png');

SET FOREIGN_KEY_CHECKS = 1;
