<template>
    <el-table :data="list" style="width: 100%;padding-top: 15px;" max-height="600">
        <el-table-column label="标题" min-width="120" show-tooltip-when-overflow>
            <template slot-scope="scope">
                <router-link :to="'/article/' + (scope.row.id)" target="_blank">{{scope.row.title}}</router-link>
            </template>
        </el-table-column>
        <el-table-column label="分类" min-width="80" align="center" show-tooltip-when-overflow>
            <template slot-scope="scope">
                <el-tag type="success">{{ scope.row.category }}</el-tag>
            </template>
        </el-table-column>
        <el-table-column label="浏览量" min-width="50" align="center">
            <template slot-scope="scope">
                <el-tag type="primary"> {{ scope.row.eye_count }}</el-tag>
            </template>
        </el-table-column>
    </el-table>
</template>

<script>
    import {findAllArticle} from '@/api/article'

    export default {
        filters: {
            statusFilter(status) {
                const statusMap = {
                    success: 'success',
                    pending: 'danger'
                }
                return statusMap[status]
            },
            orderNoFilter(str) {
                return str.substring(0, 30)
            }
        },
        data() {
            return {
                list: []
            }
        },
        created() {
            this.fetchData()
        },
        methods: {
            fetchData() {
                findAllArticle().then(response => {
                    if (response.code === 20000) {
                        this.list = response.data
                    }
                })
            }
        }
    }
</script>
