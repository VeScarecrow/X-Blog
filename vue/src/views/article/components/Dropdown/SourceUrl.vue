<template>
  <el-dropdown :show-timeout="100" trigger="click">
    <el-button type="primary">
      外链
      <i class="el-icon-caret-bottom el-icon--right"/>
    </el-button>
    <el-dropdown-menu slot="dropdown" class="no-padding no-border" style="width:400px">
        <el-input v-model="source_uri" placeholder="请输入内容">
          <template slot="prepend">Http://</template>
        </el-input>
    </el-dropdown-menu>
  </el-dropdown>
</template>

<script>
export default {
  props: {
    value: {
      type: String,
      default: ''
    }
  },
  computed: {
    source_uri: {
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
