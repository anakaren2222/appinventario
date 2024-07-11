let tableRegistros;
let rowTable;

document.addEventListener("DOMContentLoaded", () => {
  MostrarRegistros();
  fntOptions();
  fntAgregar();
});

//Funcion para extraer los registros de la base de datos
function MostrarRegistros() {
  tableRegistros = $("#registros").DataTable({
    procesing: true,
    responsive: true,
    columnDefs: [
      {
        targets: -4,
        responsivePriority: 4,
      },
    ],
    destroy: true,
    lengthMenu: [10, 25, 50],
    pageLength: 10,
    ajax: {
      url: Base_URL + "/Home/getRegistros",
      dataSrc: "",
    },
    columns: [
      { data: "idInventario", className: "text-center" },
      { data: "Codigo", className: "text-center" },
      { data: "Linea", className: "text-center" },
      { data: "Ubicacion", className: "text-center" },
      { data: "Responsable", className: "text-center" },
      { data: "Cantidad", className: "text-center" },
      { data: "CostoFormato", className: "text-center" },
      { data: "costoTotalformato", className: "text-center" },
      { data: "options", className: "text-center", orderable: false },
      { data: "Descripcion", visible: false },
      { data: "FechaCreacion", visible: false },
      { data: "FechaActualizacion", visible: false },
    ],
    dom:
      "<'row'<'col-12 mb-3'B>>" + // Botones de exportación
      "<'row'<'col-12 mb-2'<<'col-12 mb-2'l> <<'col-12'f>>>>" + // Selector de longitud y cuadro de búsqueda
      "<'row'<'col-12 mb-4'tr>>" + // Tabla
      "<'row'<'col-12'p>>", // Paginación
    buttons: [
      {
        extend: "copyHtml5",
        text: "<i class='fas fa-copy'></i> Copy",
        titleAttr: "Copy",
        className: "btn btn-secondary col-12 col-sm-auto mb-2",
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5, 6, 7, 9, 10, 11], // Excluir la columna de acciones
        },
      },
      {
        extend: "excelHtml5",
        text: "<i class='fas fa-file-excel'></i> Excel",
        titleAttr: "Excel",
        className: "btn btn-success col-12 col-sm-auto mb-2",
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5, 6, 7, 9, 10, 11], // Excluir la columna de acciones
        },
      },
      {
        extend: "csvHtml5",
        text: "<i class='fas fa-file-csv'></i> CSV",
        titleAttr: "CSV",
        className: "btn btn-light col-12 col-sm-auto mb-2",
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5, 6, 7, 9, 10, 11], // Excluir la columna de acciones
        },
      },
    ],
  });
}

function fntOptions() {
  let request = window.XMLHttpRequest
    ? new XMLHttpRequest()
    : new ActiveXObject("Microsoft.XMLHTTP");
  let ajaxUrl = Base_URL + "/Home/getOpciones";
  request.open("GET", ajaxUrl, true);
  request.send();

  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      try {
        let objData = JSON.parse(request.responseText);
        let selectParte = document.querySelector("#txtParte");
        let selectParteUpdate = document.querySelector("#txtParteUpdate");
        let txtCantidad = document.getElementById("txtCantidad");
        let txtCantidadUpdate = document.getElementById("txtCantidadUpdate");

        // Limpiar las opciones previas
        selectParte.innerHTML = "";
        selectParteUpdate.innerHTML = "";

        // Añadir las nuevas opciones
        objData.forEach(function (opcion) {
          let option = document.createElement("option");
          option.value = opcion.id;
          option.text = opcion.codigo;
          selectParte.appendChild(option);

          let optionUpdate = document.createElement("option");
          optionUpdate.value = opcion.id;
          optionUpdate.text = opcion.codigo;
          selectParteUpdate.appendChild(optionUpdate);
        });

        // Seleccionar el primer valor si hay opciones disponibles
        if (objData.length > 0) {
          selectParte.value = objData[0].id;
          selectParteUpdate.value = objData[0].id;
        }

        // Función para calcular y actualizar los costos
        function actualizarCostos(
          cantidadElement,
          costoElement,
          costoTotalElement
        ) {
          let selectedIndex = selectParte.selectedIndex;
          if (selectedIndex >= 0 && selectParte.options[selectedIndex]) {
            let selectedOption = objData[selectedIndex];
            let costoSeleccionado = selectedOption.costo;
            let cantidad = parseFloat(cantidadElement.value);
            let SumaTotal = costoSeleccionado * cantidad;

            costoElement.value = formatoMoney(costoSeleccionado);
            costoTotalElement.value = formatoMoney(SumaTotal);
          } else {
            console.error("No hay una opción válida seleccionada.");
          }
        }

        // Eventos para actualizar los costos cuando cambian la cantidad
        txtCantidad.addEventListener("input", () => {
          actualizarCostos(
            txtCantidad,
            document.getElementById("txtCosto"),
            document.getElementById("txtCostoTotal")
          );
        });

        txtCantidadUpdate.addEventListener("input", () => {
          actualizarCostos(
            txtCantidadUpdate,
            document.getElementById("txtCostoUpdate"),
            document.getElementById("txtCostoTotalUpdate")
          );
        });

        // Eventos para actualizar los costos cuando cambia la selección de parte
        selectParte.addEventListener("change", () => {
          actualizarCostos(
            txtCantidad,
            document.getElementById("txtCosto"),
            document.getElementById("txtCostoTotal")
          );
        });

        selectParteUpdate.addEventListener("change", () => {
          actualizarCostos(
            txtCantidadUpdate,
            document.getElementById("txtCostoUpdate"),
            document.getElementById("txtCostoTotalUpdate")
          );
        });
      } catch (e) {
        console.error("Error al parsear JSON: ", e);
      }
    }
  };
}

function formatoMoney($cantidad) {
  let suma = $cantidad.toLocaleString("es-MX", {
    style: "currency",
    currency: "MXN",
  });
  return suma;
}

// Agregar registros a la base de datos
function fntAgregar() {
  const btnAgregar = document.getElementById("btnAgregar");
  btnAgregar.addEventListener("click", () => {
    $("#modalAgregar").modal("show");
    document.getElementById("formRegistros").reset();

    const formulario = document.getElementById("formRegistros");

    formulario.onsubmit = async (e) => {
      e.preventDefault();

      // Capturar valores justo antes de enviar el formulario
      const intCantidad = document.getElementById("txtCantidad").value;
      const intNoParte = document.getElementById("txtParte").value;
      const intCosto = parseFloat(
        document
          .getElementById("txtCosto")
          .value.replace("$", "")
          .replace(",", "")
      );
      const strUbicacion = document.getElementById("txtUbicacion").value;
      const strLinea = document.getElementById("txtLinea").value;
      const strResponsable = document.getElementById("txtResponsable").value;
      const strDescripcion = document.getElementById("txtDescripcion").value;
      const strCostoTotal = parseFloat(
        document
          .getElementById("txtCostoTotal")
          .value.replace("$", "")
          .replace(",", "")
      );

      // Actualizar campos ocultos con los valores actuales
      document.getElementById("txtCostoHidden").value = intCosto;
      document.getElementById("txtCostoTotalHidden").value = strCostoTotal;

      // Validar los campos antes de enviar el formulario
      if (
        intCantidad === "" ||
        intNoParte === "" ||
        isNaN(intCosto) || // Validar que intCosto sea un número válido
        strUbicacion === "" ||
        strLinea === "" ||
        strResponsable === "" ||
        strDescripcion === "" ||
        isNaN(strCostoTotal) // Validar que strCostoTotal sea un número válido
      ) {
        Swal.fire({
          title: "¡Atención!",
          text: "Todos los campos son requeridos",
          icon: "info",
          confirmButtonText: "Aceptar",
        });
        return false;
      }

      try {
        const formData = new FormData(formulario);
        const response = await fetch(Base_URL + "/Home/setRegistro", {
          method: "POST",
          body: formData,
        });

        if (!response.ok) {
          throw new Error("Error en la solicitud");
        }

        const data = await response.json();
        console.log("Respuesta del servidor:");
        console.log(data);

        if (data.status) {
          $("#modalAgregar").modal("hide");
          formulario.reset();
          Swal.fire({
            title: "¡Registro!",
            text: data.msg,
            icon: "success",
            confirmButtonText: "Aceptar",
          });
          tableRegistros.ajax.reload();
        } else {
          Swal.fire({
            title: "Error",
            text: data.msg,
            icon: "error",
            confirmButtonText: "Aceptar",
          });
        }
      } catch (error) {
        console.error("Error en la solicitud:", error);
        Swal.fire({
          title: "¡Atención!",
          text: "Algo pasó en el proceso, revisar código",
          icon: "error",
          confirmButtonText: "Aceptar",
        });
      }

      return false;
    };
  });
}

//Visualizar la informacion del registro
function btnView(idInventario) {
  //Creamos un fetch para mandar la peticion al servidor
  fetch(Base_URL + "/Home/getRegistro/" + idInventario, {
    method: "GET",
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error("Error en la solicitud");
      }
      return response.json();
    })
    .then((Objdata) => {
      if (Objdata.status) {
        //Capturamos el id de nuestros elementos del modal
        document.getElementById("cellParte").innerHTML = Objdata.data.Codigo;
        document.getElementById("cellLinea").innerHTML = Objdata.data.Linea;
        document.getElementById("cellUbicacion").innerHTML =
          Objdata.data.Ubicacion;
        document.getElementById("cellDescripcion").innerHTML =
          Objdata.data.Descripcion;
        document.getElementById("cellResponsable").innerHTML =
          Objdata.data.Responsable;
        document.getElementById("cellCantidad").innerHTML =
          Objdata.data.Cantidad;
        document.getElementById("cellCreacion").innerHTML =
          Objdata.data.FechaCreacion;
        document.getElementById("cellActualizacion").innerHTML =
          Objdata.data.FechaActualizacion;
        $("#modalView").modal("show");
      } else {
        Swal.fire({
          title: "¡Atención!",
          text: Objdata.msg,
          icon: "error",
          confirmButtonText: "Aceptar",
        });
      }
    })
    .catch(() => {
      Swal.fire({
        title: "¡Atención!",
        text: "Algo ha ocurrido en el proceso, verificar código",
        icon: "error",
        confirmButtonText: "Aceptar",
      });
    });
}

//Editar informacion de los registros
function btnUpdate(element, idInventario) {
  rowTable = element.parentNode.parentNode.parentNode;
  $("#modalEditar").modal("show");
  fetch(Base_URL + "/Home/getRegistro/" + idInventario, {
    method: "GET",
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error("Error en la solicitud");
      }
      return response.json(); // Obtén la respuesta como JSON
    })
    .then((data) => {
      console.log(data);
      if (data.status) {
        //Creamos variables y capturamos el id de los inputs
        document.getElementById("idInventario").value = data.data.idInventario;
        document.getElementById("txtCostoUpdate").value = data.data.Costo;
        document.getElementById("txtParteUpdate").value = data.data.No_Parte_id;
        document.getElementById("txtLineaUpdate").value = data.data.Linea;
        document.getElementById("txtUbicacionUpdate").value =
          data.data.Ubicacion;
        document.getElementById("txtDescripcionUpdate").value =
          data.data.Descripcion;
        document.getElementById("txtResponsableUpdate").value =
          data.data.Responsable;
        document.getElementById("txtCantidadUpdate").value = data.data.Cantidad;
        document.getElementById("txtCostoTotalUpdate").value =
          data.data.CostoTotal;
      }
    })
    .catch((error) => {
      console.error("Error al procesar la respuesta del servidor:", error);
      Swal.fire({
        title: "¡Atención!",
        text: "Algo ocurrió en el proceso, revisa el código",
        icon: "error",
        confirmButtonText: "Aceptar",
      });
    });

  //creamos una variable y capturamos el id del formulario
  const formRegistroUpdate = document.getElementById("formRegistrosUpdate");
  formRegistroUpdate.onsubmit = (e) => {
    e.preventDefault();
    //Creamos variables y capturamos el id de los inputs
    const strParte = document.querySelector("#txtParteUpdate").value;
    const strLinea = document.querySelector("#txtLineaUpdate").value;
    const intCosto = parseFloat(
      document
        .getElementById("txtCostoUpdate")
        .value.replace("$", "")
        .replace(",", "")
    );
    const strUbicacion = document.querySelector("#txtUbicacionUpdate").value;
    const strDescripcion = document.querySelector(
      "#txtDescripcionUpdate"
    ).value;
    const strResponsable = document.querySelector(
      "#txtResponsableUpdate"
    ).value;
    const intCantidad = document.querySelector("#txtCantidadUpdate").value;
    const strCostoTotal = parseFloat(
      document
        .getElementById("txtCostoTotalUpdate")
        .value.replace("$", "")
        .replace(",", "")
    );

    // Actualizar campos ocultos con los valores actuales
    document.getElementById("txtCostoHiddenUpdate").value = intCosto;
    document.getElementById("txtCostoTotalHiddenUpdate").value = strCostoTotal;

    //Creamos una validacion para comprobar que los campos no vayan vacios
    if (
      strParte == "" ||
      strLinea == "" ||
      strUbicacion == "" ||
      strDescripcion == "" ||
      strResponsable == "" ||
      intCantidad == ""
    ) {
      Swal.fire({
        title: "¡Atención!",
        text: "Todos los campos son requeridos",
        icon: "error",
        confirmButtonText: "Aceptar",
      });
      return false;
    }

    //creamos el fetch para mandar solicitudes http al servidor
    fetch(Base_URL + "/Home/updateRegistro/" + idInventario, {
      method: "POST",
      body: new FormData(formRegistroUpdate),
    })
      .then((response) => {
        if (!response.ok) {
          throw new Error("Error en la solicitud");
        }
        return response.json(); // Obtén la respuesta como JSON
      })
      .then((objData) => {
        if (objData.status) {
          if (rowTable == "") {
            tableRegistros.ajax.reload();
          } else {
            rowTable.cells[1].textContent = strParte;
            rowTable.cells[2].textContent = strLinea;
            rowTable.cells[3].textContent = strUbicacion;
            rowTable.cells[4].textContent = strDescripcion;
            rowTable.cells[5].textContent = strResponsable;
            rowTable.cells[6].textContent = intCantidad;
            rowTable.cells[7].textContent = intCosto;
            rowTable.cells[8].textContent = strCostoTotal;
            tableRegistros.ajax.reload();
          }
          $("#modalEditar").modal("hide");
          formRegistroUpdate.reset();
          Swal.fire({
            title: "Registro",
            text: objData.msg,
            icon: "success",
            confirmButtonText: "Aceptar",
          });
        } else {
          Swal.fire({
            title: "Error",
            text: objData.msg,
            icon: "error",
            confirmButtonText: "Aceptar",
          });
        }
      })
      .catch((error) => {
        console.error("Error al procesar la respuesta del servidor:", error);
        Swal.fire({
          title: "¡Atención!",
          text: "Algo ocurrio en el proceso, revisar código",
          icon: "error",
          confirmButtonText: "Aceptar",
        });
      });
    return false;
  };
}

//Funcion para eliminar registro
function btnDelete(idInventario) {
  Swal.fire({
    title: "Eliminar registro",
    text: "¿Estas seguro de eliminar el registro?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Si, Eliminar",
    cancelButtonText: "No, cancelar",
    reverseButtons: true,
    confirmButtonColor: "#800000",
    iconColor: "#800000",
  }).then((result) => {
    if (result.isConfirmed) {
      fetch(Base_URL + "/Home/deleteRegistro/" + idInventario, {
        method: "POST",
      })
        .then((response) => {
          if (!response.ok) {
            throw new Error("Error en la solicitud");
          }
          return response.json(); // Obtén la respuesta como JSON
        })
        .then((Objdata) => {
          if (Objdata.status) {
            Swal.fire({
              title: "Eliminado",
              text: Objdata.msg,
              icon: "success",
              confirmButtonText: "Aceptar",
            });
            tableRegistros.ajax.reload();
          } else {
            Swal.fire({
              title: "Atención",
              text: Objdata.msg,
              icon: "error",
              confirmButtonText: "Aceptar",
            });
          }
        })
        .catch(() => {
          Swal.fire({
            title: "¡Atención!",
            text: "Algo paso durante el proceso, revisar código",
            icon: "error",
            confirmButtonText: "Aceptar",
          });
        });
      return false;
    }
  });
}
