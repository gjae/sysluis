import React from 'react'

import Navigator from './navbar.js'

import {
	Grid,
	Row,
	Col
} from 'react-bootstrap'
import $ from 'jquery'

import storeConsulta from '../stores/ReducerConsulta.js'

export default class Solicitud extends React.Component{

	constructor(props){
		super(props)

		this.state = {
			tipos: "",
			categorias: ""
		}

		storeConsulta.subscribe(()=>{
			this.setState({
				tipos: storeConsulta.getState().tipos,
				categorias: storeConsulta.getState().categorias
			})

			console.log(this.state);
		})
	}

	componentWillMount(){
		$.get("http://localhost:8000/solicitudes/categoria-tipo-servicio", (resp) =>{
			storeConsulta.dispatch({
				type: "SERVICIO_TIPOS_CATEGORIAS",
				datos: resp
			})
		});
	}

	renderTipos =()=>{
		if(this.state.tipos.length > 0){
			const options = this.state.tipos.map((tipo , indice) =>{
				return <option value={tipo.id} key={tipo.id}>{tipo.denominacion}</option>
			})

			return options
		}

	}

	renderCategorias =()=>{

		if(this.state.categorias.length > 0){
			const options = this.state.categorias.map((categoria , indice) =>{
				return <option value={categoria.id} key={categoria.id}>{categoria.nombre_categoria}</option>
			})

			return options
		}	
	}
 	
 	validarCedula(e){
	    var input = e.target
	    var longitud = 15
	    if( !(/^[0-9\-]+$/.test( input.value )) || input.value.length > longitud){
	        alert("EL CAMPO QUE INTENTA USAR SOLO PUEDE POSEER CARACTERES NUMERICOS Y DEBE TENER UNA LONGITUD MAXIMA DE "+longitud+ " CARACTERES")
	        input.value = input.value.substring(0 , (input.value.length - 1) ) 
	     }
 	}

 	soloTexto(e){
 		var input = e.target
        if( ( /\d|\u00C0|\u017F|[`~!@#$%^&*()_°¬|+\-=?;:'",.<>\{\}\[\]\\\/]/.test(input.value) ) ){
            alert("EL NOMBRE DE UNA PERSONA NO PUEDE CONTENER SIMBOLOS ESPECIALES NI NÚMEROS")
            input.value = input.value.substring(0 , (input.value.length - 1) )
        } 	
        if(input.value.length > 50)
        {
        	input.value = input.value.substring(0, (input.value.length - 1))
        }
    }

    soloNumeros(e){
    	var input = e.target
    	var longitud = 15
        if( !(/^[0-9]+$/.test( input.value )) ){
            alert("EL CAMPO QUE INTENTA USAR SOLO PUEDE POSEER CARACTERES NUMERICOS Y DEBE TENER UNA LONGITUD MAXIMA DE "+longitud+ " CARACTERES")
            input.value = input.value.substring(0 , (input.value.length - 1) )
        }
        if(input.value.length > longitud)
        	input.value = input.value.substring(0, (input.value.length - 1))
    }

	render(){

		return(
			<div>
				<Navigator />
				<Grid>
					<form method="post" id="info" action="http://localhost:8000/solicitudes/servicios">
					<div className="row">
						<div className="col-sm-10">
								<h3>Datos personales</h3>
								<hr className="divider" />
							</div>
							<div className="col-sm-11">
								<label for="cedula">Cedula</label>
								<input type="text" onChange={ (e) => {this.validarCedula(e)}}  required name="cedula" id="cedula" className="form-control" />
							</div>
							<div className="col-sm-4">
								<label for="nombres">nombres</label>
								<input type="text" onChange={ e => { this.soloTexto(e) } } onKeyDown={ e => { this.soloTexto(e) } } required name="nombres" id="nombres" className="form-control" />
							</div>
							<div className="col-sm-4">
								<label for="apellidos">apellidos</label>
								<input type="text" onChange={ e => { this.soloTexto(e) } } onKeyDown={ e => { this.soloTexto(e) } } required name="apellidos" id="apellidos" className="form-control" />
							</div>

							<div className="col-sm-3">
								<label for="email">Correo electronico</label>
								<input type="email" required name="email" className="form-control" />
							</div>
						</div>
						<div className="row">
							<div className="col-sm-12 col-md-6 col-lg-6">
								<label for="telefono">Telefono personal</label>
								<input type="text" onChange = { (e)=>{ this.soloNumeros(e) }} required name="telefono_personal" className="form-control" />
							</div>
							<div className="col-sm-12 col-md-5 col-lg-5">
								<label for="telefono">Telefono de contacto</label>
								<input type="text" onChange = { (e)=>{ this.soloNumeros(e) }} required name="telefono_habitacion" className="form-control" />
							</div>
						</div>
						<div className="row">
							<div className="col-sm-10">
								<h3>Datos del servicio</h3>
								<hr className="divider" />
							</div>
							<div className="col-sm-6">
								<label for="tipo_servicio">Tipo de servicio solicitado</label>
								<select name="tipo_id" id="" required className="form-control">
									{this.renderTipos()}
								</select>
							</div>

							<div className="col-sm-5">
								<label for="tipo_servicio">Categoria del servicio</label>
								<select name="categoria_id" id="" required className="form-control">
									{this.renderCategorias()}
								</select>
							</div>
							<div className="row">
								<div className="col-sm-11">
									<label for="direccion">Dirección</label>
									<textarea name="direccion" id="direccion" required className="form-control" cols="30" rows="10"></textarea>
								</div>
								<div className="col-sm-11">
									<label for="direccion">Explique aquí brevemente su problema</label>
									<textarea name="detalles" id="detalles" required className="form-control" cols="30" rows="10"></textarea>
								</div>
							</div>
						</div>
						<br />
						<div className="row" style={{marginTop: "12px", marginLeft: "17px", marginBottom: "17px"}}>
							<button type="submit" className="btn btn-primary btn-lg">Guardar</button>
						</div>
					</form>
				</Grid>
			</div>
		);
	}
}