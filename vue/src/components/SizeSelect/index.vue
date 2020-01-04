<template>
    <el-dropdown trigger="click" @command="handleSetSize">
        <div>
            <svg-icon class-name="size-icon" icon-class="size"/>
        </div>
        <el-dropdown-menu slot="dropdown">
            <el-dropdown-item :disabled="size==='medium'" command="medium">中号 / Medium</el-dropdown-item>
            <el-dropdown-item :disabled="size==='small'" command="small">小号 / Small</el-dropdown-item>
            <el-dropdown-item :disabled="size==='mini'" command="mini">迷你 / Mini</el-dropdown-item>
        </el-dropdown-menu>
    </el-dropdown>
</template>

<script>
    export default {
        computed: {
            size() {
                return this.$store.getters.size
            }
        },
        methods: {
            handleSetSize(size) {
                this.$ELEMENT.size = size
                this.$store.dispatch('setSize', size)
                this.refreshView()
                this.$message({
                    message: this.$i18n.locale === 'zh' ? '更换尺寸成功' : 'Switch Size Success',
                    type: 'success'
                })
            },
            refreshView() {
                // In order to make the cached page re-rendered
                this.$store.dispatch('delAllCachedViews', this.$route)

                const {fullPath} = this.$route

                this.$nextTick(() => {
                    this.$router.replace({
                        path: '/redirect' + fullPath
                    })
                })
            }
        }

    }
</script>

<style scoped>
    .size-icon {
        font-size: 20px;
        cursor: pointer;
        vertical-align: -4px !important;
    }
</style>

