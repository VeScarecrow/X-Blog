<template>
    <div class="app-container">
        <el-card >
            <div slot="header">
                <span class="card-header">文章封面</span>
            </div>
            <div class="cover-container">
                <pic-card :list="list" @refushFlag="refushFlag"/>

                <pagination v-show="total>0" :total="total" :page.sync="listQuery.pageCode"
                            :limit.sync="listQuery.pageSize"
                            :pageSizes="[8,12,16,20]" @pagination="getList"/>
            </div>
        </el-card>
    </div>
</template>

<script>
    import {findByPage} from '@/api/article'
    import PicCard from './components/PicCard'
    import Pagination from '@/components/Pagination'

    export default {
        name: "index",
        components: {PicCard, Pagination},
        data() {
            return {
                list: null,
                listLoading: true,
                total: 0,
                listQuery: {
                    pageCode: 1,
                    pageSize: 8
                }
            }
        },
        created() {
            this.getList()
        },
        methods: {
            getList(arg) {
                if (arg) {
                    this.listQuery.pageCode = arg.page;
                    this.listQuery.pageSize = arg.limit;
                }
                this.listLoading = true;
                findByPage(this.listQuery.pageCode, this.listQuery.pageSize).then(response => {
                    if (response.code === 20000) {
                        this.list = response.data.rows;
                        this.total = response.data.total;
                        this.listLoading = false
                    }
                })
            },
            refushFlag(val) {
                if (val) {
                    this.getList();
                }
            }
        },

    }
</script>

<style rel="stylesheet/scss" lang="scss" scoped>
    .cover-container {
        /*padding: 0 30px;*/
    }
</style>
