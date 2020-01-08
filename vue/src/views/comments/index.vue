<template>
    <div class="app-container">
        <el-card>
            <el-table :data="list" border style="width: 100%" max-height="500">
                <el-table-column ref="selection" align="center" type="selection" width="55"/>
                <el-table-column prop="id" align="center" sortable fixed label="编号" show-overflow-tooltip width="80"/>
                <el-table-column align="center" prop="content" label="留言内容" min-width="180" show-overflow-tooltip/>
                <el-table-column align="center" prop="article_title" label="文章标题" min-width="180" show-overflow-tooltip/>
                <el-table-column align="center" prop="author" show-overflow-tooltip label="留言人" min-width="100"/>
                <el-table-column align="center" prop="author_id" show-overflow-tooltip label="回复对象" min-width="100"/>
                <el-table-column align="center" prop="time" sortable show-overflow-tooltip label="留言时间"
                                 min-width="170"/>
                <el-table-column align="center" prop="email" show-overflow-tooltip label="留言人邮箱" min-width="150"/>
                <el-table-column align="center" prop="url" label="留言人URL" show-overflow-tooltip min-width="150">
                    <template slot-scope="scope">
                        <a :href="scope.row.url" target="_blank">{{scope.row.url}}</a>
                    </template>
                </el-table-column>
                <el-table-column align="center" prop="state" label="状态" width="100" fixed="right" sortable>
                    <template slot-scope="scope">
                        <el-tag :type="getState(scope.row.state)">{{scope.row.state}}</el-tag>
                    </template>
                </el-table-column>
                <el-table-column label="操作" align="center" fixed="right" min-width="180">
                    <template slot-scope="scope">
                        <el-button icon="el-icon-delete" size="mini" type="danger" @click="handleDelete(scope.row.id)">
                            删除
                        </el-button>
                        <router-link :to="(scope.row.sort === 0) ? ( '/article/' + scope.row.article_id) : '/'"
                                     target="_blank">
                            <el-button size="mini" icon="el-icon-view" type="primary">预览</el-button>
                        </router-link>
                    </template>
                </el-table-column>
            </el-table>

            <pagination v-show="total>0" :total="total" :page.sync="listQuery.pageCode" :limit.sync="listQuery.pageSize"
                        @pagination="getList"/>
        </el-card>
    </div>
</template>

<script>
    import {findByPage, deleteById} from '@/api/comments'
    import Pagination from '@/components/Pagination'

    export default {
        name: "index",
        components: {Pagination},
        data() {
            return {
                list: [],
                loading: false,
                total: 0,
                listQuery: {
                    pageCode: 1,
                    pageSize: 10
                }
            }
        },
        created() {
            this.getList();
        },
        methods: {
            getState(val) {
                return val === '正常' ? 'success' : 'danger';
            },
            getList(arg) {
                if (arg) {
                    this.listQuery.pageCode = arg.page;
                    this.listQuery.pageSize = arg.limit;
                }
                this.loading = true;
                findByPage(this.listQuery.pageCode, this.listQuery.pageSize).then(response => {
                    if (response.code === 20000) {
                        this.list = response.data.rows;
                        this.total = response.data.total;
                        this.loading = false;
                    }
                }).catch(err => {
                    console.log(err);
                })
            },

            handleDelete(id) {
                this.$confirm('你确定永久删除此用户信息？', '提示', {
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
            }
        },
    }
</script>

<style rel="stylesheet/scss" lang="scss" scoped>
    .comments-container {
        padding: 32px;
    }
</style>
