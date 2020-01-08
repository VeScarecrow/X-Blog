<template>
    <div class="detail-container">
        <!-- 文章内容 -->
        <article class="main-content page-page" itemscope itemtype="http://schema.org/Article">
            <div class="post-header">
                <h1 class="post-title" itemprop="name headline">
                    <a :href="'/article/' + detail.id" v-text="detail.title"/>
                </h1>
                <div class="post-data">
                    <time datetime="2020-01-01" itemprop="datePublished">发布于 {{detail.publish_time}}</time>
                    / <a :href="'/category/' + detail.category" v-text="detail.category"/> /
                    <a @click="backComments"><b v-text="commentCount"/> 条评论</a> /
                    <b v-text="detail.eye_count"/> 浏览
                </div>
            </div>
            <div class="post-content" itemprop="articleBody" v-highlight v-html="detail.content_html"
                 ref="content"></div>
            <div class="post-content">
                <p class="post-info">
                    本文由 <a href="/" v-text="detail.author"/> 创作，采用 <a
                    href="https://creativecommons.org/licenses/by/4.0/" target="_blank" rel="external nofollow">知识共享署名4.0</a>
                    国际许可协议进行许可<br>本站文章除注明转载/出处外，均为本站原创或翻译，转载前请务必署名<br>最后编辑时间为:
                    {{detail.edit_time}}
                </p>
            </div>
        </article>

        <!-- 目录导航 -->
        <div id="directory-content" class="directory-content">
            <div id="directory"></div>
        </div>

        <!-- 评论内容 -->
        <Comments :detail="this.detail" />
    </div>
</template>

<script>
    import {findById, findCountByArticleId} from '@/api/article'
    import Highlight from './components/Highlight.vue'
    import Comments from './components/Comments.vue'
    import {postDirectoryBuild} from './components/Directory.js'

    export default {
        name: "index",
        components: {Highlight, Comments},
        data() {
            return {
                id: this.$route.params.id,
                detail: {
                    id: ''
                },
                listLoading: true,
                commentCount: '',
            }
        },
        created() {
            this.findById();
            // let thisId = window.location.hash;
            // if (thisId !== "" && thisId !== undefined) {
            //     // console.log(thisId);
            // }
        },
        methods: {
            findById() {
                this.listLoading = true;
                findById(this.id).then(response => {
                    if (response.code === 20000) {
                        this.detail = response.data;
                        setTimeout(() => {
                            postDirectoryBuild(this.$refs.content)
                        }, 400);
                    }
                }).catch(err => {
                    console.log(err);
                });
                findCountByArticleId(this.id).then(response => {
                    if (response.code === 20000) {
                        this.commentCount = response.data;
                        this.listLoading = false
                    }
                }).catch(err => {
                    console.log(err);
                })
            },
            backComments() {
                let element = document.getElementById('comments');
                element.scrollIntoView(); //让页面滚动到指定区域
            }
        }
    }
</script>

<style src="../../styles/site.css"/>
<style scoped>
    .main-content {
        font-family: -apple-system, SF UI Text, Arial, PingFang SC, Hiragino Sans GB, Microsoft YaHei, WenQuanYi Micro Hei, sans-serif;
        font-size: 14px;
        line-height: 1.8;
        margin: 0 auto;
        color: #313131;
        text-rendering: geometricPrecision;
        -webkit-font-smoothing: antialiased;
    }
</style>
