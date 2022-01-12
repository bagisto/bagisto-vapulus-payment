const { mix } = require("laravel-mix");
require("laravel-mix-merge-manifest");

if (mix.inProduction()) {
    var publicPath = 'publishable/assets';
} else {
    var publicPath = "../../../public/vendor/webkul/vapulus/assets";;
}


mix.setPublicPath(publicPath).mergeManifest();
mix.disableNotifications();

    mix.copy(__dirname + "/src/Resources/assets/images", publicPath + "/images/")
    .sass(__dirname + "/src/Resources/assets/sass/vapulus.scss", "css/vapulus.css")
    .options({
        processCssUrls: false
    });

if (mix.inProduction()) {
    mix.version();
}