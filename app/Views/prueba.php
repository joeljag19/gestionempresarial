<form  method="post" id="form-datos-personales" action="<?=base_url('empleados/actualizarDatos/1/')?>">
                    <div class="form-group">
                        <label for="primer_nombre">Primer Nombre</label>
                        <input type="text" class="form-control" id="primer_nombre" name="primer_nombre" value="Alexander" required>
                    </div>
                    <div class="form-group">
                        <label for="apellido">Apellido</label>
                        <input type="text" class="form-control" id="apellido" name="apellido" value="alto" required>
                    </div>
                    <div class="form-group">
                        <label for="cedula">Cédula</label>
                        <input type="text" class="form-control" id="cedula" name="cedula" value="001-0002992-3" required>
                    </div>
                    <div class="form-group">
                        <label for="genero">Género</label>
                        <input type="text" class="form-control" id="genero" name="genero" value="M" required>
                    </div>
                    <div class="form-group">
                        <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                        <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" value="2024-10-08" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar Datos Personales</button>
                </form>


