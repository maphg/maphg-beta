var numSem = new Date().getDay();
var diasSem = ['domingo', 'lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado'];
var hoydia = diasSem[numSem];
var horas = new Date().getHours();
var minutos = new Date().getMinutes();
var mes = new Date().getMonth()+1;
var dia = new Date().getDate();

if (dia < 10) {
    dia='0'+dia;
}

if (mes < 10) {
    mes = '0'+mes;
}

document.getElementById('hora').innerHTML = horas + ':' + minutos;
document.getElementById('mes').innerHTML = mes;
document.getElementById('dia').innerHTML = dia;



switch (hoydia) {
    case 'lunes':
        document.getElementById('colzia').classList.toggle('hidden');
        document.getElementById('colzhp').classList.toggle('hidden');
        document.getElementById('coldep').classList.toggle('hidden');
        document.getElementById('btn-zia').classList.toggle('btn-activo');
        document.getElementById('btn-zhp').classList.toggle('btn-activo');
        document.getElementById('btn-dep').classList.toggle('btn-activo');
        document.getElementById('label-lunes').classList.add('text-gray-700');
        break;
    case 'martes':
        document.getElementById('colzic').classList.toggle('hidden');
        document.getElementById('coldep').classList.toggle('hidden');
        document.getElementById('btn-dep').classList.toggle('btn-activo');
        document.getElementById('btn-zic').classList.toggle('btn-activo');
        document.getElementById('label-martes').classList.add('text-gray-700');
        break;
    case 'miercoles':
        document.getElementById('coldec').classList.toggle('hidden')
        document.getElementById('coldep').classList.toggle('hidden');
        document.getElementById('colzie').classList.toggle('hidden');
        document.getElementById('btn-dec').classList.toggle('btn-activo');
        document.getElementById('btn-dep').classList.toggle('btn-activo');
        document.getElementById('btn-zie').classList.toggle('btn-activo');
        document.getElementById('label-miercoles').classList.add('text-gray-700');
        break;
    case 'jueves':
        document.getElementById('colzhc').classList.toggle('hidden');
        document.getElementById('colzha').classList.toggle('hidden');
        document.getElementById('coldep').classList.toggle('hidden');
        document.getElementById('btn-zhc').classList.toggle('btn-activo');
        document.getElementById('btn-zha').classList.toggle('btn-activo');
        document.getElementById('btn-dep').classList.toggle('btn-activo');
        document.getElementById('label-jueves').classList.add('text-gray-700');
        break;
    case 'viernes':
        document.getElementById('colzil').classList.toggle('hidden');
        document.getElementById('colauto').classList.toggle('hidden');
        document.getElementById('coldep').classList.toggle('hidden');
        document.getElementById('btn-zil').classList.toggle('btn-activo');
        document.getElementById('btn-auto').classList.toggle('btn-activo');
        document.getElementById('btn-dep').classList.toggle('btn-activo');
        document.getElementById('label-viernes').classList.add('text-gray-700');
        break;
    default:
        document.getElementById('colzia').classList.toggle('hidden');
        document.getElementById('colzhp').classList.toggle('hidden');
        document.getElementById('coldep').classList.toggle('hidden');
        document.getElementById('colzic').classList.toggle('hidden');
        document.getElementById('coldec').classList.toggle('hidden');
        document.getElementById('colzie').classList.toggle('hidden');
        document.getElementById('colzhc').classList.toggle('hidden');
        document.getElementById('colzha').classList.toggle('hidden');
        document.getElementById('colzil').classList.toggle('hidden');
        document.getElementById('colauto').classList.toggle('hidden');
        document.getElementById('btn-zil').classList.toggle('btn-activo');
        document.getElementById('btn-auto').classList.toggle('btn-activo');
        document.getElementById('btn-dep').classList.toggle('btn-activo');
        document.getElementById('btn-zia').classList.toggle('btn-activo');
        document.getElementById('btn-zhp').classList.toggle('btn-activo');
        document.getElementById('btn-zic').classList.toggle('btn-activo');
        document.getElementById('btn-dec').classList.toggle('btn-activo');
        document.getElementById('btn-zie').classList.toggle('btn-activo');
        document.getElementById('btn-zhc').classList.toggle('btn-activo');
        document.getElementById('btn-zha').classList.toggle('btn-activo');
        break;

}

function botones(idd) {
    switch (idd) {
        case 'zia':
            document.getElementById('colzia').classList.toggle('hidden');
            document.getElementById('btn-zia').classList.toggle('btn-activo');
            break;
        case 'zie':
            document.getElementById('colzie').classList.toggle('hidden');
            document.getElementById('btn-zie').classList.toggle('btn-activo');
            break;
        case 'zic':
            document.getElementById('colzic').classList.toggle('hidden');
            document.getElementById('btn-zic').classList.toggle('btn-activo');
            break;
        case 'zhp':
            document.getElementById('colzhp').classList.toggle('hidden');
            document.getElementById('btn-zhp').classList.toggle('btn-activo');
            break;
        case 'dec':
            document.getElementById('coldec').classList.toggle('hidden');
            document.getElementById('btn-dec').classList.toggle('btn-activo');
            break;
        case 'zhc':
            document.getElementById('colzhc').classList.toggle('hidden');
            document.getElementById('btn-zhc').classList.toggle('btn-activo');
            break;
        case 'zha':
            document.getElementById('colzha').classList.toggle('hidden');
            document.getElementById('btn-zha').classList.toggle('btn-activo');
            break;
        case 'zil':
            document.getElementById('colzil').classList.toggle('hidden');
            document.getElementById('btn-zil').classList.toggle('btn-activo');
            break;
        case 'aut':
            document.getElementById('colauto').classList.toggle('hidden');
            document.getElementById('btn-auto').classList.toggle('btn-activo');
            break;
        case 'dep':
            document.getElementById('coldep').classList.toggle('hidden');
            document.getElementById('btn-dep').classList.toggle('btn-activo');
            break;
    }
}
