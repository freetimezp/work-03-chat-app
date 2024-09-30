function __(element) {
    return document.getElementById(element);
}

var logoutBtn = __("logout");
if (logoutBtn) {
    logoutBtn.addEventListener("click", logout);
}

function logout() {
    var answer = confirm("Are you sure you want to log out?");

    if (answer) {
        get_data({}, "logout");
    }
};

var label_contacts = __("label_contacts");
if (label_contacts) {
    label_contacts.addEventListener("click", get_contacts);
}
var label_chat = __("label_chat");
if (label_chat) {
    label_chat.addEventListener("click", get_chats);
}
var label_settings = __("label_settings");
if (label_settings) {
    label_settings.addEventListener("click", get_settings);
}



function get_data(find, type) {
    var xml = new XMLHttpRequest();

    var loader_holder = __("loader_holder");
    loader_holder.className = "loader_on";

    xml.onload = function () {
        if (xml.readyState == 4 || xml.status == 200) {
            loader_holder.className = "loader_off";

            handle_result(xml.responseText, type);
        }
    };

    var data = {};
    data.find = find;
    data.data_type = type;
    data = JSON.stringify(data);

    xml.open("POST", "api.php", true);
    xml.send(data);
}

function handle_result(result, type) {
    if (result.trim() != "") {
        var obj = JSON.parse(result);

        //console.log(obj);
        if (typeof (obj.logged_in) != "undefined" && !obj.logged_in) {
            window.location = 'login.php';
        } else {
            //alert(result.data_type);

            switch (obj.data_type) {
                case "user_info":
                    var username = __("username");
                    var email = __("email");
                    username.innerHTML = obj.username;
                    email.innerHTML = obj.email;
                    break;

                case "contacts":
                    var inner_left_pannel = __("inner_left_pannel");
                    inner_left_pannel.innerHTML = obj.message;
                    break;

                case "chats":
                    var inner_left_pannel = __("inner_left_pannel");
                    inner_left_pannel.innerHTML = obj.message;
                    break;

                case "settings":
                    var inner_left_pannel = __("inner_left_pannel");
                    inner_left_pannel.innerHTML = obj.message;
                    break;
            }
        }
    }
}

get_data({}, "user_info");

function get_contacts(e) {
    get_data({}, "contacts");
}

function get_chats(e) {
    get_data({}, "chats");
}

function get_settings(e) {
    get_data({}, "settings");
}























