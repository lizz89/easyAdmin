'use strict';

var spawnSync = require('child_process').spawnSync;
var spawn = require('child_process').spawn;
var browserSync = require('browser-sync').create();

// 停止并重新启动easySwoole实例
spawnSync('killall', ['php']);
var esStart = spawn('php', ['easyswoole', 'start']);

// easyswoole 控制台输出内容处理
console.clear();
esStart.stdout.on('data', function (data) {
    process.stdout.write(data.toString());
});
esStart.stderr.on('data', function (data) {
    process.stdout.write(data.toString());
});

// 下列文件被修改时将刷新浏览器
var staticMonitor = ['Public/**/*.js', 'Public/**/*.css', 'View/**/*.html'];
// 下列文件被修改时将重启easySwoole
var scriptMonitor = ['App/**/*.php', 'Conf/**/*.php', 'System/**/*.php', 'vendor/**/*.php', 'EasySwooleEvent.php'];

// 监控函数
staticMonitor.push({
    match: scriptMonitor,
    fn: function (event, file) {
        spawn('php', ['easyswoole', 'reload']).stdout.on('data', function (data) {
            process.stdout.write(event.toUpperCase() + ': ' + file + '\n');
            process.stdout.write(data)
        })
    }
});

// 启动服务
browserSync.init({
    files: staticMonitor,
    proxy: 'localhost:9501',
    logPrefix: 'easySwoole',
    open: false
});