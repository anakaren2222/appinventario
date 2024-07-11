let tableRegistros;
let rowTable;

document.addEventListener("DOMContentLoaded", () => {
  MostrarRegistros();
  fntAgregar();
});

function formatoMoney($cantidad) {
  let suma = $cantidad.toLocaleString("es-MX", {
    style: "currency",
    currency: "MXN",
  });
  return suma;
}

//Funcion para extraer los registros de la base de datos
function MostrarRegistros() {
  tableRegistros = $("#registros_Partes").DataTable({
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
      url: Base_URL + "/Parte/getRegistros",
      dataSrc: "",
    },
    columns: [
      { data: "idParte", className: "text-center" },
      { data: "Codigo", className: "text-center" },
      { data: "CostoFormato", className: "text-center" },
      { data: "status", className: "text-center" },
      { data: "createDate", className: "text-center" },
      { data: "options", className: "text-center", orderable: false },
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
          columns: [0, 1, 2, 4], // Excluir la columna de acciones
        },
      },
      {
        extend: "excelHtml5",
        text: "<i class='fas fa-file-excel'></i> Excel",
        titleAttr: "Excel",
        className: "btn btn-success col-12 col-sm-auto mb-2",
        exportOptions: {
          columns: [0, 1, 2, 4], // Excluir la columna de acciones
        },
      },
      {
        extend: "csvHtml5",
        text: "<i class='fas fa-file-csv'></i> CSV",
        titleAttr: "CSV",
        className: "btn btn-light col-12 col-sm-auto mb-2",
        exportOptions: {
          columns: [0, 1, 2, 3, 4], // Excluir la columna de acciones
        },
      },
    ],
  });
}

//Fucnion para agregar no partes
function fntAgregar() {
  const botonAgregar = document.getElementById("btnAgregar");
  botonAgregar.addEventListener("click", () => {
    $("#modalAgregar").modal("show");
    document.getElementById("formRegistros").reset();

    const formulario = document.getElementById("formRegistros");
    formulario.addEventListener("submit", (e) => {
      e.preventDefault();

      //Capturamos los inputs y el input de costo lo declaramos para que enviemos un datos de tipo float
      const intCodigo = document.getElementById("txtCodigo").value;
      const intCosto = parseFloat(document.getElementById("txtCosto").value);
      const intStatus = document.getElementById("intStatus").value;

      //Validamos que no vayan vacios
      if (intCodigo == "" || intCosto == "" || intStatus == "") {
        Swal.fire({
          title: "¡Atención!",
          text: "Todos los campos son requeridos",
          icon: "info",
          confirmButtonText: "Aceptar",
        });
        return false;
      }

      //Creamos un fetch
      fetch(Base_URL + "/Parte/setRegistros", {
        method: "POST",
        body: new FormData(formulario),
      })
        .then((response) => {
          if (!response.ok) {
            throw new Error("Error en la solicitud");
          }
          return response.json();
        })
        .then((objdata) => {
          if (objdata.status) {
            intStatus == 1
              ? '<span class="bagde" style="color:#004610;"><i class="fas fa-check-circle fa-2x"></i></span>'
              : '<span class="bagde" style="color:#560000;"><i class="fas fa-times-circle fa-2x"></i></span>';

            $("#modalAgregar").modal("hide");
            formulario.reset();
            Swal.fire({
              title: "No. parte",
              text: objdata.msg,
              icon: "success",
              confirmButtonText: "Aceptar",
            });
            tableRegistros.ajax.reload();
          } else {
            Swal.fire({
              title: "Error",
              text: objdata.msg,
              icon: "error",
              confirmButtonText: "Aceptar",
            });
          }
        })
        .catch((e) => {
          console.log(e.Error);
          Swal.fire({
            title: "No. parte",
            text: "Algo ocurrio en el proceso, revisar código",
            icon: "error",
            confirmButtonText: "Aceptar",
          });
        });
      return false;
    });
  });
}

//Funcion para actualizar registros
function btnUpdateParte(element, idParte) {
  rowTable = element.parentNode.parentNode.parentNode;
  $("#modalUpdate").modal("show");
  fetch(Base_URL + "/Parte/getParte/" + idParte, {
    method: "GET",
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error("Error en la solicitud");
      }
      return response.json(); // Obtén la respuesta como JSON
    })
    .then((data) => {
      if (data.status) {
        //Creamos variables y capturamos el id de los inputs
        document.querySelector("#idParte").value = data.data.idParte;
        document.querySelector("#txtCodigoUpdate").value = data.data.Codigo;
        document.querySelector("#txtCostoUpdate").value = data.data.Costo;
        if (data.data.status == 1) {
          document.querySelector("#intStatusUpdate").value = 1;
        } else {
          document.querySelector("#intStatusUpdate").value = 2;
        }
      }
    })
    .catch((error) => {
      console.error("Error al procesar la respuesta del servidor:", error);
      Swal.fire({
        title: "¡Attention!",
        text: "Something happened in the process, check code",
        icon: "error",
        confirmButtonText: "Accept",
      });
    });

  //creamos una variable y capturamos el id del formulario
  const formParteUpdate = document.querySelector("#formRegistrosUpdate");
  formParteUpdate.onsubmit = (e) => {
    e.preventDefault();
    //Creamos variables y capturamos el id de los inputs
    const intCodigo = document.querySelector("#txtCodigoUpdate").value;
    const floatCosto = parseFloat(
      document.querySelector("#txtCostoUpdate").value
    );
    const intStatus = document.querySelector("#intStatusUpdate").value;

    //Creamos una validacion para comprobar que los campos no vayan vacios
    if (intCodigo == "" || floatCosto == "" || intStatus == "") {
      Swal.fire({
        title: "¡Atencion!",
        text: "Todos los campos son requeridos",
        icon: "error",
        confirmButtonText: "Aceptar",
      });
      return false;
    }

    //creamos el fetch para mandar solicitudes http al servidor
    fetch(Base_URL + "/Parte/updateParte/" + idParte, {
      method: "POST",
      body: new FormData(formParteUpdate),
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
            htmlStatus =
              intStatus == 1
                ? '<span class="bagde" style="color:#004610;"><i class="fas fa-check-circle fa-2x"></i></span>'
                : '<span class="bagde" style="color:#560000;"><i class="fas fa-times-circle fa-2x"></i></span>';

            rowTable.cells[1].textContent = intCodigo;
            rowTable.cells[2].textContent = formatoMoney(floatCosto);
            rowTable.cells[3].innerHTML = htmlStatus;
          }
          $("#modalUpdate").modal("hide");
          formParteUpdate.reset();
          Swal.fire({
            title: "No. Parte",
            text: objData.msg,
            icon: "success",
            confirmButtonText: "Aceptar",
          });
        } else {
          Swal.fire({
            title: "Error",
            text: objData.msg,
            icon: "error",
            confirmButtonText: "Accept",
          });
        }
      })
      .catch((error) => {
        console.error("Error al procesar la respuesta del servidor:", error);
        Swal.fire({
          title: "¡Attention!",
          text: "Algo ocurrio en el proceso, revisar codigo",
          icon: "error",
          confirmButtonText: "Aceptar",
        });
      });
    return false;
  };
}

//Funcion para eliminar
function btnDeletedParte(idParte) {
  Swal.fire({
    title: "Delete No. parte",
    text: "¿Estas seguro de eliminar este No. parte?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Si, eliminar",
    cancelButtonText: "No, cancelar",
    reverseButtons: true,
    confirmButtonColor: "#560000",
    iconColor: "#560000",
  }).then((result) => {
    if (result.isConfirmed) {
      fetch(Base_URL + "/Parte/deleteParte/" + idParte, {
        method: "POST",
      })
        .then((response) => {
          if (!response.ok) {
            throw new Error("Error en la solicitud");
          }
          return response.json(); // Obtén la respuesta como JSON
        })
        .then((data) => {
          if (data.status) {
            Swal.fire({
              title: "Eliminado",
              text: data.msg,
              icon: "success",
              confirmButtonText: "Accept",
            });
            tableRegistros.ajax.reload();
          } else {
            Swal.fire({
              title: "Error",
              text: data.msg,
              icon: "error",
              confirmButtonText: "Accept",
            });
          }
        })
        .catch(() => {
          Swal.fire({
            title: "¡Atención!",
            text: "Algo paso durante el código, revisar codigo",
            icon: "error",
            confirmButtonText: "Accept",
          });
        });
      return false;
    }
  });
}
