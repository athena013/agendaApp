var ambiente = 'local';
var urlParametrosModule = getUrlServidor();

var urlFront = getUrlFront();

//var x = location.host; 

var urlBackEnd = getUrlServidor();

function getUrlServidor() {
    if (ambiente === 'local') {
        return 'http://localhost:88/agenda/agendaBE/';
    }else if (ambiente === 'desarrollo') {
        return 'http://192.168.1.41/agenda/agendaBE/';
    }
}
function getUrlFront() {
    if (ambiente === 'local') {
        return 'http://localhost:88/agenda/agendaFront/';
    }else if (ambiente === 'desarrollo') {
        return 'http://192.168.1.41/agenda/agendaBE/';
    }
}

