        <!-- MODAL AGREGAR TIPO DE DOCUMENTO -->
        <div class="modal fade" id="modalAgregarTipoDoc" tabindex="-1" aria-labelledby="modalAgregarTipoDocLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="modalAgregarTipoDocLabel">
                  <i class="fas fa-plus-circle me-2"></i>Agregar Tipo de Documento
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
              </div>
              
              <form id="formAgregarTipoDoc">
                <div class="modal-body">
                  <div class="mb-3">
                    <label for="nombreTipoDoc" class="form-label">
                      <i class="fas fa-file-alt me-1"></i>Nombre del Tipo de Documento
                    </label>
                    <input 
                      type="text" 
                      class="form-control" 
                      id="nombreTipoDoc" 
                      name="nombre" 
                      placeholder="Ej: DNI, Pasaporte, Carnet de Extranjería"
                      required
                      maxlength="100"
                    >
                    <div class="form-text">Máximo 100 caracteres</div>
                  </div>
                  
                  <div class="mb-3">
                    <label for="estadoTipoDoc" class="form-label">
                      <i class="fas fa-toggle-on me-1"></i>Estado
                    </label>
                    <select class="form-select" id="estadoTipoDoc" name="estado" required>
                      <option value="1" selected>Activo</option>
                    </select>
                  </div>
                </div>
                
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Cancelar
                  </button>
                  <button type="submit" class="btn btn-success">
                    <i class="fas fa-save me-1"></i>Guardar
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
          // EVENTO SUBMIT FORMULARIO AGREGAR
        $(document).ready(function(){
        $('#formAgregarTipoDoc').on('submit', function(e) {
            e.preventDefault();
            
            // Validación básica
            var nombre = $('#nombreTipoDoc').val().trim();
            if (nombre.length < 2) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error de validación',
                    text: 'El nombre debe tener al menos 2 caracteres',
                    confirmButtonColor: '#d33'
                });
                return;
            }

            // Envío AJAX
            $.ajax({
                url: 'acciones/tipo_documento/agregar.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    nombre: nombre,
                    estado: $('#estadoTipoDoc').val()
                },
                beforeSend: function() {
                    // Deshabilitar botón durante el envío
                    $('#formAgregarTipoDoc button[type="submit"]').prop('disabled', true);
                },
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Éxito!',
                            text: response.message,
                            confirmButtonColor: '#28a745'
                        }).then(() => {
                            $('#modalAgregarTipoDoc').modal('hide');
                            location.reload(); // Recargar para mostrar el nuevo registro
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message,
                            confirmButtonColor: '#d33'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error AJAX:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error de conexión',
                        text: 'No se pudo conectar con el servidor',
                        confirmButtonColor: '#d33'
                    });
                },
                complete: function() {
                    // Rehabilitar botón
                    $('#formAgregarTipoDoc button[type="submit"]').prop('disabled', false);
                }
            });
        });
        });
</script>