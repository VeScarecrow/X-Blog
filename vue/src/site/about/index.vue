<template>
    <div class="about-container">
        <article role="pge-title-content" class="main-content page-page" itemscope itemtype="http://schema.org/Article">
            <div class="post-header">
                <h1 class="post-title" itemprop="name headline">关于</h1>
                <div class="post-data">
                    <time datetime="2017-09-17" itemprop="datePublished">发布于 2020-01-01</time>
                </div>
            </div>
            <div id="post-content" class="post-content">
                <header>
                    <div class="hello"><span>Hi! </span> We are Xian&Tao.</div>
                </header>
                <label>We're Developers with an enduring interest in Coding and Writing Blog.</label>
                <br/>
                <br/>
                <h1>About</h1>
                <p style="font-size: 15px">&#8594; From&nbsp;JMU&nbsp;SoftWare1712</p>
                <h1>Works</h1>
                <ul>
                    <li><a href="https://github.com/Xiant999/AirSystem" target="_blank">AirSystem : </a>
                        基于VueJs+ElemenUI+SSM+Shiro的航空票务管理系统（前后台）
                    </li>
                    <li><a href="https://github.com/Xiant999/SpringAll" target="_blank">SpringAll : </a>循序渐进，学习Spring
                        Boot、Spring Boot & Shiro、Spring Cloud、Spring Security & Spring Security OAuth2 ,
                        博客Spring系列源码
                    </li>
                    <li><a href="https://github.com/Xiant999/ssm-redis-solr" target="_blank">SSM-Redis-Solr : </a>
                        整合SSM+Redis+Solr+Shiro框架，结合Vue.js+ElementUI简单实现搜索功能
                    </li>
                    <li><a href="https://github.com/Xiant999/Interactive-design-notes" target="_blank">Interactive-design-notes : </a>
                        简约至上：交互式设计四策略（Simple and Usable Web,Mobile, and Interaction Design）笔记
                    </li>
                    <li><a href="https://github.com/Xiant999/LeetCode" target="_blank">LeetCode : </a> LeetCode Solutions
                        by ALL programming language
                    </li>
                    <li><a href="https://github.com/VeScarecrow/Hi-Dancer" target="_blank">Hi-Dancer : </a>Hi! Dancer! Follow my
                        posture!
                    </li>
                </ul>
                <br/>
                <h1>Concat</h1>

            </div>
        </article>

        <!-- 评论 -->
        <Comments></Comments>
    </div>
</template>

<script>
    import {findAll} from '@/api/links'
    import Comments from './components/Comments.vue'

    export default {
        name: "index",
        components: {Comments},
        data() {
            return {
                list: null,
                listLoading: false
            }
        },
        created() {
            this.getList();
        },
        methods: {
            getList() {
                this.listLoading = true;
                findAll().then(response => {
                    if (response.code === 20000) {
                        this.list = response.data;
                        this.listLoading = false
                    }
                })
            },
        }
    }
</script>

<style src="../../styles/site.css"></style>
<style scoped>
    article[role="pge-title-content"] {
        padding-left: 41px;
    }

    article[role="pge-title-content"] header, article[role="pge-title-content"] header {
        padding-bottom: 19px;
        /*padding-top: 83px;*/
    }

    article[role="pge-title-content"] header h2, main[role="main-inner-wrapper"] article[role="pge-title-content"] header h2 {
        font-size: 46px;
        line-height: 53px;
        color: #404040;
        font-weight: 800;
    }

    article[role="pge-title-content"] header .hello {
        font-size: 46px;
        line-height: 53px;
        color: #404040;
        font-weight: 800;
        margin-top: 30px;
    }

    article[role="pge-title-content"] header .hello span {
        display: block;
        font-size: 80px;
        color: #fb5353;
        padding-bottom: 15px;
    }

    article[role="pge-title-content"] header h2 span, article[role="pge-title-content"] header h2 span {
        display: block;
        font-size: 80px;
        color: #fb5353;
        padding-bottom: 15px;
    }

    article[role="pge-title-content"] label, article[role="pge-title-content"] label {
        font-size: 20px;
        line-height: 30px;
        color: #454545;
    }

    article[role="pge-title-content"] ul li {
        font-size: 16px;
        line-height: 30px;
        color: #454545;
        margin-left: 18px;
    }

    article[role="pge-title-content"] ul li a {
        color: #00a8c6;
    }

    article[role="pge-title-content"] img {
        margin-left: -21px;
    }

    .el-menu--horizontal .el-menu [role="8-2"] a {
        color: #409EFF;
    }

    .el-submenu[role="8"] .el-submenu__title {
        color: #409EFF;
    }

    .el-submenu[role="8"] .el-submenu__title:hover {
        color: #409EFF;
    }
</style>
