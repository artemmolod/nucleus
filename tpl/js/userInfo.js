var ua = navigator.userAgent.toLowerCase();
var clientInfo = {
  browser: {
     mozilla: /firefox/i.test(ua),
     chrome: /chrome/i.test(ua) && !/edge/i.test(ua),
     iphone: /iphone/i.test(ua),
     android: /android/i.test(ua),
     opera: (/opera/i.test(ua) || /opr/i.test(ua)),
     safari: (!(/chrome/i.test(ua)) && /webkit|safari|khtml/i.test(ua)),
     safari_mobile: /iphone|ipod|ipad/i.test(ua),
     edge: (/edge/i.test(ua) && !/opera/i.test(ua)),
     msie: (/msie/i.test(ua) && !/opera/i.test(ua) || /trident\//i.test(ua)) || /edge/i.test(ua),
  }
} 
if (clientInfo.browser.safari && !clientInfo.browser.safari_mobile || clientInfo.browser.msie) {
  document.location.href = "/badbrowser.php";
}