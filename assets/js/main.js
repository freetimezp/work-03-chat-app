function __(element) {
    return document.getElementById(element);
}

var label = __("label_chat");

label.addEventListener("click", function () {
    var inner_pannel = __("inner_left_pannel");

    var ajax = new XMLHttpRequest();
    ajax.onload = function () {
        if (ajax.status == 200 || ajax.readyState == 4) {
            inner_pannel.innerHTML = ajax.responseText;
        }
    };
    ajax.open("POST", "file.php", true);
    ajax.send();
});



























