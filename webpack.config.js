const Encore = require("@symfony/webpack-encore");

Encore.setOutputPath("public/build/")
  .setPublicPath("/build")
  .addEntry("app", "./assets/app.js") // Fichier JS principal
  .splitEntryChunks()
  .enableSingleRuntimeChunk()

  // Vue.js support
  .enableVueLoader()

  .cleanupOutputBeforeBuild()
  .enableSourceMaps(!Encore.isProduction())
  .enableVersioning(Encore.isProduction())
  .configureBabel((config) => {
    config.plugins.push("@babel/plugin-syntax-dynamic-import");
  });

module.exports = Encore.getWebpackConfig();
