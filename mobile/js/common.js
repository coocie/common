//计算屏幕宽度
var deviceWidth = document.documentElement.clientWidth;
document.documentElement.style.fontSize=100*document.documentElement.clientWidth/750+'px';


//不知道是干啥的，看起来好厉害的样子
$(function () {
  var nav_on = 0;
  var height = document.documentElement.clientHeight;
  height = height + 'px';
  console.log(height)


  var u = navigator.userAgent;
  var isIOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/); //ios终端
  if (isIOS) {
    if (screen.height == 812 && screen.width == 375) {
      $(".content").css('padding-bottom', '0.8rem')
    }
  }
});

//时间戳转时间
function formatDateTime(inputTime) {
  var date = new Date(inputTime);
  var y = date.getFullYear();
  var m = date.getMonth() + 1;
  m = m < 10 ? ('0' + m) : m;
  var d = date.getDate();
  d = d < 10 ? ('0' + d) : d;
  var h = date.getHours();
  h = h < 10 ? ('0' + h) : h;
  var minute = date.getMinutes();
  var second = date.getSeconds();
  minute = minute < 10 ? ('0' + minute) : minute;
  second = second < 10 ? ('0' + second) : second;
  return y + '-' + m + '-' + d ;
}
//获取请求参数
function GetQueryString(name) {
  var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)");
  var r = window.location.search.substr(1).match(reg); //search,查询？后面的参数，并匹配正则
  if (r != null) return unescape(r[2]);
  return null;
}
