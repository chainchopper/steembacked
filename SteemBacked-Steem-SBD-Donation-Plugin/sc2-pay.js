var sc2_pay = (function() {
  var win = null;

  function requestPayment(title, to, amount, currency, memo, callback) {
    if(currency != 'STEEM' && currency != 'SBD') {
      console.log('Unsupported currency "' + currency + '". Supported currencies are "STEEM" or "SBD".');
      return;
    }

    var url = sc2.sign('transfer', {
      to: to,
      amount: amount.toFixed(3) + ' ' + currency,
      memo: memo
    });

    win = popupCenter(url, 'sc2-pay-test', 500, 560);
    checkSteemTransfer(to, amount, currency, memo, new Date(), callback);
  }

  

  function getCurrency(amount) {
    return amount.substr(amount.indexOf(' ') + 1);
  }

  var cancel_check = false;
  function checkSteemTransfer(to, amount, currency, memo, date, callback, retries) {
      if (cancel_check || (win && win.closed) || retries > 60) {
          cancel_check = false;
          win = null;

          if (callback)
              callback(null);

          return;
      }

      console.log('Checking Steem Transfer...' + memo + ', amount: ' + amount + ' ' + currency);

      steem.api.getAccountHistory(to, -1, 10, function (err, result) {
        var confirmed = false;

        for (var i = 0; i < result.length; i++)
        {
          var trans = result[i];
          var op = trans[1].op;
          var ts = new Date((trans[1].timestamp) + 'Z');

          if (ts > date && op[1].memo == memo && op[0] == 'transfer' && op[1].to == to && parseFloat(op[1].amount) == amount && getCurrency(op[1].amount) == currency) {
            // The payment went through successfully!
            confirmed = true;

            // Close the popup window
            if(win)
              win.close();

            if(callback)
              callback(trans);

            break;
          }
        }

        if (!confirmed)
          setTimeout(function () { checkSteemTransfer(to, amount, currency, memo, date, callback, retries + 1); }, 1000);
      });
  }

  function popupCenter(url, title, w, h) {
    // Fixes dual-screen position                         Most browsers      Firefox
    var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : screen.left;
    var dualScreenTop = window.screenTop != undefined ? window.screenTop : screen.top;

    var width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
    var height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

    var left = ((width / 2) - (w / 2)) + dualScreenLeft;
    var top = ((height / 2) - (h / 2)) + dualScreenTop;
    var newWindow = window.open(url, title, 'scrollbars=yes, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);

    // Puts focus on the newWindow
    if (window.focus) {
        newWindow.focus();
    }

    return newWindow;
  }

  return { requestPayment: requestPayment };
})();
