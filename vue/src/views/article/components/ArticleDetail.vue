<template>
    <div class="app-container">
        <el-card>
            <div class="createPost-container">
                <sticky :class-name="'sub-navbar '+ this.postForm.state">
                    <!--                    <CommentDropdown v-model="postForm.comment_disabled"/>-->
                    <!--                    <PlatformDropdown v-model="postForm.platforms"/>-->
                    <el-button style="margin-left: 10px;" type="success" @click="submitForm('published')">发布
                    </el-button>
                    <el-button type="warning" @click="submitForm('draft')">草稿</el-button>
                    <el-button type="primary" @click="submitForm('save')">保存</el-button>
                    <el-button type="danger" @click="submitForm('delete')">删除</el-button>
                </sticky>


                <el-form ref="postForm" :model="postForm" :rules="rules"
                         label-width="100px" :inline="true"
                         label-position="top" class="createPost-main-container">

                    <el-form-item prop="title" label="文章标题:" style="width: 80%;">
                        <el-input v-model="postForm.title" placeholder="标题" clearable style="max-width: 80%"/>
                        <el-button @click="uploadCoverVisable = true" type="primary" icon="el-icon-upload2">上传封面图片
                        </el-button>
                        <el-dialog title="修改文章封面图片" :visible.sync="uploadCoverVisable" width="50%"
                                   :append-to-body='false'>
                            <span>
                                 <Upload v-model="postForm.title_pic"/>
                            </span>
                            <span slot="footer" class="dialog-footer">
                                <el-button type="primary" @click="uploadCoverVisable = false">确 定</el-button>
                            </span>
                        </el-dialog>
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

                    <el-form-item label-width="60px" label="分类:" style="min-width: 30%;margin-right: 3%"
                                  prop="category">
                        <el-tooltip effect="dark" content="下拉框中没有？可直接键入"
                                    placement="top-start">
                            <el-select v-model="postForm.category" allow-create filterable remote
                                       :remote-method="remoteSearch" :loading="searchLoading"
                                       placeholder="请输入/选择文章分类">
                                <el-option
                                    v-for="item in searchArr"
                                    :key="item.value"
                                    :label="item.label"
                                    :value="item.value">
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

                    <el-form-item prop="origin" label="外链:" style="min-width: 30%;margin-right: 3%">
                        <el-input v-model="postForm.origin" placeholder="URL" style="min-width: 195px;"
                                  clearable>
                            <template slot="prepend">HTTP / FTP</template>
                        </el-input>
                    </el-form-item>

                    <el-form-item prop="content_md" label-width="60px" label="内容:"
                                  style="width: 100%;" :inline-message="true">
                        <div class="tinymce-container editor-container">
                            <!-- Markdown富文本组件 -->
                            <markdown :content="postForm.content_md" @editor="editor" style="line-height: normal"/>
                        </div>
                    </el-form-item>

                </el-form>

            </div>
        </el-card>
    </div>
</template>

<script>
    import markdown from './markdown'
    // import Upload from '@/components/Upload/singleImage3'
    import MDinput from '@/components/MDinput'
    import Sticky from '@/components/Sticky' // 粘性header组件
    import {validateURL} from '@/utils/validate'
    import {findById, save, update} from '@/api/article'
    import {findByName} from '@/api/category'
    import {userSearch} from '@/api/remoteSearch'
    import Warning from './Warning'
    import {CommentDropdown, PlatformDropdown, SourceUrlDropdown} from './Dropdown'
    import Upload from '@/components/Upload/singleImage'

    const defaultForm = {
        id: undefined,//文章id
        title: '', // 标题
        title_pic: '', // 图片url
        author: 'Colborne',//作者
        content: '', // 文章摘要
        content_md: '', // 文章内容-md
        content_html: '', // 文章内容-html
        origin: '', // 文章外链
        state: 'draft', //文章状态draft/deleted/published
        eye_count: 0,//
        publish_time: '', // 时间
        edit_time: '',
        category: 'UI/UE',
        tags: '',

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
                console.log(value);
                if (value) {
                    if (validateURL(value)) {
                        callback()
                    } else {
                        callback(new Error('url格式错误'))
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
                        {max: 50, message: '长度不大于50字符', trigger: 'blur'}
                    ],
                    author: [
                        {required: true, message: '请输入作者姓名(长度<=20)', trigger: 'blur'},
                        {max: 30, message: '长度不大于30字符', trigger: 'blur'}
                    ],
                    category: [
                        {required: true, message: '请选择/输入文章类型', trigger: 'blur'},
                    ],
                    content: [
                        {required: true, message: '请输入文章摘要(长度5-30)', trigger: 'blur'},
                        {min: 0, max: 50, message: '长度不大于50字符', trigger: 'blur'}
                    ],
                    content_md: [
                        {required: true, message: '请输入文章内容', trigger: 'blur'},
                        {max: 15000000, message: '长度受限', trigger: 'blur'}
                    ],
                    origin: [
                        // {required: true, message: '请输入url', trigger: 'blur'},
                        {validator: validateSourceUri, trigger: 'blur'}
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
                tempRoute: {},
                searchLoading: false,
                searchArr: [],
                uploadCoverVisable: false
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
            remoteSearch(query) {
                if (query !== '') {
                    this.searchLoading = true;
                    setTimeout(() => {
                        findByName(query).then(response => {
                            this.searchArr = response.data.map(item => {
                                return {value: item, label: item};
                            });
                        }).catch(err => {
                            console.log(err)
                        });
                        this.searchLoading = false;
                    }, 300);
                } else {
                    this.searchArr = [];
                }
            },
            fetchData(id) {
                findById(id).then(response => {
                    this.dynamicTags = eval(response.data.tags);
                    this.postForm = response.data;
                    this.postForm.tags = '';
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
                this.postForm.state = state || 'draft';
                // if (this.postForm.state == 'save') this.postForm.state = 'draft';
                if (this.isEdit) {
                    this.$refs.postForm.validate(valid => this.updateAction(valid));
                } else {
                    this.$refs.postForm.validate(valid => this.saveAction(valid));
                }
            },
            updateAction(valid) {
                if (valid) {
                    this.loading = true;
                    console.log(this.postForm.content_html.length);
                    update(this.postForm).then(response => {
                        if (response.code === 20000) {
                            this.$notify({
                                title: '更新',
                                message: response.data,
                                type: 'success',
                                duration: 3000
                            });
                            this.$router.push('/admin/article/list')
                        } else {
                            this.$notify({
                                title: '更新',
                                message: response.data,
                                type: 'warning',
                                duration: 3000
                            });
                        }
                    }).catch(err => {
                        console.log(err)
                    })
                    this.loading = false
                } else {
                    this.$message({
                        showClose: true,
                        type: 'warning',
                        message: '请完善文章内容',
                        duration: 3000
                    });
                }
            },
            saveAction(valid) {
                if (valid) {
                    this.loading = true;
                    save(this.postForm).then(response => {
                        if (response.code === 20000) {
                            this.$notify({
                                title: '添加成功',
                                message: response.data,
                                type: 'success',
                                duration: 3000
                            });
                            this.$router.push('/admin/article/list')
                        } else {
                            this.$notify({
                                title: '添加失败',
                                message: response.data,
                                type: 'warning',
                                duration: 3000
                            });
                        }
                    }).catch(err => {
                        console.log(err)
                    })
                    this.loading = false
                } else {
                    this.$message({
                        showClose: true,
                        type: 'warning',
                        message: '请完善文章内容',
                        duration: 3000
                    });
                }
            },
            //定时任务，实现定时保存文章数据
            interval() {
                this.saveFlag = false;
                this.submitForm('draft'); //定时将文章数据保存到草稿箱中
                this.saveFlag = true;
            },

            editor(val) {
                console.log(this.postForm.content_html.length);
                this.postForm.content_md = val.md;
                this.postForm.content_html = val.html;
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
                if (inputValue === '' || inputValue === []) return;
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
                        showClose: true,
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
        z-index: 1;

        .tips {
            margin-right: 5px;
            font-size: 12px;
        }
    }

</style>
