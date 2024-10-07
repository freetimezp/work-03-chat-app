var CURRENT_CHAT_USER = "";
var SEEN_STATUS = false;

var sent_audio = new Audio("message-sent.wav");
var received_audio = new Audio("message-received.wav");

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

        var inner_right_pannel = __("inner_right_pannel");
        inner_right_pannel.style.overflow = 'visible';


        //console.log(obj);
        if (typeof (obj.logged_in) != "undefined" && !obj.logged_in) {
            window.location = 'login.php';
        } else {
            //alert(result.data_type);

            switch (obj.data_type) {
                case "user_info":
                    var username = __("username");
                    var email = __("email");
                    var profile_image = __("user_photo_image");
                    username.innerHTML = obj.username;
                    email.innerHTML = obj.email;

                    profile_image.src = obj.image;

                    break;

                case "contacts":
                    var inner_left_pannel = __("inner_left_pannel");

                    inner_left_pannel.innerHTML = obj.message;
                    inner_right_pannel.style.overflow = 'hidden';
                    break;

                case "chats_refresh":
                    SEEN_STATUS = false;
                    var messages_holder = __("messages_holder");
                    if (messages_holder) {
                        messages_holder.innerHTML = obj.messages;
                    }

                    if (typeof obj.new_message != 'undefined') {
                        if (obj.new_message) {
                            received_audio.play();

                            setTimeout(function () {
                                message_holder?.scrollTo(0, message_holder.scrollHeight);
                                var message_text = __("message_text");
                                message_text?.focus();
                            }, 200);
                        }
                    }

                    break;

                case "send_message":
                    sent_audio.play();
                case "chats":
                    SEEN_STATUS = false;
                    var inner_left_pannel = __("inner_left_pannel");
                    var inner_right_pannel = __("inner_right_pannel");

                    inner_left_pannel.innerHTML = obj.user != undefined ? obj.user : "Choose user from list";
                    inner_right_pannel.innerHTML = obj.messages;

                    var message_holder = __("messages_holder");
                    setTimeout(function () {
                        message_holder?.scrollTo(0, message_holder.scrollHeight);
                        var message_text = __("message_text");
                        message_text?.focus();
                    }, 200);

                    if (typeof obj.new_message != 'undefined') {
                        if (obj.new_message) {
                            received_audio.play();
                        }
                    }
                    break;

                case "settings":
                    var inner_left_pannel = __("inner_left_pannel");
                    inner_left_pannel.innerHTML = obj.message;
                    settings_func();
                    break;

                case "send_image":
                    //alert(obj.message);
                    break;
                case "save_settings":
                    //alert(obj.message);
                    get_settings(true);
                    get_data({}, "user_info");
                    break;
            }
        }
    }
}



get_data({}, "user_info");
get_data({}, "contacts");
var radio_contacts = __("radio_contacts");
radio_contacts.checked = true;

function get_contacts(e) {
    get_data({}, "contacts");
}

function get_chats(e) {
    get_data({}, "chats");
}

function get_settings(e) {
    get_data({}, "settings");
}

function send_message(e) {
    e.preventDefault();

    var message_text = __("message_text");

    if (message_text.value.trim() == "") {
        alert("Please, type message text..");
        return;
    }

    //alert(message_text.value);
    get_data({
        message: message_text.value.trim(),
        user_id: CURRENT_CHAT_USER
    }, "send_message");
}

function settings_func() {
    var save_button = __("save_button");

    if (save_button) {
        save_button.addEventListener("click", collect_updated_data);
    }

    function collect_updated_data(e) {
        e.preventDefault();

        save_button.disabled = true;
        save_button.value = "Loading...";

        var myForm = __("profile-form");
        var inputs = myForm.getElementsByTagName("input");

        var data = {};
        for (var i = inputs.length - 1; i >= 0; i--) {
            var key = inputs[i].name;

            switch (key) {
                case "username":
                    data.username = inputs[i].value;
                    break;

                case "email":
                    data.email = inputs[i].value;
                    break;

                case "gender":
                    if (inputs[i].checked) {
                        data.gender = inputs[i].value;
                    }
                    break;

                case "password":
                    data.password = inputs[i].value;
                    break;

                case "password2":
                    data.password2 = inputs[i].value;
                    break;
            }
        }

        send_updated_data(data, "save_settings");
    }

    function send_updated_data(data, type) {
        var xml = new XMLHttpRequest();

        xml.onload = function () {
            if (xml.status == 200 || xml.readyState == 4) {
                //alert(xml.responseText);
                handle_result(xml.responseText);

                save_button.disabled = false;
                save_button.value = "Save";

                get_settings(true);
                get_data({}, "user_info");
            }
        }

        data.data_type = type;
        var data_string = JSON.stringify(data);

        xml.open("POST", "api.php", true);
        xml.send(data_string);
    }
}


function upload_profile_image(files) {
    var xml = new XMLHttpRequest();

    //check file extention
    var filename = files[0].name;
    var ext_start = filename.lastIndexOf(".");
    var ext = filename.substr(ext_start + 1, 3);

    if (!(ext == 'jpg' || ext == 'JGP')) {
        alert("This file type is not allowed");
        return;
    }

    var change_image_button = __("change_image_button");
    change_image_button.disabled = true;
    change_image_button.innerHTML = "Uploading Image";

    var myForm = new FormData();

    xml.onload = function () {
        if (xml.status == 200 || xml.readyState == 4) {
            //alert(xml.responseText);

            get_data({}, "user_info");
            get_settings(true);

            change_image_button.disabled = false;
            change_image_button.innerHTML = "Change Image";
        }
    }

    myForm.append("file", files[0]);
    myForm.append("data_type", 'change_profile_image');

    xml.open("POST", "uploader.php", true);
    xml.send(myForm);
}

function handle_drag_and_drop(e) {
    if (e.type == "dragover") {
        e.preventDefault();
        e.target.className = "dragging";
    } else if (e.type == "dragleave") {
        e.preventDefault();
        e.target.className = "";
    } else if (e.type == "drop") {
        e.preventDefault();
        e.target.className = "";

        //drop image and save it in $_FILES
        upload_profile_image(e.dataTransfer.files);
    } else {
        e.preventDefault();
        e.target.className = "";
    }
}


function start_chat(e) {
    e.preventDefault();

    //grab user id from contact block
    var user_id = e.target.getAttribute("user_id");
    if (user_id == "" || user_id == null) {
        user_id = e.target.parentNode.getAttribute("user_id");
    }

    //console.log(user_id);
    CURRENT_CHAT_USER = user_id;

    var radio_chat = __("radio_chat");
    radio_chat.checked = true;
    get_data({
        user_id: CURRENT_CHAT_USER
    }, "chats");
}


function enter_pressed(e) {
    e.preventDefault();

    if (e.keyCode == 13) {
        send_message(e);
    }

    SEEN_STATUS = true;
}

function set_seen(e) {
    SEEN_STATUS = true;
}

setInterval(function () {
    //console.log(SEEN_STATUS);

    if (CURRENT_CHAT_USER && CURRENT_CHAT_USER != "") {
        get_data({
            user_id: CURRENT_CHAT_USER,
            seen: SEEN_STATUS
        }, "chats_refresh");
    }
}, 150000);


function delete_message(e) {
    e.preventDefault();

    if (confirm("Are you sure you want to delete this message?")) {
        var msgId = e.target.getAttribute("msgId");

        get_data({
            rowId: msgId
        }, "delete_message");

        get_data({
            user_id: CURRENT_CHAT_USER,
            seen: SEEN_STATUS
        }, "chats_refresh");
    }
}

function delete_thread(e) {
    e.preventDefault();

    if (confirm("Are you sure you want to delete this all thread?")) {
        get_data({
            user_id: CURRENT_CHAT_USER,
        }, "delete_thread");

        get_data({
            user_id: CURRENT_CHAT_USER,
            seen: SEEN_STATUS
        }, "delete_thread");
    }
}


function send_image(files) {
    //check file extention
    var filename = files[0].name;
    var ext_start = filename.lastIndexOf(".");
    var ext = filename.substr(ext_start + 1, 3);

    if (!(ext == 'jpg' || ext == 'JGP')) {
        alert("This file type is not allowed");
        return;
    }

    var xml = new XMLHttpRequest();
    var myForm = new FormData();

    xml.onload = function () {
        if (xml.status == 200 || xml.readyState == 4) {
            //alert(xml.responseText);
            handle_result(xml.responseText, 'send_image');

            get_data({
                user_id: CURRENT_CHAT_USER,
                seen: SEEN_STATUS
            }, "chats_refresh");
        }
    }

    myForm.append("file", files[0]);
    myForm.append("data_type", 'send_image');
    myForm.append("user_id", CURRENT_CHAT_USER);

    xml.open("POST", "uploader.php", true);
    xml.send(myForm);
}

function close_image(e) {
    e.preventDefault();

    e.target.className = 'image_off';
}

function image_show(e) {
    e.preventDefault();

    var image = e.target.src;
    var image_viewer = __("image_viewer");

    if (image_viewer && image) {
        image_viewer.innerHTML = "<img src='" + image + "' style='width: 100%;' />";
        image_viewer.className = "image_on";
    }
}