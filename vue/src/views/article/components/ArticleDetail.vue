<template  v-loading="loading">
    <div class="createPost-container">
        <sticky :class-name="'sub-navbar '+ this.postForm.state">
            <CommentDropdown v-model="postForm.comment_disabled"/>
            <PlatformDropdown v-model="postForm.platforms"/>
            <SourceUrlDropdown v-model="postForm.origin"/>
            <el-button  style="margin-left: 10px;" type="success" @click="submitForm('published')">发布
            </el-button>
            <el-butto type="warning" @click="submitForm('draft')">草稿</el-butto>
        </sticky>

        <el-form ref="postForm" :model="postForm" :rules="rules"
                 label-width="100px" :inline="true"
                 label-position="top" class="createPost-main-container">

            <el-form-item prop="title" label="文章标题:" style="width: 80%;">
                <el-input v-model="postForm.title" placeholder="标题" clearable/>
            </el-form-item>

            <el-form-item prop="author" label="作者姓名:" style="min-width: 30%;margin-right: 3%">
                <el-input v-model="postForm.author" placeholder="文章作者" style="min-width: 195px;"
                          clearable/>
            </el-form-item>

            <el-form-item label="发布时间:" style="min-width: 30%;margin-right: 3%" prop="publish_time">
                <el-date-picker value-format="yyyy-MM-dd HH:mm:ss" type="datetime"
                                format="yyyy-MM-dd HH:mm:ss" placeholder="选择日期时间"
                                v-model="postForm.publish_time" :picker-options="timePickerOptions"
                />
            </el-form-item>

            <el-form-item label-width="60px" label="分类:" style="min-width: 30%;margin-right: 3%" prop="category">
                <el-tooltip effect="dark" content="下拉框中没有？可直接键入"
                            placement="top-start">
                    <el-select v-model="postForm.category" allow-create filterable
                               placeholder="请选择文章分类">
                        <el-option
                            v-for="item in userListOptions" :key="item.value"
                            :label="item.label" :value="item.value">
                        </el-option>
                    </el-select>
                </el-tooltip>
            </el-form-item>

            <el-form-item prop="tag" label-width="60px" label="标签:"
                          style="min-width: 30%;margin-right: 3%">
                <el-tag :key="tag" v-for="tag in dynamicTags" closable
                        :disable-transitions="false" @close="handleCloseTag(tag)">
                    {{tag}}
                </el-tag>
                <el-input class="input-new-tag" v-if="inputVisible" v-model="postForm.tags"
                          ref="saveTagInput" @keyup.enter.native="handleInputConfirm"
                          @blur="handleInputConfirm"/>
                <el-button v-else @click="showInput">+添加
                </el-button>
            </el-form-item>

            <el-form-item prop="content" label-width="60px" label="摘要:"
                          style="min-width: 30%;margin-right: 3%;">
                <el-input :rows="1" v-model="postForm.content" type="textarea"
                          :autosize="{ minRows: 2, maxRows: 5}" placeholder="请输入内容"/>
                <span v-show="contentShortLength" class="word-counter">{{ contentShortLength }}字</span>
            </el-form-item>

            <el-form-item prop="content_md" label-width="60px" label="内容:"
                          style="width: 100%;">
                <div class="tinymce-container editor-container">
                    <div class="editor-custom-btn-container" v-if="!isEdit">
                        <span class="tips">
                            <span v-show="!saveFlag"><i class="el-icon-loading"></i>保存中...</span>
                            <span v-show="saveFlag">已保存</span>
                        </span>
                    </div>
                    <!-- Markdown富文本组件 -->
                    <markdown :content="postForm.content_md" @editor="editor"></markdown>
                </div>
            </el-form-item>

        </el-form>

    </div>
</template>

<script>
    import markdown from './markdown'
    import Upload from '@/components/Upload/singleImage3'
    import MDinput from '@/components/MDinput'
    import Sticky from '@/components/Sticky' // 粘性header组件
    import {validateURL} from '@/utils/validate'
    import {findById, save, update} from '@/api/article'
    import {userSearch} from '@/api/remoteSearch'
    import Warning from './Warning'
    import {CommentDropdown, PlatformDropdown, SourceUrlDropdown} from './Dropdown'

    const defaultForm = {
        id: undefined,//文章id
        title: '', // 标题
        title_pic: '', // 图片url
        author: '',//作者
        content: '', // 文章摘要
        content_md: '', // 文章内容
        origin: '', // 文章外链
        state: 'draft', //文章状态draft/deleted/published
        eye_count: 0,//
        publish_time: '', // 时间
        edit_time: '',
        category: '',
        tags: [],

        //头部内容-未设置
        platforms: [],
        comment_disabled: false,
        importance: 0,
    };

    export default {
        name: 'ArticleDetail',
        components: {markdown, MDinput, Upload, Sticky, Warning, CommentDropdown, PlatformDropdown, SourceUrlDropdown},
        props: {
            isEdit: {
                type: Boolean,
                default: false
            }
        },
        data() {
            const validateSourceUri = (rule, value, callback) => {
                if (value) {
                    if (validateURL(value)) {
                        callback()
                    } else {
                        this.$message({
                            message: '外链url填写不正确',
                            type: 'error'
                        });
                        callback(new Error('外链url填写不正确'))
                    }
                } else {
                    callback()
                }
            };
            return {
                postForm: Object.assign({}, defaultForm),
                loading: false,
                userListOptions: [],
                rules: {
                    title: [
                        {required: true, message: '请输入文章标题(长度<=30)', trigger: 'blur'},
                        {max: 30, message: '长度不大于30字符', trigger: 'blur'}
                    ],
                    author: [
                        {required: true, message: '请输入作者姓名(长度<=20)', trigger: 'blur'},
                        {max: 20, message: '长度不大于20字符', trigger: 'blur'}
                    ],
                    category: [
                        {required: true, message: '请选择/输入文章类型', trigger: 'blur'},
                    ],
                    content: [
                        {required: true, message: '请输入文章摘要(长度5-30)', trigger: 'blur'},
                        {min: 5, max: 30, message: '长度在5-30字符间', trigger: 'blur'}
                    ],
                    content_md: [
                        {required: true, message: '请输入文章内容', trigger: 'blur'},
                        {max: 10000, message: '长度受限', trigger: 'blur'}
                    ],
                },
                timePickerOptions: {
                    disabledDate(time) {
                        return time.getTime() <= Date.now() - 24 * 3600 * 1000;
                    }
                },
                dynamicTags: [],//动态标签
                inputVisible: false,
                saveFlag: true,
                tempRoute: {}
            }
        },
        computed: {
            contentShortLength() {
                return this.postForm.content.length
            },
            lang() {
                return this.$store.getters.language
            }
        },
        created() {
            if (this.isEdit) { //说明是编辑文章的，获取路由传递的id
                const id = this.$route.params && this.$route.params.id;
                this.fetchData(id)
            } else {
                this.postForm = Object.assign({}, defaultForm)
            }
            this.tempRoute = Object.assign({}, this.$route)
        },
        methods: {
            fetchData(id) {
                findById(id).then(response => {
                    this.dynamicTags = eval(response.data.tags);
                    this.postForm = response.data;
                    // Set tagsview title
                    this.setTagsViewTitle()
                }).catch(err => {
                    console.log(err)
                })
            },
            setTagsViewTitle() {
                const title = '编辑文章';
                const route = Object.assign({}, this.tempRoute, {title: `${title}-${this.postForm.id}`});
                this.$store.dispatch('updateVisitedView', route)
            },
            //表单提交
            submitForm(state) {
                this.postForm.tags = JSON.stringify(this.dynamicTags); //给tags字段赋值
                // this.postForm.publishTime = parseInt(this.publishTime / 1000);
                this.postForm.state = state || 'draft';
                // console.log(this.postForm);
                this.$refs.postForm.validate(valid => this.updateAction(valid));
            },
            updateAction(valid) {
                if (valid) {
                    this.loading = true;
                    update(this.postForm).then(response => {
                        if (response.code === 20000) {
                            this.$notify({
                                title: '成功',
                                message: response.data,
                                type: 'success',
                                duration: 2000
                            });
                            this.$router.push('/admin/article/list?xx')
                        } else {
                            this.$notify({
                                title: '失败',
                                message: response.data,
                                type: 'warning',
                                duration: 2000
                            });
                        }
                    }).catch(err => {
                        console.log(err)
                    })
                    this.loading = false
                } else {
                    console.log('error submit!!');
                    return false
                }
            },
            //草稿
            // draftForm() {
            //     this.postForm.tags = JSON.stringify(this.dynamicTags); //给tags字段赋值
            //     this.postForm.state = 'draft'
            //     if (this.postForm.content.length === 0 || this.postForm.title.length === 0) {
            //         this.$message({
            //             message: '请填写必要的标题和内容',
            //             type: 'warning'
            //         });
            //         return
            //     } else {
            //         save(this.postForm).then(response => {
            //             if (response.code === 20000) {
            //                 this.$notify({
            //                     title: '成功',
            //                     message: response.data,
            //                     type: 'success',
            //                     duration: 2000
            //                 });
            //                 this.$router.push('/admin/article/list?xx')
            //             } else {
            //                 this.$notify({
            //                     title: '失败',
            //                     message: response.data,
            //                     type: 'warning',
            //                     duration: 2000
            //                 });
            //             }
            //         }).catch(err => {
            //             console.log(err)
            //         })
            //     }
            // },
            // getRemoteUserList(query) {
            //     userSearch(query).then(response => {
            //         if (!response.data.items) return;
            //         this.userListOptions = response.data.items.map(v => v.name);
            //     })
            // },

            //定时任务，实现定时保存文章数据
            interval() {
                this.saveFlag = false;
                this.submitForm('draft'); //定时将文章数据保存到草稿箱中
                this.saveFlag = true;
            },

            editor(val) {
                this.postForm.content_md = val.md;
                if (this.isEdit) { //如果是修改操作，就定时保存文章数据
                    //定时器，每隔5分钟执行一次
                    // setTimeout(() => {
                    //     this.interval()
                    // }, 5 * 1000)
                }
            },

            //===============标签==================
            handleCloseTag(tag) {
                this.dynamicTags.splice(this.dynamicTags.indexOf(tag), 1);
            },
            showInput() {
                this.inputVisible = true;
                this.$nextTick(_ => {
                    this.$refs.saveTagInput.$refs.input.focus();
                });
            },
            handleInputConfirm() {
                let inputValue = this.postForm.tags;
                if (inputValue == '' || inputValue == []) return;
                let repeat = false;
                this.dynamicTags.forEach((item) => {
                    if (item === inputValue) {
                        repeat = true;
                        return;
                    }
                });
                if (!repeat) {
                    this.dynamicTags.push(inputValue);
                    this.inputVisible = false;
                    this.postForm.tags = '';
                } else {
                    this.$message({
                        message: '标签不可重复',
                        type: 'warning',
                    })
                }
            },
        }
    }
</script>

<style rel="stylesheet/scss" lang="scss" scoped>
    @import '~@/styles/mixin.scss';

    .createPost-container {
        position: relative;

        .createPost-main-container {
            min-width: 80%;
            padding: 40px 8%;

            .postInfo-container {
                position: relative;
                @include clearfix;
                margin-bottom: 10px;

                .postInfo-container-item {
                    float: left;
                }
            }

            .editor-container {
                min-height: 500px;
                margin: 0 0 30px;

                .editor-upload-btn-container {
                    text-align: right;
                    margin-right: 10px;

                    .editor-upload-btn {
                        display: inline-block;
                    }
                }
            }
        }

        .word-counter {
            width: 40px;
            position: absolute;
            right: -10px;
            top: 0px;
            font-family: 'Operator Mono', 'Source Sans Pro', Menlo, Monaco, Consolas, Courier New, monospace;
            color: #0000cc;
        }
    }

    .input-new-tag {
        width: 90px;
        margin-left: 10px;
        vertical-align: bottom;
    }

    .tinymce-container {
        position: relative;
    }

    .tinymce-container > > > .mce-fullscreen {
        z-index: 10000;
    }

    .tinymce-textarea {
        visibility: hidden;
        z-index: -1;
    }

    .editor-custom-btn-container {
        position: absolute;
        right: 106px;
        top: 7px;

        .tips {
            margin-right: 5px;
            font-size: 10px;
        }
    }

    .editor-custom-btn-container {
        z-index: 10000;
    }

</style>
