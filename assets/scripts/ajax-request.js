/**
 * Sends ajax requests.
 * Used for post loading and inserting ads.
 * Variable site_info is defined with localize_scripts in function.php
 * @param {string} action ajax action that is registered on the server
 * @param {object} dataToSend data to send to ajax function on the server
 * @param {function} requestCallback callback function performed on request load
 * @param {array} callbackParam parameters to be passed to callback function
 */

export default function ajaxRequest(action, dataToSend, requestCallback = null, callbackParam = []) {
    const request = new XMLHttpRequest();
    request.open('POST', site_info.ajax_url, true);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
    let _data = dataToSend;
    _data.action = action;
    //nonce adedd via localize script
    _data.nonce = site_info.nonce;
    //console.log(_data)
    request.onload = () => {
        if (requestCallback){
            if (callbackParam.length > 0){
                requestCallback(request.responseText, ...callbackParam);
            } else {
                requestCallback(request.responseText);
            }
        }
    }
    //console.log(new URLSearchParams(_data));
    request.send((new URLSearchParams(_data)).toString());
}