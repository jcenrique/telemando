function desplegar(key) {
  
    var accion = document.querySelector('#accion' + key);
    var up = document.querySelector('#up' + key);
    var down = document.querySelector('#down' + key);

    accion.classList.toggle('hidden');
   
    down.classList.toggle('hidden');

    up.classList.toggle('hidden');
   
}