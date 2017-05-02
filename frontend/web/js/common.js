/**
 * Created by su on 2017-4-19.
 * useful determine helpers
 */

/**
 * determine whether the string is a positive integer
 * @param str
 * @returns {boolean}
 */
function isInteger(str){

    var m = /^[0-9]+$/;
    return m.test(str);

}

/**
 * 判断手机号格式是否正确
 * @param str
 * @returns {boolean}
 */
function isPhone(str){
    var reg = /^(\+)?(86)?\d{11}$/;
    return (reg.test(str))
}

/**
 * 判断字符串是否为纯数字格式
 * @param str
 * @returns {*|{options, src}|{src}|{files, tasks}|boolean}
 */
function isNumber(str){
    var m = new RegExp('^[0-9]+$');
    return (m.test(str));
}

/**
 * has special char
 * @param str
 * @returns {boolean}
 */
function hasSpecialChar(str){

    var m = '/[(\ )(\~)(\!)(\@)(\#)(\$)(\%)(\^)(\&)(\*)(\()(\))(\-)(\_)(\+)(\=)(\[)(\])(\{)(\})(\|)(\\)(\;)(\:)(\')(\")(\,)(\.)(\/)(\<)(\>)(\?)(\)]+/';
    return ( m.test(str) );
}

/**
 * 判断字符串长度
 * @param str
 * @returns {number}
 */
function getStringLength(str){

    //<summary>获得字符串实际长度，中文2，英文1 </summary>
    //<param name="str">要获得长度的字符串</param>
    var realLength = 0, len = str.length, charCode = -1;
    for (var i = 0; i < len; i++) {
        charCode = str.charCodeAt(i);
        if (charCode >= 0 && charCode <= 128) realLength += 1;
        else realLength += 2;
    }
    return realLength;

}

/**
 * determine whether tow str is equal
 * @param str1
 * @param str2
 * @returns {boolean}
 */
function compareString(str1,str2){

    return str1.toLowerCase() === str2.toLowerCase();
}







