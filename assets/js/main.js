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

function get_data(find, type) {
    var xml = new XMLHttpRequest();
    xml.onload = function () {
        if (xml.readyState == 4 || xml.status == 200) {
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

                    break;
            }
        }
    }
}

get_data({}, "user_info");



























