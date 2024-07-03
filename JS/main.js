// variables de elementos del DOM
const regionElement = document.getElementById('region');
const comunaElement = document.getElementById('comuna');
const rutElement = document.getElementById('rut');

// Eventos de escucha
regionElement.addEventListener('change', ObtenerComunas);
emailElement.addEventListener('input', RellenarSimbolos);

// Funcion que obtiene los checkbox que contienen check en el nombre y verifica que al menos dos esten seleccionados
// No me funciono t-t
// No cambie el codigo y me funciono, no se que paso XD
function onSubmit() {
    const checkboxes = document.querySelectorAll('input[type="checkbox"][name^="check-"]');
    let seleccionados = 0;
    checkboxes.forEach(function(checkbox) {
        if (checkbox.checked) {
            seleccionados++;
        }
    });
    if (seleccionados < 2) {
        alert('Por favor, selecciona más de dos opciones.');
        return false;
    }
    else {
        return true;
    }
}

// Funcion para hacer fetch a un archivo PHP y obtener los datos de las comunas segun la region seleccionada
function FetchSetData(url, formData, targetElement){
    return fetch(url, {
        method: 'POST',
        body: formData,
        mode: 'cors'
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);
        targetElement.innerHTML = data;
    })
    .catch(error => console.error('Error:', error));
}
// Funcion para configurar llamado a la funcion FetchSetData
function ObtenerComunas(){
    let selectedRegion = regionElement.value;
    let url = 'getComunas.php'
    let formData = new FormData();
    // Agrega Region a nuevo FormData para que lo reciba el archivo PHP
    formData.append('region_selected', selectedRegion);
    FetchSetData(url, formData, comunaElement);
}
