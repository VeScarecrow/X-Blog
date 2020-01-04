<template>
    <el-dropdown :show-timeout="100" trigger="click">
        <el-button type="primary">
            {{ !comment_disabled?'评论已打开':'评论已关闭' }}
            <i class="el-icon-caret-bottom el-icon--right"/>
        </el-button>
        <el-dropdown-menu slot="dropdown" class="no-padding no-border">
            <el-radio-group v-model="comment_disabled" style="padding: 10px;">
                <el-radio-button :label="true">关闭评论</el-radio-button>
                <el-radio-button :label="false">开启评论</el-radio-button>
            </el-radio-group>
        </el-dropdown-menu>
    </el-dropdown>
</template>

<script>
    export default {
        props: {
            value: {
                type: Boolean,
                default: false
            }
        },
        computed: {
            comment_disabled: {
                get() {
                    return this.value
                },
                set(val) {
                    this.$emit('input', val)
                }
            }
        }
    }
</script>
