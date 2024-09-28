function __(element) {
    return document.getElementById(element);
}

var login_button = __("login_button");
if (login_button) {
    login_button.addEventListener("click", collect_data);
}

function collect_data(e) {
    e.preventDefault();

    login_button.disabled = true;
    login_button.value = "Loading...";

    var myForm = __("login-form");
    var inputs = myForm.getElementsByTagName("input");

    var data = {};
    for (var i = inputs.length - 1; i >= 0; i--) {
        var key = inputs[i].name;

        switch (key) {
            case "email":
                data.email = inputs[i].value;
                break;
            case "password":
                data.password = inputs[i].value;
                break;
        }
    }

    send_data(data, 'login');
}


function send_data(data, type) {
    var xml = new XMLHttpRequest();

    xml.onload = function () {
        if (xml.status == 200 || xml.readyState == 4) {
            handle_result(xml.responseText);

            login_button.disabled = false;
            login_button.value = "Login";
        }
    }

    data.data_type = type;
    var data_string = JSON.stringify(data);

    xml.open("POST", "api.php", true);
    xml.send(data_string);
}

function handle_result(result) {
    var data = JSON.parse(result);

    if (data.data_type == "info") {
        window.location = "index.php";
    } else {
        var error = __("error");
        error.innerHTML = data.message;
        error.style.display = "block";
    }
}
