<template>
    <div>
        <el-row :gutter="40" class="panel-group" type="flex" justify="space-between" align="top">
            <el-col :xs="12" :sm="12" :lg="6" class="card-panel-col" v-for="item in list" :key="item.id">
                <el-card class="box-card-component">
                    <div slot="header" class="box-card-header">
                        <img :src="item.title_pic">
                    </div>
                    <div class="footer">
                        <span>{{getItemTitle(item.title)}}</span>
                        <div class="bottom clearfix">
                            <time class="time">{{item.publish_time}}</time>
                            <el-button type="text" class="button" @click="handleEdit(item.id)">编辑</el-button>
                        </div>
                    </div>
                </el-card>
            </el-col>
        </el-row>

        <el-dialog title="修改文章封面图片" :visible.sync="editDialog" width="50%" :append-to-body='true'
                   :before-close="handleClose">
            <span>
                 <Upload v-model="editor.title_pic"/>
            </span>
            <span slot="footer" class="dialog-footer">
                <el-button @click="editDialog = false">取 消</el-button>
                <el-button type="primary" @click="edit">确 定</el-button>
            </span>
        </el-dialog>
    </div>
</template>

<script>
    import {findById, update} from '@/api/article'
    import Upload from '@/components/Upload/singleImage'

    export default {
        name: "PicCard",
        props: ['list'],
        components: {Upload},
        data() {
            return {
                editor: {
                    id: '',
                    title_pic: '',
                },
                editDialog: false, //编辑Dialog
                //文件上传的参数
                dialogImageUrl: '',
                //图片列表（用于回显图片）
                fileList: [{name: '', url: ''}],
            }
        },

        methods: {
            getItemTitle(title) {
                if (title.length > 20) {
                    title = title.substr(0, title.length) + '...';
                }
                return title;
            },
            handleClose() {
                this.editDialog = false;
            },
            handleEdit(id) {
                this.editDialog = true;
                findById(id).then(result => {
                    this.editor = result.data;

                    this.fileList.forEach(row => {
                        row.url = result.data.title_pic; //将图片的URL地址赋值给file-list展示出来
                    });
                });
            },
            edit() {
                update(this.editor).then(result => {
                    this.editDialog = false;
                    if (result.code === 20000) {
                        this.$message({
                            showClose: true,
                            type: 'success',
                            message: result.data,
                            duration: 3000
                        });
                        this.$emit('refushFlag', true)
                    } else {
                        this.$message({
                            showClose: true,
                            type: 'error',
                            message: result.data,
                            duration: 3000
                        });
                        this.$emit('refushFlag', false)
                    }
                });
            },


        }
    }
</script>
<style rel="stylesheet/scss" lang="scss">
    .box-card-component {
        .el-card__header {
            padding: 0 !important;
            height: 80%;
            min-height: 280px;
            max-height: 280px;
        }
    }
</style>
<style rel="stylesheet/scss" lang="scss" scoped>
    * {
        [class*=el-col-] {
            float: none;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }
    }

    .panel-group {
        box-sizing: border-box;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
    }

    .card-panel-col {
        margin: 20px 0;
    }

    .box-card-component {
        width: 100%;
        height: 100%;

        .box-card-header {
            position: relative;
            width: 100%;
            height: 100%;
            img {
                width: 100%;
                height: 100%;
                transition: all 0.3s linear;
                &:hover {
                    transform: scale(1.1, 1.1);
                    filter: contrast(130%);
                }
            }
        }

        .footer {
            width: 100%;
            height: 100%;

            .bottom {
                margin-top: 13px;
                line-height: 12px;

                .time {
                    font-size: 13px;
                    color: #999;
                }

                .button {
                    padding: 0;
                    float: right;
                }
            }

            .clearfix:before,
            .clearfix:after {
                display: table;
                content: "";
            }

            .clearfix:after {
                clear: both
            }
        }
    }

</style>
