'use strict'
const merge = require('webpack-merge')
const prodEnv = require('./prod.env')

module.exports = merge(prodEnv, {
    NODE_ENV: '"development"',
    BASE_API: '"http://192.168.43.241:80/"'
    // BASE_API: '"http://xcoding.com:8080"'
    // BASE_API: '"http://127.0.0.1:8084/"'
    // BASE_API: '"https://easy-mock.com/mock/5950a2419adc231f356a6636/vue-admin"',
})
