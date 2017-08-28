function isDateValid(dateInput, isField)
{
    var dateRegEx = /^((?:0[1-9]|[12][0-9]|3[01])\/(?:0[1-9]|1[0-2])\/(?:19|20)[0-9]{2})$/;
    
    if (isField) dateStr = dateInput.val();
    else dateStr = dateInput;
    
    if (dateRegEx.test(dateStr)) {
        // Check that the date is valid
        var parts = dateStr.split('/');
        var d = parseInt(parts[0], 10);
        var m = parseInt(parts[1], 10);
        var y = parseInt(parts[2], 10);
        var date = new Date(y,m-1,d);
        
        if ((date.getFullYear() != y) || (date.getMonth() + 1 != m) || (date.getDate() != d)) {
          //alert("This date is invalid!");
          if (isField) dateInput.focus();
          return false;
        }
    } else {
        //alert("The date format is not correct!");
        if (isField) dateInput.focus();
        return false;
    }
    
    return true
}

function isEmailAddressValid(emailInput, isField)
{
    var emailRegEx = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    
    if (isField) emailStr = emailInput.val();
    else emailStr = emailInput;
    
    if (!emailRegEx.test(emailStr)) {
        if (isField) emailInput.focus();
        return false;
    }
    
    return true
}

function isValidImageFormat(fileInput, isField)
{
    var imageRegEx = /^(.+)\.(gif|jpe?g|png)$/;
    
    if (isField) imageStr = fileInput.val();
    else imageStr = fileInput;
    
    if (!imageRegEx.test(imageStr.toLowerCase())) {
        if (isField) fileInput.focus();
        return false;
    }
    
    return true
}

function isIE() {

    var ua = window.navigator.userAgent;

    var msie = ua.indexOf('MSIE ');
    if (msie > 0) {
        // IE 10 or older
        return true;
    }

    var trident = ua.indexOf('Trident/');
    if (trident > 0) {
        // IE 11
        return true;
    }

    var edge = ua.indexOf('Edge/');
        if (edge > 0) {
        // IE 12 / Edge
        return true;
    }

    // other browser
    return false;
}
