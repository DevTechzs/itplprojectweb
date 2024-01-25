//global variable 
var done_tag;
var action;
var formid;
var ServicePath = document.URL.slice(0, document.URL.lastIndexOf('/') + 1) + "";
// calling web service
function TransportCall(data,successFn=onSuccess,errorFn=onError) {

    on();

    data.MSC = $.md5(new Date().getDate().toString().padStart(2, "0"));
    var srvdata = JSON.stringify(data);
    $.ajax({
        data: srvdata,
        type: 'POST',
        dataType: 'json',
        contentType: 'application/json',
        async: true,
        url: GetUrl(),
        success: function showData(arg) {
            off();
            successFn(arg);
        },
        error: function err(arg) {

            // off();
            // alert(JSON.stringify(arg));
            if (arg.status == 404) {
                // alert(arg.statusText);
                alert("Session Expired!!");
                window.open("../", '_self');
            } else if (arg.status == 401) {
                // alert(arg.statusText);
                alert("Session Expired!!");
                window.open("../", '_self');
            }
            errorFn(arg);
            off();
        }
    });
}

function GetUrl() {
    if (ServicePath.toLocaleLowerCase().indexOf("pages") >= 0) {
        return ServicePath.toLocaleLowerCase().replace("pages/", "") + "app/index.php";
    } else {
        return ServicePath + "app/index.php";
    }
}

function on() {
    $.LoadingOverlay("show", {
        image: "",
        fontawesome: "fad fa-spinner-third"
    });
}

function off() {
    $.LoadingOverlay("hide");
}
function  notify(type,text) {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
      });

     
    switch(type){
        case "success":
            Toast.fire({
                icon: 'success',
                title: text
              });
            break;
        case "error": 
            Toast.fire({
                icon: 'error',
                title: text
            });
            break;
        case "info":
            Toast.fire({
                icon: 'info',
                title: text
              });
            break;
        default:
            Toast.fire({
                icon: 'info',
                title: text
              });
    }
   
  } 