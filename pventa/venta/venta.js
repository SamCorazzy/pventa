const searchBox = document.getElementById("buscar");
const resultsList = document.getElementById("lista-resultados");
const shoppingList = document.getElementById("venta");
const lista = document.getElementById("listaCorrecta");
const totalPrice = document.getElementById("total");
var obt_Prod = ""; //variables a usar en las funciones
var datos = [];
var url;
let codigo_productos = "";
var cod_prods = [];
var nomb_prods = [];
let cod_prods_str;
let nomb_prods_str;
let fecha = "";
let valores = [];

function obtenerDatos() {
  var nombre = document.querySelector("#buscar").value; //obtiene el valor de un elemento html y lo guarda en una variable
  obt_Prod = nombre;
  //console.log(obt_Prod);
  if (nombre != "") {
    //se analiza si la varible esta vacia
    $.ajax({
      type: "POST", //sentencia de tipo POST
      url: "obtener_prod.php", //elemento en donde se ejecutara la sentencia
      data: "json=" + obt_Prod, //datos que se usaran en la sentencia
      dataType: "json",
      success: function (datosp) {
        for (i = 0; i < datosp.length; i++) {
          datos[i] = datosp[i];
        }
        //console.log(datos[0].imagen);
        resultsList.innerHTML = "";
        // Obtener término de búsqueda
        const searchTerm = nombre.toLowerCase(); //searchBox.value.toLowerCase();

        // Filtrar elementos que coincidan con el término de búsqueda
        const matchingItems = datos.filter((item) =>
          item.nombre.toLowerCase().includes(searchTerm)
        );

        // Mostrar resultados en la lista
        matchingItems.forEach((item) => {
          const li = document.createElement("li");
          li.id = "Resultados";
          li.className = "my-4 px-4 flex justify-between items-stretch w-full border-2 border-indigo-200 rounded-xl";
          
          const img = document.createElement("img");
          img.id = "imagen";
          var a = item.tipo_imagen;
          var b = item.imagen;
          img.src = 'data:'+a+';base64,'+b+'';
          img.className = "w-24 h-auto self-center";
          img.width = 50;
          img.height = 50;
          // li.innerHTML = "<img src='data:" + item.tipo_imagen + ";base64," + item.imagen + "'>";
          li.textContent = `Nombre: ${item.nombre} - Precio: $${item.precio_venta} - Cantidad: ${item.existencia}`;
          li.appendChild(img);
          const addButton = document.createElement("button");
          addButton.id = "agregarProducto";
          addButton.textContent = "Agregar";
          addButton.className = "bg-indigo-200 hover:bg-indigo-100 rounded-xl py-2 px-3 self-center";
          addButton.addEventListener("click", () => {
            addItemToList(item);
            const liToRemove = addButton.parentNode;
            liToRemove.parentNode.removeChild(liToRemove);
            searchBox.value = "";
          });
          li.appendChild(addButton);
          resultsList.appendChild(li);
        });
      },
      error: function (jqXHR, textStatus, errorThrown) {
        //mostrara un error si no hay conexion
        alert(
          "Error..." + jqXHR + "  |||  " + textStatus + "  ||||  " + errorThrown
        );
      },
    }).fail(function () {
      alert("Error... ");
    });
  } else {
    //limpia los elementos del elemento seleccionado.
    var ul = document.getElementById("lista-resultados");
    ul.innerHTML = "";
  }
}


function addItemToList(item) {
    // Agregar elemento a la lista de compras
    const li = document.createElement("li");
    li.id = "listaCompras";
    var cant = 1;
    li.textContent = `Nombre: ${item.nombre} - Precio: $${item.precio_venta} - Cantidad: `+cant;
    const img = document.createElement("img");
    img.id = "imagen";
    var a = item.tipo_imagen;
    var b = item.imagen;
    img.src = 'data:'+a+';base64,'+b+'';
    img.className = "w-24 h-auto self-center";
    img.width = 50;
    img.height = 50;
    li.appendChild(img);
    cod_prods.push(item.codigo_prod);//agregar un producto a la lista de productos que se gaurdaran 
    nomb_prods.push(item.nombre);
    //boton agregar cantidad
    agregarCant(li, item, cant);
    //agregar boton menos cantidad
    quitarCant(li, item, cant);
    //boton eliminar producto
    eliminarElem(li, item, cant);
    li.className = "my-4 px-4 flex justify-between items-stretch w-full border-2 border-indigo-200 rounded-xl";
    lista.appendChild(li);

    // Actualizar precio total
    const currentPrice = parseFloat(totalPrice.textContent);
    const newPrice = currentPrice + parseInt(item.precio_venta);
    totalPrice.textContent = newPrice.toFixed(2);
    cod_prods_str = cod_prods.join(", ");
    nomb_prods_str = nomb_prods.join(", ");
    //onsole.log(cod_prods_str);
    //console.log(nomb_prods_str);
}
  
function removeItemFromList(li, precio_venta, item) {
    // Eliminar elemento de la lista de compras
    li.remove();
  
    // Actualizar precio total
    const currentPrice = parseFloat(totalPrice.textContent);
    const newPrice = currentPrice - precio_venta;
    totalPrice.textContent = newPrice.toFixed(2);
    const index = cod_prods.indexOf(item.codigo_prod);
      if (index !== -1) {
        cod_prods.splice(index, 1);
        nomb_prods.splice(index, 1);
        cod_prods_str = cod_prods.join(", ");
        nomb_prods_str = nomb_prods.join(", ");
      }
    //console.log(cod_prods_str);
    //console.log(nomb_prods_str);
}

  function actualizarCantidad(li, item, quantityChange) {
    const currentQuantity = parseInt(li.getAttribute("data-quantity") || "1");
    const newQuantity = currentQuantity + quantityChange;
    //console.log(newQuantity);
    if (newQuantity > 0 && item.existencia >= newQuantity) {
      li.setAttribute("data-quantity", newQuantity);
      li.textContent =
        `Nombre: ${item.nombre} - Precio: $${item.precio_venta} - Cantidad: ` +
        newQuantity;
        const img = document.createElement("img");
    img.id = "imagen";
    var a = item.tipo_imagen;
    var b = item.imagen;
    img.src = "data:" + a + ";base64," + b + "";
    img.className = "w-24 h-auto self-center";
    img.width = 50;
    img.height = 50;
    li.appendChild(img);
      const priceChange = item.precio_venta * quantityChange;
      const currentPrice = parseFloat(totalPrice.textContent);
      const newPrice = currentPrice + priceChange;
      totalPrice.textContent = newPrice.toFixed(2);
      //boton agregar cantidad
      agregarCant(li, item);
      //agregar boton menos cantidad
      quitarCant(li, item, newQuantity);
      //boton eliminar producto
      eliminarElem(li, item, newQuantity);
      li.appendChild(agregarCant);
      li.appendChild(quitarCant);
      li.appendChild(eliminarElem);
    } else if (newQuantity == 0) {
      li.remove();
      //console.log(item.precio_venta+"    "+currentQuantity+" E? priceChange: "+item.precio_venta*currentQuantity);
      const priceChange = item.precio_venta * currentQuantity;
      const currentPrice = parseFloat(totalPrice.textContent);
      //console.log(" E? currentprice: "+currentPrice);
      const newPrice = currentPrice - priceChange;
      //console.log(newPrice);
      totalPrice.textContent = newPrice.toFixed(2);
      const index = cod_prods.indexOf(item.codigo_prod);
      if (index !== -1) {
        cod_prods.splice(index, 1);
        nomb_prods.splice(index, 1);
        cod_prods_str = cod_prods.join(", ");
        nomb_prods_str = nomb_prods.join(", ");
      }
    }
    
  }

  function agregarCant(li, item){
    const addButton = document.createElement("button");
    addButton.title = "Agregar";
    addButton.className = "bg-indigo-200 hover:bg-indigo-100 rounded-full p-2 self-center";
    var svgMas = document.createElementNS("http://www.w3.org/2000/svg", "svg");
    svgMas.setAttribute("xmlns", "http://www.w3.org/2000/svg");
    svgMas.setAttribute("fill", "none");
    svgMas.setAttribute("viewBox", "0 0 24 24");
    svgMas.setAttribute("stroke-width", "1.5");
    svgMas.setAttribute("stroke", "currentColor");
    svgMas.setAttribute("class", "w-6 h-6");
    var pathMas = document.createElementNS("http://www.w3.org/2000/svg", "path");
    pathMas.setAttribute("stroke-linecap", "round");
    pathMas.setAttribute("stroke-linejoin", "round");
    pathMas.setAttribute("d", "M12 6v12m6-6H6");
    svgMas.appendChild(pathMas);
    addButton.appendChild(svgMas);
    addButton.addEventListener("click", () => {
      actualizarCantidad(li, item, 1);
    });
    li.appendChild(addButton);
  }

  function quitarCant(li, item, cant){
    const addButtonMenos = document.createElement("button");
    addButtonMenos.title = "Quitar";
    addButtonMenos.className = "bg-indigo-200 hover:bg-indigo-100 rounded-full p-2 self-center mx-2";
    var svgMenos = document.createElementNS("http://www.w3.org/2000/svg", "svg");
    svgMenos.setAttribute("xmlns", "http://www.w3.org/2000/svg");
    svgMenos.setAttribute("fill", "none");
    svgMenos.setAttribute("viewBox", "0 0 24 24");
    svgMenos.setAttribute("stroke-width", "1.5");
    svgMenos.setAttribute("stroke", "currentColor");
    svgMenos.setAttribute("class", "w-6 h-6");
    var pathMenos = document.createElementNS("http://www.w3.org/2000/svg", "path");
    pathMenos.setAttribute("stroke-linecap", "round");
    pathMenos.setAttribute("stroke-linejoin", "round");
    pathMenos.setAttribute("d", "M18 12H6");
    svgMenos.appendChild(pathMenos);
    addButtonMenos.appendChild(svgMenos);
    addButtonMenos.addEventListener("click", () => {
      actualizarCantidad(li, item, -1);
    });
    li.appendChild(addButtonMenos);
  }
  
  function eliminarElem(li, item, cant){
    const removeButton = document.createElement("button");
    removeButton.title = "Eliminar";
    removeButton.className = "bg-red-200 hover:bg-red-100 rounded-full p-2 self-center";
    var svgEliminar = document.createElementNS("http://www.w3.org/2000/svg", "svg");
    svgEliminar.setAttribute("xmlns", "http://www.w3.org/2000/svg");
    svgEliminar.setAttribute("fill", "none");
    svgEliminar.setAttribute("viewBox", "0 0 24 24");
    svgEliminar.setAttribute("stroke-width", "1.5");
    svgEliminar.setAttribute("stroke", "currentColor");
    svgEliminar.setAttribute("class", "w-6 h-6");
    var pathEliminar = document.createElementNS("http://www.w3.org/2000/svg", "path");
    pathEliminar.setAttribute("stroke-linecap", "round");
    pathEliminar.setAttribute("stroke-linejoin", "round");
    pathEliminar.setAttribute("d", "M6 18L18 6M6 6l12 12");
    svgEliminar.appendChild(pathEliminar);
    removeButton.appendChild(svgEliminar);
    removeButton.addEventListener("click", () => {
      removeItemFromList(li, (item.precio_venta * (cant)), item);
    });
    li.appendChild(removeButton);
  }

  function revisarCambio() {
    let total = document.getElementById("total").textContent;
    let pago = document.getElementById("pago").value;
    pago = parseFloat(pago);
    total = parseFloat(total);
    if (pago === "") {
      alert("No se ha ingresado un pago");
    } else {
      if (pago.length == total.length) {
        let cambio = pago - total;
        document.getElementById("cambio").textContent = parseFloat(cambio);
      } else {
        alert("????");
      }
    }
  }

  function vender(){
    const lista = document.getElementById("listaCorrecta");
    if (lista != null) {//verifica si existe una lista de compras
      const elementos = lista.getElementsByTagName("li");
      let cod_prods = cod_prods_str;
      codigo_productos = cod_prods;
      let nomb_prods = nomb_prods_str;
      let total = document.getElementById("total").textContent;
      const usuario = document.getElementById("usuario").textContent;
      let pago = document.getElementById("pago").value;
      let cambio = document.getElementById("cambio").textContent;
      total = parseFloat(total);
      cambio = parseFloat(cambio);
      //console.log(lista);
      for (let i = 0; i < elementos.length; i++) {
        const texto = elementos[i].textContent;
        const partes = texto.split(" - ");
        const nombre = partes[0].substring(8); // eliminar la palabra "Nombre: "
        const precio = partes[1].substring(9); // eliminar el signo precio: $
        const cantidad = partes[2].substring(10); // eliminar la palabra "Cantidad: "
        //console.log(nombre);
        //codigo para obtener datos de cantidad de cada elemento a vender
        valores.push({ nombre, precio, cantidad, cod_prods, nomb_prods, total, usuario, pago, cambio });
        cantidadInv(nombre);
      }
      const valoresJSON = JSON.stringify(valores);
      const xhttp = new XMLHttpRequest();
      xhttp.open("POST", "realizar_venta.php", true);
      xhttp.setRequestHeader("Content-type", "application/json");
      xhttp.send(valoresJSON);
      xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {//si hay conexion con el archivo procede
          alert("Realizado");//cambiar el texto de la alerta por el siguiente para saber lo que ocurre en el servidor: "La respuesta del servidor es: " + xhttp.responseText
          fecha = xhttp.responseText;
          console.log(fecha);
          let cadena = fecha;
          let fechastr = cadena.substring(15, 34);
          fecha = fechastr;
          console.log(fecha);
          let form = document.createElement("form");
          //const button = document.getElementById("vender");
          const url = "ticket/ticket.php";
          form.method = "POST";
          form.action = url;
          form.target = "_blank";

          // Agregar campos ocultos al formulario
          let codProdsInput = document.createElement("input");
          codProdsInput.type = "hidden";
          codProdsInput.name = "codigo_productos";
          codProdsInput.value = codigo_productos;
          form.appendChild(codProdsInput);

          let fechaInput = document.createElement("input");
          fechaInput.type = "hidden";
          fechaInput.name = "fecha";
          fechaInput.value = fecha;
          form.appendChild(fechaInput);

          // Enviar el formulario automáticamente
          document.body.appendChild(form);
          form.submit();
        }
      };
    } else{
      alert("No hay ningún elemento a vender");
    }
    limpiar();
  }

  function limpiar(){
    const lista = document.getElementById("listaCorrecta");
    lista.innerHTML = ""; //se vacian todos los elementos de la lista de compras despues de realizar la compra
    document.getElementById("total").textContent = 0;
    document.getElementById("pago").value = "";
    document.getElementById("cambio").textContent = 0;
    valores.length = 0; //vaciar un array
    cod_prods_str = "";
    nomb_prods_str = "";
    cod_prods = [];
    nomb_prods = [];
    fecha = "";
  }

  function tamaño(){
    let resultados = document.getElementById("resultados");
    resultados.style.maxWidth = "400px";
    resultados.style.maxHeight = "200px";
    div.style.overflowY = "auto";
    let venta = document.getElementById("venta");

  }



  //variables para hacer el ticket
  //para actualizar la cantidad en el inventario
  $codigo_producto = "";
  $cantidad_En_Inv = 0;
  //para guardar el movimiento que se realizó
  $nueva_Cantidad_Inv = 0;
  $datosCant = [];

  //funciones del ticket
  function cantidadInv($nombre){
    $nombrePro = [];
    $nombrePro.push({$nombre});
    const valoresJSON = JSON.stringify($nombrePro);
      const xhttp = new XMLHttpRequest();
      xhttp.open("POST", "cantidad.php", true);
      xhttp.setRequestHeader("Content-type", "application/json");
      xhttp.send(valoresJSON);
      xhttp.onreadystatechange = function (datos) {
        for(i = 0; i < datos.length; i++){
          $datosCant[i] = $datos[i];
        }
      }
      console.log($datosCant);
  }