<template>
    <div class="app-container">
        <el-card>
            <div>
                <el-form :inline="true" :model="editor" ref="postForm">
                    <el-form-item required prop="name" :rules="[{ required: true, message: '请输入友链名称'}]"
                                  label="友链名称">
                        <el-input style="min-width: 300px" v-model="editor.name" placeholder="请输入友链名称"/>
                    </el-form-item>
                    <el-form-item required prop="url" :rules="[{ required: true, message: '请输入链接地址'}]"
                                  label="链接地址">
                        <el-input style="min-width: 300px" v-model="editor.url" placeholder="请输入链接地址"/>
                    </el-form-item>
                    <el-form-item>
                        <el-button type="success" @click="handleSave">保存友链</el-button>
                    </el-form-item>
                </el-form>
            </div>

            <el-table v-loading="listLoading" :data="list" border fit highlight-current-row style="width: 100%"
                      max-height="450" size="medium">
                <el-table-column align="center" label="编号" width="100" sortable>
                    <template slot-scope="scope">
                        <span>{{ scope.row.id }}</span>
                    </template>
                </el-table-column>

                <el-table-column width="230px" align="center" label="友链名称" show-tooltip-when-overflow>
                    <template slot-scope="scope">
                        <span>{{ scope.row.name }}</span>
                    </template>
                </el-table-column>

                <el-table-column min-width="230px" align="center" label="连接地址" show-tooltip-when-overflow>
                    <template slot-scope="scope">
                        <template v-if="scope.row.edit">
                            <el-input v-model="scope.row.url" class="edit-input" size="small"/>
                            <el-button class="cancel-btn" size="small" icon="el-icon-refresh" type="warning"
                                       @click="cancelEdit(scope.row)">取消
                            </el-button>
                        </template>
                        <span v-else>{{ scope.row.url }}</span>
                    </template>
                </el-table-column>

                <el-table-column align="center" label="操作" width="250" fixed="right">
                    <template slot-scope="scope">
                        <el-button v-if="scope.row.edit" type="success" size="small"
                                   icon="el-icon-circle-check-outline"
                                   @click="confirmEdit(scope.row)">确认
                        </el-button>
                        <el-button v-else type="primary" size="small" icon="el-icon-edit"
                                   @click="scope.row.edit=!scope.row.edit">编辑
                        </el-button>
                        <el-button type="danger" size="small" icon="el-icon-delete"
                                   @click="handleDelete(scope.row.id)">
                            删除
                        </el-button>
                    </template>
                </el-table-column>
            </el-table>

            <pagination v-show="total>0" :total="total" :page.sync="listQuery.pageCode" :limit.sync="listQuery.pageSize"
                        @pagination="getList"/>
        </el-card>
    </div>
</template>

<script>
    import {findByPage, deleteById, save, update} from '@/api/links'
    import Pagination from '@/components/Pagination'

    export default {
        name: 'index',
        components: {Pagination},
        total: 0,
        filters: {
            statusFilter(status) {
                const statusMap = {
                    published: 'success',
                    draft: 'info',
                    deleted: 'danger'
                }
                return statusMap[status]
            }
        },
        data() {
            return {
                editor: {
                    name: '',
                    url: '',
                },
                list: [],
                listLoading: true,
                listQuery: {
                    pageCode: 1,
                    pageSize: 10
                }
            }
        },
        created() {
            this.getList()
        },
        methods: {
            getList(arg) {
                this.listLoading = true
                this.refreshList(arg);
            },
            refreshList(arg) {
                if (arg) {
                    this.listQuery.pageCode = arg.page;
                    this.listQuery.pageSize = arg.limit;
                }
                findByPage(this.listQuery.pageCode, this.listQuery.pageSize).then(response => {
                    if (response.code === 20000) {
                        const items = response.data.rows;
                        this.list = items.map(v => {
                            this.$set(v, 'edit', false);
                            return v
                        })
                        this.total = response.data.total;
                        this.listLoading = false
                    } else {
                        this.$message({
                            showClose: true,
                            type: 'error',
                            message: response.data,
                            duration: 3000
                        });
                    }
                }).catch(err => {
                    console.log(err);
                })
            },
            cancelEdit(row) {
                row.title = row.originalTitle
                row.edit = false
                this.$message({
                    showClose: true,
                    message: '已取消修改',
                    type: 'warning'
                })
                this.refreshList();
            },
            confirmEdit(row) {
                update(row).then(response => {
                    if (response.code === 20000) {
                        this.$message({
                            showClose: true,
                            message: '更新成功',
                            type: 'success',
                            duration: 3000
                        });
                        this.refreshList();
                    } else {
                        this.$message({
                            showClose: true,
                            message: response.data,
                            type: 'error',
                            duration: 3000
                        });
                    }
                }).catch(err => {
                    console.log(err);
                })
                row.edit = false
                row.originalTitle = row.title

            },
            handleDelete(id) {
                this.$confirm('你确定永久删除此友链信息？', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning',
                    center: true
                }).then(() => {
                    let ids = [];
                    ids.push(id);
                    deleteById(ids).then(response => {
                        let flag = 'success';
                        if (response.code !== 20000) {
                            flag = 'warning'
                        }
                        this.$message({
                            showClose: true,
                            type: flag,
                            message: response.data,
                            duration: 3000
                        });
                        this.getList();
                    }).catch(err => {
                        console.log(err);
                    });
                }).catch(() => {
                    this.$message({
                        showClose: true,
                        type: 'info',
                        message: '已取消删除',
                        duration: 3000
                    });
                });
            },
            handleSave() {
                this.$refs.postForm.validate(valid => {
                    if (valid) {
                        save(this.editor).then(response => {
                            if (response.code === 20000) {
                                this.$notify({
                                    title: '成功',
                                    message: response.data,
                                    type: 'success',
                                    duration: 3000
                                });
                                this.editor.name = '';
                                this.editor.url = '';
                                this.refreshList();
                            } else {
                                this.$notify({
                                    title: '失败',
                                    message: response.data,
                                    type: 'warning',
                                    duration: 3000
                                });
                            }
                            this.$refs.postForm.resetFields();
                        }).catch(err => {
                            console.log(err);
                        })
                    }
                });
            }
        }
    }
</script>

<style scoped>

    .card-header {
        font-size: 20px;
        /*font-family: 'Operator Mono', 'Source Sans Pro', Menlo, Monaco, Consolas, Courier New, monospace;*/
    }

    .edit-input {
        padding-right: 100px;
    }

    .cancel-btn {
        position: absolute;
        right: 15px;
        top: 10px;
    }
</style>
