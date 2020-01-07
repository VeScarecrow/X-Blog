<template>
    <el-table :data="list" style="width: 100%;padding-top: 15px;"  max-height="600">
        <el-table-column label="留言者" width="100" show-tooltip-when-overflow>
            <template slot-scope="scope">
                {{ scope.row.author }}
            </template>
        </el-table-column>
        <el-table-column label="内容" width="120" align="center" show-tooltip-when-overflow>
            <template slot-scope="scope">
                <router-link :to="'/article/' +((scope.row.sort === 0) ? (scope.row.article_id) : '')" target="_blank">
                    {{scope.row.content }}
                </router-link>
            </template>
        </el-table-column>
        <el-table-column label="时间" min-width="150" align="center">
            <template slot-scope="scope">
                {{ scope.row.time }}
            </template>
        </el-table-column>
    </el-table>
</template>

<script>
    import {findAllComments} from '@/api/comments'

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
                findAllComments().then(response => {
                    if (response.code === 20000) {
                        this.list = response.data
                    }
                })
            }
        }
    }
</script>
