<template>
    <div class="app-container">
        <el-card>
            <el-form ref="searchForm" :model="searchForm"
                     :inline="true" style="width: 100%"
                     label-position="left" size="medium">
                <el-form-item label="最近修改时间: " label-width="110px" style="margin-right: 50px">
                    <el-date-picker
                        v-model="searchTime"
                        type="datetimerange"
                        :picker-options="pickerOptions"
                        range-separator="至"
                        start-placeholder="开始日期"
                        end-placeholder="结束日期"
                        value-format="yyyy-MM-dd HH:mm:ss"
                        format="yyyy-MM-dd HH:mm:ss"
                        align="right" clearable>
                    </el-date-picker>
                </el-form-item>
                <el-form-item prop="title" label="标题/作者: " label-width="80px" style="margin-right: 50px">
                    <el-input v-model="searchForm.title" placeholder="标题/作者"
                              @keyup.enter.native="getList" clearable/>
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" icon="el-icon-search" @click="searchMethod">搜索</el-button>
                    <el-button type="success" icon="el-icon-refresh" @click="getList">刷新</el-button>
                    <el-button type="danger" icon="el-icon-delete" @click="deleteGroup">删除</el-button>
                </el-form-item>
            </el-form>

            <el-table v-loading="listLoading" :data="list" border fit highlight-current-row style="width: 100%"
                      max-height="450" @selection-change="handleSelectionChange">
                <el-table-column
                    type="selection"
                    width="55"/>
                <el-table-column prop="id" align="center" sortable show-overflow-tooltip label="编号" width="80"/>
                <el-table-column align="center" prop="author" label="作者" width="100" show-overflow-tooltip/>
                <el-table-column align="center" prop="title" label="文章标题" min-width="150" show-overflow-tooltip/>
                <el-table-column align="center" prop="origin" label="来源" min-width="150" show-overflow-tooltip/>
                <el-table-column align="center" prop="edit_time" label="最后编辑时间" min-width="170" sortable/>
                <el-table-column align="center" prop="publish_time" label="发布时间" min-width="170" sortable/>
                <el-table-column align="center" prop="category" show-overflow-tooltip label="分类" width="130"/>
                <el-table-column align="center" prop="state" label="状态" width="100" fixed="right"
                                 :filters="[{text: '发布', value: 'published'}, {text: '草稿', value: 'draft'}, {text: '删除', value: 'deleted'}]"
                                 :filter-method="filterTag">
                    <template slot-scope="scope">
                        <el-tag v-bind:type="getStateType(scope.row.state)">{{getStateText(scope.row.state)}}</el-tag>
                    </template>
                </el-table-column>
                <el-table-column label="操作" align="center" width="180"
                                 class-name="small-padding fixed-width" fixed="right">
                    <template slot-scope="scope">
                        <router-link :to="'/admin/article/edit/' + scope.row.id">
                            <el-button size="mini" icon="el-icon-edit" type="warning"/>
                        </router-link>
                        <!--                    <el-button size="mini" icon="el-icon-view" type="primary"/>-->
                        <el-button @click="handleDelete(scope.row.id)" icon="el-icon-delete" size="mini" type="danger"/>
                    </template>
                </el-table-column>
            </el-table>

            <pagination v-show="total>0" :total="total" :page.sync="listQuery.pageCode" :limit.sync="listQuery.pageSize"
                        @pagination="getList"/>
        </el-card>
    </div>
</template>

<script>
    import {findAll, findByPage, deleteById} from '@/api/article'
    import Pagination from '@/components/Pagination' // Secondary package based on el-pagination

    export default {
        name: 'ArticleList',
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
                list: [],
                listLoading: true,
                total: 0,
                listQuery: {
                    pageCode: 1,
                    pageSize: 10
                },
                stateText: {
                    published: '发布',
                    draft: '草稿',
                    deleted: '删除'
                },
                stateType: {
                    published: 'success',
                    draft: 'info',
                    deleted: 'danger'
                },
                searchTime: [],
                searchForm: {
                    begin_time: '',
                    end_time: '',
                    title: '',
                },
                multipleSelection: [],
                pickerOptions: {
                    shortcuts: [{
                        text: '最近一周',
                        onClick(picker) {
                            const end = new Date();
                            const start = new Date();
                            start.setTime(start.getTime() - 3600 * 1000 * 24 * 7);
                            picker.$emit('pick', [start, end]);
                        }
                    }, {
                        text: '最近一个月',
                        onClick(picker) {
                            const end = new Date();
                            const start = new Date();
                            start.setTime(start.getTime() - 3600 * 1000 * 24 * 30);
                            picker.$emit('pick', [start, end]);
                        }
                    }, {
                        text: '最近三个月',
                        onClick(picker) {
                            const end = new Date();
                            const start = new Date();
                            start.setTime(start.getTime() - 3600 * 1000 * 24 * 90);
                            picker.$emit('pick', [start, end]);
                        }
                    }]
                },
            }
        },
        created() {
            this.getList();
        },
        watch: {
            searchTime(newVal, oldVal) {
                if (newVal !== null) {
                    this.searchForm.begin_time = newVal[0];
                    this.searchForm.end_time = newVal[1];
                } else {
                    this.searchForm.begin_time = '';
                    this.searchForm.end_time = '';
                }
            }
        },
        methods: {
            handleSelectionChange(val) {
                this.multipleSelection = val;
            },
            deleteGroup() {
                this.handleDelete(this.multipleSelection);
            },
            searchMethod() {
                this.getList();
            },
            filterTag(value, row) {
                return row.state === value;
            },
            getStateType(val) {
                return this.stateType[val];
            },
            getStateText(val) {
                return this.stateText[val];
            },
            refreshList(arg) {
                if (arg) {
                    this.listQuery.pageCode = arg.page;
                    this.listQuery.pageSize = arg.limit;
                }
                findByPage(this.listQuery.pageCode, this.listQuery.pageSize,
                    this.searchForm.begin_time, this.searchForm.end_time,
                    this.searchForm.title).then(response => {
                    if (response.code === 20000) {
                        this.list = response.data.rows;
                        this.total = response.data.total;
                    }
                    this.listLoading = false;
                }).catch(err => {
                    console.log(err);
                });
            },
            getList(arg) {
                this.listLoading = true;
                this.refreshList(arg);
            },
            handleDelete(id) {
                this.$confirm('你确定永久删除选中的信息？', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning',
                    center: true
                }).then(() => {
                    let ids = id;
                    if (!Array.isArray(ids)) {
                        ids = [];
                        ids.push(id);
                    }
                    deleteById(ids).then(response => {
                        let flag = 'success';
                        if (response.code !== 20000) {
                            flag = 'error'
                        }
                        this.refreshList();
                        this.$message({
                            showClose: true,
                            type: flag,
                            message: response.data,
                        });
                    });
                }).catch(() => {
                    this.$message({
                        showClose: true,
                        type: 'info',
                        message: '已取消删除',
                    });
                });
            }
        }
    }
</script>

<style rel="stylesheet/scss" lang="scss" scoped>
    .editor-container {
        padding: 32px;
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
