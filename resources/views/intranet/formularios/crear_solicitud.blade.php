			<div class="container">
				<div class="row">
					<form method="post" id="info" action="http://localhost:8000/solicitudes/servicios">
					{{ csrf_field() }}
					<div class="row">
						<div class="col-sm-10">
								<h3>Datos personales</h3>
								<hr class="divider" />
							</div>
							<div class="col-sm-11">
								<label for="cedula">Cedula</label>
								<input type="text" required name="cedula" id="cedula" class="form-control" />
							</div>
							<div class="col-sm-4">
								<label for="nombres">nombres</label>
								<input type="text" required name="nombres" id="nombres" class="form-control" />
							</div>
							<div class="col-sm-4">
								<label for="apellidos">apellidos</label>
								<input type="text" required name="apellidos" id="apellidos" class="form-control" />
							</div>

							<div class="col-sm-3">
								<label for="email">Correo electronico</label>
								<input type="email" required name="email" class="form-control" />
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12 col-md-6 col-lg-6">
								<label for="telefono">Telefono personal</label>
								<input type="text" required name="telefono_personal" class="form-control" />
							</div>
							<div class="col-sm-12 col-md-3 col-lg-3">
								<label for="telefono">Telefono de contacto</label>
								<input type="text" required name="telefono_habitacion" class="form-control" />
							</div>
						</div>
						<div class="row">
							<div class="col-sm-10">
								<h3>Datos del servicio</h3>
								<hr class="divider" />
							</div>
							<div class="col-sm-6">
								<label for="tipo_servicio">Tipo de servicio solicitado</label>
								<select name="tipo_id"  required id="" class="form-control">
									<option value="">-----</option>
									@foreach($tiposervicio as $key => $tipo)
										@if( $key > 0)
											<option value="{{ $tipo->id }}">
												{{ $tipo->denominacion }}
											</option>
										@endif
									@endforeach
								</select>
							</div>

							<div class="col-sm-5">
								<label for="tipo_servicio">Categoria del servicio</label>
								<select name="categoria_id" required id="" class="form-control">
									<option value="">----------</option>
									@foreach($categorias as $key => $categoria)
										
											<option value="{{ $categoria->id }}">
												{{ $categoria->nombre_categoria }}
											</option>
										
									@endforeach
								</select>
							</div>
							<div class="row">
								<div class="col-sm-11">
									<label for="direccion">Dirección</label>
									<textarea name="direccion" required id="direccion" class="form-control" cols="30" rows="10"></textarea>
								</div>
								<div class="col-sm-11">
									<label for="direccion">Explique aquí brevemente su problema</label>
									<textarea name="detalles" required id="detalles" class="form-control" cols="30" rows="10"></textarea>
								</div>
							</div>
						</div>
						<br />
						<div class="row" >
							<button type="submit" class="btn btn-primary btn-lg">Guardar</a>
						</div>
					</form>
				</div>
			</div>