const { defineConfig } = require('@vue/cli-service')
const webpack = require("webpack");
module.exports = defineConfig({
  outputDir: '../pos-vue3-build/',
  transpileDependencies: true,
  publicPath: (process.env.VUE_APP_ENV == "development") ? "/" : "../../",
  devServer: {
    proxy: 'http://localhost:8082/'
  },
  configureWebpack: {
    plugins: [
      new webpack.ProvidePlugin({
        $: 'jquery',
        jQuery: 'jquery',
        'window.jQuery': 'jquery',
        Popper: ['popper.js', 'default']
      })
    ]
  }
})
