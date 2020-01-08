<template>
    <div>
        <el-card class="card-tags" shadow="hover">
            <div slot="header">
                <span>标签列表</span>
                <el-button type="success" style="float: right;padding: 7px 1pc 6px 17px;color:#fff;"
                           @click="dialogVisible = true">添加
                </el-button>
            </div>
            <!-- 列表 -->
            <el-table ref="tags" :data="list" border
                      tooltip-effect="dark" max-height="420" size="medium"
                      style="width: 100%">
                <el-table-column prop="id" align="center" sortable label="编号" show-overflow-tooltip width="80"/>
                <el-table-column min-width="250px" label="标签名称" show-tooltip-when-overflow show-overflow-tooltip>
                    <template slot-scope="scope">
                        <template v-if="scope.row.edit">
                            <el-input v-model="scope.row.name" class="edit-input" size="mini"/>
                            <el-button class="cancel-btn" size="mini" icon="el-icon-refresh" type="warning"
                                       @click="cancelEdit(scope.row)">取消
                            </el-button>
                        </template>
                        <span v-else>{{ scope.row.name }}</span>
                    </template>
                </el-table-column>

                <el-table-column align="center" label="操作" width="200" fixed="right">
                    <template slot-scope="scope">
                        <el-button v-if="scope.row.edit" type="success" size="mini" icon="el-icon-circle-check-outline"
                                   @click="confirmEdit(scope.row)">确认
                        </el-button>
                        <el-button v-else type="primary" size="mini" icon="el-icon-edit"
                                   @click="scope.row.edit=!scope.row.edit">编辑
                        </el-button>
                        <el-button icon="el-icon-delete" size="mini" type="danger" @click="handleDelete(scope.row.id)">
                            删除
                        </el-button>
                    </template>
                </el-table-column>
            </el-table>

            <!-- 分页 -->
            <pagination v-show="total>0" :total="total" :page.sync="listQuery.pageCode" :limit.sync="listQuery.pageSize"
                        @pagination="getList" :pageSizes="[6,12,16,20]"/>
        </el-card>

        <!-- 标签添加 -->
        <el-dialog title="新增标签" :visible.sync="dialogVisible" width="30%" :append-to-body='true'
                   :before-close="handleClose">
        <span>
            <el-input placeholder="请输入标签名称" v-model="editor.name">
                <template slot="prepend">标签名称</template>
            </el-input>
        </span>
            <span slot="footer" class="dialog-footer">
            <el-button @click="dialogVisible = false">取 消</el-button>
            <el-button type="primary" @click="handleSave">确 定</el-button>
        </span>
        </el-dialog>

    </div>
</template>

<script>
    import {findByPage, deleteById, save, update} from '@/api/tags'
    import Pagination from '@/components/Pagination' // Secondary package based on el-pagination
    export default {
        name: "Tags",
        components: {Pagination},
        filters: {
            statusFilter(status) {
                const statusMap = {
                    published: 'success',
                    draft: 'info',
                    deleted: 'danger'
                };
                return statusMap[status]
            }
        },
        data() {
            return {
                list: null,
                listLoading: true,
                total: 0,
                listQuery: {
                    pageCode: 1,
                    pageSize: 6
                },
                editor: {
                    id: '',
                    name: ''
                },
                dialogVisible: false
            }
        },
        created() {
            this.getList()
        },
        methods: {
            refreshList(arg) {
                if (arg) {
                    this.listQuery.pageCode = arg.page;
                    this.listQuery.pageSize = arg.limit;
                }
                findByPage(this.listQuery.pageCode, this.listQuery.pageSize).then(response => {
                    this.total = response.data.total;
                    const items = response.data;

                    this.list = items.rows.map(v => {
                        this.$set(v, 'edit', false);
                        return v
                    });
                    this.listLoading = false
                }).catch(err => {
                    console.log(err);
                })
            },
            getList(arg) {
                this.listLoading = true;
                this.refreshList(arg);
            },
            cancelEdit(row) {
                row.edit = false;
                this.$message({
                    showClose: true,
                    message: '已取消更改',
                    type: 'warning'
                });
                this.refreshList();
            },
            confirmEdit(row) {
                row.edit = false;
                this.editor = row;
                update(this.editor).then(response => {
                    let flag = 'success';
                    if (response.code !== 20000) {
                        flag = 'danger'
                    }
                    this.$message({
                        showClose: true,
                        type: flag,
                        message: response.data,
                        duration: 3000
                    });
                    this.getList();
                    this.editor = {}
                }).catch(err => {
                    console.log(err);
                });
            },
            handleDelete(id) {
                this.$confirm('你确定永久删除此分类信息？', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning',
                    center: true
                }).then(() => {
                    let ids = [];
                    ids.push(id);
                    deleteById(ids).then(response => {
                        if (response.code === 20000) {
                            this.$message({
                                showClose: true,
                                type: 'success',
                                message: '删除成功',
                                duration: 3000
                            });
                        } else {
                            this.$message({
                                showClose: true,
                                type: 'error',
                                message: response.data,
                                duration: 3000
                            });
                        }
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
                this.dialogVisible = false;
                save(this.editor).then(response => {
                    if (response.code === 20000) {
                        this.$notify({
                            title: '成功',
                            message: response.data,
                            type: 'success',
                            duration: 3000
                        });
                        this.editor = {};
                        this.getList();
                    } else {
                        this.$notify({
                            title: '失败',
                            message: response.data,
                            type: 'warning',
                            duration: 3000
                        });
                    }
                }).catch(err => {
                    console.log(err);
                })
            },
            handleClose() {
                this.dialogVisible = false;
            }
        }
    }
</script>

<style scoped>
    .edit-input {
        padding-right: 100px;
    }

    .cancel-btn {
        position: absolute;
        right: 15px;
        top: 10px;
    }
</style>
