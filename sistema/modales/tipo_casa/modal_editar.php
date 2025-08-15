<!-- MODAL EDITAR TIPO DE DOCUMENTO -->
        <div class="modal fade" id="modalEditarTipoDoc" tabindex="-1" aria-labelledby="modalEditarTipoDocLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title" id="modalEditarTipoDocLabel">
                  <i class="fas fa-edit me-2"></i>Editar Tipo de Documento
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
              </div>
              
              <form id="formEditarTipoDoc">
                <!-- Campo oculto para el ID -->
                <input type="hidden" id="editarId" name="id">
                
                <div class="modal-body">
                  <div class="mb-3">
                    <label for="editarNombreTipoDoc" class="form-label">
                      <i class="fas fa-file-alt me-1"></i>Nombre del Tipo de Documento
                    </label>
                    <input 
                      type="text" 
                      class="form-control" 
                      id="editarNombreTipoDoc" 
                      name="nombre" 
                      placeholder="Ej:  girasol, rosas, esmeralda"
                      required
                      maxlength="100"
                    >
                    <div class="form-text">Máximo 100 caracteres</div>
                  </div>
                  
                  <div class="mb-3">
                    <label for="editarEstadoTipoDoc" class="form-label">
                      <i class="fas fa-toggle-on me-1"></i>Estado
                    </label>
                    <select class="form-select" id="editarEstadoTipoDoc" name="estado" required>
                      <option value="1">Activo</option>
                      <option value="0">Inactivo</option>
                    </select>
                  </div>

                  <!-- Información adicional para el usuario -->
                  <div class="alert alert-info d-flex align-items-center" role="alert">
                    <i class="fas fa-info-circle me-2"></i>
                    <div>
                      <strong>Nota:</strong> Al cambiar el nombre, verifique que no exista otro tipo de documento con el mismo nombre.
                    </div>
                  </div>
                </div>
                
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Cancelar
                  </button>
                  <button type="submit" class="btn btn-warning text-dark">
                    <i class="fas fa-save me-1"></i>Actualizar
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>

<script>
    $(document).ready(function(){
        $(document).on('click','.btn-edit', function(e){
          e.preventDefault();

          var id = $(this).data('id');
          console.log('id=', id);

          cargarDatosParaEditar(id); 
        });

        function cargarDatosParaEditar(id){
            $.ajax({
                url:      'acciones/tipo_casa/obtener.php',
                type:     'POST',
                dataType: 'json',
                data: {id: id},
                beforeSend: function() {
                    // Mostrar loading
                    Swal.fire({
                        title: 'Cargando datos...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                },
                success: function(response){
                        Swal.close();

                        if(response.status === 'success'){
                            $('#editarId').val(response.data.id);
                            $('#editarNombreTipoDoc').val(response.data.nombre);
                            $('#editarEstadoTipoDoc').val(response.data.estado);

                            $('#modalEditarTipoDoc').modal('show');
                        } else{
                            Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message,
                            confirmButtonColor: '#d33'
                            });
                        }

                    },
                    error: function(xhr, status, error) {
                    Swal.close();
                    console.error('Error al cargar datos:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error de conexión',
                        text: 'No se pudieron cargar los datos del registro',
                        confirmButtonColor: '#d33'
                    });
                }
                    
            });
        }
        
        $('#formEditarTipoDoc').on('submit',function(e){
            e.preventDefault();

            var id=$('#editarId').val();
            var nombre=$('#editarNombreTipoDoc').val().trim();  
            
            if(!id){
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'ID de registro no válido',
                    confirmButtonColor: '#d33'
                });
                return;
            }
            if(nombre.length <2){
                    Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'El nombre no debe tener menos de 2 caracteres',
                    confirmButtonColor: '#d33'
                });
                return;
            }

            Swal.fire({
                title: '¿Confirmar actualización?',
                text: `Se actualizará el tipo de casa: "${nombre}"`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#ffc107',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sí, actualizar',
                cancelButtonText: 'Cancelar'
            }).then((result)=>{
                if(result.isConfirmed){
                    $.ajax({
                        url: 'acciones/tipo_casa/editar.php',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            id: id,
                            nombre: nombre,
                            estado: $('#editarEstadoTipoDoc').val(),
                            
                        },
                        beforeSend: function() {
                            // Deshabilitar botón durante el envío
                            $('#formEditarTipoDoc button[type="submit"]').prop('disabled', true);
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                Swal.fire({
                                    icon: 'success',
                                    title: '¡Actualizado!',
                                    text: response.message,
                                    confirmButtonColor: '#28a745'
                                }).then(() => {
                                    $('#modalEditarTipoDoc').modal('hide');
                                    location.reload(); // Recargar para mostrar los cambios
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
                            console.error('Error AJAX al editar:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error de conexión',
                                text: 'No se pudo actualizar el registro',
                                confirmButtonColor: '#d33'
                            });
                        },
                        complete: function() {
                            // Rehabilitar botón
                            $('#formEditarTipoDoc button[type="submit"]').prop('disabled', false);
                        }
                    });

                }

            });
        });
        
    });
</script>