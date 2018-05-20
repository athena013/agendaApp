var ambiente = 'local';
var urlParametrosModule = getUrlServidor();
var urlFront = 'http://localhost:88/Apoyo_escolar/agenda/agendaFront/';
var urlBackEnd = getUrlServidor();
function getUrlServidor() {
    if (ambiente === 'local') {
        return 'http://localhost:88/Apoyo_escolar/agenda/agendaBE/index.php/';
    }else if (ambiente === 'desarrollo') {
        return 'http://192.168.1.41:80/agenda/agendaBE/';
    }
}

