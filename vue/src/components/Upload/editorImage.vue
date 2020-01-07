<template>
    <div class="upload-container">
        <el-button :style="{background:color,borderColor:color}" icon="el-icon-upload" size="mini" type="primary"
                   @click=" dialogVisible=true">上传图片
        </el-button>
        <el-dialog :visible.sync="dialogVisible">
            <el-upload
                drag
                :multiple="true"
                :file-list="fileList"
                :show-file-list="true"
                :on-remove="handleRemove"
                :on-success="handleSuccess"
                :before-upload="beforeUpload"
                class="editor-slide-upload"
                action="http://xcoding.com:8080/storage/upload"
                list-type="picture-card">
                <i class="el-icon-upload"/>
                <div slot="tip" class="el-upload__tip">只能上传jpg,png,jpeg,gif文件,最多10张</div>
                <div class="el-upload__text">将文件拖到此处，或<em>点击上传</em></div>
            </el-upload>
            <el-button @click="dialogVisible = false">取 消</el-button>
            <el-button type="primary" @click="handleSubmit">确 定</el-button>
        </el-dialog>
    </div>
</template>

<script>
    import imageConversion from 'image-conversion'

    export default {
        name: 'editorImage',
        props: {
            color: {
                type: String,
                default: '#1890ff'
            }
        },
        data() {
            return {
                dialogVisible: false,
                listObj: {},
                fileList: []
            }
        },
        methods: {
            checkAllSuccess() {
                return Object.keys(this.listObj).every(item => this.listObj[item].hasSuccess)
            },
            handleSubmit() {
                const arr = Object.keys(this.listObj).map(v => this.listObj[v])
                if (!this.checkAllSuccess()) {
                    this.$message('请等待所有图片上传成功 或 出现了网络问题，请刷新页面重新上传！')
                    return
                }
                this.$emit('successCBK', arr);
                this.listObj = {};
                this.fileList = [];
                this.dialogVisible = false
            },
            handleSuccess(response, file) {
                const uid = file.uid;
                const objKeyArr = Object.keys(this.listObj)
                for (let i = 0, len = objKeyArr.length; i < len; i++) {
                    if (this.listObj[objKeyArr[i]].uid === uid) {
                        this.listObj[objKeyArr[i]].url = response.data
                        this.listObj[objKeyArr[i]].hasSuccess = true
                        return
                    }
                }
            },
            handleRemove(file) {
                const uid = file.uid
                const objKeyArr = Object.keys(this.listObj)
                for (let i = 0, len = objKeyArr.length; i < len; i++) {
                    if (this.listObj[objKeyArr[i]].uid === uid) {
                        delete this.listObj[objKeyArr[i]]
                        return
                    }
                }
            },
            beforeUpload(file) {
                if (this.fileList.length > 10) {
                    this.fileList.splice(-10);
                    this.$message({
                        message: '最多上传10张',
                        type: 'warning'
                    })
                }
                const _self = this
                const _URL = window.URL || window.webkitURL
                const fileName = file.uid
                const isLt1M = file.size / 1024 / 1024 > 1 //图片大于1M
                this.listObj[fileName] = {}
                return new Promise((resolve, reject) => {
                    // if (_self.fileList.length > 10) {
                    //     _self.fileList.splice(-10);
                    //     _self.$message({
                    //         message: '最多上传10张',
                    //         type: 'warning'
                    //     })
                    //     reject();
                    // }
                    const img = new Image()
                    img.src = _URL.createObjectURL(file)
                    img.onload = function () {
                        if (isLt1M) {
                            //如超过则压缩
                            imageConversion.compressAccurately(file, {
                                size: 100,
                                width: 1920,
                                height: 1080
                            }).then(res => {
                                // resolve(res)
                            })
                        }
                        _self.listObj[fileName] = {
                            hasSuccess: false,
                            uid: file.uid,
                            width: this.width,
                            height: this.height
                        }
                    }
                    resolve(true)
                })
            }
        }
    }
</script>
<style rel="stylesheet/scss" lang="scss">
    .el-upload--picture-card {
        line-height: 27px;
    }

    .el-upload-dragger {
        border: none;
        height: 146px !important;
    }

    .el-upload-dragger .el-icon-upload {
        line-height: 0;
        margin: 52px 0 16px;
    }
</style>
<style rel="stylesheet/scss" lang="scss" scoped>
    .editor-slide-upload {
        margin-bottom: 20px;

        /deep/ .el-upload--picture-card {
            width: 100%;
        }
    }
</style>
